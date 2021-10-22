@extends('layouts.base')
@section('contents')

<section class="section padding-bottom-0 cust-bg" style="min-height: 50em;">

    <div class="container padding-bottom-80">
        <div class="row" style="margin-top: 100px;">
                @foreach ($groups as $item)
                    <!-- ***** Features Small Item Start ***** -->
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a class="features-small-item" href="{{ route('group.posts', strtolower(str_replace('+', '-', urlencode($item->name)))) }}">
                            <h3 class="features-title mt-3" style="font-weight: bolder;font-size:24px;">{{ $item->name }}</h3>
                        </a>
                    </div>
                    <!-- ***** Features Small Item End ***** -->
                @endforeach

        </div>
    </div>
</section>
@endsection
