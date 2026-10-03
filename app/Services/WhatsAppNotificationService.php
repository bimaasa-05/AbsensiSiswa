<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppNotificationService
{
    /**
     * Kirim pesan WhatsApp.
     *
     * @return array{success: bool, provider_message_id: ?string, error: ?string}
     */
    public function send(string $to, string $message): array
    {
        $driver = config('services.whatsapp.driver', 'log');

        if ($driver === 'http') {
            return $this->sendViaHttp($to, $message);
        }

        Log::info('[WhatsApp/log] To: '.$to."\n".$message);

        return [
            'success' => true,
            'provider_message_id' => 'log-'.now()->format('YmdHis'),
            'error' => null,
        ];
    }

    protected function sendViaHttp(string $to, string $message): array
    {
        $url = config('services.whatsapp.api_url');
        $key = config('services.whatsapp.api_key');

        if (empty($url)) {
            return ['success' => false, 'provider_message_id' => null, 'error' => 'WA_API_URL belum dikonfigurasi.'];
        }

        try {
            $response = Http::timeout(15)->post($url, [
                'api_key' => $key,
                'to' => $to,
                'message' => $message,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'provider_message_id' => (string) ($response->json('message_id') ?? $response->json('id') ?? 'http-'.now()->format('YmdHis')),
                    'error' => null,
                ];
            }

            return [
                'success' => false,
                'provider_message_id' => null,
                'error' => 'Provider menjawab HTTP '.$response->status().'.',
            ];
        } catch (\Throwable $e) {
            return ['success' => false, 'provider_message_id' => null, 'error' => $e->getMessage()];
        }
    }
}
