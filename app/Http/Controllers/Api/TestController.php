<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use App\Models\User;


class TestController extends Controller
{
    public function sendNotification(FirebaseService $firebase)
    {
        $user = User::find(1);

        foreach ($user->deviceTokens as $token) {
            $firebase->send(
                $token->device_token,
                'Order Update',
                'Your order is out for delivery 🚚'
            );
        }

        return response()->json(['message' => 'Sent']);
    }
}
