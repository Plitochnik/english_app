import { createApp } from 'vue';
import { createStore } from 'vuex';

const store = createStore({
    state: {
        testVar: 'hello',
    },
    mutations: {
        setTestVar(state, value) {
            state.testVar = value;
        },
    }
})

export default store;
