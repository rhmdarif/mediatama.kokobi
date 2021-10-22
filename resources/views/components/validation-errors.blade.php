@if ($errors->any())
    <div class="alert alert-danger">
        <strong>
            {{ __('Whoops! ') }}
        </strong>

        {{ $errors->first() }}
    </div>
@endif
