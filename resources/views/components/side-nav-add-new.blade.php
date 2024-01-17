<div class="add-new-container">
<div>
    <a class="icon-small" href="/">{{ svg('ri-add-fill') }}New Note</a>
</div>

<div>
    <a class="icon-small" data-bs-toggle="modal" data-bs-target="#addNewFolder">{{ svg('ri-add-fill') }}New Folder</a>
    @include('popups.add-new-folder')
</div>

<div>
    <a class="icon-small" data-bs-toggle="modal" data-bs-target="#addNewProfile">{{ svg('ri-add-fill') }}New Profile</a>
    @include('popups.add-new-profile')
</div>

<div>
    <a class="icon-small" data-bs-toggle="modal" data-bs-target="#editProfilesFolders">{{ svg('ri-add-fill') }}Edit Profiles and Folders</a>
    @include('popups.edit-profiles-folders')
</div>
</div>