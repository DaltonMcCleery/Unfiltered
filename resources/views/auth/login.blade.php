@extends('wrapper')

@section('content')

    <section class="hero is-medium is-dark is-bold">
        <div class="hero-body">

            <div class="container" align="center">
                <h1 class="title">
                    <span class="icon is-medium">
                        <i class="fas fa-exclamation-circle"></i>
                    </span>
                    UNFILTERED NINJAS
                </h1>
            </div>

            <br><br>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <header class="card-header">
                                <p class="card-header-title is-centered">
                                    Login to your existing Ninja Account
                                </p>
                            </header>
                            <div class="card-content">
                                <div class="content">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        {{-- EMAIL --}}
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-4 col-form-label text-md-right">
                                                Email Address
                                            </label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                       name="email" value="{{ old('email') }}" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- PASSWORD --}}
                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">
                                                Password
                                            </label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                       name="password" required>

                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="button is-success">
                                                    Login
                                                </button>

                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    Forgot Your Password?
                                                </a>

                                                <br><br>

                                                <a href="{{ route('register') }}">
                                                    Register to become a Ninja
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
