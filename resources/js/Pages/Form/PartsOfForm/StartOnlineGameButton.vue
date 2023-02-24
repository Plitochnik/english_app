<template>
    <div class="multiplayer-button">
        <div v-if="$page.props.user">
            <Link  @click.prevent="checkinRegisteredUsers"
                  class="px-4 py-3 bg-blue-600 rounded-md text-white outline-none focus:ring-4 shadow-lg transform active:scale-x-75 transition-transform mx-5 flex">
                <img src="../../../../../public/icons/multiplay_button/icon.png">
                <span class="ml-2">Сыграть с другом</span>
            </Link>
        </div>
        <div v-else>
            <Link
                href="/login"
                type="submit"
                class="px-4 py-3 bg-blue-600 rounded-md text-white outline-none focus:ring-4 shadow-lg transform active:scale-x-75 transition-transform mx-5 flex">
                <img src="../../../../../public/icons/multiplay_button/icon.png">
                <span class="ml-2">Сыграть с другом</span>
            </Link>
        </div>
    </div>
</template>

<script>

import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "StartOnlineGameButton",

    components: {
        Link,
    },

    methods: {
        checkinRegisteredUsers() {
        //     Echo.channel('playground').subscribed(() => {
        //         console.log('subscribed!');
        //     }).listen('.pubg', (event) => {
        //         console.log(event)
        //     })
        },
    }
}
</script>

<style scoped>

</style>
