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

                {{-- Max Sessions --}}
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Players</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control">
                                <input id="max_sessions" type="number" min="3" max="7" placeholder="Number of Players (Min 3 and Max 7)"
                                       class="input form-control{{ $errors->has('max_sessions') ? ' is-invalid' : '' }}"
                                       name="max_sessions" required>
                            </p>
                            @if ($errors->has('max_sessions'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('max_sessions') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Game Type --}}
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Game Type</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control">
                                <select id="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                        name="type" required>
                                    <option value="public" selected>Public Game</option>
                                    <option value="private">Private Game</option>
                                </select>
                            </p>
                            @if ($errors->has('type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>
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