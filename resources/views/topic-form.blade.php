@extends('layouts.base')

@push('meta')
    <title>Buat Topic</title>
    <meta property="og:site_name" content="{{ env('APP_NAME') }}">
    <meta property="og:title" content="Buat Topic" />
    <meta property="og:description" content="{{ env('APP_NAME') ?? "" }}" />
    <meta property="og:image" itemprop="image" content="{{ env('APP_IMAGE') ?? "/assets/images/bi.png" }}">
    <meta property="og:type" content="website" />
    <meta property="og:updated_time" content="{{ time() }}" />
@endpush
@section('contents')

<section class="section padding-bottom-0 cust-bg" style="min-height: 50em;">

    <div class="container padding-bottom-80 padding-top-80">

        <div class="left-text">

            <div class="card" style="border-radius: 20px;">
                <div class="card-body" style="padding: 20px; padding-left: 50px; padding-right: 50px;">
                    <h5>Create Topic</h5>

                    <div class="mt-4"></div>

                    <form action="{{ route('topic.create.store') }}" method="post">
                        @csrf
                        @if (isset($topic))
                            @method("PUT")
                            <input type="hidden" name="id" value="{{ $topic->id }}">
                        @endif

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ $topic->title ?? "" }}" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Berlaku Hingga</label>
                            <div class="row">
                                <div class="col">
                                    <input type="date" class="form-control" name="exp_date" value="{{ ($topic->expired_at)? substr($topic->expired_at, 0, 10) : "" }}" required>
                                </div>
                                <div class="col">
                                    <input type="time" class="form-control" name="exp_time" value="{{ ($topic->expired_at)? substr($topic->expired_at, 11, 5) : "" }}" required>
                                </div>
                            </div>
                        </div>

                        @auth
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">Umum</option>
                                @foreach ($categories as $item)
                                    @if (isset($topic) && $topic->group_id == $item->id)
                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        @endauth

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="15" required>{!! $topic->body ?? "" !!}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary pull-right">Publish</button>
                    </form>
                </div>
            </div>
        </div>


    </div>
</section>
<!-- ***** Features Big Item End ***** -->
@endsection

@push('js')
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('content', {
          height: 260,
          width: '100%',
          removeButtons: 'PasteFromWord'
        });
    </script>
@endpush
