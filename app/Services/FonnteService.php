<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $token;
    protected $apiUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = env('WA_TOKEN_API_KEY');
    }

    /**
     * Send WhatsApp message via Fonnte API
     *
     * @param string|array $target (e.g., '08123456789' or '0812...,0813...')
     * @param string $message
     * @return bool
     */
    public function sendMessage($target, $message)
    {
        if (empty($this->token)) {
            Log::warning('Fonnte API token is missing. WhatsApp notification not sent.');
            return false;
        }

        // Format phone number to replace '0' prefix with '62'
        $target = $this->formatPhoneNumber($target);

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->apiUrl, [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Optional, Fonnte uses this if target is not fully formatted
            ]);

            $responseData = $response->json();

            if ($response->successful() && isset($responseData['status']) && $responseData['status'] == true) {
                Log::info("WhatsApp notification sent successfully to {$target}. Response: " . json_encode($responseData));
                return true;
            } else {
                Log::error("Failed to send WhatsApp notification to {$target}. Response: " . json_encode($responseData));
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Exception when sending WhatsApp notification to {$target}. Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper to format phone number to standard format
     */
    protected function formatPhoneNumber($number)
    {
        if (is_array($number)) {
            $number = implode(',', $number);
        }

        // Fonnte accepts numbers starting with 0, 62, or +62. 
        // We ensure spaces and hyphens are removed.
        $number = preg_replace('/[^0-9,]/', '', $number);
        
        return $number;
    }
}
