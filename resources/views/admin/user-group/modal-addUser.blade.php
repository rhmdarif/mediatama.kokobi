
<!-- Modal -->
<div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Peserta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.group.user.not_join', $group->id) }}" method="post">
            <div class="modal-body">
                @csrf
                @method('POST')


                <div class="form-group">
                    <label for="name">Nama Pengguna</label>
                    <input type="text" class="form-control" name="name" id="name" onkeyup="openAddUserModal('{{ route('admin.group.user.not_join', $group->id) }}')">
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody style="max-height : 300px;overflow-y: auto;"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
