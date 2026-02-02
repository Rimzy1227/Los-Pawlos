<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOrderConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // PERFORMANCE: Simulating expensive operation (sending email)
        // In a real app, this would use Mail::to($this->order->user->email)->send(new OrderConfirmed($this->order));
        
        Log::info("--- QUEUE JOB EXECUTING ---");
        Log::info("Simulating Sending Confirmation Email for Order ID: " . $this->order->id);
        Log::info("Recipient: " . ($this->order->user?->email ?? 'Guest'));
        Log::info("Total Amount: $" . $this->order->total);
        Log::info("--- EMAIL SENT SUCCESSFULLY ---");
    }
}
