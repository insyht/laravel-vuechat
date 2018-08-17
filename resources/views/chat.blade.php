<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/app.js') }}" defer></script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/chat.css') }}" rel="stylesheet">
<div id="app" class="chat">
    <div class="chatmessages-container">
        <chat></chat>
    </div>

    <br><br>

    <sendmessage token="{{csrf_token()}}" defaultmessage="{{session('message') ?: ''}}"></sendmessage>
</div>
