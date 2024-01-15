<div class="ai-form-footer">
<form action="/delete_form">
    @csrf
    <input type="hidden" name="note_id" value="@if($current_note != ""){{$current_note->id}}@endif">
    <button class="crud-icon" type="submit"> {{ svg('fas-trash') }} </button>
</form>
</div>