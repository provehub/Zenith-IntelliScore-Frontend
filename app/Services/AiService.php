<?php
namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use HosseinHezami\LaravelGemini\Facades\Gemini;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class AiService
{
    /**
     * Generates a basic text response from a prompt.
     * @param string $prompt
     * @return string
     */
    public function generateText(string $prompt): string
    {
        try {
            $response = Gemini::text()
                ->model('gemini-2.5-flash') // Fast, general-purpose model
                ->prompt($prompt)
                ->temperature(0.7) // A bit creative
                ->maxTokens(1024)
                ->generate();

            return $response->content();

        } catch (Exception $e) {
            // Log the error and return a friendly message
            \Log::error('Gemini Text Generation Error: ' . $e->getMessage());
            return "Sorry, I couldn't generate a response right now. Please try again later.";
        }
    }

    /**
     * Generates structured JSON output based on a defined schema.
     * @param string $textToAnalyze
     * @return array
     */
    public function generateStructuredJson(string $textToAnalyze): array
    {
        // Define the JSON schema we want the model to follow
        $schema = [
            'type' => 'object',
            'properties' => [
                'sentiment' => [
                    'type' => 'string',
                    'enum' => ['positive', 'negative', 'neutral'],
                    'description' => 'The overall tone of the review.',
                ],
                'confidence_score' => [
                    'type' => 'number',
                    'description' => 'A score from 0.0 to 1.0 indicating confidence.',
                ],
                'key_features' => [
                    'type' => 'array',
                    'items' => ['type' => 'string'],
                    'description' => 'A list of 3-5 key features mentioned.',
                ],
            ],
            'required' => ['sentiment', 'confidence_score', 'key_features'],
        ];

        $prompt = "Analyze the following customer review and extract the structured data: \"{$textToAnalyze}\"";

        try {
            $response = Gemini::text()
                ->model('gemini-2.5-flash')
                ->prompt($prompt)
                ->structuredSchema($schema) // Enforce the JSON output structure
                ->generate();

            // The content() method returns the raw JSON string
            return json_decode($response->content(), true);

        } catch (Exception $e) {
            \Log::error('Gemini Structured JSON Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Generates an image and saves it to a specified path.
     * NOTE: Image generation is handled by the Imagen model.
     * @param string $prompt
     * @return string|bool The public URL of the saved image, or false on failure.
     */
    public function generateImage(string $prompt): string|bool
    {
        try {
            // 1. Generate the image using the specialized image model
            $response = Gemini::image()
                // Use the image model if the package is configured for it
                ->model('imagen-3.0-generate-002') 
                ->prompt($prompt)
                ->generate();

            if (!empty($response->content())) {
                $fileName = 'ai_image_' . time() . '.png';
                $savePath = public_path('images/generated/' . $fileName);
                
                // 2. The save() helper method takes the binary data and saves it to disk
                $response->save($savePath);

                // 3. Return the public path
                return asset('images/generated/' . $fileName);
            }

            return false;

        } catch (Exception $e) {
            \Log::error('Gemini Image Generation Error: ' . $e->getMessage());
            return false;
        }
    }

    public function generateMOU(array $data): string
    {
        $prompt = <<<EOT
Generate a professional Memorandum of Understanding (MOU) in HTML format, but return ONLY the <body> content — do not include <html>, <head>, <style>, or closing </body> or </html> tags.

Use semantic tags like <h1>, <h2>, <p>, <b>, and <hr>. Structure it with the following sections:

1. Title
2. Introduction
3. Parties
4. Purpose
5. Terms and Conditions
6. Signatures

Details:
- Company connecting both parties: {$data['company']}
- Party A: {$data['party_a_name']}
- Party B: {$data['party_b_name']}
- Purpose: {$data['purpose']}
- Start Date: {$data['start_date']}
- End Date: {$data['end_date']}
- Terms: {$data['terms']}
- Country: {$data['country']}

Return only the raw HTML content inside the <body> tag.
EOT;


        $response = OpenAI::chat()->create([
            'model' => 'gpt-4-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a legal assistant generating Memorandums of Understanding (MOUs).'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $mouText = $response['choices'][0]['message']['content'];

        return $mouText;
    }

    protected function savePDF(string $content): string
    {
        $pdf = Pdf::loadHTML(nl2br(e($content)));
        $filename = 'mou_' . uniqid() . '.pdf';

        Storage::disk('public')->put("mous/$filename", $pdf->output());

        return Storage::disk('public')->url("mous/$filename");
    }
}
