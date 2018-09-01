@extends('wrapper')
@section('content')

    <section class="hero is-medium is-bold">
        <div class="container">
            <div class="hero-body" style="padding-top: 4rem; !important">

                <div class="row">
                <!-- Menu -->
                <div class="col-md-4">
                    <aside id="how-to-menu" class="menu">

                        <!-- Game Rules -->
                        <p class="menu-label">
                            Playing the Game
                        </p>
                        <ul class="menu-list">
                            <li><a href="#game-rules" class="is-active">Rules</a></li>
                        </ul>

                        <!-- Lobbies -->
                        <p class="menu-label">
                            Finding & Setting up a Game
                        </p>
                        <ul class="menu-list">
                            <li><a href="#creating-game">Creating a Game</a></li>
                            <li><a href="#codes">Game/Room Codes</a></li>
                            <li><a href="#games">Public/Private Games</a></li>
                            <li><a href="#lobby">Lobby</a></li>
                        </ul>

                        <!-- Profiles -->
                        <p class="menu-label">
                            Ninja Profiles
                        </p>
                        <ul class="menu-list">
                            <li><a href="#profile">Creating an Account</a></li>
                            <li><a href="#update-profile">Updating Details</a></li>
                        </ul>

                        <!-- Reporting -->
                        <p class="menu-label">
                            Complaints & Reports
                        </p>
                        <ul class="menu-list">
                            <li><a href="#reporting">Reporting a User</a></li>
                        </ul>
                    </aside>
                    <hr>
                </div>

                <!-- Content -->
                <div class="col-md-8">
                    {{-- Game Rules --}}
                    <div id="game-rules" class="content">
                        <h4 class="subtitle"><b>Game Rules</b></h4>
                        <p>
                            The main parts of playing the Unfiltered Ninjas game are:
                        </p>
                        <ul>
                            <li>Question Ninja</li>
                            <li>Answer Time</li>
                            <li>Picking a Round Winner</li>
                        </ul>
                        <p>
                            The Game will start by selecting a <b>Question Ninja</b>. The Question Ninja will have a set
                            amount of time to write out a open-ended question for all of the other Ninja's in the game
                            to answer (Don't write yes/no questions - those suck).
                        </p>
                        <p>
                            Once the Question Ninja has submitted their question to the other Ninjas, they will have a set
                            amount of time to write the funniest, edgy, obscure, and <em>unfiltered</em> answer possible to the question.
                        </p>
                        <p>
                            Once all Ninjas have posted their Answer, or the timer has ran out, the Question Ninja will be
                            shown all of the Answers (sorted randomly) <b>without</b> showing them who wrote the Answer!
                        </p>
                        <p>
                            The Question Ninja will then pick which Answer they thought was the best or the funniest; whichever
                            Ninja wrote that Answer will be awarded 1 point! The Ninja who was selected as the round winner
                            will then become the Question Ninja for the next round.
                        </p>
                        <p>
                            First Ninja to win 3 rounds wins the entire Game!
                        </p>
                    </div>
                    <br>

                    {{-- Creating a Game --}}
                    <div id="creating-game" class="content">
                        <h4 class="subtitle"><b>Creating a Game</b></h4>
                        <p>
                            Navigate to the <a href="{{ url('/play') }}">Games List page</a>; once there, you will see the
                            <b>Create a New Game</b> form at the top. All you need is a creative Game/Room code (make it an inside joke between you and your enemies),
                            set the number of players you want in your game (minimum of 3 players and maximum of 7), and
                            then decide whether you want your game open to the public (like your mom) or private (I don't have a good joke for that one...)
                        </p>
                        <p>
                            You can read more about Game/Room codes and Public vs Private games below!
                        </p>
                    </div>
                    <br>

                    {{-- Game Codes --}}
                    <div id="codes" class="content">
                        <h4 class="subtitle"><b>Game/Room Codes</b></h4>
                        <p>
                            Game or "Room" codes allow your friends to find your game much faster and easier.
                            If you create a new game (Public or Private), send the Game/Room code to your friends and they'll
                            be able to search for your game and join instantly versus having to scroll through a list of other games.
                        </p>
                        <p>
                            <b>For Private Games</b> this is the only way to join. If the game type is set to private,
                            only those who know your Game/Room code will be able to join your game, so don't give it to uncle Steve.
                        </p>
                    </div>
                    <br>

                    {{-- Public/Private Games --}}
                    <div id="games" class="content">
                        <h4 class="subtitle"><b>Public Games</b></h4>
                        <p>
                            Games that are created with the type set to Public will be displayed for anybody to join;
                            no Game/Room code required! If you aren't afraid to play with like-minded, fool-mouthed strangers,
                            then set up or join a Public game and make some new enemies!
                        </p>
                        <br>
                        <h4 class="subtitle"><b>Private Games</b></h4>
                        <p>
                            Different from Public games, Private games will <b>not</b> be displayed in the Find a Game page.
                            The <b>only way</b> to find or join a Private game is to search for it via the Game/Room code (see above).
                        </p>
                        <p>
                            Set up a Private game if you want a nice, family-friendly experience with no strangers interrupting
                            the flow of your game!
                        </p>
                    </div>
                    <br>

                    {{-- Game Lobby --}}
                    <div id="lobby" class="content">
                        <h4 class="subtitle"><b>Game Lobby</b></h4>
                        <p>
                            Once you create a new game, you will automatically join the Game's Lobby. If you create the game,
                            you will be the Game's Master; which means you have some big responsibilities buttercup. The Game's Master
                            has access to Kick players out of the Lobby and to Start the Game. <b>Only</b> the Game Master can start
                            the game when they are good and ready, so don't rush them.
                        </p>
                        <p>
                            Everyone else who joins your game will be placed in the Lobby with you, but they won't be
                            able to do anything but wait. Once the Game's Master is satisfied with the player's in the
                            Lobby, he/she/it will Start the Game!
                        </p>
                    </div>
                    <br>

                    {{-- Profile --}}
                    <div id="profile" class="content">
                        <h4 class="subtitle"><b>Ninja Profiles</b></h4>
                        <p>
                            In order to play, you will need to <b>Create an Account.</b> It's super simple, click the
                            "Sign up" button in the top menu of any page (yep, even this one) and fill out your Ninja Profile
                            information.
                        </p>
                        <p>
                            You'll need to input your actual name, a cool Username (how everyone will see you in Games and Lobbies),
                            any old email address (you'll use this to login), and a super-secret password.
                        </p>
                        <p>
                            Once you have an account, you'll be able to create games, join Public/Private games, and view
                            your Ninja Profile which has your in-game statistics (like how many games you've won).
                        </p>
                    </div>
                    <br>

                    {{-- Profile Updates --}}
                    <div id="update-profile" class="content">
                        <h4 class="subtitle"><b>Updating your Ninja Profile</b></h4>
                        <p>
                            Once you're logged in, you can access your Profile page by clicked the "My Profile" button
                            in the top menu (in the same place you used to create an Account, dumby).
                        </p>
                        <p>
                            From here, you can change your Profile name, username, email address, or change your Profile
                            password - it's really straight forward.
                        </p>
                    </div>
                    <br>

                    {{-- Reports --}}
                    <div id="reporting" class="content">
                        <h4 class="subtitle"><b>Reporting a User</b></h4>
                        <p>
                            Although the purpose of these games is to provide an unfiltered experience of madness and comedy,
                            sometimes people do take things a little to far - and for that you can
                            <a href="{{ url('/report') }}">Report a User</a>.
                        </p>
                        <p>
                            For example, if someone is threatening you, cyber-bullying, making death threats, things of that nature
                            - please report them. We review all reports and will take action when necessary.
                        </p>
                    </div>
                    <br>

                </div>

            </div>

            </div>
        </div>
    </section>

@endsection