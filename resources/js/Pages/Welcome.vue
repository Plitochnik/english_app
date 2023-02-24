<template>
    <div>
        <ul>
            <li v-for="post in posts">
                {{ post }}
            </li>
        </ul>
    </div>
    <div class="p-6">
        <form @submit.prevent="submit">
            <input id="input-message" v-model="input" type="text" placeholder="Text">
            <button type="submit" class="">Submit</button>
        </form>
    </div>
</template>


<script>
import {Link} from "@inertiajs/inertia-vue3";


export default {
    name: "Welcome",

    components: {
        Link,
    },

    data() {
        return {
            input: null,
            posts: [],
        }
    },

    methods: {
        submit() {
            this.$inertia.post('/chat-message', {
                message: this.input,
            })
        }
    },

}
</script>

<style scoped>

</style>
