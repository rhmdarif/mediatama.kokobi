@extends('admin.components.base')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Group</h1>
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
                  <a class="btn btn-primary btn-sm" href="{{ route('admin.group.create') }}">Tambah Group</a>
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
                  <div class="table-responsive">
                      <table class="table table-bordered">
                          <thead class="text-center">
                              <tr>
                                  <th width="5%">#</th>
                                  <th>Nama Group</th>
                                  <th width="10%">Jumlah Kiriman</th>
                                  <th width="10%">Total Komentar</th>
                                  <th width="10%">Permintaan Bergabung</th>
                                  <th width="15%">Aksi</th>
                              </tr>
                          </thead>

                          <tbody>
                              @php
                                  $i = 1;
                              @endphp
                              @foreach ($groups as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->total_topic ?? 0 }}</td>
                                    <td>{{ $item->total_komentar ?? 0 }}</td>
                                    <td>{{ $item->total_request ?? 0 }}</td>
                                    <td>
                                        <div class="btn-group">
                                          <a href="{{ route('admin.topic.byGroup', $item->id) }}" class="btn btn-default">Lihat Kiriman</a>
                                          <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                          </button>
                                          <div class="dropdown-menu p-1" role="menu">
                                            <a class="dropdown-item" href="{{ route('admin.group.user.index', $item->id) }}">Lihat Peserta</a>
                                            <a class="dropdown-item bg-warning" href="#" onclick="openEditModal({{ $item->id }})">Edit</a>
                                            <a class="dropdown-item bg-danger" href="#" onclick="openDeleteModal({{ $item->id }})">Hapus</a>
                                          </div>
                                        </div>
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

    @include('admin.group.modal-edit')
    @include('admin.group.modal-delete')
@endsection
@push('js')
    <script>
        function  openEditModal(id) {
            $.get("{{ route('admin.group.index') }}/"+id, (result) => {
                if(result.length != 0) {
                    $('#modalEdit .modal-title').text("Edit "+ result.name);
                    $('#modalEdit input[name=name]').val(result.name);
                    $('#modalEdit input[name=passcode]').val(result.passcode);
                    $('#modalEdit input[name=invite_code]').val(result.invite_code);
                    $('#modalEdit form').attr('action', "{{ route('admin.group.index') }}/"+id);
                    $('#modalEdit').modal('show');
                }
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
    </script>
@endpush
