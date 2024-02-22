<div class="ai-form-footer">
<div class="tos-container">
<a href="/terms-of-service">Terms of Service</a> |
<a href="/privacy-policy">Privacy Policy</a>
</div>
@if(trim($this->note_id ) != '')
<form action="/delete-note" method="post">
    @csrf
    <input type="hidden" name="note_id" value="{{$this->note_id}}">
    <button class="crud-icon" type="submit"> {{ svg('fas-trash') }} </button>
</form>
@endif
</div>