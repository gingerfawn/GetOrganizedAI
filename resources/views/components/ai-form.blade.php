<div>
<form action="/" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    <div>
        <label for="chat">Chat</label>
        <textarea name="chat" value="" class="chatBox"></textarea>
        <input type="hidden" name="note" value="@isset($current_note){{$current_note->id}}@endisset">
    </div>
    <div>
        <input type="submit" value="Submit">
    </div>
</form>

<div>

    @isset($history)
    @foreach($history as $chat_history)
        <div>{!! $chat_history->chat!!}</div>
        <div>{{$chat_history->is_AI_resp}}</div>
    @endforeach
    @endisset

</div>

<div>
@include('components.ai-form-footer')
</div>
</div>
