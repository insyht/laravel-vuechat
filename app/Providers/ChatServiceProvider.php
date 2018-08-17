<?php

namespace App\Providers;

use App\Service\ChatMessageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Set a var that contains all chats
        view()->composer(
            'chat',
            function($view) {
                $loggedInUser = Auth::user();

                if ($loggedInUser) {
                    /** @var ChatMessageService $chatMessageService */
                    $chatMessageService = app(ChatMessageService::class);
                    $view->with('chats', $chatMessageService->getChats());
                }
            }
        );
    }

    /**
     * Register the chat message service
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ChatMessageService::class, function() {
            return new ChatMessageService();
        });
    }
}
