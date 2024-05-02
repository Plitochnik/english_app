<template>
    <Head title="Friends"/>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding-top: 10px;">
        <div class="main-block bg-white overflow-hidden shadow-xl">
            <div class="flex justify-end gap-2 p-6">
                <Button label="Invitations" @click="getFriendshipInvitations(); invitesDialogue = true"
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
                        <div>
                            <span class="font-medium text-900 block mb-3">
                                Do you want to delete
                                {{ friendToDelete.name }} friend?
                            </span>
                        </div>
                        <div class="flex flex-column justify-content-center gap-3 w-25rem">
                            <Button label="Confirm" type="button"
                                    @click="deleteFriend"
                                    class="card flex justify-content-center bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4"/>
                            <Button label="Cancel" type="button"
                                    @click="cancelDelete"
                                    class="card flex justify-content-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4"/>
                        </div>
                    </OverlayPanel>

                    <!--    list of friends    -->
                    <div v-for="friend in friends" :key="friend.id"
                         class="hover:bg-gray-100 border-gray-200 rounded-md pl-4 pr-4 pb-4"
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
                            <div class="ml-auto button-container" style="display: flex; align-items: center;">
                                <div style="position: relative;">
                                    <Button :loading="friend.loading"
                                            icon="pi pi-envelope" type="button"
                                            @click="startChat(friend)"
                                            class="mt-4 card justify-content-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4"
                                    />
                                    <Badge v-if="friend.new_messages" :value="friend.new_messages"
                                           style="position: absolute; top: 0; right: -10px;"></Badge>
                                </div>
                                <Button :loading="friend.loading"
                                        icon="pi pi-trash" type="button"
                                        @click="confirmFriendDeletion($event, friend)"
                                        class="mt-4 ml-3 card justify-content-center bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4"
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
            <div v-if="invitations.length">
                <span class="flex p-text-secondary mb-5">
                    Invites that you have received
                    <div
                        class="card flex justify-content-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 ml-auto"
                        style="border-radius: 10px; cursor: pointer">
                        <Button :loading="acceptingAllProcess" type="button" @click="acceptAllInvitations()"
                                label="Accept All"/>
                    </div>
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
                        <Button :loading="invitation.loading" type="button"
                                @click="acceptInvitation(invitation.sender_user_id)" label="Accept" icon="pi pi-plus"/>
                    </div>
                </div>
            </div>
            <div v-else-if="gettingInvitations"
                 class="center flex items-center justify-center h-full overflow-hidden"
            >
                <ProgressSpinner style="width: 150px; height: 150px" strokeWidth="1" fill="white"
                                 animationDuration=".9s" aria-label="Custom ProgressSpinner"/>
            </div>
            <span v-else-if="noInvitations" class="p-text-secondary mb-5 flex items-center justify-center mt-10
            ">
                No invites
            </span>
        </Dialog>

        <!--    find and add people    -->
        <Dialog v-model:visible="addFriendDialogue" :style="{ height: '40em' }" modal header="Search" class="dialog-box"
                @hide="closeDialogue">
            <span class="flex p-text-secondary mb-5">
                Search for people around the world and send them an invitation
            </span>
            <div class="mb-10 sm:px-20">
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
                        <Button :loading="user.loading" :disabled="user.added"
                                :label="user.status ? user.status : 'Add'" type="button"
                                class="card flex justify-content-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4"
                                @click="addFriend(user)"/>
                    </div>
                </div>
            </div>
            <div v-else-if="searchingUsers"
                 class="center mt-10 flex items-center justify-center h-full overflow-hidden"
            >
                <ProgressSpinner style="width: 150px; height: 150px" strokeWidth="1" fill="white"
                                 animationDuration=".9s" aria-label="Custom ProgressSpinner"/>
            </div>
            <div v-else-if="noUsersFound" class="flex items-center justify-center mt-10">
                No results
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
            searchingUsers: false,
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
            gettingInvitations: false,
        }
    },
    layout: LeftPannel,
    computed: {
        url() {
            return window.location.href;
        },
        noUsersFound() {
            return !this.users.length && !this.searchingUsers && this.search && !this.searchInterval;
        },
        noInvitations() {
            return !this.invitations.length && !this.gettingInvitations;
        },
        recipientID: {
            get() {
                return this.$store.state.recipientID;
            },
            set(value) {
                this.$store.commit('setRecipientID', value);
            }
        },
        chatDialogue: {
            get() {
                return this.$store.state.chatDialogue;
            },
            set(value) {
                this.$store.commit('setChatDialogue', value);
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
        this.getFriendshipInvitations();
    },
    methods: {
        closeDialogue() {
            this.users = [];
            this.search = '';
        },
        confirmFriendDeletion(event, friend) {
            this.$refs.op.toggle(event);
            this.friendToDelete = friend;
        },
        cancelDelete() {
            this.$refs.op.hide();
            this.friendToDelete = null;
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
                    })
                })
                .finally(() => {
                    this.loadingFriends = false;
                });
        },
        deleteFriend() {
            // get friend we're deleting
            let user = this.friends.find((user) => user.id === this.friendToDelete.id);

            if (!user.hasOwnProperty('deleting')) {
                this.friends.forEach((item) => {
                    if (item.id === this.friendToDelete.id) {
                        item.deleting = true;
                    }
                })

                this.$refs.op.hide();

                axios.delete('/api/delete-friend/' + this.friendToDelete.id)
                    .then(response => {
                        this.friends = response.data;

                        toast.success('Success', {
                            position: 'bottom-right',
                        })
                    })
                    .catch(error => {
                        console.error(error);
                        toast.warning(error.response.data.message, {
                            position: 'bottom-right',
                        })
                    })
            }
        },
        startChat(friend) {
            this.chatDialogue = true;
            this.recipientID = friend.id;
            this.readMessages(friend.id)
        },
        readMessages(friendID) {
            axios.get('/api/set-messages-read/' + friendID)
                .then(response => {
                    this.friends.forEach((user) => {
                        if (user.id === friendID) {
                            user.new_messages = 0;
                        }
                    })
                })
                .catch(error => {
                    console.error('Error reading messages:', error);
                })
                .finally(() => {
                    this.searchingUsers = false;
                });
        },
        searchPeople(name) {
            this.searchingUsers = true;

            axios.get('/api/search-people/' + name)
                .then(response => {
                    this.users = response.data;
                })
                .catch(error => {
                    console.error('Error fetching users:', error);
                })
                .finally(() => {
                    this.searchingUsers = false;
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
                // we are friends
                case 'Friend':
                    return;
            }

            // activate loading
            this.users.forEach((item) => {
                if (item.id === user.id) {
                    item.loading = true;
                }
            })

            axios.get('/api/add-friend/' + user.id)
                .then(response => {
                    this.users.forEach((item) => {
                        if (item.id === user.id) {
                            item.status = 'Invited';
                            item.loading = false;
                        }
                    })
                })
                .catch(error => {
                    console.error(error);
                    toast.warning(error.response.data.message, {
                        position: 'bottom-right',
                    })
                })
        },
        getFriendshipInvitations() {
            this.gettingInvitations = true;

            axios.get('/api/check-invites')
                .then(response => {
                    this.invitations = response.data;
                })
                .catch(error => {
                    console.error(error);
                    toast.warning(error.response.data.message, {
                        position: 'bottom-right',
                    })
                })
                .finally(() => {
                    this.loadingInvitations = false;
                    this.gettingInvitations = false
                });
        },
        acceptInvitation(id) {
            // activate loading
            this.invitations.forEach((item) => {
                if (item.id === id) {
                    item.loading = true;
                }
            })

            // list of searched users
            this.users.forEach((user) => {
                if (user.id === id) {
                    user.loading = true;
                }
            })

            axios.get('/api/accept-friendship-invitation/' + id)
                .then(response => {
                    this.invitations = response.data;

                    this.users.forEach((user) => {
                        if (user.id === id) {
                            user.loading = false;
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
                    })
                })
                .finally(() => {
                    // deactivate loading spinner
                    this.invitations.forEach((item) => {
                        if (item.sender_id === id) {
                            item.loading = false;
                        }
                    })
                });
        },
        acceptAllInvitations() {
            this.acceptingAllProcess = true;
            axios.get('/api/accept-all-invitations')
                .then(response => {
                    this.invitations = response.data;
                    this.getFriends();
                })
                .catch(error => {
                    console.error(error);
                    toast.warning(error.response.data.message, {
                        position: 'bottom-right',
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
                    this.searchInterval = null;
                }, 500);
            }
        }
    }
}

</script>

<style lang="css">

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

.p-badge {
    background: #fdb500 !important;
    color: white;
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
