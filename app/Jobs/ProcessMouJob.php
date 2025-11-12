<?php

namespace App\Jobs;

use Throwable;
use App\Models\{User,Contract};

use App\Mail\GeneralEmail;
use App\Services\MOUService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessMouJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $useremail;
    protected $userename;
    protected $subject;
    protected $message;
    protected $payment;
    protected $mouService;

     /**
     * Create a new job instance.
     */
    public function __construct($useremail, $userename, $subject, $message, $payment)
    {
        $this->useremail = $useremail;
        $this->userename = $userename;
        $this->subject = $subject;
        $this->message = $message;
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mouService = app(MOUService::class); // Resolves from container

        $contract = Contract::where('payment_id', $this->payment)
            ->with(['deal.proposal.user', 'deal.proposal.ptop.user'])
            ->first();

        $data = [
            'party_a_name' => $contract->deal->proposal->ptop->user->name,
            'company' => 'Zenith IntelliScore Technologies Ltd.',
            'party_b_name' => $contract->deal->proposal->user->name,
            'purpose' => $contract->deal->proposal->ptop->description,
            'start_date' => '2025-05-31 20:44:18',
            'end_date' => '2025-09-29 20:44:18',
            'terms' => 'suggest for us',
            'country' => 'Nigeria',
        ];

        $downloadUrl = $mouService->generateMOU($data);

        $contract->update([
            'body' => $downloadUrl,
            'party_a' => $contract->deal->proposal->ptop->user->name,
            'party_b' => $contract->deal->proposal->user->name,
            'status' => 1,
        ]);

        Mail::to($this->useremail)->send(new GeneralEmail(
            $this->userename,
            $this->subject,
            $this->message,
        [
            'url' => route('contract.show',$contract->id), 
            'text' => 'View Contract', 
        ]
        ));
    }


    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        // Send user notification of failure, etc...
        $subject = 'MOU Job Failure for Events';
        $messagetosend = $exception;
        Mail::to('support@Zenith IntelliScore.ng')->send(new GeneralEmail('Job MOU','New Error Received',$messagetosend,[
                    'url' => route('index'), 
                    'text' => 'Goto Zenith IntelliScore', 
                ]));
    }
}
