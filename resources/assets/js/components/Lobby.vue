<template>

    <div id="game_lobby">

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
    </div>

</template>

<script>
    export default {
        data() {
            return {
                count: 1,
                users: [],
                lobby_game: {},
                endpoint: "/api/game/start"
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
                })
                .leaving((user) => {
                    this.leaveLobby(user)
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

            kickPlayer(user) {
                console.log('Kicking Player...');
                console.log(user);

                // Remove Player from Channel/Session
                //todo

                // Redirect Player to Find Game page
                //todo
            },

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

                // Redirect to Find Game page
                window.location.href = '/play';
            },

            closeLobby() {
                console.log('Closing Game...')
                // Remove all current players from Channel
                //todo

                // Delete Game in DB
                //todo

                // Redirect all Players to the Find Game page
                //todo
            },

            startGame() {
                axios.post(this.endpoint, {
                        session_id: this.lobby_game.session_id
                    })
                    .then(({data}) => {
                        console.log('Starting Game...')
                    });
            }
        }
    };
</script>