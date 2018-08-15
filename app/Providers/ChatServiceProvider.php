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
        // Set a var that contains all chats in which the logged in user participated
        view()->composer(
            'input',
            function($view) {
                $loggedInUser = Auth::user();

                if ($loggedInUser) {
                    /** @var ChatMessageService $chatMessageService */
                    $chatMessageService = app(ChatMessageService::class);
                    $view->with('chats', $chatMessageService->getChatsForUser($loggedInUser));
                }
            }
        );
    }

    /**
     * Register services.
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
