
<!-- Modal -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
            <div class="modal-body">
                @csrf
                @method('DELETE')
                Apakah anda yakin ingin menghapus group ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Tidak</button>
                <button type="submit" class="btn btn-primary">Yakin</button>
            </div>
        </form>
      </div>
    </div>
  </div>
