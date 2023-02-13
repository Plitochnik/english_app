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
            <li v-if="userName === 0">
                <u class="unregister">
                    <Link :href="route('login')">Log In</Link>
                </u>
                <span>Web Developer</span>
            </li>
            <li v-else>
                <Link :href="route('parameters')">{{ userName }}</Link>
                <span>Web Developer</span>
            </li>
            <li>
                <Link :href="route('dashboard')" target="_blank">
                    Dashboard
                </Link>
            </li>
            <li>
                <Link :href="route('profile.show')" target="_blank">Settings</Link>
            </li>
            <a class="logout">
                <form @submit.prevent="logout">
                    <button type="submit" class="">
                        Log out
                    </button>
                </form>
            </a>
        </ul>
    </div>
</template>

<script setup>

const logout = () => {
    Inertia.post(route('logout'));
};

</script>


<script>

import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import "../../../../public/cssform/sidebar.css";

export default {
    name: "TableTest",

    components: {
        Link,
    },

    props: [
        'userName',
    ],

}
</script>

<style scoped>

</style>
