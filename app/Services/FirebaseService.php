<?php

namespace App\Services;

use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class FirebaseService
{
     public function send(string $token, string $title, string $body, array $data = []): bool
    {
        try {
            $serverKey = config('firebase.projects.app.credentials.file');

            dd($serverKey);
            $payload = [
                'to' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data
            ];

            $response = Http::withHeaders([
                'Authorization' => 'key=' . $serverKey,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', $payload);

            // Optional: log failure if FCM returns non-200
            if (!$response->successful()) {
                Log::error('FCM send failed', [
                    'token' => $token,
                    'response' => $response->body(),
                ]);
                return false;
            }

            return true;

        } catch (Exception $e) {
            Log::error('FCM request exception', [
                'token' => $token,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
    {
        try {
            $serverKey = config('services.fcm.key');

            $payload = [
                'to' => "/topics/{$topic}",
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data
            ];

            $response = Http::withHeaders([
                'Authorization' => 'key=' . $serverKey,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', $payload);

            if (!$response->successful()) {
                Log::error('FCM topic send failed', [
                    'topic' => $topic,
                    'response' => $response->body(),
                ]);
                return false;
            }

            return true;

        } catch (Exception $e) {
            Log::error('FCM topic request exception', [
                'topic' => $topic,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

}