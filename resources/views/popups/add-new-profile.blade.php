
<div class="modal fade" id="addNewProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Profile Name</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form method="post" action="/add-new-profile">
                @csrf
                <input type="text" name="profile_name" value="">
                <input class="btn btn-primary"type="submit">
            </form>

        </div>
      </div>
    </div>
  </div>