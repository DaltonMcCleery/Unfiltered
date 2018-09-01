<div class="card">
    <header class="card-header">
        <p class="card-header-title is-centered">
            Join a Private Game
        </p>
    </header>
    <div class="card-content">
        <div class="content">
            <form method="POST" action="{{ route('join.game') }}">
                @csrf

                {{-- Game Code --}}
                {{-- Game ID--}}
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Room Code</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control">
                                <input id="game_id" type="text" class="input form-control{{ $errors->has('game_id') ? ' is-invalid' : '' }}"
                                       name="game_id" value="{{ old('game_id') }}" placeholder="Game/Room Code (ex. THELOUDCREW)"
                                       required autofocus>
                            </p>
                            @if ($errors->has('game_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('game_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="button is-success">
                        Join Game
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>