<div class="popup add-new-folder">
    <div class="modal-header">
        <div>Add New Folder</div>
        <div class="close" onclick="closePopup()">{{ svg('ri-close-fill') }}</div>
    </div>
    <div>
        {{$current_profile->id}}
        <form method="post" action="/add-new-folder">
            @csrf
            <label for="folder_name">Folder Name</label>
            <input type="text" name="folder_name" value=""/>
            <input type="submit">
        </form>
    </div> 
</div>