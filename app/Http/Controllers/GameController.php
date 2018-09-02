<?php

namespace App\Http\Controllers;

use App\Events\answerQuestion;
use App\Events\closeLobby;
use App\Events\kickPlayer;
use App\Events\lobbyChat;
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
     * Post a Message in the Lobby's Chat
     *
     * @param Request $request
     */
    public function chat(Request $request) {
        broadcast(new lobbyChat($request->session_id, $request->username, $request->message));
    }

    /**
     * Kick a Player from the Lobby Channel
     *
     * @param Request $request
     */
    public function kickLobbyPlayer(Request $request) {
        // Broadcast to all players in Lobby to go to the Game page
        broadcast(new kickPlayer($request->username, $request->session_id));
    }

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
     * Close a current Game Lobby and Game
     *
     * @param Request $request
     */
    public function closeLobby(Request $request) {
        broadcast(new closeLobby($request->session_id));
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
