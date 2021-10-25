
<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Group</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="passcode">Pass Code</label>
                    <input type="text" class="form-control" name="passcode" id="passcode">
                </div>
                <div class="form-group">
                    <label for="invite_code">Invite Code</label>
                    <input type="text" class="form-control" name="invite_code" id="invite_code">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
