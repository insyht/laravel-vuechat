<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/app.js') }}" defer></script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<style>
    .chatmessage .timestamp {
        color: grey;
    }
    .chatmessage .sender {
        color: black;
    }
    .chatmessage .body {
        color: blue;
        display        : inline-block;
        vertical-align : top;
    }

    table {
        width: 50%;
    }

</style>

<div id="app">
        <div class="container-fluid" id="chatmessages">
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
        <table>
            <tr>
                <td>
                    <input type="text" class="form-control " name="message">{{session('message') ?: ''}}</input>
                </td>
                <td>
                    <input type="submit" name="submit" value="Send" class="btn btn-default">
                </td>
            </tr>
        </table>


    </form>
</div>
