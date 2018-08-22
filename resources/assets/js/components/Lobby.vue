<template>

    <div id="game_lobby">

        <nav class="panel is-dark">
            <p class="panel-heading">
                {{ count }} Users in Lobby
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
                <a @click="startGame" class="button is-success is-medium is-fullwidth">
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
                <a @click="leaveLobby" class="button is-danger is-outlined is-medium is-fullwidth">
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
                endpoint: "api/games/play"
            };
        },

        props: {
            current_ninja: String,
            game: String
        },

        created() {
            this.fetch();
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
                    this.users = _.remove(this.users, function(lobby_user) {
                        return lobby_user.id !== user.id;
                    });
                    this.count = this.count - 1;

                    // Check if Last User left
                    if (this.count === 0) {
                        // Destroy Lobby/Session
                        // todo
                    }
                })
                .listen('joinLobby', (data) => {
                    // Push data to Lobby User list.
                    this.users.push({
                        username: data.user.username
                    });

                    // Update Lobby Count
                    this.count = this.count + 1;
                });
        },

        beforeDestroy() {
            Echo.leave('lobby.'+this.lobby_game.session_id);
        },

        methods: {
            fetch() {
                // Get available Games
                // axios.get(this.endpoint).then(({ data }) => {
                //     this.games = data.data;
                //     this.count = this.games.length;
                // });
            },

            kickPlayer(user) {
                console.log('Kicking Player...');
                console.log(user);

                // Remove Player from Channel/Session
                //todo

                // Redirect Player to Find Game page
                //todo
            },

            leaveLobby() {
                console.log('Leaving Lobby...')
                // Player has decided to leave the game
                //todo
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
                console.log('Starting Game...')

                //todo
            }
        }
    };
</script>