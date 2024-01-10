<div class="popup add-new-profile">
    <div class="modal-header">
        <div>Add New Profile</div>
        <div class="close" onclick="closePopup()">{{ svg('ri-close-fill') }}</div>
    </div>
    <div>
        <form method="post" action="/add-new-profile">
            @csrf
            <label for="profile_name">Profile Name</label>
            <input type="text" name="profile_name" value="">
            <input type="submit">
        </form>
    </div>
</div>