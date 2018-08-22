@if(Session::has('success'))
    <article class="notification is-success" style="margin-bottom: 0rem; !important">
        <div class="media">
            <div class="media-left">
                <span class="icon is-large">
                    <i class="mdi mdi-check-circle mdi-48px"></i>
                </span>
            </div>
            <div class="media-content">
                {{ Session::get('success') }}
            </div>
        </div>
    </article>
@elseif (Session::has('info'))
    <article class="notification is-info" style="margin-bottom: 0rem; !important">
        <div class="media">
            <div class="media-left">
                <span class="icon is-large">
                    <i class="mdi mdi-information mdi-48px"></i>
                </span>
            </div>
            <div class="media-content">
                {{ Session::get('info') }}
            </div>
        </div>
    </article>
@elseif (Session::has('warn'))
    <article class="notification is-warning" style="margin-bottom: 0rem; !important">
        <div class="media">
            <div class="media-left">
                <span class="icon is-large">
                    <i class="mdi mdi-alert mdi-48px"></i>
                </span>
            </div>
            <div class="media-content">
                {{ Session::get('warn') }}
            </div>
        </div>
    </article>
@elseif (Session::has('error'))
    <article class="notification is-danger" style="margin-bottom: 0rem; !important">
        <div class="media">
            <div class="media-left">
                <span class="icon is-large">
                    <i class="mdi mdi-alert-circle mdi-48px"></i>
                </span>
            </div>
            <div class="media-content">
                {{ Session::get('error') }}
            </div>
        </div>
    </article>
@elseif (Session::has('general'))
    <article class="notification" style="margin-bottom: 0rem; !important">
        <div class="media">
            <div class="media-left">
                <span class="icon is-large">
                    <i class="mdi mdi-information mdi-48px"></i>
                </span>
            </div>
            <div class="media-content">
                {{ Session::get('general') }}
            </div>
        </div>
    </article>
@else
@endif