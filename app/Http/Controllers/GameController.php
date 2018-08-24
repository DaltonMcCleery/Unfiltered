<?php

namespace App\Http\Controllers;

use App\Events\answerQuestion;
use App\Events\startGame;
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
            ->where('session_id', $session_id);

        if ($game->exists()) {
            // Get Game settings
            $game = $game->first();

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
        } else {
            // No Game found
            return redirect('/play')->with('error', 'That game is full or invalid!');
        }
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
     * Try to join a Game set to Private by Room Code (Game ID)
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function joinPrivateGame(Request $request) {
        // Get DB Query ready
        $game = Games::where('game_id', $request->game_id);

        if ($game->exists()) {
            // Try to join
            $session_id = $game->value('session_id');
            return $this->lobby($session_id);
        } else {
            // Game cannot be found
            return redirect('/play')->with('error', 'Cannot find a Game with that Room Code!');
        }
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

        if ($game->current_sessions <= $game->max_sessions) {
            if (Auth::user()->username === $game->Host->username) {
                // Host starting Game
                Games::where('id', $game->id)
                    ->update([
                        'status' => 1
                    ]);

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

    // ---> GAME

    /**
     * Send out the Start Game Event to the Lobby Channel
     *
     * @param Request $request
     */
    public function startGame(Request $request) {
        // Broadcast to all players in Lobby to go to the Game page
        broadcast(new startGame(Auth::user(), $request->session_id));
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

        // Update the Winning Ninja's stats
        //todo
    }

    /**
     * Remove a given Game from Database
     *
     * @param Request $request
     */
    public function closeGame(Request $request) {
        Games::where('session_id', $request->session_id)->delete();
    }

}
