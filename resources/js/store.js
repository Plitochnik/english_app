import { createApp } from 'vue';
import { createStore } from 'vuex';

const store = createStore({
    state: {
        // chat: [],
        recipientID: null,
        chatDialogue: false,
    },
    mutations: {
        // setChat(state, value) {
        //     state.chat = value;
        // },
        setRecipientID(state, value) {
            state.recipientID = value;
        },
        setChatDialogue(state, value) {
            state.chatDialogue = value;
        },
    }
})

export default store;
