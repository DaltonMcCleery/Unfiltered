@extends('wrapper')
@section('content')
    <section class="hero is-medium is-dark is-bold">
        <div class="container" align="center">

            {{-- Create a New Game --}}
            <div class="hero-body">
                <h2 class="subtitle">
                    <span class="icon is-medium">
                        <i class="fas fa-plus-circle"></i>
                    </span>
                    CREATE A GAME
                </h2>
                @include('game.create')

                <br><br>

                {{-- Available Public Games --}}
                <h2 class="subtitle">
                    <span class="icon is-medium">
                        <i class="fas fa-users"></i>
                    </span>
                    PUBLIC GAMES
                </h2>
                <available-games :authed_user_id = {{ Auth::user()->id }}></available-games>
            </div>
        </div>
    </section>
@endsection