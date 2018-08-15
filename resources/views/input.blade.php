<!-- Temporary view to check if sending chat messages works -->
<form method="post" action="/chat">
    {{csrf_field()}}

    <select name="chat_partner">
        @foreach ($users as $user)
            <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach
    </select><br>
    <textarea name="message" rows="10" cols="40"></textarea><br>
    <input type="submit" name="submit" value="Send">
</form>
