<template>

    <div id="play_game">

        <!-- Match Winner -->
        <section class="hero is-medium is-success is-bold" v-if="match_winner">
            <div class="hero-body" align="center">
                <div class="container">
                    <h2 class="title">
                        "{{ match_winner }}" is the Winner!
                    </h2>
                    <div v-if="timerObject">
                        <br><br>
                        <nav class="level is-mobile">
                            <div class="level-item has-text-centered">
                                <div>
                                    <p class="heading">Lobby closes in</p>
                                    <p class="title">{{ timer }} seconds...</p>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- Game is in Progress -->
        <div v-else>

            <!-- Round Question -->
            <section class="hero is-small is-info is-bold">
                <div class="hero-body">

                    <!-- Submitting a Question -->
                    <div class="container" v-if="question_ninja === current_ninja">
                        <div v-if="postedQuestion === null">
                            <h2 class="title">
                                You are writing the Question!
                            </h2>
                            <!-- Question Form -->
                            <form method="post" @submit.prevent="postQuestion">
                                <fieldset>
                                    <b-field label="Your Question">
                                        <b-input maxlength="200" type="textarea" v-model="question"
                                                 placeholder="Write out a funny, witty, or outrageous question for your fellow Ninjas to answer!">

                                        </b-input>
                                    </b-field>
                                    <button type="submit" class="button is-medium is-success">Submit Question</button>
                                </fieldset>
                            </form>
                        </div>

                        <!-- Display new Question -->
                        <div v-else>
                            <h1 class="title">
                                {{ question }}
                            </h1>
                            <h2 class="subtitle">
                                "{{ question_ninja }}"
                            </h2>
                        </div>
                    </div>

                    <!-- Waiting/View submitted Question from someone else -->
                    <div class="container" v-else>
                        <h1 class="title">
                            {{ question }}
                        </h1>
                        <h2 class="subtitle">
                            "{{ question_ninja }}"
                        </h2>
                    </div>

                    <div v-if="timerObject">
                        <br><br>
                        <nav class="level is-mobile">
                            <div class="level-item has-text-centered">
                                <div>
                                    <p class="heading">Time Remaing</p>
                                    <p class="title">{{ timer }} seconds...</p>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </section>

            <!-- Round Winner -->
            <section class="hero is-light is-bold" v-if="round_winner">
                <div class="hero-body">
                    <div class="container">
                        <h1 class="title">
                            Round Winner: "{{ round_winner }}"
                        </h1>
                    </div>
                </div>
            </section>

            <!-- Errors -->
            <section class="hero is-danger" v-if="error">
                <div class="hero-body">
                    <div class="container">
                        <h2 class="title">
                            {{ error }}
                        </h2>
                    </div>
                </div>
            </section>

            <!-- Answers -->
            <section class="hero is-dark is-bold">
                <div class="hero-body">

                    <!-- Player Cards -->
                    <div class="columns container is-fluid" v-if="roundOver">
                        <div class="column" v-for="answer in answers">
                            <div class="card">
                                <header class="card-header">
                                    <p class="card-header-title" v-if="showAnswers">
                                        {{ answer.username }}
                                    </p>
                                </header>
                                <div class="card-content">
                                    <div class="content">
                                        {{ answer.answer }}
                                    </div>
                                </div>
                                <footer class="card-footer" v-if="!showAnswers">
                                    <div v-if="question_ninja === current_ninja">
                                        <a @click="selectWinner(answer.username)" class="card-footer-item button is-success">
                                            Select as Winner
                                        </a>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>

                    <!-- waiting for answers -->
                    <div class="container" align="center" v-else>
                        <!-- Question Ninja is waiting for answers -->
                        <div v-if="question_ninja === current_ninja">
                            <div v-if="!question">
                                <b-message type="is-info" has-icon>
                                    Waiting on All Ninja's to answer...
                                </b-message>
                            </div>
                        </div>
                        <!-- Other Ninja who has answered and waiting for all other Ninjas -->
                        <div v-else>
                            <div v-if="!canAnswer">
                                <b-message type="is-info" has-icon>
                                    Waiting on All Ninja's to answer...
                                </b-message>
                            </div>
                        </div>
                    </div>

                    <!-- Answering a Question -->
                    <div class="container" v-if="question_ninja !== current_ninja">
                        <br>
                        <div v-if="canAnswer">
                            <!-- Answer Form -->
                            <form method="post" @submit.prevent="answerQuestion">
                                <fieldset>
                                    <b-field label="Your Answer">
                                        <b-input maxlength="200" type="textarea" v-model="answer"
                                                 placeholder="Write an unfiltered and hilarious answer to your Question Ninja!">
                                        </b-input>
                                    </b-field>
                                    <button type="submit" class="button is-medium is-success">Submit Answer</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        <!-- Lobby List -->
        <section class="hero is-dark is-bold">
            <div class="hero-body">
                <hr>
                <nav class="panel is-dark container">
                    <p class="panel-heading">
                        {{ count }} Users in Game
                    </p>
                    <div class="panel-block" v-for="user in users">
                        <span v-if="current_ninja === user.username" style="color: deepskyblue;">
                            "{{ user.username }}" (You)
                        </span>
                        <span v-else style="color: white;">
                            "{{ user.username }}"
                        </span>
                    </div>
                    <div class="panel-block">
                        <a @click="leaveGame" class="button is-danger is-outlined is-medium is-fullwidth">
                            Leave Lobby
                        </a>
                    </div>
                </nav>
            </div>
        </section>

    </div>

</template>

<script>
    export default {
        data() {
            return {
                // Game Users
                count: 0,
                users: [],
                lobby_game: {},
                // Game Settings
                rounds_won: 0,
                round_winner: null,
                match_winner: null,
                error: null,
                // Game Timers
                timerObject: null,
                timer: 90,
                // Game Question
                question: null,
                postedQuestion: null,
                question_ninja: null,
                // Game Answers
                answer: null,
                roundOver: false,
                showAnswers: false,
                canAnswer: false,
                answers: [],
                // API Endpoint
                endpoint: "/api/game/"
            };
        },

        props: {
            current_ninja: String,
            game: String
        },

        // Initialize Game Settings and Event Listeners
        created() {
            this.lobby_game = JSON.parse(this.game);

            // Outside access to Vue Data and Props
            let env = this;
            Echo.join('lobby.'+this.lobby_game.session_id)
                .here((users) => {
                    // Loop through all current Lobby Users and display them for the newest User
                    users.forEach(function(user, index) {
                        env.users.push({
                            id: user.id,
                            username: user.username
                        });

                        env.count = env.count + 1;
                    });

                })
                .joining((user) => {
                    env.users.push({
                        username: user.username
                    });

                    env.count = env.count + 1;
                })
                .leaving((user) => {
                    // Player has decided to leave the game
                    this.users = _.remove(this.users, function(lobby_user) {
                        return lobby_user.username !== user.username;
                    });
                    this.count = this.count - 1;

                    if (this.count === 0) {
                        // Destroy Game
                        axios.post(this.endpoint+'destroy-game', {
                            session_id: this.lobby_game.session_id
                        });
                    }
                })
                .listen('newQuestionNinja', (data) => {
                    this.newQuestionNinja(data.username);
                })
                .listen('newQuestion', (data) => {
                    this.newQuestion(data.question)
                })
                .listen('answerQuestion', (data) => {
                    this.answers.push({
                        username: data.username,
                        answer: data.answer
                    });

                    if (this.answers.length === (this.count - 1) ) {
                        // All Users in the Lobby (except Question Ninja) have answered,
                        // prompt Question Ninja to pick a Round Winner
                        this.pickWinner()
                    }
                })
                .listen('roundWinner', (data) => {
                    this.roundWinner(data.user)
                })
                .listen('matchWinner', (data) => {
                    this.matchWinner(data.user)
                });

            this.start();
        },

        // Leave Lobby Event Channel before the Vue Component is destroyed
        beforeDestroy() {
            Echo.leave('lobby.'+this.lobby_game.session_id);
            this.leaveGame();
        },

        methods: {
            // Initialize Game and starting Question Ninja
            start() {
                // Pick which User goes First (Host)
                this.question_ninja = this.lobby_game.host.username;
                this.error = null;

                // Initialize and Start the Game
                if (this.question_ninja === this.current_ninja) {
                    // Person Asking the Question
                    this.postedQuestion = null;
                } else {
                    // Wait for Question to be submitted
                    this.question = 'Waiting on "'+this.question_ninja+'" to write a Question...';
                }

                // Start Question Timer
                let env = this;
                this.timerObject = setInterval(function () {
                    env.handleTimer('question')
                }, 1000);
            },

            // Handle Timer countdowns for Answering Questions or finishing the Game
            handleTimer(type) {
                this.timer = this.timer - 1;

                if (this.timer <= 0) {
                    // Times up!
                    if (type === 'game') {
                        this.pickWinner();
                    } else if (type === 'question') {
                        this.postQuestion();
                    } else { // type === 'exit'
                        // Close Lobby and redirect All players to the homepage
                        clearInterval(this.timerObject);
                        this.timerObject = null;
                        this.leaveGame();
                    }
                }
            },

            // Leave the Game
            leaveGame() {
                // User is leaving the Game
                let env = this;
                this.users = _.remove(this.users, function(lobby_user) {
                    return lobby_user.username !== env.current_ninja;
                });

                this.count = this.count - 1;

                // Check if Last User left
                if (this.count === 0) {
                    // Destroy Lobby/Session
                    axios.post(this.endpoint+'destroy-game', {
                        session_id: this.lobby_game.session_id
                    });
                }

                // Check if the User who left was the Question Ninja
                if (this.current_ninja === this.question_ninja) {
                    // Pick another User in the Lobby to be the Question Ninja and restart the round
                    let new_user = (this.users[0]).username;

                    // Send a round reset message to rest of the Game Lobby with the new round's Question Ninja
                    axios.post(this.endpoint+'new-question-ninja', {
                        session_id: this.lobby_game.session_id,
                        username: new_user
                    });
                }

                // Redirect to Find Game page
                window.location.href = '/play';
            },

            // Question Ninja submits a new Question
            postQuestion() {
                // Disable the Question Ninja's Form
                this.postedQuestion = this.question;
                this.error = null;

                // Send Request to update other player's games
                axios.post(this.endpoint+'post-question', {
                        question: this.question,
                        session_id: this.lobby_game.session_id
                    })
                    .then(({data}) => {
                        // Wait for Event to be Broadcast
                        // ---> New Question
                    });
            },

            // (BROADCAST METHOD) A New Question has been submitted by the Question Ninja
            newQuestion(question) {
                // Stop Question Timer
                clearInterval(this.timerObject);
                this.timerObject = null;
                this.error = null;

                if (this.question_ninja !== this.current_ninja) {
                    // Question Ninja submitted a Question
                    this.question = question;
                    this.canAnswer = true;
                }

                // Start Answer Timer
                this.timer = 90;
                let env = this;
                this.timerObject = setInterval(function () {
                    env.handleTimer('game')
                }, 1000);
            },

            // Post your Answer to the submitted Question
            answerQuestion() {
                // Send Request to update other player's games
                axios.post(this.endpoint+'post-answer', {
                        answer: this.answer,
                        username: this.current_ninja,
                        session_id: this.lobby_game.session_id
                    })
                    .then(({data}) => {
                        // Hide Input form
                        this.canAnswer = false;
                    });
            },

            // Question Ninja must pick a winning Ninja's Answer for the round
            pickWinner() {
                // Stop Answer Timer
                clearInterval(this.timerObject);
                this.timerObject = null;

                // Show JUST Ninja Answers (no Usernames)
                this.roundOver = true;
            },

            // Question Ninja has picked which Answer they like the most
            selectWinner(username) {
                // Send Request to update other player's games
                axios.post(this.endpoint+'round-winner', {
                        username: username,
                        session_id: this.lobby_game.session_id
                    })
                    .then(({data}) => {
                        // Wait for Broadcast Event
                        // ---> Round Winner
                    });
            },

            // (BROADCAST METHOD) Question Ninja left, picked New Question Ninja
            newQuestionNinja(username) {
                // Clear Timer and show all Answers
                clearInterval(this.timerObject);
                this.timerObject = null;

                // Display message to Game Lobby
                this.error = 'Player has left, picking a new Ninja to ask a Question';

                // Wait for a few seconds then continue on to the next Round
                let env = this;
                setTimeout(function () {
                    env.startNextRound(username);
                }, 5000);
            },

            // (BROADCAST METHOD) Display the Round's Winner
            roundWinner(username) {
                // Clear Timer and show all Answers
                clearInterval(this.timerObject);
                this.timerObject = null;
                this.showAnswers = true;

                // Display Round Winner to everyone
                this.round_winner = username;
                this.error = null;

                // Check if the Round Winner is the current Authed Ninja
                if (username === this.current_ninja) {
                    // If it is, their Round Won total goes up by 1 (3 to win)
                    this.rounds_won = this.rounds_won + 1;
                }

                // Wait for a few seconds then continue on to the next Round
                let env = this;
                setTimeout(function () {
                    env.startNextRound(username);
                }, 5000);
            },

            // Switch Question Ninjas
            startNextRound(username) {
                // Check if User has won 3 rounds
                if (this.rounds_won === 3) {
                    axios.post(this.endpoint+'match-winner', {
                            username: username,
                            session_id: this.lobby_game.session_id
                        })
                        .then(({data}) => {
                            // Wait for Broadcast Event
                            // ---> Match Winner
                        });
                }

                // Reset Round Settings (Clear Answers and Question)
                this.answers = [];
                this.question_ninja = username;
                this.question = null;
                this.postedQuestion = null;
                this.answer = null;
                this.roundOver = false;
                this.showAnswers = false;
                this.canAnswer = false;
                this.round_winner = null;

                // Winner of Round becomes the Question Ninja
                if (this.question_ninja === this.current_ninja) {
                    // Person Asking the Question
                    this.postedQuestion = null;
                } else {
                    // Wait for Question to be submitted
                    this.question = 'Waiting on "'+this.question_ninja+'" to write a Question...';
                }

                // Start the next Question Timer
                this.timer = 90;
                let env = this;
                this.timerObject = setInterval(function () {
                    env.handleTimer('question')
                }, 1000);
            },

            // (BROADCAST METHOD) Select a Ninja as the Match Winner
            matchWinner(username) {
                // Display Winner
                this.match_winner = username;
                this.error = null;

                // Stop any Timer
                clearInterval(this.timerObject);

                // Start Exit Timer
                this.timer = 100;
                let env = this;
                this.timerObject = setInterval(function() { env.handleTimer('exit') }, 1000);
            }
        }
    };
</script>