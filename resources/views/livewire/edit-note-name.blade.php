<div>
    @if($show == false)
    <h2 wire:click="$set('show', true)">{{ $current_note_name}}{{ svg('gmdi-edit') }}</h2>
    @endif
    @if($show)
        <form action="/" method="get">
        <input type="hidden" name="note" value="{{$current_note_id}}">
        <input type="text" name="note_name" value="{{$current_note_name}}">
        <input type="submit" value="Save">
        </form>
    @endif
</div>
