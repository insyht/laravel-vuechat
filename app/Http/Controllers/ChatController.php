<?php

namespace App\Http\Controllers;

use App\Events\SendChatMessageEvent;
use App\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('input', ['users' => $users]);
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
        // Reset cached message and recipient
        session(['message' => null, 'recipient' => null]);

        /** @var User $sender */
        $sender = Auth::user();
        $recipient = User::find($request->chat_partner);
        $message = $request->message;

        // If there is no sender set (which means the user is not logged in)
        if (!$sender) {
            // Cache the message that was entered and the recipient that was chosen so that (s)he doesn't have to do
            // that again after logging in
            session(['message' => $message, 'recipient' => $recipient]);
            // Return the user to the login page
            return redirect('home');
        }

        broadcast(new SendChatMessageEvent($sender, $recipient, $message));

        return view('input')->with('users', User::all());
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
