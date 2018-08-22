<!doctype html>
<html lang="{{ app()->getLocale() }}">

    @include('layout.header')

    <body>
        <div id="app">
            <nav class="navbar is-dark">
                <div class="navbar-brand">
                    <a class="navbar-item" href="{{ url('/') }}">
                        <span class="icon is-medium">
                            <i class="fas fa-exclamation-circle"></i>
                        </span>
                        UNFILTERED NINJAS
                    </a>
                    <div class="navbar-burger burger" data-target="navbar">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <div id="navbar" class="navbar-menu">
                    <div class="navbar-start">
                        <a class="navbar-item" href="{{ url('/how-to-play') }}">
                            How to Play
                        </a>
                    </div>

                    <div class="navbar-end">
                        @guest
                            <a class="navbar-item" href="{{ url('/login') }}">
                                Login
                            </a>
                            <div class="navbar-item">
                                <a class="button is-rounded" href="{{ url('/register') }}">
                                    Sign up
                                </a>
                            </div>
                        @else
                            <a class="navbar-item" href="{{ url('/logout') }}">
                                Logout
                            </a>
                            <div class="navbar-item">
                                <a class="button is-rounded" href="{{ url('/my-profile') }}">
                                    My Profile
                                </a>
                            </div>
                        @endguest
                    </div>
                </div>
            </nav>

            @include('layout.flash_messages')

            @yield('content')

        </div>

        @include('layout.footer')
    </body>
</html>
