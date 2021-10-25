@if (isset($msg) && isset($type))
    <div class="alert alert-{{ $type }}">
        <strong>{{ $type == "success"? "Yeahh!" : "Oops!" }} </strong> {{ $msg ?? "" }}
    </div>
@endif
