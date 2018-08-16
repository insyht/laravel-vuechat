<?php

namespace App\Events;

use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var User */
    public $sender;

    /** @var string */
    public $message;

    /** @var DateTime */
    public $timestamp;

    /**
     * Create a new event instance.
     *
     * @param User   $sender
     * @param string $message
     * @param Carbon $timestamp
     */
    public function __construct(User $sender, string $message, Carbon $timestamp)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->timestamp = $timestamp;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat');
    }

    /**
     * Set the event name
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'newMessage';
    }
}
