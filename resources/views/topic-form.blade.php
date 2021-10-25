@extends('layouts.base')

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

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Berlaku Hingga</label>
                            <div class="row">
                                <div class="col">
                                    <input type="date" class="form-control" name="exp_date" required>
                                </div>
                                <div class="col">
                                    <input type="time" class="form-control" name="exp_time" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" {{ request()->get('category') == $item->id ? "selected" : "" }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="15" required></textarea>
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
