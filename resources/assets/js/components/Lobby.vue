<template>

    <div id="game_lobby">

        <div class="row">
            <!-- Lobby List -->
            <div class="col-md-6">
                <!-- Players -->
                <nav class="panel is-dark">
                    <p class="panel-heading">
                        {{ count }} Users in Lobby (of {{ lobby_game.max_sessions }})
                    </p>
                    <!--<p class="panel-tabs">-->
                        <!--<a class="is-active">all</a>-->
                        <!--<a>public</a>-->
                        <!--<a>private</a>-->
                        <!--<a>sources</a>-->
                        <!--<a>forks</a>-->
                    <!--</p>-->
                    <div class="panel-block is-active" style="color: deepskyblue;">
                        "{{ current_ninja }}" (You)
                    </div>
                    <div class="panel-block" v-for="user in users" style="color: white">
                        "{{ user.username }}"
                        <span v-if="current_ninja === lobby_game.host.username">
                            <a @click="kickPlayer(user)" class="button is-danger" style="color: white; margin-left: 10px;">
                                Kick
                            </a>
                        </span>
                    </div>
                    <!-- Host Options -->
                    <div class="panel-block" v-if="current_ninja === lobby_game.host.username">
                        <a @click="startGame" class="button is-success is-medium is-fullwidth" style="color: white;">
                            Start Game
                        </a>
                    </div>
                    <div class="panel-block" v-if="current_ninja === lobby_game.host.username">
                        <a @click="closeLobby" class="button is-danger is-outlined is-medium is-fullwidth">
                            Close Lobby
                        </a>
                    </div>
                    <!-- Guest Options -->
                    <div class="panel-block" v-else>
                        <a @click="leaveLobby(current_ninja)" class="button is-danger is-outlined is-medium is-fullwidth">
                            Leave Lobby
                        </a>
                    </div>
                </nav>

                <!-- Post Chat Message -->
                <nav class="panel is-dark">
                    <div class="panel-block">
                        <p class="control">
                            <b-field>
                                <b-input class="is-fullwidth" maxlength="50" type="textarea" v-model="chat_message"></b-input>
                            </b-field>
                            <button @click="chatMessage()" class="button is-info is-inverted is-fullwidth">
                                Post Chat Message
                            </button>
                        </p>
                    </div>
                </nav>
            </div>

            <!-- Chat -->
            <div class="col-md-6">
                <nav class="panel is-dark">
                    <p class="panel-heading">
                        Lobby Chat
                    </p>
                    <div v-if="chat">
                        <div class="panel-block" v-for="object in chat" style="color: white; overflow: scroll; height: auto;">
                            "{{ object.username }}": {{ object.message }}
                        </div>
                    </div>
                    <div v-else>
                        <div class="panel-block" style="color: white;">
                            No chat messages - post a message in the chat to get the party started!
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                count: 1,
                users: [],
                lobby_game: {},
                chat: null,
                chat_message: null,
                starting: null,
                endpoint: "/api/game/"
            };
        },

        props: {
            current_ninja: String,
            game: String
        },

        created() {
            this.lobby_game = JSON.parse(this.game);
        },

        mounted() {
            // Outside access to Vue Data and Props
            let env = this;

            Echo.join('lobby.'+this.lobby_game.session_id)
                .here((users) => {
                    // Loop through all current Lobby Users and display them for the newest User
                    users.forEach(function(user, index) {
                        if (user.username !== env.current_ninja) {
                            env.users.push({
                                username: user.username
                            });

                            env.count = env.count + 1;
                        }
                    });
                })
                .joining((user) => {
                    env.users.push({
                        username: user.username
                    });

                    env.count = env.count + 1;
                    this.updateSessions();
                })
                .leaving((user) => {
                    this.leaveLobby(user);
                    this.updateSessions();
                })
                .listen('lobbyChat', (data) => {
                    // Check if Chat is empty/null
                    if (this.chat === null) {
                        this.chat = [];
                    }

                    // Player has posted in Chat
                    this.chat.push({
                        username: data.username,
                        message: data.message
                    });
                })
                .listen('kickPlayer', (data) => {
                    // Host has kicked a Player
                    this.leaveLobby(data.user);
                    this.updateSessions();
                })
                .listen('closeLobby', (data) => {
                    // Host has chosen to close the Lobby/Game
                    this.leaveLobby(this.current_ninja);
                })
                .listen('startGame', (data) => {
                    // Redirect the User to the Game's page
                    window.location.href = '/play/game/'+this.lobby_game.session_id;
                });
        },

        beforeDestroy() {
            Echo.leave('lobby.'+this.lobby_game.session_id);
        },

        methods: {

            // Updates DB count of current players in Lobby
            updateSessions() {
                axios.post('/api/update/lobby', {
                    session_id: this.lobby_game.session_id,
                    current_sessions: this.count
                });
            },

            // Host requests to Kick a Player
            kickPlayer(user) {
                // Redirect Player to Find Game page
                axios.post(this.endpoint+'kick-player', {
                    session_id: this.lobby_game.session_id,
                    username: user
                });
            },

            // User is leaving the Lobby
            leaveLobby(user) {
                // Player has decided to leave the game
                this.users = _.remove(this.users, function(lobby_user) {
                    return lobby_user.username !== user;
                });
                this.count = this.count - 1;

                if (this.count === 0) {
                    // Destroy Lobby/Session
                    axios.post(this.endpoint+'destroy-game', {
                        session_id: this.lobby_game.session_id
                    });
                }

                if (user === this.current_ninja) {
                    // Redirect to Find Game page
                    window.location.href = '/play';
                }
            },

            // Host requests to close the Lobby and delete the Game Session
            closeLobby() {
                // Delete Game in DB
                axios.post(this.endpoint+'close-lobby', {
                    session_id: this.lobby_game.session_id
                });
            },

            // Host has requested to Start the Game with the current Lobby Players
            startGame() {
                axios.post(this.endpoint+'start', {
                        session_id: this.lobby_game.session_id
                    })
                    .then(({data}) => {
                        this.starting = true;
                    });
            },

            // Post a Message in the Lobby Chat
            chatMessage() {
                axios.post(this.endpoint+'chat', {
                        session_id: this.lobby_game.session_id,
                        username: this.current_ninja,
                        message: this.chat_message
                    })
                    .then(({data}) => {
                        this.chat_message = null;
                    });

            }
        }
    };
</script>