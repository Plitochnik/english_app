<template>

    <!--    <meta name="viewport" content="width=600">-->
    <Head title="Friends"/>
    <!-- <table-test :user-name="userName"></table-test> -->

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding-top: 10px;">
        <div class="main-block bg-white overflow-hidden shadow-xl">
            <!-- button to see my invitations with the count at the top -->
            <div class="flex justify-end gap-2 p-6">
                <Button label="Invitations"
                        @click="invitesDialogue = true"
                        :badge="invitations.length ? invitations.length.toString() : ''"
                        badgeSeverity="warning"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4"/>
            </div>

            <!-- search box -->
            <div id="search">
                <svg viewBox="0 0 420 60" xmlns="http://www.w3.org/2000/svg">
                    <rect class="bar"/>
                    <g class="magnifier">
                        <circle class="glass"/>
                        <line class="handle" x1="32" y1="32" x2="44" y2="44"></line>
                    </g>
                    <g class="sparks">
                        <circle class="spark"/>
                        <circle class="spark"/>
                        <circle class="spark"/>
                    </g>
                    <g class="burst pattern-one">
                        <circle class="particle circle"/>
                        <path class="particle triangle"/>
                        <circle class="particle circle"/>
                        <path class="particle plus"/>
                        <rect class="particle rect"/>
                        <path class="particle triangle"/>
                    </g>
                    <g class="burst pattern-two">
                        <path class="particle plus"/>
                        <circle class="particle circle"/>
                        <path class="particle triangle"/>
                        <rect class="particle rect"/>
                        <circle class="particle circle"/>
                        <path class="particle plus"/>
                    </g>
                    <g class="burst pattern-three">
                        <circle class="particle circle"/>
                        <rect class="particle rect"/>
                        <path class="particle plus"/>
                        <path class="particle triangle"/>
                        <rect class="particle rect"/>
                        <path class="particle plus"/>
                    </g>
                </svg>
                <input v-model="search" type=search placeholder="Search people"
                       aria-label="Search for people around the world"/>
            </div>
            <div id="results"></div>
            <div class="p-6 sm:px-20 bg-white border-gray-200">
                <!--     list of users    -->
                <div v-for="user in users" :key="user.id" v-if="users.length">
                    <div class="flex items-center">
                        <div class="flex items-center pt-5">
                            <!--    user's image or just first letter of their name     -->
                            <div v-if="user.profile_photo_path" class="flex-shrink-0">
                                <img :src="user.profile_photo_path" class="w-10 h-10 rounded-full">
                            </div>
                            <div v-else
                                 class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-500 text-white">
                                {{ user.name.charAt(0) }}
                            </div>

                            <div class="ml-4">
                                <div class="text-xl font-medium text-gray-900">
                                    {{ user.name }}
                                </div>
                                <div class="text-sm font-medium text-gray-500">
                                    user
                                </div>
                            </div>
                        </div>
                        <div class="ml-auto">
                            <Button
                                :loading="user.accepting_process"
                                :disabled="user.added"
                                :label="user.status ? user.status : 'Add'"
                                type="button"
                                class="card flex justify-content-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4"
                                @click="addFriend(user)"
                            />
                        </div>
                    </div>
                </div>
                <div v-else-if="noResults" class="flex items-center justify-center mt-10">
                    No results
                </div>
            </div>
        </div>

        <Dialog v-model:visible="invitesDialogue" modal header="Invites" :style="{ width: '45rem', height: '40em' }">
            <span class="flex p-text-secondary block mb-5">
                Invites that you have received
                <div v-if="invitations.length"
                     class="card flex justify-content-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 ml-auto"
                     style="border-radius: 10px; width: 17%; cursor: pointer">
                    <Button :loading="acceptingAllProcess" type="button" @click="acceptAllInvitations()" label="Accept All"/>
                </div>
            </span>
            <div v-for="invitation in invitations" :key="invitation.id" class="mt-10 ml-3 flex items-center justify-between">
                <div class="flex items-center">
                    <!--    user's image or just first letter of their name     -->
                    <div v-if="invitation.sender_photo" class="flex-shrink-0">
                        <img :src="invitation.sender_photo" class="w-10 h-10 rounded-full">
                    </div>
                    <div v-else
                         class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-500 text-white">
                        {{ invitation.sender_name.charAt(0) }}
                    </div>
                    <div class="ml-4">
                        <div class="text-xl font-medium text-gray-900">
                            {{ invitation.sender_name }}
                        </div>
                    </div>
                </div>
                <div
                    class="card flex justify-content-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ml-auto"
                    style="border-radius: 10px">
                    <Button :loading="invitation.accepting_process" type="button"
                            @click="acceptInvitation(invitation.sender_id)" label="Accept" icon="pi pi-plus"/>
                </div>
            </div>
        </Dialog>
    </div>

</template>

<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import spinner from "../Components/spinner.vue";
import LeftPannel from "@/Layouts/LeftPannel.vue";
import {useToast} from "vue-toastification";

const toast = useToast();

export default {
    name: "Friends",
    data() {
        return {
            search: '',
            searchInterval: null,
            loadingUsers: false,
            users: [],
            invitesDialogue: false,
            invitations: [],
            loadingInvitations: false,
            acceptingAllProcess: false,
        }
    },
    layout: LeftPannel,
    computed: {
        noResults() {
            return !this.users.length && !this.loadingUsers && this.search;
        }
    },
    components: {
        Link,
        Head,
        spinner,
    },
    mounted() {
        this.checkMyInvitations();
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
        },
        addFriend(user) {
            switch (user.status) {
                // if this user has already send us an invitation, then approve it
                case 'Accept invitation':
                    this.acceptInvitation(user.id)
                    return;
                // we've already sent an invitation
                case 'Invited':
                    return;
                case 'Friend':
                    return;
                default:
                    this.users.forEach((item) => {
                        if (item.id === user.id && item.status !== 'Invited') {
                            item.status = 'Invited';
                        }
                    })
            }

            axios.get('/api/add-friend/' + user.id)
                .then(response => {})
                .catch(error => {
                    console.error(error);
                    toast.warning(error.response.data.message, {
                        position: 'bottom-right',
                        timeout: 5000,
                    })
                })
                .finally(() => {
                    this.loadingUsers = false;
                });

        },
        checkMyInvitations() {
            axios.get('/api/check-invites')
                .then(response => {
                    this.invitations = response.data;
                })
                .catch(error => {
                    console.error(error);
                    toast.warning(error.response.data.message, {
                        position: 'bottom-right',
                        timeout: 5000,
                    })
                })
                .finally(() => {
                    this.loadingInvitations = false;
                });
        },
        acceptInvitation(id) {
            // activate loading spinner for this user
            this.invitations.forEach((item) => {
                if (item.id === id) {
                    item.accepting_process = true;
                }
            })

            // list of users under the search box
            this.users.forEach((user) => {
                if (user.id === id) {
                    user.accepting_process = true;
                }
            })

            axios.get('/api/accept-friendship-invitation/' + id)
                .then(response => {
                    this.invitations = response.data;

                    this.users.forEach((user) => {
                        if (user.id === id) {
                            user.accepting_process = false;
                            user.status = 'Friend';
                        }
                    })
                })
                .catch(error => {
                    console.error(error);
                    toast.warning(error.response.data.message, {
                        position: 'bottom-right',
                        timeout: 5000,
                    })
                })
                .finally(() => {
                    // deactivate loading spinner
                    this.invitations.forEach((item) => {
                        if (item.sender_id === id) {
                            item.accepting_process = false;
                        }
                    })
                });
        },
        acceptAllInvitations() {
            this.acceptingAllProcess = true;
            axios.get('/api/accept-all-invitations')
                .then(response => {
                    this.invitations = response.data;
                })
                .catch(error => {
                    console.error(error);
                    toast.warning(error.response.data.message, {
                        position: 'bottom-right',
                        timeout: 5000,
                    })
                })
                .finally(() => {
                    this.acceptingAllProcess = false;
                })
        },
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
.p-badge-warning {
    background: #fdb500 !important;
}

.main-block {
    border-radius: 30px;
    min-height: 90vh;
    margin-bottom: 50px;
}

#search {
    display: grid;
    grid-area: search;
    grid-template:
		"search" 60px
		/ 420px;
    justify-content: center;
    align-content: center;
    justify-items: stretch;
    align-items: stretch;
    background: hsl(0, 0%, 99%);
    padding-top: 5vh;
}

#search input {
    display: block;
    grid-area: search;
    -webkit-appearance: none;
    appearance: none;
    width: 100%;
    height: 100%;
    background: none;
    padding: 0 30px 0 60px;
    border: none;
    border-radius: 100px;
    font: 24px/1 system-ui, sans-serif;
    outline-offset: -8px;
}

#search svg {
    grid-area: search;
    overflow: visible;
    color: hsl(213, 97%, 63%);
    fill: none;
    stroke: currentColor;
}

.burst {
    stroke-width: 3;
}

.burst :nth-child(2n) {
    color: #ff783e
}

.burst :nth-child(3n) {
    color: #ffab00
}

.burst :nth-child(4n) {
    color: #55e214
}

.burst :nth-child(5n) {
    color: #82d9f5
}

.circle {
    r: 6;
}

.rect {
    width: 10px;
    height: 10px;
}

.triangle {
    d: path("M0,-6 L7,6 L-7,6 Z");
    stroke-linejoin: round;
}

.plus {
    d: path("M0,-5 L0,5 M-5,0L 5,0");
    stroke-linecap: round;
}

.burst:nth-child(4) {
    transform: translate(30px, 100%) rotate(150deg);
}

.burst:nth-child(5) {
    transform: translate(50%, 0%) rotate(-20deg);
}

.burst:nth-child(6) {
    transform: translate(100%, 50%) rotate(75deg);
}

.burst * {
}

@keyframes particle-fade {
    0%, 100% {
        opacity: 0
    }
    5%, 80% {
        opacity: 1
    }
}

.burst :nth-child(1) {
    animation: particle-fade 600ms 0.55s both, particle-one-move 600ms 0.55s both;
}

.burst :nth-child(2) {
    animation: particle-fade 600ms 0.55s both, particle-two-move 600ms 0.55s both;
}

.burst :nth-child(3) {
    animation: particle-fade 600ms 0.55s both, particle-three-move 600ms 0.55s both;
}

.burst :nth-child(4) {
    animation: particle-fade 600ms 0.55s both, particle-four-move 600ms 0.55s both;
}

.burst :nth-child(5) {
    animation: particle-fade 600ms 0.55s both, particle-five-move 600ms 0.55s both;
}

.burst :nth-child(6) {
    animation: particle-fade 600ms 0.55s both, particle-six-move 600ms 0.55s both;
}

@keyframes particle-one-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(-20deg) translateX(8%) scale(0.5, 0.5)
    }
}

@keyframes particle-two-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(0deg) translateX(8%) scale(0.5, 0.5)
    }
}

@keyframes particle-three-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(20deg) translateX(8%) scale(0.5, 0.5)
    }
}

@keyframes particle-four-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(-35deg) translateX(12%)
    }
}

@keyframes particle-five-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(0deg) translateX(12%)
    }
}

@keyframes particle-six-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(35deg) translateX(12%)
    }
}

.bar {
    width: 100%;
    height: 100%;
    ry: 50%;
    stroke-width: 10;
    animation: bar-in 900ms 0.55s both;
}

@keyframes bar-in {
    0% {
        stroke-dasharray: 0 180 0 226 0 405 0 0
    }
    100% {
        stroke-dasharray: 0 0 181 0 227 0 405 0
    }
}

.magnifier {
    animation: magnifier-in 600ms 0.80s both;
    transform-box: fill-box;
}

@keyframes magnifier-in {
    0% {
        transform: translate(20px, 8px) rotate(-45deg) scale(0.01, 0.01);
    }
    50% {
        transform: translate(-4px, 8px) rotate(-45deg);
    }
    100% {
        transform: translate(0px, 0px) rotate(0deg);
    }
}

.magnifier .glass {
    cx: 27;
    cy: 27;
    r: 8;
    stroke-width: 3;
}

.magnifier .handle {
    x1: 32;
    y1: 32;
    x2: 44;
    y2: 44;
    stroke-width: 3;
}

#results {
    grid-area: results;
    background: hsl(0, 0%, 95%);
}

</style>
