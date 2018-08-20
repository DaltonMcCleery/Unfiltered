@extends('wrapper')
@section('content')
    <section class="hero is-medium is-dark is-bold">
        <div class="hero-body">
            <div class="container" align="center">
                <h1 class="title">
                    <span class="icon is-medium">
                        <i class="fas fa-exclamation-circle"></i>
                    </span>
                    UNFILTERED
                </h1>
                <h2 class="subtitle">
                    The hilarious, say-anything-you-want party game!
                    <br><br>
                    <div class="buttons is-centered">
                        <a class="button is-info is-outlined" href="{{ url('/how-to-play') }}">How to Play</a>
                        <a class="button is-success" href="{{ url('/play') }}">Play Now</a>
                    </div>
                </h2>

                <br><br>

                <div class="tile is-ancestor">
                    <div class="tile is-parent">
                        <article class="tile is-child box">
                            <p class="title" style="color: black;">No Censorship</p>
                            <div class="content">
                                <p>
                                    This is truly a unfiltered party game, where no word shall be censored
                                </p>
                            </div>
                        </article>
                    </div>
                    <div class="tile is-parent">
                        <article class="tile is-child box">
                            <p class="title" style="color: black;">No Boundaries</p>
                            <div class="content">
                                <p>
                                    No subject matter or topics are off limits here
                                </p>
                            </div>
                        </article>
                    </div>
                    <div class="tile is-parent">
                        <article class="tile is-child box">
                            <p class="title" style="color: black;">No Hard Feelings?</p>
                            <div class="content">
                                <p>
                                    Be aware; someone is going to say something you're not going to like
                                </p>
                            </div>
                        </article>
                    </div>
                </div>

                <br><br>

                <h2 class="subtitle">
                    That being said, we do take personal threats and attacks on Users very seriously.
                    <br>
                    Please report a User <a href="{{ url('/report') }}"><b>here</b></a>
                </h2>

            </div>
        </div>
    </section>

    </div>

@endsection