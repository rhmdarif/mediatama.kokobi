@extends('layouts.base')
@push('meta')
    <title>Topic in Trending</title>
    <meta property="og:site_name" content="{{ env('APP_NAME') }}">
    <meta property="og:title" content="Tranding in {{ date("F") }}" />
    <meta property="og:description" content="{{ env('APP_DESCRIPTION') ?? "" }}" />
    <meta property="og:image" itemprop="image" content="{{ env('APP_IMAGE') ?? "/assets/images/bi.png" }}">
    <meta property="og:type" content="website" />
    <meta property="og:updated_time" content="{{ time() }}" />
@endpush
@push('css')

<script>
    function countDown(elementId, expired) {
        console.log(elementId);
        // Set the date we're counting down to
        var countDownDate = new Date(expired).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            let show = "";
            if(days > 0)
                show +=  days + "d ";
            if(hours > 0)
                show +=  hours + "h ";
            if(minutes > 0)
                show +=  minutes + "m ";

            show +=  seconds + "s ";

            document.getElementById(elementId).innerHTML = show;

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById(elementId).innerHTML = "EXPIRED";
            }
        }, 1000);
    }
</script>
@endpush
@section('contents')

<section class="section padding-bottom-0 cust-bg" style="min-height: 50em;">

    <div class="container padding-bottom-80">
        <div class="row" style="margin-top: 100px;">
            <div class="col-12">

                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col">
                                <h3>Tranding in {{ date("F") }}</h3>
                            </div>
                            @auth
                                <div class="col">
                                    <a href="{{ route('topic.create.index') }}" class="pull-right main-button-slider">Buat Kolom</a>
                                </div>
                            @endauth
                        </div>
                        <div class="row mt-3">

                            <div class="col-12">
                                @foreach ($tranding_topics as $item)
                                    @php
                                        $time_explode = explode(':', $item->selisih);

                                        list($h, $i, $s) = $time_explode;
                                    @endphp
                                    <a href="/t/{{ date("Y", strtotime($item->created_at)) }}{{ $item->id }}-{{ str_replace('+', '-', urlencode($item->title))  }}" class="card mb-3">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-3 col-4 align-self-center text-center text-black p-2"
                                                        style="color: black !important;padding-left:10px;">
                                                        @if ($item->status == "active")
                                                            <script> countDown('h3_{{ $item->id }}', '{{ $item->expired_at }}') </script>
                                                            <h4 class="mb-4" id="h3_{{ $item->id }}"></h4>
                                                            <span class="text-black">to expired</span>
                                                        @else
                                                            <h3 class="mb-4">Expired</h3>
                                                            <span class="text-black">at
                                                                @if (substr($item->expired_at, 0, 10) == date("Y-m-d"))
                                                                    {{ trim(substr($item->expired_at, 10)) }}
                                                                @else
                                                                    {{ date("d M Y H:i:s", strtotime($item->expired_at)) }}
                                                                @endif
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-10 col-md-9 col-8 align-self-center mobile-top-fix">
                                                        <div class="left-heading mt-4">
                                                            <h2 class="section-title" style="margin-bottom:10px;">{{ $item->title }}</h2>
                                                        </div>
                                                        <div class="left-text pr-1">
                                                            {{-- @dd(strlen($item->body)) --}}
                                                            @if (strlen($item->body) >= 250)
                                                                {!! firstwords_2(strip_tags($item->body), 250) !!}
                                                            @else
                                                                {!! strip_tags($item->body) !!}
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
                                                                <li class="mr-4" >
                                                                    <img src="assets/images/comment.png" width="20" alt="Softy Pinko" />

                                                                    {{ $item->jumlah_comment ?? 0 }}
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
                                        </div>
                                    </a>
                                @endforeach

                                <div class="mt-2 pull-right">
                                    {{ $tranding_topics->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
