@extends('layouts.base')
@push('meta')
    <title>List Group</title>
    <meta property="og:site_name" content="{{ env('APP_NAME') }}">
    <meta property="og:title" content="List Group" />
    <meta property="og:description" content="{{ env('APP_NAME') ?? "" }}" />
    <meta property="og:image" itemprop="image" content="{{ env('APP_IMAGE') ?? "/assets/images/bi.png" }}">
    <meta property="og:type" content="website" />
    <meta property="og:updated_time" content="{{ time() }}" />
@endpush
@section('contents')

<section class="section padding-bottom-0 cust-bg" style="min-height: 50em;">

    <div class="container padding-bottom-80">
        <div class="row" style="margin-top: 100px;">
            <div class="col-12">
                @if (session('error'))
                    @include('components.client.alert', ['msg' => session('error'), 'type'=> 'danger'])
                @endif
                @if (session('success'))
                    @include('components.client.alert', ['msg' => session('success'), 'type'=> 'success'])
                @endif
            </div>

                @foreach ($groups as $item)
                    <!-- ***** Features Small Item Start ***** -->
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a class="features-small-item" href="{{ (auth()->check()) ? route('group.posts', $item->id) : "javascript:masukGroup('".route('group.posts', $item->id)."')" }}">
                            <h3 class="features-title mt-3" style="font-weight: bolder;font-size:24px;">{{ $item->name }}</h3>
                        </a>
                    </div>
                    <!-- ***** Features Small Item End ***** -->
                @endforeach

                @if (auth()->check())
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a class="features-small-item" href="#" data-toggle="modal" data-target="#join">
                            <h3 class="features-title mt-3" style="font-weight: bolder;font-size:24px;">[ <span style="font-size: 20px !important;">Join Grup</span> ]</h3>
                        </a>
                    </div>
                @endif

        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Enter Passcode</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" method="get">
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" name="passcode" placeholder="Eg. CDX6723">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  @if (auth()->check())

    <!-- Modal -->
    <div class="modal fade" id="join" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Group Passcode</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ route('group.join') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="invite_code" placeholder="Eg. CDX6723">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Request Join</button>
                </div>
            </form>
        </div>
        </div>
    </div>
  @endif
@endsection
@push('js')
    <script>
        function masukGroup(url) {
            $('#confirmation form').attr('action', url);
            $('#confirmation').modal('show');

        }
    </script>
@endpush
