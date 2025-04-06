<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BrevoMailService
{
    public function sendEmail($to, $subject, $message)
    {
        $apiKey = env('BREVO_API_KEY');

        $response = Http::withHeaders([
            'api-key' => $apiKey,
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'email' => env('MAIL_FROM_ADDRESS'),
                'name'  => env('MAIL_FROM_NAME'),
            ],
            'to' => [
                ['email' => $to],
            ],
            'subject' => $subject,
            'htmlContent' => $message,
        ]);

        return $response->successful();
    }
}
