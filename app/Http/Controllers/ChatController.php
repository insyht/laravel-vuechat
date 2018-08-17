<?php

namespace App\Http\Controllers;

use App\Events\SendChatMessageEvent;
use App\Service\ChatMessageService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /** @var ChatMessageService $chatMessageService */
    private $chatMessageService;

    public function __construct()
    {
        $this->chatMessageService = app(ChatMessageService::class);
    }
    /**
     * Show the page with the chat
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggedInUser = Auth::user();
        if (!$loggedInUser) {
            // User is nog logged in yet, let him/her login
            return redirect('home');
        }

        return view('chat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\View\View
     * @throws \Exception
     */
    public function store(Request $request): \Illuminate\View\View
    {
        // Reset cached message
        session(['message' => null]);

        /** @var User $sender */
        $sender = Auth::user();
        $message = $request->message;

        // If there is no sender set (which means the user is not logged in)
        if (!$sender) {
            // Cache the message that was entered so that the user doesn't have to do that again after logging in
            session(['message' => $message]);
            // Return the user to the login page
            return redirect('home');
        }

        $timestamp = Carbon::now();
        // Save the message in Redis
        $this->chatMessageService->saveMessage($sender, $message, $timestamp);
        // Broadcast the message to the channel
        broadcast(new SendChatMessageEvent($sender, $message, $timestamp));

        return view('chat');
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function showMessages(): array
    {
        // Return all chats as an array
        return $this->chatMessageService->getChats();
    }
}
