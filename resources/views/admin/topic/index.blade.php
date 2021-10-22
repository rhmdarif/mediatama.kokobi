@extends('admin.components.base')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
                @if (isset($user) || isset($group))
                    @if (isset($user))
                        <h1>Topics By {{ $user->name }}</h1>
                    @endif

                    @if (isset($group))
                        <h1>Topics about {{ $group->name }}</h1>
                    @endif
                @else
                        <h1>Topics</h1>
                @endif

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Topics</li>
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
              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table table-bordered">
                          <thead class="text-center">
                              <tr>
                                  <th width="5%" rowspan="2">#</th>
                                  <th rowspan="2">Judul</th>
                                  @if (isset($group))
                                    <th rowspan="2" width="10%">Group</th>
                                  @endif
                                  @if (isset($user))
                                    <th rowspan="2" width="10%">Penulis</th>
                                  @endif
                                  <th width="20%" colspan="2">Jumlah</th>
                                  <th rowspan="2">Posted At</th>
                                  <th width="15%" rowspan="2">Aksi</th>
                              </tr>
                              <tr>
                                  <th width="10%">Like</th>
                                  <th>Comment</th>
                              </tr>
                          </thead>

                          <tbody>
                              @php
                                  $i = 1;
                              @endphp
                              @foreach ($topics as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->title }}</td>
                                    @if (isset($group))
                                        <td>{{ $item->group_name }}</td>
                                    @endif
                                    @if (isset($user))
                                        <td>{{ $item->user_name }}</td>
                                    @endif
                                    <td>{{ $item->total_likes }}</td>
                                    <td>{{ $item->total_comments }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <div class="btn-group">
                                          <a href="{{ route('admin.topic.index') }}/{{ date("Y", strtotime($item->created_at)) }}{{ $item->id }}-{{ str_replace('+', '-', urlencode($item->title))  }}" class="btn btn-default">Lihat Detail</a>
                                          <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                          </button>
                                          <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Separated link</a>
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
@endsection
