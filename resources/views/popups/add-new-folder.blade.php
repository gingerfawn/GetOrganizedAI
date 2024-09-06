
<div class="modal fade" id="addNewFolder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Folder Name</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form method="post" action="/add-new-folder">
                @csrf
                <input type="text" name="folder_name" value=""/>
                {{-- <input type="hidden" name="profile_id" value="{{$current_profile->id}}"> --}}
                <input type="submit" value="Submit">
            </form>

        </div>
      </div>
    </div>
  </div>