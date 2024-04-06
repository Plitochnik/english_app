import { createApp } from 'vue';
import { createStore } from 'vuex';

const store = createStore({
    state: {
        recipientID: null,
        chatDialogue: false,
        newMessageNotification: false,
        privateMessages: [],
    },
    mutations: {
        setRecipientID(state, value) {
            state.recipientID = value;
        },
        setChatDialogue(state, value) {
            state.chatDialogue = value;
        },
        setNewMessageNotification(state, value) {
            state.newMessageNotification = value;
        },
        setPrivateMessages(state, value) {
            state.privateMessages = value;
        },

    }
})

export default store;
