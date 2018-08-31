@extends('wrapper')
@section('content')

    <section class="hero is-medium is-dark is-bold">
        <div class="container" align="center">
            <div class="hero-body" style="padding-top: 4rem; !important">
                <report-user :user_id="'{{ Auth::user()->id }}'"></report-user>
            </div>
        </div>
    </section>

@endsection