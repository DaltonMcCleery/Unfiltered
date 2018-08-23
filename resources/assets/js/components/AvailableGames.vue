<template>

    <div id="games">
        <!-- Refresh List -->
        <a @click="fetch()" class="button is-info">REFRESH LIST</a>
        <br><br>

        <div class="columns is-desktop is-fluid" v-if="count !== 0">
            <!-- Available Games (if any) -->
            <div class="column" v-for="game in games">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            {{ game.game_id }}
                        </p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <p>
                                Host Ninja: {{ game.host.username }}
                                <br>
                                Current Players: {{ game.current_sessions }} out of {{ game.max_sessions }}
                            </p>
                            <p v-if="authed_user_id === game.ninja_id">
                                <a class="button is-danger is-outlined"> This is your Game!</a>
                            </p>
                            <p v-else>
                                <a :href="'/play/lobby/' + game.session_id" class="button is-success">JOIN GAME</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- No Available Games -->
        <div class="columns is-desktop is-fluid" v-else>
            <!-- Available Games (if any) -->
            <div class="column">
                <div id="no_public_games" class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            No Public Games Found
                        </p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <p>
                                Refresh the List or Create your own Game!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                games: null,
                count: 0,
                endpoint: "api/find/games"
            };
        },

        props: {
            authed_user_id: Number,
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch() {
                // Get available Games
                axios.get(this.endpoint).then(({ data }) => {
                    this.games = data.data;
                    this.count = this.games.length;
                });
            },
        }
    };
</script>