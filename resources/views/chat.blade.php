<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/app.js') }}" defer></script>

<style>
    .chatMessage {
        display : block;
    }
        .chatmessage .timestamp {
            color: grey;
        }
        .chatmessage .sender {
            color: black;
        }
        .chatmessage .body {
            color: blue;
        }

    #chatmessages {
        padding : 10px;
        border  : 1px solid black;
        width   : 50%;
    }
</style>


<div id="app">
    <div class="online_users"></div>

    <div class="" id="chatmessages">
        @if (isset($chats))
            @foreach ($chats as $chatMessage)
                <chatmessage timestamp="{{$chatMessage['timestamp']->toRfc7231String()}}" sender="{{$chatMessage['sender']->name}}">
                    {{$chatMessage['message']}}
                </chatmessage>
            @endforeach
        @endif
    </div>

    <form method="post" action="/chat">
        {{csrf_field()}}
        <textarea name="message" rows="10" cols="40">{{session('message') ?: ''}}</textarea><br>
        <input type="submit" name="submit" value="Send">
    </form>
</div>
