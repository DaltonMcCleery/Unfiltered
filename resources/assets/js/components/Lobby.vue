<template>

    <div id="game_lobby">
        <p>{{ count }} Users in Lobby</p>
        <br>
        <p style="color: dodgerblue;">"{{ current_ninja }}" (You)</p>
        <p v-for="user in users">
            "{{ user.username }}"
        </p>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                count: 1,
                users: [],
                endpoint: "api/games/play"
            };
        },

        props: {
            current_ninja: String,
            session_id: String
        },

        created() {
            this.fetch();
        },

        mounted() {
            // Outside access to Vue Data and Props
            let env = this;

            Echo.join('lobby.'+this.session_id)
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
                    console.log('joining');
                    console.log(user);

                    // Check if Lobby is now at Full capacity (don't let more people join)
                })
                .leaving((user) => {
                    console.log('leaving');
                    console.log(user);

                    // Check if Last User left (Destroy Lobby/Session)
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
            alert('no!')
        },

        methods: {
            fetch() {
                // Get available Games
                // axios.get(this.endpoint).then(({ data }) => {
                //     this.games = data.data;
                //     this.count = this.games.length;
                // });
            }
        }
    };
</script>