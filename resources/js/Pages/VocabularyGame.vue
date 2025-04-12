<template>
  <div v-if="wrongURL">
    <InvalidGameURLMessage/>
  </div>
  <div v-else class="gameContent">
    <!--  users  -->
    <div v-for="(user, index) in users" :class="'space_' + (index + 1)">
      <div :class="'player_' + (index + 1)" class="playerCard">
        <div class="playerInfo">
          <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-500 text-white">
            {{ user.name.charAt(0) }}
          </div>
          <div class="ml-3">
            <div class="text-lg font-medium text-gray-900">{{ user.name }}</div>
            Score: 0
          </div>
        </div>
        <div class="animationStatus">
          <!--      TODO: status of current job. Thinking, answered, waiting to answer or something      -->
        </div>
      </div>
    </div>
    <!--  game board  -->
    <div class="gameBoard">
      <div class="text-center mt-4">
        <p class="text-base">What is this:</p>
        <p class="text-4xl">London</p>
      </div>
      <div class="d-flex text-center">
        <button v-for="(index, number) in 3"
                id="button_1" type="button"
                class=" elemline_1 mr-3 px-9 py-3 bg-blue-600 rounded-md text-white outline-none shadow-lg transform active:scale-75 transition-transform focus:outline-none focus:bg-yellow-400"
        >
          word {{ number }}
        </button>
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
    this.joinGame();
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
.playerCard {
  height: 150px;
  padding: 20px;
  width: 200px;
  background-color: white;
  border-radius: 30px;
}

.playerInfo {
  width: 100%;
  height: 50px;
  display: flex;
  align-items: center;
}

.animationStatus {

}

.gameBoard {
  /* place in the center of the display*/
  position: fixed;
  transform: translate(-50%, -50%);
  top: 50%;
  left: 50%;
  width: 60%;
  height: 40%;
  background-color: white;
  border-radius: 30px;
}

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

.player_3 {
  position: fixed;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
}

.player_4 {
  position: fixed;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
}

.space_1 {
  width: 100%;
  display: flex;
  justify-content: center;
}

.space_2 {
  width: 100%;
  display: flex;
  justify-content: center;
}

</style>
