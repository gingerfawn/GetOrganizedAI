<div>
<form action="/" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    <div>
        <textarea name="chat" value="" class="chatBox"></textarea>
        <input type="hidden" name="note" value="@if($current_note != ""){{$current_note->id}}@endif">
    </div>
    <div>
        <input type="submit" value="Ask" class="gemini_submit">
    </div>
</form>

<div class="scroll-history">

    @if($history != "")
    @foreach($history as $chat_history)
    @if($chat_history->is_AI_resp == 'user')
        <div>{{ $chat_history->chat }}</div>
        <div>{{$chat_history->is_AI_resp}}</div>
    @else 
        <div>{!! $chat_history->chat!!}</div>
        <div>{{$chat_history->is_AI_resp}}</div>
    @endif
    @endforeach
    @endif

</div>

<div class="chat-footer">
@include('components.ai-form-footer')
</div>
</div>
