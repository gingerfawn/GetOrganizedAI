<div class="ai-form-footer">
<div class="tos-container">
<a href="/terms-of-service">Terms of Service</a> |
<a href="/privacy-policy">Privacy Policy</a>
</div>
@if(trim($current_note) != '')
<form action="/delete-note" method="post">
    @csrf
    <input type="hidden" name="note_id" value="@if($current_note != ""){{$current_note->id}}@endif">
    <button class="crud-icon" type="submit"> {{ svg('fas-trash') }} </button>
</form>
@endif
</div>