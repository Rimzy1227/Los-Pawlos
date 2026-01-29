<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Jobs\SendOrderConfirmation;
use Illuminate\Support\Facades\Log;

class SendOrderNotification
{
    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        // PERFORMANCE: Offloading heavy email tasks to the Queue
        SendOrderConfirmation::dispatch($event->order);

        // EXTRA CREDIT: Adding an admin log entry
        Log::info("Admin Notification: A new order #{$event->order->id} has been placed for ${$event->order->total}");
    }
}
