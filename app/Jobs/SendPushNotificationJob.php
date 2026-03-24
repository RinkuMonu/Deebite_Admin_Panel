<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\FirebaseService;
use Illuminate\Foundation\Bus\Dispatchable;
// use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendPushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $token;
    protected string $title;
    protected string $body;
    protected array $data;
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(string $token, string $title, string $body, array $data = [])
    {
        $this->token = $token;
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    // public function handle(FirebaseService $firebase)
    // {
    //     if ($this->user->fcm_token) {
    //         $firebase->send($this->user->fcm_token, $this->title, $this->body, $this->data);
    //     }
    // }
    public function handle(): void
    {
        try {
            $firebase = new FirebaseService();
            $sent = $firebase->send($this->token, $this->title, $this->body, $this->data);

            if ($sent) {
                Log::info('FCM sent successfully', ['token' => $this->token]);
            } else {
                Log::warning('FCM failed', ['token' => $this->token]);
            }
        } catch (\Exception $e) {
            Log::error('FCM Job Exception', ['error' => $e->getMessage()]);
        }
    }
}
