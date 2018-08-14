<?php

namespace App\Listeners;

use App\Events\SendChatMessageEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendChatMessageEventListener
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
     * @param  SendChatMessageEvent  $event
     * @return void
     */
    public function handle(SendChatMessageEvent $event)
    {
        //
    }
}
