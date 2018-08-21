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
                                    Register to be a Ninja!
                                </p>
                            </header>
                            <div class="card-content">
                                <div class="content">
                                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                                        @csrf

                                        {{-- NAME--}}
                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">
                                                Name <span style="color:red;">*</span>
                                            </label>

                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                       name="name" value="{{ old('name') }}" required autofocus>

                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- USERNAME --}}
                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">
                                                Username <span style="color:red;">*</span>
                                            </label>

                                            <div class="col-md-6">
                                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                                       name="username" value="{{ old('username') }}" required>

                                                @if ($errors->has('username'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- EMAIL --}}
                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                                Email Address <span style="color:red;">*</span>
                                            </label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                       name="email" value="{{ old('email') }}" required>

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
                                                Password <span style="color:red;">*</span>
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

                                        {{-- CONFIRM PASSWORD --}}
                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                                                Confirm Password <span style="color:red;">*</span>
                                            </label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="button is-success">
                                                    Become a Ninja
                                                </button>

                                                <br><br>

                                                <a href="{{ route('login') }}">
                                                    Login to existing Ninja Account
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
