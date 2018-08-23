<template>

    <div id="play_game">

        <section class="hero is-medium is-info is-bold">
            <div class="hero-body">

                <!-- Submitting a Question -->
                <div class="container" v-if="question_ninja === current_ninja">
                    <div v-if="postedQuestion === null">
                        <h2 class="title">
                            You are writing the Question!
                        </h2>
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
            </div>
        </section>

        <section class="hero is-dark is-bold">
            <div class="hero-body">

                <!-- Player Cards -->
                <div class="columns container is-fluid" v-if="roundOver">
                    <div class="column" v-for="answer in answers">
                        <div class="card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    NAME
                                </p>
                            </header>
                            <div class="card-content">
                                <div class="content">
                                    ANSWER HERE
                                </div>
                            </div>
                            <footer class="card-footer">
                                <a href="#" class="card-footer-item">
                                <span class="icon">
                                    <i class="fas fa-thumbs-up"></i>
                                </span>
                                    Like
                                </a>
                                <a href="#" class="card-footer-item">
                                <span class="icon">
                                    <i class="fas fa-thumbs-down"></i>
                                </span>
                                    Dislike
                                </a>
                            </footer>
                        </div>
                    </div>
                </div>
                <div class="container" align="center" v-else>
                    <b-message type="is-info" has-icon>
                        Waiting on All Ninja's to answer...
                    </b-message>
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
                count: 0,
                users: [],
                lobby_game: {},
                question: null,
                postedQuestion: null,
                question_ninja: null,
                roundOver: false,
                showAnswers: false,
                canAnswer: false,
                answers: [],
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
                    // this.newQuestion(data)
                    console.log(data);
                })
                .listen('answerQuestion', (data) => {
                    env.answers.push({
                        username: data.username,
                        answer: data.answer
                    });

                    if (data.last === true) {
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

                // Send Request to update other player's games
                axios.post(this.endpoint+'post-question', {
                        question: this.question,
                        session_id: this.lobby_game.session_id
                    })
                    .then(({data}) => {
                        // Start Answer Timer
                        // todo
                    });
            },

            newQuestion(question) {
                // Question Ninja submitted a Question
                this.postedQuestion = question;
                this.canAnswer = true;

                // Start Answer Timer
                // todo
            },

            answerQuestion(answer) {
                console.log(answer);
                this.canAnswer = false;

                //todo
            },

            pickWinner() {
              // Check if all Ninja's have answered the question
              this.roundOver = true;

                // Stop Answer Timer
                // todo
            },

            roundWinner(user) {
                console.log('Won a Round');
                console.log(user);

                this.showAnswers = true;

                // Wait for a few seconds
                //todo

                // Check if User has won 3 rounds
                let check = false; //temp
                if (check === true) {
                    this.matchWinner(user)
                }

                // Clear Answers and Question
                //todo

                // Winner of Round becomes the Question Ninja
                //todo
            },

            matchWinner(user) {
                console.log('WINNER!');
                console.log(user)

                // Display Winner
                //todo

                // Start Exit Timer
                //todo
            }
        }
    };
</script>