<div class="row justify-content-center">
    <div class="col-md-8">
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
                        <div class="form-group row">
                            <label for="game_id" class="col-sm-4 col-form-label text-md-right">
                                Room Code
                            </label>
                            <div class="col-md-6">
                                <input id="game_id" type="text" class="form-control{{ $errors->has('game_id') ? ' is-invalid' : '' }}"
                                       name="game_id" value="{{ old('game_id') }}" placeholder="Game Room Code (ex. THELOUDCREW)"
                                       required autofocus>

                                @if ($errors->has('game_id'))
                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('game_id') }}</strong>
                                                    </span>
                                @endif
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
    </div>
</div>