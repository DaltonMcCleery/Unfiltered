<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title is-centered">
                    Create a New Game
                </p>
            </header>
            <div class="card-content">
                <div class="content">
                    <form method="POST" action="{{ route('create.game') }}">
                        @csrf

                        {{-- Game ID --}}
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

                        {{-- Max Sessions --}}
                        <div class="form-group row">
                            <label for="max_sessions" class="col-md-4 col-form-label text-md-right">
                                Max Player Count
                            </label>
                            <div class="col-md-6">
                                <input id="max_sessions" type="number" min="3" max="6" placeholder="Number of Players (Min 3 & Max 6)"
                                       class="form-control{{ $errors->has('max_sessions') ? ' is-invalid' : '' }}"
                                       name="max_sessions" required>

                                @if ($errors->has('max_sessions'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('max_sessions') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Game Type --}}
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">
                                Game Type
                            </label>
                            <div class="col-md-6">
                                <select id="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                        name="type" required>
                                    <option value="public" selected>Public Game</option>
                                    <option value="private">Private Game</option>
                                </select>

                                @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="button is-success">
                                Create Game
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>