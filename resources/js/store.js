import { createApp } from 'vue';
import { createStore } from 'vuex';

const store = createStore({
    state: {
        chat: [],
        recipient: null,
    },
    mutations: {
        setChat(state, value) {
            state.chat = value;
        },
        setRecipient(state, value) {
            state.recipient = value;
        },
    }
})

export default store;
