<?php

namespace App\Events;

use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var User */
    public $sender;

    /** @var User */
    public $recipient;

    /** @var string */
    public $message;

    /** @var DateTime */
    public $timestamp;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $recipient, string $message)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->message = $message;
        $this->timestamp = Carbon::now();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        $participants = [
          $this->sender->id,
          $this->recipient->id
        ];

        // Always sort by value, so that the lowest user id is first when naming the chat
        sort($participants);

        return new Channel('chat');// todo change to: sprintf('chat.%d-%d', $participants[0], $participants[1]));
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
