<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="site-header">
    <div class="site-header-note">
    @if($show == false && trim($this->current_note_name) != '')
    <h2 wire:click="$set('show', true)">{{ ucwords($this->current_note_name) }}{{ svg('gmdi-edit') }}</h2>
    @endif
    @if($show)
        <form wire:submit.prevent="editNoteName">
        <input type="hidden" wire:model="note_id">
        <input type="text" wire:model="current_note_name">
        <input type="submit" value="Save" wire:click="$set('show', false)">
        </form>
    @endif
    </div>
    </div>

    <form wire:submit.prevent="submitChat">
        <textarea wire:model="current_chat" type="text" class="chatBox"></textarea>
        <button type="submit" class="gemini_submit">Ask</button>
    </form>
    <div class="scroll-history">
        @isset($history)
            @foreach($history as $chat_history)
            @if($chat_history->is_AI_resp == 'user')
                <div class="card">
                <a href="/delete-chat?chat_id={{$chat_history->id}}" class="delete-chat-link">{{ svg('ri-close-fill') }}</a>
                <div class="user-chat">{!! ucfirst($chat_history->chat) !!}</div>
            @else
                <div>{!! $chat_history->chat!!}</div>
                </div>
            @endif
            @endforeach
        @endisset
    </div>
    @include('components.ai-form-footer')
</div>
