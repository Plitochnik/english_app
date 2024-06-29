<template>
    <div style="padding: 100px; border: solid black 2px; width: 500px;">
        <div>{{ users.length }}</div>
        <div v-for="(user, index) in users" :key="user.id">
            id: {{ user.id }} name: {{ user.name }}
        </div>
    </div>
</template>

<script>
import LeftPannel from "@/Layouts/LeftPannel.vue";

export default {
    name: "VocabularyGame",
    data: () => ({
        gameKey: '',
        users: [],
    }),
    layout: LeftPannel,
    mounted() {
        this.joinGame();
    },
    unmounted() {
        // TODO: leave the game logic
        this.logConnectionToPublicGame(true);
    },
    methods: {
        joinGame() {
            this.gameKey = this.getURLParam("game-id");

            if (this.gameKey) {
                Echo.join(`game.${this.gameKey}`)
                    // when we're connected
                    .here((users) => {
                        this.users = users;
                    })
                    // someone's joined
                    .joining((user) => {
                        this.users.push(user);
                    })
                    .leaving((kickedUser) => {

                        this.users = this.users.filter((user) => user.id !== kickedUser.id)
                    })
                    .error((error) => {
                        // error handling
                    });
            }
        },
        logConnectionToPublicGame(action = true) {
            let data = {
                game_key: this.gameKey,
                leave: action,
            };

            axios.post('/api/log-connection-public-vocabulary', data);
        },
        getURLParam(param) {
            let url = window.location.href
                .slice(window.location.href.indexOf("?") + 1);

            return url.split("=")[1];
        }
    }
}
</script>
<style scoped>

</style>
