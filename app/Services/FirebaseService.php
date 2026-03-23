<?php

namespace App\Services;

use Kreait\Firebase\Messaging\CloudMessage;

class FirebaseService
{
    public function send($token, $title, $body)
    {
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification([
                'title' => $title,
                'body' => $body
            ]);

        app('firebase.messaging')->send($message);
    }
}