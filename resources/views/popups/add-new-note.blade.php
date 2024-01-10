<div class="popup add-new-note">
    <div class="modal-header">
        <div> Add New Note </div>
        <div class="close" onclick="closePopup()">{{ svg('ri-close-fill') }}</div>
    </div>
    <div>
        {{$folder->id}}

        <form method="post" action="/add-new-note">
            @csrf
            <label for="note_name">New Note</label>
            <input type="text" name="note_name" value="">
            <input type="submit">
        </form>
    </div>
</div>