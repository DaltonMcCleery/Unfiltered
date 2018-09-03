<!doctype html>
<html lang="{{ app()->getLocale() }}">

    @include('admin.layout.header')

    <body class="skin-default-dark fixed-layout">

        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Elite admin</p>
            </div>
        </div>

        <div id="app">

            @include('admin.layout.topbar')
            @include('admin.layout.sidebar')
            @yield('content')

        </div>

        @include('admin.layout.footer')
    </body>
</html>