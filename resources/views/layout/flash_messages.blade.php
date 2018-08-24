@if(Session::has('success'))
    <section class="hero is-success">
        <div class="hero-body" align="center">
            <div class="container">
                <h2 class="subtitle">
                    {{ Session::get('success') }}
                </h2>
            </div>
        </div>
    </section>
@elseif (Session::has('info'))
    <section class="hero is-info">
        <div class="hero-body" align="center">
            <div class="container">
                <h2 class="subtitle">
                    {{ Session::get('info') }}
                </h2>
            </div>
        </div>
    </section>
@elseif (Session::has('warn'))
    <section class="hero is-warning">
        <div class="hero-body" align="center">
            <div class="container">
                <h2 class="subtitle">
                    {{ Session::get('warn') }}
                </h2>
            </div>
        </div>
    </section>
@elseif (Session::has('error'))
    <section class="hero is-danger">
        <div class="hero-body" align="center">
            <div class="container">
                <h2 class="subtitle">
                    {{ Session::get('error') }}
                </h2>
            </div>
        </div>
    </section>
@elseif (Session::has('general'))
    <section class="hero">
        <div class="hero-body" align="center">
            <div class="container">
                <h2 class="subtitle">
                    {{ Session::get('general') }}
                </h2>
            </div>
        </div>
    </section>
@else
@endif