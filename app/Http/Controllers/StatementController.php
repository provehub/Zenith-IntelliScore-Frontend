<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\PdfToText\Pdf;
use Throwable;

class StatementController extends Controller
{
    /**
     * Upload a Zenith PDF statement, parse it, score it and save assessment.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'statement' => ['required', 'file', 'mimes:pdf'],
        ]);

        $file = $request->file('statement');

        if (! $file->isValid()) {
            return response()->json(['message' => 'Invalid file upload'], 422);
        }

        // Store the original PDF
        $path     = $file->store('statements');       // e.g. statements/xxxx.pdf
        $fullPath = Storage::path($path);            // absolute path

        try {
            // 1) Extract text from PDF
            $text = trim(Pdf::getText($fullPath));

            if (mb_strlen($text) < 50) {
                return response()->json([
                    'message' => 'Unable to extract text from statement. Check PDF quality.',
                ], 422);
            }

            // 2) Parse Zenith statement into rows + meta
            [$rows, $meta] = $this->parseZenith($text);

            // 3) Build model features from parsed rows
            $features = $this->featuresFromRows($rows);

            // 4) Call ML service
            $mlBase = config('services.intelliscore.url', 'http://127.0.0.1:8001');
            $resp   = Http::timeout(10)->post(rtrim($mlBase, '/').'/score', $features);

            if ($resp->failed()) {
                return response()->json([
                    'message' => 'ML scoring service unavailable',
                ], 503);
            }

            $scoreData = $resp->json();

            // 5) Save assessment in DB
            $assessment = Assessment::create([
                'project_id'         => session()->get('current_project_id'),
                'account_name'       => $meta['account_name'] ?? 'Unknown',
                'account_no'         => $meta['account_no']   ?? 'Unknown',
                'period'             => $meta['period']       ?? null,
                'credit_trust_score' => $scoreData['credit_trust_score'] ?? 0,
                'risk_band'          => $scoreData['risk_band']          ?? 'D',
                'pd_90d'             => $scoreData['pd_90d']             ?? 0,
                'meta'               => $meta,
                'features'           => $features,
                'score'              => $scoreData,
            ]);

            return redirect()->route('user.dashboard')->with('success', 'A new assesment was created! You can preview your new credit score in your dashboard pending additional data.');

            // 6) Return a clean, UI-friendly payload
            // return response()->json($this->presentAssessment($assessment));
        } catch (Throwable $e) {
            // For dev, you might dd($e->getMessage()); but return JSON in prod
            return response()->json([
                'message' => 'Failed to process statement',
                'error'   => app()->environment('local') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Parse Zenith-style statement text into rows + metadata.
     *
     * Rows: [
     *   ['date' => '01/11/2025', 'description' => '...', 'debit' => 0.00, 'credit' => 1000.00, 'value_date' => '01/11/2025', 'balance' => 3712.13]
     * ]
     */
    private function parseZenith(string $text): array
    {
        $lines = preg_split('/\R+/', $text);

        $rows = [];
        $meta = [
            'account_name' => null,
            'account_no'   => null,
            'period'       => null,
        ];

        // Basic metadata extraction
        foreach ($lines as $line) {
            if (! $meta['account_name'] && preg_match('/ACCOUNT\s*NAME:\s*(.+)/i', $line, $m)) {
                $meta['account_name'] = trim($m[1]);
            }

            if (! $meta['account_no'] && preg_match('/ACCOUNT\s*NO\.?\s*:\s*([0-9]+)/i', $line, $m)) {
                $meta['account_no'] = trim($m[1]);
            }

            if (! $meta['period'] && preg_match('/Period:\s*([0-9\/]+)\s*TO\s*([0-9\/]+)/i', $line, $m)) {
                $meta['period'] = trim($m[1]).'—'.trim($m[2]);
            }
        }

        // Find table header
        $inTable = false;

        foreach ($lines as $l) {
            $line = trim(preg_replace('/\s{2,}/', '  ', $l)); // squeeze multiple spaces

            if (! $inTable && preg_match('/^DATE\s+DESCRIPTION\s+DEBIT\s+CREDIT/i', $line)) {
                $inTable = true;
                continue;
            }

            if (! $inTable) {
                continue;
            }

            if ($line === '' || stripos($line, 'TOTAL') !== false) {
                continue;
            }

            // Typical Zenith-style row pattern (may need tuning for other variants)
            if (preg_match(
                '/^(\d{2}\/\d{2}\/\d{4})\s+(.+?)\s+([0-9,]+\.\d{2}|0\.00)\s+([0-9,]+\.\d{2}|0\.00)\s+(\d{2}\/\d{2}\/\d{4})\s+(-?[0-9,]+\.\d{2})$/',
                $line,
                $m
            )) {
                $rows[] = [
                    'date'        => $m[1],
                    'description' => $m[2],
                    'debit'       => $this->toAmount($m[3]),
                    'credit'      => $this->toAmount($m[4]),
                    'value_date'  => $m[5],
                    'balance'     => $this->toAmount($m[6]),
                ];
            } else {
                // For hackathon: ignore weird/wrapped lines
                continue;
            }
        }

        return [$rows, $meta];
    }

    private function toAmount(string $s): float
    {
        $clean = str_replace([',', ' '], '', $s);

        return (float) $clean;
    }

    /**
     * Convert parsed rows into model features.
     */
    private function featuresFromRows(array $rows): array
    {
        $sumCredit = 0.0;
        $sumDebit  = 0.0;
        $nCredit   = 0;
        $nDebit    = 0;

        $nipFees   = 0.0;
        $nipCount  = 0;
        $vatFees   = 0.0;
        $feeCount  = 0;

        $salaryInflow = 0.0;
        $otherInflow  = 0.0;

        foreach ($rows as $r) {
            $desc = strtoupper($r['description']);
            $credit = $r['credit'];
            $debit  = $r['debit'];

            if ($credit > 0) {
                $sumCredit += $credit;
                $nCredit++;
            }
            if ($debit > 0) {
                $sumDebit += $debit;
                $nDebit++;
            }

            // Salary vs other inflows (heuristic)
            if ($credit > 0 && (str_contains($desc, 'SALARY') || str_contains($desc, 'PAYROLL'))) {
                $salaryInflow += $credit;
            } elseif ($credit > 0) {
                $otherInflow += $credit;
            }

            // Charges / fees
            if (str_contains($desc, 'NIP CHARGE')) {
                $nipFees += $debit;
                $nipCount++;
                $feeCount++;
            }
            if (str_contains($desc, 'VAT')) {
                $vatFees += $debit;
                $feeCount++;
            }
            if (str_contains($desc, 'FEE') || str_contains($desc, 'CHARGE')) {
                $feeCount++;
            }
        }

        $netInflow = $sumCredit - $sumDebit;
        $avgTicket = ($nCredit + $nDebit) > 0
            ? ($sumCredit + $sumDebit) / ($nCredit + $nDebit)
            : 0;

        // Map to the ML model schema you already use
        return [
            'pos_txn_cnt_90d'         => max($nDebit + $nCredit, 1),          // proxy for activity
            'pos_volume_90d_ngn'      => max($sumDebit, 0.01),                 // treat spend as POS-like volume
            'salary_inflow_90d_ngn'   => $salaryInflow,
            'net_inflow_90d_ngn'      => $netInflow,

            // Static defaults for now (you can replace with real telecom/utilities data later)
            'tel_topups_cnt_90d'      => 10,
            'tel_inactive_days_90d'   => 2,
            'util_late_cnt_90d'       => 0,
            'age_years'               => 32,

            '_derived' => [
                'sum_credit' => $sumCredit,
                'sum_debit'  => $sumDebit,
                'nip_fees'   => $nipFees,
                'nip_count'  => $nipCount,
                'vat_fees'   => $vatFees,
                'fee_count'  => $feeCount,
                'avg_ticket' => round($avgTicket, 2),
            ],
        ];
    }

    /**
     * Turn an Assessment model into a clean, UI-friendly view model.
     */
    private function presentAssessment(Assessment $a): array
    {
        $score = $a->score ?? [];
        $top   = $score['top_feature_impacts'] ?? [];

        $explanations = [];

        foreach ($top as $item) {
            $f      = $item['feature'] ?? '';
            $v      = $item['value']   ?? null;
            $impact = (float) ($item['impact'] ?? 0);

            $direction = $impact >= 0 ? 'increases risk' : 'reduces risk';

            $label  = $this->featureLabel($f);
            $detail = sprintf(
                '%s (value: %s) %s.',
                $label,
                is_numeric($v) ? number_format((float) $v, 2) : $v,
                $direction
            );

            $explanations[] = [
                'label'  => $label,
                'detail' => $detail,
                'impact' => $impact,
            ];
        }

        return [
            'id'      => $a->id,
            'account' => [
                'name'   => $a->account_name,
                'number' => $a->account_no,
                'period' => $a->period,
            ],
            'score' => [
                'credit_trust_score' => (int) $a->credit_trust_score,
                'risk_band'          => $a->risk_band,
                'pd_90d'             => (float) $a->pd_90d,
            ],
            'explanations' => $explanations,
            'raw' => [
                'features' => $a->features,
                'score'    => $a->score,
                'meta'     => $a->meta,
            ],
        ];
    }

    /**
     * Human-readable labels for feature keys.
     */
    private function featureLabel(string $key): string
    {
        return match ($key) {
            'pos_volume_90d_ngn'      => 'Spending volume (last 90 days)',
            'pos_txn_cnt_90d'         => 'Transaction count (last 90 days)',
            'salary_inflow_90d_ngn'   => 'Salary inflow (last 90 days)',
            'net_inflow_90d_ngn'      => 'Net inflow (last 90 days)',
            'tel_inactive_days_90d'   => 'Inactive days on line (90 days)',
            'tel_topups_cnt_90d'      => 'Airtime top-ups (90 days)',
            'util_late_cnt_90d'       => 'Late utility payments (90 days)',
            default                   => Str::headline($key),
        };
    }
}
