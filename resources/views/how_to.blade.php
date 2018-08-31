@extends('wrapper')
@section('content')

    <section class="hero is-medium is-bold">
        <div class="container">
            <div class="hero-body" style="padding-top: 4rem; !important">

                <div class="row">
                <!-- Menu -->
                <div class="col-md-4">
                    <aside class="menu">

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
                    <div id="game-rules">
                        <h4 class="subtitle"><b>Game Rules</b></h4>
                    </div>
                    <br>

                    {{-- Creating a Game --}}
                    <div id="creating-game">
                        <h4 class="subtitle"><b>Creating a Game</b></h4>
                    </div>
                    <br>

                    {{-- Game Codes --}}
                    <div id="codes">
                        <h4 class="subtitle"><b>Game/Room Codes</b></h4>
                    </div>
                    <br>

                    {{-- Public/Private Games --}}
                    <div id="games">
                        <h4 class="subtitle"><b>Public Games</b></h4>

                        <br>

                        <h4 class="subtitle"><b>Private Games</b></h4>
                    </div>
                    <br>

                    {{-- Game Lobby --}}
                    <div id="lobby">
                        <h4 class="subtitle"><b>Game Lobby</b></h4>
                    </div>
                    <br>

                    {{-- Profile --}}
                    <div id="profile">
                        <h4 class="subtitle"><b>Ninja Profiles</b></h4>
                    </div>
                    <br>

                    {{-- Profile Updates --}}
                    <div id="update-profile">
                        <h4 class="subtitle"><b>Updating your Ninja Profile</b></h4>
                    </div>
                    <br>

                    {{-- Reports --}}
                    <div id="reporting">
                        <h4 class="subtitle"><b>Reporting a User</b></h4>
                    </div>
                    <br>

                </div>

            </div>

            </div>
        </div>
    </section>

@endsection