@extends('wrapper')
@section('content')
    <section class="hero is-medium is-dark is-bold">
        <div class="hero-body">
            <div class="container" align="center">
                <h2 class="subtitle">
                    <span class="icon is-medium">
                        <i class="fas fa-exclamation-circle"></i>
                    </span>
                    AVAILABLE GAMES
                </h2>
                <br>
                <available-games></available-games>
            </div>
        </div>
    </section>
@endsection