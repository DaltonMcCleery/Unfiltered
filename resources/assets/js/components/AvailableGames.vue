<template>
    <div class="tile is-ancestor">
        <div v-if="games">
            <div class="tile is-parent" v-for="game in games">
                <article class="tile is-child box">
                    <p class="title" style="color: black;">Title</p>
                    <div class="content">
                        <p>
                            Session ID: {{ game.session_id }}
                        </p>
                    </div>
                </article>
            </div>
        </div>
        <div v-else>
            <div class="tile is-parent">
                <article class="tile is-child box">
                    <p class="title" style="color: black;">No available Games</p>
                    <div class="content">
                        <p>
                            Trying creating one <a href="#">here</a>
                        </p>
                    </div>
                </article>
            </div>
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
                    this.games = data.date;
                });
            },
        }
    };
</script>