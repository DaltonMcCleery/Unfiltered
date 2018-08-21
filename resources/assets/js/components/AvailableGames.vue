<template>

        <!-- Available Games (if any) -->
        <div v-if="games">
            <a @click="fetch()" class="button is-info">REFRESH LIST</a>
            <br><br>
            <div class="columns is-desktop is-fluid">
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
                                <p>
                                    <a :href="'/play/session/' + game.session_id" class="button is-success">JOIN GAME</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- No Available Games -->
        <div class="tile is-ancestor" v-else>
            <div class="tile is-parent">
                <article class="tile is-child box">
                    <p class="title" style="color: black;">No available Games</p>
                    <div class="content">
                        <p>
                            Trying creating one
                        </p>
                    </div>
                </article>
            </div>
        </div>

</template>

<script>
    export default {
        data() {
            return {
                games: null,
                endpoint: "api/games/find"
            };
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch() {
                // Get available Games
                axios.get(this.endpoint).then(({ data }) => {
                    this.games = data.data;
                });
            },
        }
    };
</script>