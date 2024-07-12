<template>
    <div v-if="wrongURL">
        <InvalidGameURLMessage/>
    </div>
    <div v-else class="gameContent">
        <!--        <div>{{ users.length }}</div>-->
        <!--        <div v-for="(user, index) in users" :key="user.id">-->
        <!--            id: {{ user.id }} name: {{ user.name }}-->
        <!--        </div>-->

        <div v-for="(user, index) in users" :class="'space_' + (index + 1)">
            <div :class="'player_' + (index + 1)" class="playerCard">
                <div class="playerName" style="width: 100%; height: 50px; border: solid black 2px;">
                    Player {{ index + 1 }}: {{ user.name }}
                </div>
                <div class="score" style="width: 100%; height: 50px; border: solid black 2px;">
                    Score
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LeftPannel from "@/Layouts/LeftPannel.vue";
import InvalidGameURLMessage from "@/Components/InvalidGameURLMessage.vue";

export default {
    name: "VocabularyGame",
    components: {InvalidGameURLMessage},
    data() {
        return {
            gameKey: '',
            users: [
                {
                    id: 1,
                    name: 'Paul',
                    avatar: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMp2QN2WCx7VRAXuJme-AcdxJJeXRSM3obFhXX_uIKvQ&s',
                    player_count: 4
                },
                {
                    id: 2,
                    name: 'John',
                    avatar: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMp2QN2WCx7VRAXuJme-AcdxJJeXRSM3obFhXX_uIKvQ&s'
                },
                {
                    id: 3,
                    name: 'Nick',
                    avatar: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMp2QN2WCx7VRAXuJme-AcdxJJeXRSM3obFhXX_uIKvQ&s'
                },
                {
                    id: 13,
                    name: 'David',
                    avatar: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMp2QN2WCx7VRAXuJme-AcdxJJeXRSM3obFhXX_uIKvQ&s'
                },
            ],
            wrongURL: false,
            totalPlayersCount: 0,
        }
    },
    layout: LeftPannel,
    mounted() {
        // this.joinGame();
    },
    unmounted() {
        // window.removeEventListener("beforeunload", this.confirmExit);
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
                        this.totalPlayersCount = users[0].players_count;
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

                // keep track of the user leaving the game
                // window.addEventListener("beforeunload", this.confirmExit);
            }
        },
        confirmExit(event) {
            event.preventDefault();
            event.returnValue = "If you leave the page you might lose your current progress";
        },
        logConnectionToPublicGame(action = true) {
            if (this.gameKey) {
                let data = {
                    game_key: this.gameKey,
                    leave: action,
                };

                axios.post('/api/log-connection-public-vocabulary', data);
            }
        },
        getURLParam(param) {
            let url = window.location.href
                .slice(window.location.href.indexOf("?") + 1);

            let key = url.split("=")[1];

            if (!key) {
                this.wrongURL = true;
            }

            return key;
        }
    }
}
</script>
<style scoped>
.gameContent {
    height: 100vh;
    width: 100%;
}

.player_1 {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
}

.space_2 {
    width: 100%;
    display: flex;
    justify-content: center;
}

.space_3 {

}

.player_2 {

}

.player_3 {

}

.player_4 {

}

.playerCard {
    height: 200px;
    padding: 50px;
    width: 300px;
    background-color: gray;
    border-radius: 30px;
}

</style>
