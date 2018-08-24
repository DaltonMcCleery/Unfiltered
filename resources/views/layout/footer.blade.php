<footer class="footer">
    <div class="content has-text-centered">
        <p>
            <strong>Unfiltered</strong> by <a href="https://daltonmccleery.business">Dalton McCleery</a>
            <br>
            Version {{ env('VERSION', '1.0.0') }}
        </p>
    </div>
</footer>

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script>
    // Navbar Menu Toggle
    $(document).ready(function() {

        // Check for click events on the navbar burger icon
        $(".navbar-burger").click(function() {

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            $(".navbar-burger").toggleClass("is-active");
            $(".navbar-menu").toggleClass("is-active");

        });
    });
</script>
@yield('additional-scripts')