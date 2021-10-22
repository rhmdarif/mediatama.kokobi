@extends('layouts.auth')
@section('contents')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-6 d-none d-lg-block" style="background: url({{ asset('assets/images/login.png') }});background-position: center;background-size: cover;"></div>
            <div class="col-lg-6">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                    </div>
                    @include('components.validation-errors')
                    <form class="user" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="name" name="name" value="{{ old('name') ?? '' }}" class="form-control form-control-user"
                                id="exampleInputName" aria-describedby="nameHelp"
                                placeholder="Name">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" value="{{ old('email') ?? '' }}" class="form-control form-control-user"
                                id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control form-control-user"
                                id="exampleInputPassword" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="password_confirmation" name="password_confirmation" class="form-control form-control-user"
                                id="exampleInputPassword" placeholder="Confirm Password">
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Register
                        </button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{ route('login') }}">Login in here!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
