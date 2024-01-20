
<div x-data="{ visible: false }"  class="add-new-container">  
    <div x-show="visible" x-transition:enter="transition-fade-in-up" x-transition:leave="transition-fade-out-down">
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
    <button @click="visible = !visible" class="add-new-button">{{ svg('ri-add-fill') }} Add New</button>

  </div>