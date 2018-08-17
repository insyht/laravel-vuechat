<?php


namespace App\Service;

use App\User;
use Carbon\Carbon;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Facades\Cache;
use Throwable;

class ChatMessageService
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getChats(): array
    {
        try {
            /** @var RedisManager $redis */
            $redis = Cache::getRedis();
        } catch (Throwable $t) {
            return [];
        }

        // Find all chats in Redis
        $keys = $redis->keys(sprintf('*%s*', config('chat.chatMessageCachePrefix')));
        $chats = [];
        $i = 0;
        foreach ($keys as $key) {
            // Remove the prefix Laravel sets on all Redis cache keys
            $chat = cache(str_replace(config('chat.laravelCachePrefix'), '', $key));
            if ($chat) {
                // An identifing key is needed for every element
                $chat['id'] = $i;
                $i++;
                $chats[] = $chat;
            }
        }

        // Order chats by date, descending (most recent chats first)
        usort(
            $chats,
            function($a, $b) {
                if ($a['timestamp'] == $b['timestamp']) {
                    return 0;
                }

                return $a['timestamp'] > $b['timestamp'] ? -1 : 1;
            }
        );

        return $chats;
    }

    /**
     * @param User   $sender
     * @param string $message
     * @param Carbon $timestamp
     *
     * @throws \Exception
     */
    public function saveMessage(User $sender, string $message, Carbon $timestamp)
    {
        $content = [
          'sender' => $sender,
          'message' => $message,
          'timestamp' => $timestamp,
        ];
        $duration = 60*24*7; // One week
        $key = $timestamp->timestamp . $sender->id . mt_rand(1,1000000);

        // Save the message in the Redis cache
        cache([sprintf('%s:%s', config('chat.chatMessageCachePrefix'), $key) => $content], $duration);
    }

}
