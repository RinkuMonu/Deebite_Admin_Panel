<?php

namespace App\Listeners;

use App\Events\TestEventNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyTestEvent implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    public function handle(TestEventNotification $event): void
    {
        try{

        // Dispatch the job to send FCM asynchronously
        SendPushNotificationJob::dispatch(
            $event->token,
            $event->title,
            $event->body,
            $event->data
        );

        } catch (\Exception $e) {
            Log::error('Failed to dispatch SendPushNotificationJob', ['error' => $e->getMessage()]);
        }
    }


}
