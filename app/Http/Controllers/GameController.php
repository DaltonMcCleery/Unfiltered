<?php

namespace App\Http\Controllers;

use App\Events\joinLobby;
use App\Games;
use App\Http\Resources\GamesResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ninja');
    }

    /**
     * Find or Create a New Game
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('game.find');
    }

    /**
     * Join a Game's Lobby
     *
     * @param $session_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function lobby($session_id) {
        // Get Game based on Session ID
        $game = Games::where('session_id', $session_id)->first();

        // Check if the Game has started or not
        if ($game->status === 1) {
            // Can't join game that is in progress
            return redirect('/play')->with('error', 'Cannot join a Game that is in progress!');
        }

        // Setup/Join Lobby
        broadcast(new joinLobby(Auth::user(), $session_id));
        return view('game.lobby', [
            'session_id' => $session_id
        ]);
    }

    /**
     * Create a New Game to play
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createGame(Request $request) {
        // Validate New Game request
        $data = $request->all();
        //todo

        // Randomly generate Session ID
        $session_id = str_random();

        // Create the New Game tied to the current authed User
        Games::create([
            'session_id'    => $session_id,
            'game_id'       => $data['game_id'],
            'ninja_id'      => Auth::user()->id,
            'max_sessions'  => $data['max_sessions'],
            'type'          => $data['type'],
            'status'        => 0
        ]);

        return redirect('/play/lobby/'.$session_id)->with('success', 'Your Game has been created!');
    }

    /**
     * Get the currently available Games List (Public Games)
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function find() {
        $games = Games::with('Host')
            ->where('type', 'public')
            ->whereColumn('max_sessions', '!=', 'current_sessions')
            ->where('status', 0)
            ->latest()
            ->get();

        return GamesResource::collection($games);
    }

    public function postQuestion(Request $request) {
        //
    }

    public function postAnswer(Request $request) {
        //
    }

    public function decideWinner(Request $request) {
        //
    }

}
