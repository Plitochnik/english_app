<template>

    <!--    <meta name="viewport" content="width=600">-->

    <Head title="Friends"/>
    <!-- <table-test :user-name="userName"></table-test> -->

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding-top: 10px;">
        <div class="main-block bg-white overflow-hidden shadow-xl">
            <div class="flex justify-end gap-2 p-6">
                <div @click="testVar = 1231232">111</div>
                {{$store.state.testVar}}
                <Button label="Invitations" @click="invitesDialogue = true"
                        :badge="invitations.length ? invitations.length.toString() : ''" icon="pi pi-book"
                        badgeSeverity="warning" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4"/>
                <!-- add friends -->
                <Button label="Add new friend" @click="addFriendDialogue = true" badgeSeverity="warning"
                        icon="pi pi-users" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4"/>
            </div>

            <div class="p-6 sm:px-20 bg-white border-gray-200">
                <div v-if="friends.length" class="items-center justify-center mt-6">
                    <FloatLabel class="mb-10">
                        <InputText id="username" class="searchFriendBox" v-model="friendSearch"
                                   @input="searchFriends"/>
                        <label for="username">Username</label>
                    </FloatLabel>
                    <!-- deletion confirmation -->
                    <OverlayPanel ref="op">
                        <div class="flex items center justify-between">
                            <span class="font-medium text-900 block mb-2">Do you want to delete
                                {{ friendToDelete.name }} friend?</span>
                        </div>
                        <div class="flex flex-column gap-3 w-25rem">
                            <Button label="Confirm" type="button"
                                    class="card flex justify-content-center bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4"/>
                            <Button label="Cancel" type="button"
                                    class="card flex justify-content-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4"/>
                        </div>
                    </OverlayPanel>

                    <!--                        @click.prevent="deleteFriend($event, friend)"-->

                    <!--    list of friends    -->
                    <div v-for="friend in friends" :key="friend.id"
                         class="hover:bg-gray-100 border-gray-200 cursor-pointer rounded-md pl-4 pr-4 pb-4"
                    >
                        <div
                            v-if="!friend.hide"
                            class="flex items-center"
                        >
                            <div class="flex items-center pt-5">
                                <!--    user's image or just first letter of their name     -->
                                <div v-if="friend.profile_photo_path" class="flex-shrink-0">
                                    <img :src="friend.profile_photo_path" class="w-10 h-10 rounded-full">
                                </div>
                                <div v-else
                                     class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-500 text-white">
                                    {{ friend.name.charAt(0) }}
                                </div>

                                <div class="ml-4">
                                    <div class="text-xl font-medium text-gray-900">
                                        {{ friend.name }}
                                    </div>
                                    <div class="text-sm font-medium text-gray-500">
                                        user
                                    </div>
                                </div>
                            </div>
                            <div class="ml-auto">
                                <Button :loading="friend.accepting_process" :disabled="friend.added"
                                        label="Send message" icon="pi pi-envelope" type="button"
                                        @click="showChat = true"
                                        class="mt-4 card flex justify-content-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!--    if no friends    -->
                <div v-else>
                    <div class="flex items-center justify-center mt-10">
                        You don't have any friends yet
                    </div>
                </div>
            </div>
        </div>

        <!--    see invitations    -->
        <Dialog v-model:visible="invitesDialogue" modal header="Invites" :style="{ width: '45rem', height: '40em' }">
            <span v-if="invitations.length" class="flex p-text-secondary mb-5">
                Invites that you have received
                <div
                    class="card flex justify-content-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 ml-auto"
                    style="border-radius: 10px; width: 17%; cursor: pointer">
                    <Button :loading="acceptingAllProcess" type="button" @click="acceptAllInvitations()"
                            label="Accept All"/>
                </div>
            </span>
            <span v-else class="p-text-secondary mb-5 flex items-center justify-center mt-10
            ">
                No invites
            </span>
            <div v-for="invitation in invitations" :key="invitation.id"
                 class="mt-10 ml-3 flex items-center justify-between">
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
                            @click="acceptInvitation(invitation.sender_user_id)" label="Accept" icon="pi pi-plus"/>
                </div>
            </div>
        </Dialog>

        <!--    find and add people    -->
        <Dialog v-model:visible="addFriendDialogue" modal header="Search" class="dialog-box" @hide="closeDialogue">
            <span class="flex p-text-secondary mb-5">
                Search for people around the world and send them an invitation
            </span>
            <div class="mb-10 sm:px-20 bg-white border-gray-200">
                <SearchBox :searchValue="search" @update:searchValue="search = $event"
                           :aria-label="'Search for people'"/>
            </div>
            <!--     list of users    -->
            <div v-for="user in users" v-if="users.length" :key="user.id">
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
                        <Button :loading="user.accepting_process" :disabled="user.added"
                                :label="user.status ? user.status : 'Add'" type="button"
                                class="card flex justify-content-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4"
                                @click="addFriend(user)"/>
                    </div>
                </div>
            </div>
            <div v-else-if="noResults" class="flex items-center justify-center mt-10">
                No results
            </div>
        </Dialog>

        <Dialog v-model:visible="showChat" modal :header="loadingChat ? 'Loading...' : 'Chat'"
                :style="{ width: '45rem', height: '40em' }"
                class="chat-dialogue-box"
        >
            <div
                v-if="loadingChat"
                class="center flex items-center justify-center h-full overflow-hidden"
            >
                <ProgressSpinner style="width: 200px; height: 200px" strokeWidth="1" fill="white"
                                 animationDuration=".9s" aria-label="Custom ProgressSpinner"/>
            </div>
            <div v-else
                 style="height: 90%; overflow: auto"
                 class="chat bg-white border-gray-600 p-4 overflow-auto flex flex-col justify-between"
            >
                <!--      Chat        -->
                <div v-if="messages.length" class="mb-3">
                    <div v-for="(message, index) in messages"
                         :key="index"
                         class="my-2"
                    >
                        <div :class="message.user_id === $page.props.user.id ? 'text-right' : 'text-left'">
                            <span class="inline-block px-3 py-1 mr-2 rounded-lg"
                                  :class="message.user_id === $page.props.user.id ? 'bg-blue-500 text-white' : 'bg-green-300 text-black'">
                              {{ message.message }}
                            </span>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center">
                    No messages yet
                </div>
                <!--  text field  -->
            </div>
                <div>
                    <input
                        v-model="inputMessage"
                        type="text"
                        class="bg-gray-50 mt-4 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-300 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Your message"
                        required
                        autocomplete="off"

                    >
                </div>
        </Dialog>
    </div>

</template>

<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import spinner from "../Components/spinner.vue";
import LeftPannel from "@/Layouts/LeftPannel.vue";
import SearchBox from "@/Components/SearchBox.vue";
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
            addFriendDialogue: false,
            invitations: [],
            loadingInvitations: false,
            acceptingAllProcess: false,
            friends: [],
            loadingFriends: false,
            friendSearch: '',
            isOverlayPanelVisible: false,
            friendToDelete: null,
            showChat: false,
            chat: [],
            loadingChat: false,
            messages: [
                {
                    user_id: 3,
                    message: 'Hello'
                },
                {
                    user_id: 2,
                    message: 'Hi'
                },
                {
                    user_id: 3,
                    message: 'How are you?'
                },
                {
                    user_id: 2,
                    message: 'I am fine'
                },
                {
                    user_id: 3,
                    message: 'Good to hear that'
                },
                {
                    user_id: 2,
                    message: 'Yes'
                },

                {
                    user_id: 3,
                    message: 'Good to hear that'
                },
                {
                    user_id: 2,
                    message: 'Yes'
                },
                {
                    user_id: 3,
                    message: 'Good to hear that'
                },
                {
                    user_id: 2,
                    message: 'Yes'
                },
                {
                    user_id: 3,
                    message: 'Good to hear that'
                },
                {
                    user_id: 2,
                    message: 'Yes'
                },
                {
                    user_id: 3,
                    message: 'Good to hear that'
                },
                {
                    user_id: 2,
                    message: 'Yes'
                },
                {
                    user_id: 3,
                    message: 'Good to hear that'
                },
                {
                    user_id: 2,
                    message: 'Yes'
                },
                {
                    user_id: 3,
                    message: 'Good to hear that'
                },
                {
                    user_id: 2,
                    message: 'Yes'
                },
            ]
        }
    },
    layout: LeftPannel,
    computed: {
        noResults() {
            return !this.users.length && !this.loadingUsers && this.search;
        },
        testVar: {
            get() {
                return this.$store.state.testVar;
            },
            set(value) {
                this.$store.commit('setTestVar', value);
            }
        },
    },
    components: {
        Link,
        Head,
        spinner,
        SearchBox,
    },
    mounted() {
        this.getFriends();
        this.checkMyInvitations();
    },
    methods: {
        closeDialogue() {
            this.users = [];
            this.search = '';
        },
        getFriends() {
            this.loadingFriends = true;

            axios.get('/api/get-friends')
                .then(response => {
                    this.friends = response.data;
                })
                .catch(error => {
                    console.error(error);
                    toast.warning(error.response.data.message, {
                        position: 'bottom-right',
                        timeout: 5000,
                    })
                })
                .finally(() => {
                    this.loadingFriends = false;
                });
        },
        deleteFriend(event, friend) {
            // show confirmation dialogue
            this.$refs.op.toggle(event);
            this.friendToDelete = friend;

            // delete friend
            // axios.get('/api/delete-friend/' + friend.id)
            //     .then(response => {
            //         this.friends = response.data;
            //     })
            //     .catch(error => {
            //         console.error(error);
            //         toast.warning(error.response.data.message, {
            //             position: 'bottom-right',
            //             timeout: 5000,
            //         })
            //     })
            //     .finally(() => {
            //         this.loadingFriends = false;
            //     });
        },
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
                .then(response => {
                })
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

                    // fetch friends
                    this.getFriends();
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
        searchFriends() {
            // frontend filtering
            this.friends.forEach((friend) => {
                friend.hide = !friend.name.toLowerCase().includes(this.friendSearch.toLowerCase());
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

/* make the scroll bar having a blue and green gradient color */
.chat::-webkit-scrollbar {
    width: 10px;
}
.chat::-webkit-scrollbar-track {
    background: transparent;
}
.chat::-webkit-scrollbar-thumb {
    background: #72a1f4;
    border-radius: 10px;
}

/* hide the whole dialogue scrollbar for the chat */
.chat-dialogue-box:first-child .p-dialog-content {
    overflow: hidden;
}

/* center elem */
.center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.p-badge-warning {
    background: #fdb500 !important;
}

.main-block {
    border-radius: 30px;
    min-height: 90vh;
    margin-bottom: 50px;
}

/*dialogue boxes*/
.dialog-box {
    width: 45em;
    height: 40em;
}

/* For devices with screen width less than 600px */
@media screen and (max-width: 600px) {
    .dialog-box {
        width: 90%;
        /* or any other value that fits well on mobile devices */
        height: auto;
    }
}

.searchFriendBox {
    border: 3px solid #1765fa;
    border-radius: 100px;
    width: 100%;
    height: 40px;
    padding-left: 10px;
}
</style>
