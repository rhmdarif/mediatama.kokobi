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
                                  <th>Nama</th>
                                  <th>No. Telp</th>
                                  <th width="30%">Jumlah Kiriman</th>
                                  <th width="20%">Aksi</th>
                              </tr>
                          </thead>

                          <tbody>
                              @php
                                  $i = 1;
                              @endphp
                              @foreach ($users as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->total_topic }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal({{ $item->id }})">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
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

    @include('admin.group.modal-delete')
@endsection
@push('js')
    <script>
        function  openDeleteModal(id) {
            $.get("{{ route('admin.user.index') }}/"+id, (result) => {
                if(result.length != 0) {
                    $('#modalDelete form').attr('action', "{{ route('admin.user.index') }}/"+id);
                    $('#modalDelete').modal('show');
                }
            })
        }
    </script>
@endpush

