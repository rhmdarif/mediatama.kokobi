@extends('layouts.base')

@push('meta')
    <title>{{ $topic->title ?? "" }}</title>
    <meta property="og:site_name" content="{{ env('APP_NAME') }}">
    <meta property="og:title" content="{{ $topic->title ?? "" }}" />
    <meta property="og:description" content="{{ substr(strip_tags($topic->body), 0, 100) }}" />
    <meta property="og:image" itemprop="image" content="{{ env('APP_IMAGE') ?? "/assets/images/bi.png" }}">

    <!-- Size of image. Any size up to 300. Anything above 300px will not work in WhatsApp -->
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta property="og:type" content="website" />
    <meta property="og:updated_time" content="{{ strtotime($topic->created_at) }}" />
@endpush

@section('contents')

<section class="section padding-bottom-0 cust-bg" style="min-height: 50em;">

    <div class="container padding-bottom-80 padding-top-80">

        <div class="left-text">

            <div class="card" style="border-radius: 20px;">
                <div class="card-body" style="padding: 20px;">

                    <h2 class="text-center mb-4">{{ $topic->title ?? "" }}</h2>
                    <h6 class="mb-4">Grup : {{ $topic->group_name }}</h6>
                    <style>
                        .content ul, .content li {
                            list-style-type: disc;
                            margin-left: 1rem !important;
                        }
                    </style>
                    <div class="content">
                        {!! $topic->body !!}
                    </div>
                    <div>
                        <span class="text-left">
                            <img src="{{ url('/') }}/assets/images/clock.png" width="20" alt="Suka" />
                            {{ date("d/m/y H:i", strtotime($topic->created_at)) }}
                        </span>
                        <ul style="display: flex !important;" class="pull-right">
                            <li class="mr-4" >
                                <a  onclick="like()">
                                    <img src="{{ url('/') }}/assets/images/like.png" width="20" alt="Tidak Suka" />
                                </a>

                                {{ $topic->jumlah_like }}
                            </li>
                            <li class="mr-4" >
                                <img src="{{ url('/') }}/assets/images/dislike.png" width="20" alt="Tidak Suka" onclick="dislike()" />

                                {{ $topic->jumlah_dislike }}
                            </li>
                            <li class="mr-4">
                                <a href="http://wa.me?text={{ url()->current() }}" target="_blank">
                                    <img src="{{ url('/') }}/assets/images/wa.png" onclick="share()" width="20" alt="Share" />

                                    {{ $topic->share_count ?? 0  }}
                                </a>
                            </li>
                            <li>
                                <img src="{{ url('/') }}/assets/images/copy.png" onclick="copyUrl()" width="20" alt="Copy" />
                            </li>
                        </ul>
                    </div>
                    <br>

                    <!-- User -->
                    <h5>Author</h5>
                    <div class="team-item mt-1 pt-4" style="margin-bottom: 3em;">
                        <div class="team-content">
                            <div class="user-image">
                                <img src="http://placehold.it/60x60" alt="">
                            </div>
                            <div class="team-info">
                                <h3 class="user-name m-2">{{ $topic->user_name }}</h3>
                                {{-- <span>Managing Director</span> --}}
                            </div>
                        </div>
                    </div>


                    <!-- Article -->
                    <style>
                        .team-item {
                            margin-bottom: 10px;
                        }
                    </style>
                    <h4 class="mb-3">
                        <i><img src="assets/images/testimonial-icon.png" alt=""></i> Komentar
                    </h4>
                    <div class="team-item p-4">
                        <form action="{{ route('topic.comment.store', $url) }}" method="post">
                            @csrf
                            <input type="hidden" name="topic" value="{{ $topic->id }}">
                            <input type="hidden" name="device_id" id="device_id">
                            <div class="form-group">
                                <!-- <label for="komentar">Komentar</label> -->
                                <textarea name="comment" id="comment" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-rounded btn-primary pull-right">Kirim</button>
                        </form>
                        <br>
                    </div>
                    @foreach ($topic_comments as $comment)
                        <div class="team-item">
                            <div class="team-content">
                                <style>
                                    .team-item .team-content p {
                                        margin-top: unset;
                                        padding-left: unset;
                                        padding-right: unset;
                                        margin-bottom: unset;
                                        font-weight: unset;
                                        font-size: unset;
                                        color: unset;
                                        letter-spacing: unset;
                                        line-height: unset;
                                    }
                                    .team-item .team-content ul, .team-item .team-content li {
                                        margin: unset;
                                        margin-left: 1em;
                                        list-style: square;
                                    }

                                </style>
                                <img class="pull-right m-3 {{ $comment->device_id }}" onclick="deleteComment({{ $comment->id }})" style="display:none;bottom: 0;" src="http://mediatamaforum.test/assets/images/trash.png" data-clipboard-text="Just because you can doesn't mean you should — clipboard.js" width="20" alt="Dibagikan">

                                <div style="margin-top: 25px;
                                padding-left: 25px;
                                padding-right: 25px;
                                margin-bottom: 25px;
                                font-weight: 400;
                                font-size: 15px;
                                color: #777;
                                letter-spacing: 0.6px;
                                line-height: 26px;">
                                    {{ $comment->comment }}
                                </div>

                                <div class="team-info">
                                    <span>At
                                        @if (substr($comment->created_at, 0, 10) == date("Y-m-d"))
                                            {{ trim(substr($comment->created_at, 10)) }}
                                        @else
                                            {{ $comment->created_at }}
                                        @endif</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>


    </div>
</section>
<!-- ***** Features Big Item End ***** -->
@endsection

@push('js')
    <script src="{{ url('/') }}/plugins/imprintjs/dist/imprint.min.js"></script>
    <script type="text/javascript">
        var DeviceID = "";
        var browserTests = [
            "audio",
            "availableScreenResolution",
            "canvas",
            "colorDepth",
            "cookies",
            "cpuClass",
            "deviceDpi",
            "doNotTrack",
            "indexedDb",
            "installedFonts",
            "language",
            "localStorage",
            "pixelRatio",
            "platform",
            "plugins",
            "processorCores",
            "screenResolution",
            "sessionStorage",
            "timezoneOffset",
            "touchSupport",
            "userAgent",
            "webGl"
        ];

        imprint.test(browserTests).then(function(result){
          console.log(result);

            DeviceID = result;
            $('#device_id').val(result);
            console.log(DeviceID);
            $(`.${ DeviceID }`).show();
        });

        function like() {
            $.post("{{ route('topic.like.store') }}", {_token: "{{ csrf_token() }}", topic:"{{ $topic->id }}", device_id:DeviceID, type:1 }, (result) => {
                console.log(result);
                alert("Topic telah di sukai");
                location.reload();
            });
        }

        function dislike() {
            $.post("{{ route('topic.like.store') }}", {_token: "{{ csrf_token() }}", topic:"{{ $topic->id }}", device_id:DeviceID, type:0 }, (result) => {
                alert("Topic telah di tidak sukai");
                location.reload();
            });
        }

        function share() {
            $.post("{{ route('topic.share.store') }}", {_token: "{{ csrf_token() }}", topic:"{{ $topic->id }}", device_id:DeviceID }, (result) => {
                console.log(result);
            });
        }

    </script>

@endpush
@push('js')

    <script>

        function copyUrl() {
            console.log("copy")
            var dummy = document.createElement('input'),
                text = window.location.href;

            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);

            alert("URL telah disalin")
        }

        function deleteComment(id) {
            let con = confirm("Apakah anda yakin menghapus komentar ini?");

            if(con) {
                $.post("{{ route('topic.comment.destroy') }}", {_token: "{{ csrf_token() }}", device_id:DeviceID, comment_id:id}, (result) => {
                    if(result.status) {
                        alert("[Berhasil] "+result.msg);
                        location.reload();
                    } else {
                        alert("[Gagal] "+result.msg);
                    }
                });
            }
        }
    </script>
@endpush
