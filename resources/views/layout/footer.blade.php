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
@yield('additional-scripts')