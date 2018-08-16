<?php

namespace App\Http\Controllers;

use App\Events\SendChatMessageEvent;
use App\Service\ChatMessageService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggedInUser = Auth::user();
        if (!$loggedInUser) {
            return redirect('home');
        }

        $users = User::all();

        return view('chat', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $this->chatMessageService->saveMessage($sender, $message, $timestamp);
        broadcast(new SendChatMessageEvent($sender, $message, $timestamp));

        return view('chat')->with('users', User::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
