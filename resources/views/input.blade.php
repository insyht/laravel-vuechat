<!-- Temporary view to check if sending chat messages works -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.app')

@section('content')
    <example-component></example-component>
@endsection
<form method="post" action="/chat">
    {{csrf_field()}}

    <select name="chat_partner">
        @foreach ($users as $user)
            <option value="{{$user->id}}"
                @if (session('recipient') && session('recipient')->id == $user->id)
                    {{'selected'}}
                @endif
                >{{$user->name}}</option>
        @endforeach
    </select><br>
    <textarea name="message" rows="10" cols="40">{{session('message') ?: ''}}</textarea><br>
    <input type="submit" name="submit" value="Send">
</form>
