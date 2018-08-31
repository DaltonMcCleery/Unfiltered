@extends('wrapper')
@section('content')

    <section class="hero is-medium is-dark is-bold">
        <div class="container" align="center">

            {{-- Create a New Game --}}
            <div class="hero-body" style="padding-top: 4rem; !important">

                <div class="row">
                    {{-- Profile --}}
                    <update-profile :auth_user="'{{ Auth::user() }}'"></update-profile>

                    {{-- Stats --}}
                    <div class="col-md-4">
                        <div class="card">
                            <header class="card-header">
                                <p class="card-header-title is-centered">
                                    My Game Stats
                                </p>
                            </header>
                            <div class="card-content">
                                <div class="content">

                                    {{-- Games Won --}}
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">
                                            Games Won:
                                        </label>
                                        <div class="col-md-6">
                                            {{ isset($stats->games_won) ? $stats->games_won : '0' }}
                                        </div>
                                    </div>

                                    <hr>

                                    {{-- Likes --}}
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">
                                            Likes: <br><small style="color: orangered;">(coming soon)</small>
                                        </label>
                                        <div class="col-md-6">
                                            {{ isset($stats->likes) ? $stats->likes : '0' }}
                                        </div>
                                    </div>

                                    <hr>

                                    {{-- Dislikes --}}
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">
                                            Dislikes: <br><small style="color: orangered;">(coming soon)</small>
                                        </label>
                                        <div class="col-md-6">
                                            {{ isset($stats->dislikes) ? $stats->dislikes : '0' }}
                                        </div>
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