
<div x-data="{ visible: false }"  class="add-new-container">  
    <div x-show="visible" x-transition:enter="transition-fade-in-up" x-transition:leave="transition-fade-out-down" class="add-edit-container">
            <div>
                <a class="icon-small" href="/">{{ svg('ri-add-fill') }}New Note</a>
            </div>
          
            <div>
                <a class="icon-small" data-bs-toggle="modal" data-bs-target="#addNewFolder">{{ svg('ri-add-fill') }}New Folder</a>
            </div>
          
            <div>
                <a class="icon-small" data-bs-toggle="modal" data-bs-target="#addNewProfile">{{ svg('ri-add-fill') }} New Profile</a>
            </div>
          
            <div>
                <a class="icon-small" data-bs-toggle="modal" data-bs-target="#editProfilesFolders">{{ svg('gmdi-edit') }}Profiles & Folders</a>
            </div>
    </div>
    <button @click="visible = !visible" class="add-new-button">{{ svg('ri-add-fill') }} Add or Edit</button>

  </div>