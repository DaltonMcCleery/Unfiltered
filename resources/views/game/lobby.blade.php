@extends('wrapper')
@section('content')
    <section class="hero is-medium is-dark is-bold">
        <div class="container" align="center">

            <div class="hero-body">
                <h2 class="subtitle">
                    <span class="icon is-medium">
                        <i class="fas fa-address-card"></i>
                    </span>
                    GAME LOBBY
                </h2>
                <lobby :current_ninja = "'{{ Auth::user()->username }}'" :game = "'{{ $game }}'"></lobby>
            </div>
        </div>
    </section>
@endsection