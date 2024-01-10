<div>
    @include('components.AIFormNav')
    @isset($history)
        @foreach($history as $chat_history)
            <div>{{$chat_history['message']}}</div>
            <div>{{$chat_history['role']}}</div>
        @endforeach
    @endisset
    @isset($chat)
        <div>
            {{$chat}}
        </div>
    @endisset
    @isset($gemini_response)
        <div>
            {{$gemini_response}}
        </div>
    @endisset
</div>

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


