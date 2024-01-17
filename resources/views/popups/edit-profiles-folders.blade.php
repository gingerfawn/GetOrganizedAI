
<div class="modal fade" id="editProfilesFolders" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit or Delete Profiles or Folders</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/edit-delete-profiles-folders" method="post">
                @csrf
            <div style="display: grid; grid-template-columns: 2fr 2fr 1fr">
            <div>Name</div><div>Edit</div><div>Delete</div>
            @foreach($profiles as $profile)
                    <div>{{$profile->name}}</div><input type="text" name="edit-profile-{{$profile->id}}"><div><input type="checkbox" name="delete-profile-{{$profile->id}}"></div>
                @foreach($folders as $folder)
                  @if($folder->profile_id == $profile->id)
                    <div>{{$folder->name}}</div><div><input type="text" name="edit-folder-{{$folder->id}}"></div><div><input type="checkbox" name="delete-folder-{{$folder->id}}"></div>
                  @endif
                @endforeach
            @endforeach
            </div>
            <input type="submit" value="submit">
            </form>
        </div>
      </div>
    </div>
  </div>