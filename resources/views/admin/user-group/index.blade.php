@extends('admin.components.base')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Group {{ $group->name ?? "" }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Groups</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- PIE CHART -->
            <div class="card">
              <div class="card-header">
                  <button type="button" class="btn btn-primary" onclick="openAddUserModal('{{ route('admin.group.user.not_join', $group->id) }}')">Tambah Peserta</button>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                @include('admin.components.alert-danger')
                @include('admin.components.alert-success')
                <h5>Pending Users</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">#</th>
                                <th>Nama</th>
                                <th width="15%">Tgl. Request</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($datas->where('status', 'pending') as $item)
                              <tr>
                                  <td>{{ $i++ }}</td>
                                  <td>{{ $item->name }}</td>
                                  <td>{{ $item->created_at ?? '' }}</td>
                                  <td>

                                    <button type="button" class="btn btn-success btn-sm p-1" onclick="request('{{ route('admin.group.user.accept', ['group_id' => $item->group_id, 'id' => $item->id]) }}', 'Terima permintaan dari pengguna?', 'Proses dibatalkan')">Accept</button>
                                    <button type="button" class="btn btn-danger btn-sm p-1" onclick="request('{{ route('admin.group.user.decline', ['group_id' => $item->group_id, 'id' => $item->id]) }}', 'Tolak permintaan dari pengguna?', 'Proses dibatalkan')">Decline</button>
                                  </td>
                              </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <h5>Users</h5>
                  <div class="table-responsive">
                      <table class="table table-bordered">
                          <thead class="text-center">
                              <tr>
                                  <th width="5%">#</th>
                                  <th>Nama</th>
                                  <th width="15%">Aksi</th>
                              </tr>
                          </thead>

                          <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($datas->where('status', 'active') as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm p-1" onclick="request('{{ route('admin.group.user.decline', ['group_id' => $item->group_id, 'id' => $item->id]) }}', 'Apakah anda yakin ingin menghapus orang ini dari grup?', 'Hapus pengguna dibatalkan')">Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @include('admin.user-group.modal-addUser', ['group' => $group])
@endsection
@push('js')
    <script>
        function  openAddUserModal(url) {
            let param = "";
            if($('#modalAddUser input[name=name]').val() != "") {
                param += "?name="+$('#modalAddUser input[name=name]').val();
            }
            $.get(url+param, (result) => {
                $('#modalAddUser tbody').html("");
                let rows = "";
                result.forEach(item => {
                    rows += `<tr>
                                <td class="text-center">
                                    <input type="checkbox" name="id[]" value="${item.id}">
                                </td>
                                <td>${item.name}</td>
                            </tr>`
                });
                $('#modalAddUser tbody').html(rows);


                $('#modalAddUser').modal('show');
            })
        }
        function  openDeleteModal(id) {
            $.get("{{ route('admin.group.index') }}/"+id, (result) => {
                if(result.length != 0) {
                    $('#modalDelete form').attr('action', "{{ route('admin.group.index') }}/"+id);
                    $('#modalDelete').modal('show');
                }
            })
        }

        function request(url, msg, cancel_msg) {
            let con = confirm(msg);

            if(con) {
                $.get(url, (response) => {
                    alert(response.msg)
                    location.reload();
                })
            } else {
                alert(cancel_msg)
            }
        }
    </script>
@endpush
