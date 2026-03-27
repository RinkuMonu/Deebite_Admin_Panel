<?php

namespace App\Services;

use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

use GuzzleHttp\Client;

class FirebaseService
{
     public function send(string $token, string $title, string $body, array $data = []): bool
    {
        try {
            $serverKey = config('firebase.projects.app.credentials.file');

            
            // $payload = [
            //     'to' => $token,
            //     'notification' => [
            //         'title' => $title,
            //         'body' => $body,
            //     ],
            //     'data' => $data
            // ];
            $payload = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => $data,
                ],
            ];

            $response = Http::withHeaders([
                'Authorization' => 'key=' . $serverKey,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/v1/projects/YOUR_PROJECT_ID/messages:send', $payload);

            // $response = Http::withHeaders([
            //     'Authorization' => 'key=' . $serverKey,
            //     'Content-Type' => 'application/json',
            // ])->post('https://fcm.googleapis.com/fcm/send', $payload);

            // Optional: log failure if FCM returns non-200
            if (!$response->successful()) {
                Log::error('FCM send failed in FirebaseService', [
                    'token' => $token,
                    'response' => $response->body(),
                ]);
                return false;
            }

            return true;

        } catch (Exception $e) {
            Log::error('FCM request exception in FirebaseService', [
                'token' => $token,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }



// function send($token, $title, $body, $data = []) {
//     // Path to your service account JSON
//     $serviceAccount = json_decode(file_get_contents(config('firebase.projects.app.credentials.file')), true);

//     // Prepare JWT for OAuth2
//     $now = time();
//     $header = base64_encode(json_encode(['alg'=>'RS256','typ'=>'JWT']));
//     $claims = [
//         'iss' => $serviceAccount['client_email'],
//         'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
//         'aud' => 'https://oauth2.googleapis.com/token',
//         'iat' => $now,
//         'exp' => $now + 3600
//     ];
//     $payload = base64_encode(json_encode($claims));

//     $signature = '';
//     openssl_sign($header.'.'.$payload, $signature, $serviceAccount['private_key'], 'SHA256');
//     $jwt = $header.'.'.$payload.'.'.base64_encode($signature);

//     // Get OAuth2 token
//     $client = new Client();
//     $response = $client->post('https://oauth2.googleapis.com/token', [
//         'form_params' => [
//             'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
//             'assertion' => $jwt,
//         ]
//     ]);

//     $accessToken = json_decode($response->getBody(), true)['access_token'];

//     // Send FCM message
//     $fcmUrl = 'https://fcm.googleapis.com/v1/projects/'.$serviceAccount['project_id'].'/messages:send';

//     $payload = [
//         'message' => [
//             'token' => $token,
//             'notification' => [
//                 'title' => $title,
//                 'body' => $body
//             ],
//             'data' => $data
//         ]
//     ];

//     $response = $client->post($fcmUrl, [
//         'headers' => [
//             'Authorization' => 'Bearer '.$accessToken,
//             'Content-Type' => 'application/json',
//         ],
//         'json' => $payload
//     ]);

//     return json_decode($response->getBody(), true);
// }

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