<?php

namespace App\Http\Controllers;

use App\Events\answerQuestion;
use App\Events\createGame;
use App\Events\joinLobby;
use App\Events\matchWinner;
use App\Events\newQuestion;
use App\Events\roundWinner;
use App\Games;
use App\Http\Resources\GamesResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{

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
        $game = Games::with('Host')
            ->where('session_id', $session_id)
            ->first();

        // Check if the Game has started or not
        if ($game->status === 1) {
            // Can't join game that is in progress
            return redirect('/play')->with('error', 'Cannot join a Game that is in progress!');
        }

        // Setup/Join Lobby
        broadcast(new joinLobby(Auth::user(), $session_id));
        return view('game.lobby', [
            'game' => $game
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

    /**
     * Play a Game
     *
     * @param $session_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function play($session_id) {
        $game = Games::with('Host')
            ->where('session_id', $session_id)
            ->first();

        // Check if Game exists
        //todo

        if ($game->current_sessions < $game->max_sessions) {
            if (Auth::user()->username === $game->Host->username) {
                // Host starting Game
                Games::where('id', $game->id)
                    ->update([
                        'status' => 1
                    ]);

                // Broadcast to all players in Lobby to go to the Game page
                broadcast(new createGame(Auth::user(), $session_id));

                return view('game.play', [
                    'game' => $game
                ]);

            } else {
                // Join Game
                Games::where('id', $game->id)
                    ->update([
                        'current_sessions' => $game->current_sessions + 1
                    ]);

                return view('game.play', [
                    'game' => $game
                ]);
            }

        } else {
            // Invalid Game
            return redirect('/play')->with('error', 'That game is full or invalid!');
        }

    }

    /**
     * Question Ninja has submitted a New Question to a Game
     *
     * @param Request $request
     */
    public function postQuestion(Request $request) {
        // Broadcast to all players in Lobby that a new Question has been submitted
        broadcast(new newQuestion($request->question, $request->session_id));

        // Ensure the Game Status is now "locked"
        $game = Games::where('session_id', $request->session_id);
        if ($game->value('status') !== 1) {
            $game->update(['status' => 1]);
        }
    }

    /**
     * A Ninja has answered a submitted Question
     *
     * @param Request $request
     */
    public function postAnswer(Request $request) {
        // Broadcast to all players in Lobby that a Ninja has answered a question
        broadcast(new answerQuestion($request->username, $request->answer, $request->session_id));
    }

    /**
     * Alert all Ninjas in the Game which one of them won the Round
     *
     * @param Request $request
     */
    public function decideRoundWinner(Request $request) {
        // Broadcast to all players in Lobby that a Ninja has answered a question
        broadcast(new roundWinner($request->username, $request->session_id));
    }

    /**
     * Alert all Ninjas in the Game which one of them have Won the Match
     *
     * @param Request $request
     */
    public function decideMatchWinner(Request $request) {
        // Broadcast to all players in Lobby that a Ninja has answered a question
        broadcast(new matchWinner($request->username, $request->session_id));
    }

}
