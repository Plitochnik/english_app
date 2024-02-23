<template>

    <div class="header"></div>
    <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
    <label for="openSidebarMenu" class="sidebarIconToggle">
        <div class="spinner diagonal part-1"></div>
        <div class="spinner horizontal"></div>
        <div class="spinner diagonal part-2"></div>
    </label>
    <div id="sidebarMenu">
        <ul class="sidebarMenuInner">
            <li v-if="userName === 0" class="log-in">
                <u class="unregister">
                    <Link :href="route('login')">Log In</Link>
                </u>
                <span>User</span>
            </li>
            <li v-else class="log-in">
                <Link :href="route('home')">{{ userName }}</Link>
                <span>User</span>
            </li>
            <li class="dashboard">
                <Link :href="route('dashboard')" target="_blank">
                    Dashboard
                </Link>
            </li>
            <li class="settings">
                <Link :href="route('show.friends')" target="_blank">Friends</Link>
            </li>
            <li class="settings">
                <Link :href="route('profile.show')" target="_blank">Account</Link>
            </li>
            <a v-if="userName" class="logout">
                <form @submit.prevent="logout">
                    <button type="submit" class="">
                        Log out
                    </button>
                </form>
            </a>
        </ul>
    </div>
</template>


<script>

import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import "../../../../public/cssform/sidebar.css";
import { useToast } from "vue-toastification";

const toast = useToast();

export default {
    name: "TableTest",

    components: {
        Link,
    },

    props: [
        'userName',
    ],

    methods: {
        logout() {
            toast.info('You\'ve been log out', {
                position: 'bottom-right',
                timeout: 1000,
            })

            Inertia.post(route('logout'));
        }
    }

}
</script>

<style scoped>

</style>
