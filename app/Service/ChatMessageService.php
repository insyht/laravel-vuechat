<?php


namespace App\Service;

use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Facades\Cache;
use Throwable;

class ChatMessageService
{
    /**
     * @param Authenticatable $user
     *
     * @return array
     */
    public function getChatsForUser(Authenticatable $user): array
    {
        try {
            /** @var RedisManager $redis */
            $redis = Cache::getRedis();
        } catch (Throwable $t) {
            return [];
        }

        $keys = $redis->keys(sprintf('*%s*', config('chat.chatMessageCachePrefix')));
        $chats = [];
        foreach ($keys as $key) {
            // Remove the prefix Laravel sets on all Redis cache keys
            $chat = cache(str_replace(config('chat.laravelCachePrefix'), '', $key));
            if ($chat && in_array($user->id, [$chat['sender']->id, $chat['recipient']->id])) {
                $chats[] = $chat;
            }
        }

        // Order by date, ascending
        usort(
            $chats,
            function($a, $b) {
                if ($a == $b) {
                    return 0;
                }

                return $a < $b ? -1 : 1;
            }
        );

        return $chats;
    }

    /**
     * @param User   $sender
     * @param User   $recipient
     * @param string $message
     * @param Carbon $timestamp
     *
     * @throws \Exception
     */
    public function saveMessage(User $sender, User $recipient, string $message, Carbon $timestamp)
    {
        $content = [
          'sender' => $sender,
          'recipient' => $recipient,
          'message' => $message,
          'timestamp' => $timestamp,
        ];
        $duration = 60*24*7; // One week
        $key = $timestamp->timestamp . $sender->id . $recipient->id . mt_rand(1,1000000);

        cache([sprintf('%s:%s', config('chat.chatMessageCachePrefix'), $key) => $content], $duration);
    }

}
