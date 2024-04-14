import { createApp } from 'vue';
import { createStore } from 'vuex';

const store = createStore({
    state: {
        recipientID: null,
        chatDialogue: false,
        privateMessages: [],
    },
    mutations: {
        setRecipientID(state, value) {
            state.recipientID = value;
        },
        setChatDialogue(state, value) {
            state.chatDialogue = value;
        },
        setPrivateMessages(state, value) {
            state.privateMessages = value;
        },

    }
})

export default store;
