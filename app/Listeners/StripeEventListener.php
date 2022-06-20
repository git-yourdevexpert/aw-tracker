<?php

namespace App\Listeners;

use Laravel\Cashier\Events\WebhookReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StripeEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\WebhookReceived  $event
     * @return void
     */
    public function handle(WebhookReceived $event)
    {
       // \Log::info([$event]);
        if ($event->payload['type'] === 'invoice.payment_succeeded') {
            // Handle the incoming event...
            \Log::info([$event]);
        }
    }
}
