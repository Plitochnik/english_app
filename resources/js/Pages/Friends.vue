<template>

    <!--    <meta name="viewport" content="width=600">-->
    <Head title="Dashboard"/>
    <table-test :user-name="userName"></table-test>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding-top: 10px;">
        <form>
            <label for="search">Search</label>
            <div class="search-container">
                <input v-model="search" id="search" type="search" pattern=".*\S.*" placeholder="Search" required>
                <spinner v-if="loadingUsers" class="search-container loading-spinner"/>
            </div>
            <span class="caret"></span>
        </form>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <!--     list of users    -->
                <div v-for="user in users" :key="user.id">
                    <div class="flex items
                    -center">
                        <div class="flex items
                        -center">
                            <img :src="user.profile_photo_url" alt="" class="w-10 h-10 rounded-full">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ user.name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    user
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import spinner from "../Components/spinner.vue";
import TableTest from "@/Pages/Sidebar/TableTest.vue";
import "../../../public/cssform/select.scss";

export default {
    name: "Friends",
    data() {
        return {
            search: '',
            searchInterval: null,
            loadingUsers: false,
            users: [],
        }
    },
    components: {
        Link,
        Head,
        TableTest,
        spinner,
    },
    props: [
        'userName',
    ],
    mounted() {
        // Echo.channel('test-ws')
        //     .listen('.test-message', res => {
        //         console.log(res)
        //     })
    },
    methods: {
        searchPeople(name) {
            this.loadingUsers = true;

            axios.get('/api/search-people/' + name)
                .then(response => {
                    this.users = response.data;
                })
                .catch(error => {
                    console.error('Error fetching users:', error);
                })
                .finally(() => {
                    this.loadingUsers = false;
                });
        }

    },
    watch: {
        search(name) {
            if (name) {
                clearTimeout(this.searchInterval);

                this.searchInterval = setTimeout(() => {
                    this.searchPeople(name);
                }, 500);
            }
        }
    }
}

</script>

<style lang="css">
.search-container {
    position: relative;
    width: 100%;
}

.loading-spinner {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
}

:root {
    --bg: #e3e4e8;
    --fg: #17181c;
    --input: #ffffff;
    --primary: #255ff4;
    --dur: 1s;
}

input {
    color: var(--fg);
}

input::placeholder {
    color: var(--fg);
    transition: color 2s ease-in-out;
}

input:not(:focus)::placeholder {
    color: transparent;
    transition: color 2s ease-in-out;
}

form, input, .caret {
    margin: auto;
}

form {
    position: relative;
    width: 100%;
    max-width: 17em;
}

input, .caret {
    display: block;
    transition: all calc(var(--dur) * 0.5) linear;
}

input {
    background: transparent;
    border-radius: 50%;
    box-shadow: 0 0 0 0.25em inset;
    caret-color: var(--primary);
    width: 2em;
    height: 2em;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

input:focus, input:valid {
    background: var(--input);
    border-radius: 0.25em;
    box-shadow: none;
    padding: 0.75em 1em;
    transition-duration: calc(var(--dur) * 0.25);
    transition-delay: calc(var(--dur) * 0.25);
    width: 100%;
    height: 3em;
}

input:focus {
    animation: showCaret var(--dur) steps(1);
    outline: transparent;
}

input:focus + .caret, input:valid + .caret {
    animation: handleToCaret var(--dur) linear;
    background: transparent;
    width: 1px;
    height: 1.5em;
    transform: translate(0, -1em) rotate(-180deg) translate(7.5em, -0.25em);
}

input::-webkit-search-decoration {
    -webkit-appearance: none;
}

label {
    color: #e3e4e8;
    overflow: hidden;
    position: absolute;
    width: 0;
    height: 0;
}

.caret {
    background: currentColor;
    border-radius: 0 0 0.125em 0.125em;
    margin-bottom: -0.6em;
    width: 0.25em;
    height: 1em;
    transform: translate(0, -1em) rotate(-45deg) translate(0, 0.875em);
    transform-origin: 50% 0;
}

/* Dark mode */
@media (prefers-color-scheme: dark) {
    :root {
        --bg: #17181c;
        --fg: #000000;
        --input: #ffffff;
        --primary: #5583f6;
    }
}

/* Animations */
@keyframes showCaret {
    from {
        caret-color: transparent;
    }
    to {
        caret-color: var(--primary);
    }
}

@keyframes handleToCaret {
    from {
        background: currentColor;
        width: 0.25em;
        height: 1em;
        transform: translate(0, -1em) rotate(-45deg) translate(0, 0.875em);
    }
    25% {
        background: currentColor;
        width: 0.25em;
        height: 1em;
        transform: translate(0, -1em) rotate(-180deg) translate(0, 0.875em);
    }
    50%, 62.5% {
        background: var(--primary);
        width: 1px;
        height: 1.5em;
        transform: translate(0, -1em) rotate(-180deg) translate(7.5em, 2.5em);
    }
    75%, 99% {
        background: var(--primary);
        width: 1px;
        height: 1.5em;
        transform: translate(0, -1em) rotate(-180deg) translate(7.5em, -0.25em);
    }
    87.5% {
        background: var(--primary);
        width: 1px;
        height: 1.5em;
        transform: translate(0, -1em) rotate(-180deg) translate(7.5em, 0.125em);
    }
    to {
        background: transparent;
        width: 1px;
        height: 1.5em;
        transform: translate(0, -1em) rotate(-180deg) translate(7.5em, -0.25em);
    }
}
</style>
