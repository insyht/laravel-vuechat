<?php

namespace App\Broadcasting;

use App\User;

class ChatChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join(User $user, Chat $chat)
    {
        return $this->userIsInChat($user, $chat);
    }

    private function userIsInChat(User $user, Chat $chat): bool
    {
        foreach ($chat->participants as $participant) {
            if ($participant->id === $user->id) {
                return true;
            }
        }

        return false;
    }
}
