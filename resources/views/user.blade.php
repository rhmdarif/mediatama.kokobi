@extends('layouts.base')
@section('contents')


<section class="section padding-bottom-0 cust-bg" style="min-height: 50em;">

    <div class="container padding-bottom-80 padding-top-80">
        <div class="features-small-item">
            <div class="icon">
                <i><img src="assets/images/featured-item-01.png" alt=""></i>
            </div>
            <h5 class="features-title">{{ auth()->user()->name }}</h5>
            <p>Customize anything in this template to fit your website needs</p>

            <center>
                <table class="table table-borderless mt-4 text-left" style="width: 250px;">
                    {{-- <tr>
                        <th>No. Telp</th>
                        <td>081234567</td>
                    </tr> --}}
                    <tr>
                        <th>Email</th>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                    {{-- <tr>
                        <th>Pendidikan</th>
                        <td>081234567</td>
                    </tr> --}}
                </table>
            </center>
        </div>

        <div class="card p-4 mb-4">
            <div class="card-body">
                <h5 class="card-title">Ganti Password</h5>
                <div class="form-group">
                    <label for="password">Password Sekarang</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="new_password">Password Baru</label>
                    <input type="password" name="new_password" id="new_password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Ulang Password Baru</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Ganti Password</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 m-2">
                <div class="row">
                    <div class="col">
                        <h3>Last Topic</h3>
                    </div>
                </div>
            </div>
            <div class="col-12">
                @foreach ($latest_topics as $item)
                    @php
                        $time_explode = explode(':', $item->selisih);

                        list($h, $i, $s) = $time_explode;
                    @endphp
                    <a href="/t/{{ date("Y", strtotime($item->created_at)) }}{{ $item->id }}-{{ str_replace('+', '-', urlencode($item->title))  }}" class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-4 align-self-center text-center text-black"
                                    style="color: black !important;">
                                    <h3 class="mb-4 ml-1">{{ (int)$h > 0? (((int)$h / 24) >= 1 ? floor((int)$h/24).'h '.((((int)$h/24) - floor((int)$h/24))*24).'j ': (int) $h.'j ' ) : '' }} {{ (int) $i }}m</h3>
                                    <span class="text-black">left to launch</span>
                                </div>
                                <div class="col-lg-10 col-md-9 col-8 align-self-center mobile-top-fix">
                                    <div class="left-heading mt-4">
                                        <h2 class="section-title" style="margin-bottom:10px;">{{ $item->title }}</h2>
                                    </div>
                                    <div class="left-text pr-1">
                                        {{-- @dd(strlen($item->body)) --}}
                                        @if (strlen($item->body) >= 250)
                                            {{ firstwords_2($item->body, 250) }}
                                        @else
                                            {{ $item->body }}
                                        @endif
                                        {{-- <p>{{ (strlen($item->body) > 5)? (substr($item->body, strrpos(substr($item->body, 0, 5), ' ')).".....") : $item->body }}</p> --}}
                                    </div>
                                    <div class="mr-2" style="padding-bottom: 2em;">
                                        <ul style="display: flex !important;" class="pull-right">
                                            <li class="mr-4" >
                                                <img src="assets/images/like.png" width="20" alt="Softy Pinko" />

                                                {{ $item->jumlah_like ?? 0 }}
                                            </li>
                                            <li class="mr-4" >
                                                <img src="assets/images/dislike.png" width="20" alt="Softy Pinko" />

                                                {{ $item->jumlah_dislike ?? 0 }}
                                            </li>
                                            <li>
                                                <img src="assets/images/share.png" width="20" alt="Softy Pinko" />

                                                {{ $item->share_count ?? 0 }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

                <div class="mt-2 pull-right">
                    {{ $latest_topics->links() }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="hr"></div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Features Big Item End ***** -->

@endsection
