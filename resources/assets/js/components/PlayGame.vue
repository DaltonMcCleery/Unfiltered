<template>

    <div id="play_game">

        <!-- Match Winner -->
        <section class="hero is-medium is-info is-bold" v-if="match_winner">
            <div class="hero-body" align="center">
                <div class="container">
                    <h2 class="title">
                        "{{ match_winner }}" is the Winner!
                    </h2>
                </div>
            </div>
        </section>

        <!-- Round Question -->
        <section class="hero is-medium is-info is-bold">
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
                            <!--<footer class="card-footer">-->
                                <!--<a href="#" class="card-footer-item">-->
                                <!--<span class="icon">-->
                                    <!--<i class="fas fa-thumbs-up"></i>-->
                                <!--</span>-->
                                    <!--Like-->
                                <!--</a>-->
                                <!--<a href="#" class="card-footer-item">-->
                                <!--<span class="icon">-->
                                    <!--<i class="fas fa-thumbs-down"></i>-->
                                <!--</span>-->
                                    <!--Dislike-->
                                <!--</a>-->
                            <!--</footer>-->
                        </div>
                    </div>
                </div>

                <!-- Question Ninja is waiting for answers -->
                <div class="container" align="center" v-else>
                    <b-message type="is-info" has-icon>
                        Waiting on All Ninja's to answer...
                    </b-message>
                </div>

                <!-- Answering a Question -->
                <div class="container" v-if="question_ninja !== current_ninja">
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

                <hr>

                <!-- Lobby List -->
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
                match_winner: null,
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
                .leaving((user) => {
                    // todo
                })
                .listen('newQuestion', (data) => {
                    this.newQuestion(data.question)
                })
                .listen('answerQuestion', (data) => {
                    env.answers.push({
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
                    this.roundWinner(data)
                })
                .listen('matchWinner', (data) => {
                    this.matchWinner(data)
                });

            this.start();
        },

        beforeDestroy() {
            Echo.leave('lobby.'+this.lobby_game.session_id);
        },

        methods: {
            // Initialize Game and starting Question Ninja
            start() {
                // Pick which User goes First (Host)
                this.question_ninja = this.lobby_game.host.username;

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
                        //todo
                    }
                }
            },

            // Leave the Game
            leaveGame() {
                // User is leaving the Game
                //todo
            },

            // Question Ninja submits a new Question
            postQuestion() {
                // Disable the Question Ninja's Form
                this.postedQuestion = this.question;

                // Stop Question Timer
                clearInterval(this.timerObject);
                this.timerObject = null;

                // Send Request to update other player's games
                axios.post(this.endpoint+'post-question', {
                        question: this.question,
                        session_id: this.lobby_game.session_id
                    })
                    .then(({data}) => {

                        // Start Answer Timer
                        this.timer = 90;
                        let env = this;
                        this.timerObject = setInterval(function() {
                            env.handleTimer('game')
                        }, 1000);
                    });
            },

            // A New Question has been submitted by the Question Ninja
            newQuestion(question) {
                if (this.question_ninja !== this.current_ninja) {
                    // Question Ninja submitted a Question
                    this.question = question;
                    this.canAnswer = true;

                    // Start Answer Timer
                    this.timer = 90;
                    let env = this;
                    this.timerObject = setInterval(function () {
                        env.handleTimer('game')
                    }, 1000);
                }
            },

            // Post your Answer to the submitted Question
            answerQuestion() {
                // Send Request to update other player's games
                axios.post(this.endpoint+'post-answer', {
                        answer: this.answer,
                        session_id: this.lobby_game.session_id
                    })
                    .then(({data}) => {
                        // Hide Input form
                        this.canAnswer = false;
                    });
            },

            // Question Ninja must pick a winning Ninja's Answer for the round
            pickWinner() {
                // Check if all Ninja's have answered the question
                this.roundOver = true;

                // Stop Answer Timer
                clearInterval(this.timerObject);
                this.timerObject = null;
            },

            // Select a Ninja as the Round's Winner
            roundWinner(username) {
                // Stop Answer Timer
                clearInterval(this.timerObject);
                this.timerObject = null;

                this.showAnswers = true;
                this.rounds_won = this.rounds_won + 1;

                // Wait for a few seconds
                //todo

                // Check if User has won 3 rounds
                if (this.rounds_won === 3) {
                    this.matchWinner(username)
                }

                // Clear Answers and Question
                this.answers = [];
                this.question_ninja = username;
                this.question = null;
                this.postedQuestion = null;

                // Winner of Round becomes the Question Ninja
                if (this.question_ninja === this.current_ninja) {
                    // Person Asking the Question
                    this.postedQuestion = null;
                } else {
                    // Wait for Question to be submitted
                    this.question = 'Waiting on "'+this.question_ninja+'" to write a Question...';
                }

                // Start Question Timer
                this.timer = 90;
                let env = this;
                this.timerObject = setInterval(function () {
                    env.handleTimer('question')
                }, 1000);
            },

            // Select a Ninja as the Match Winner
            matchWinner(username) {
                // Display Winner
                this.match_winner = username;

                // Start Exit Timer
                this.timer = 100;
                let env = this;
                this.timerObject = setInterval(function() { env.handleTimer('exit') }, 1000);
            }
        }
    };
</script>