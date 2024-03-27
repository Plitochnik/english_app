<template>

    <div class="header"></div>
    <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
    <label for="openSidebarMenu" class="sidebarIconToggle">
        <div class="spinner diagonal part-1"></div>
        <div class="spinner horizontal"></div>
        <div class="spinner diagonal part-2"></div>
    </label>
    <div id="sidebarMenu">
        <ul class="sidebarMenuInner" @click.prevent="closePanel()">
            <li v-if="!$page.props.user" class="log-in">
                <u class="unregister">
                    <Link :href="route('login')">Log In</Link>
                </u>
                <span>User</span>
            </li>
            <li v-else class="log-in">
                <Link :href="route('home')">{{ $page.props.user.name }}</Link>
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
            <a v-if="$page.props.user" @click="logout" class="logout">
                <button type="submit" class="">
                    Log out
                </button>
            </a>
        </ul>

        <!--  chat  -->
        <Dialog v-model:visible="chatDialogue" modal :header="loadingChat ? 'Loading...' : 'Chat'"
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
    <slot/>
</template>


<script>

import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import "../../../public/cssform/sidebar.css";
import "../../../public/cssform/select.scss";
import {useToast} from "vue-toastification";

const toast = useToast();

export default {
    name: "TableTest",

    data() {
        return {
            loadingChat: false,
            inputMessage: '',
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

    components: {
        Link,
    },

    computed: {
        recipientID: {
            get() {
                return this.$store.state.recipientID;
            },
            set(value) {
                this.$store.commit('setRecipientID', value);
            }
        },
        chat: {
            get() {
                return this.$store.state.chat;
            },
            set(value) {
                this.$store.commit('setChat', value);
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

    mounted() {
        this.listenChannels();
    },

    methods: {
        logout() {
            toast.info('You\'ve been log out', {
                position: 'bottom-right',
                timeout: 1000,
            })

            // leave channels
            this.leaveChannels();

            Inertia.post(route('logout'));
        },
        listenChannels() {
            if (this.$page.props.user) {
                // Invitation
                Echo.channel('invite-from.' + this.$page.props.user.id)
                    .listen('.invitation', res => {
                        toast.info(res.message, {
                            position: 'bottom-right',
                            timeout: 5000,
                        })
                    })

                //
            }
        },
        leaveChannels() {
            Echo.leave('invite-from.' + this.$page.props.user.id)
        },
        closePanel() {
            document.querySelector('.sidebarIconToggle').click();
        },
        getChatMessages() {

        },
    },
    watch: {
        chatDialogue: {
            handler(val) {
                if (val) {
                    this.getChatMessages();
                } else {
                    // when chat dialogue is being closed then reset the recipient ID
                    this.recipientID = null;
                }
            }
        },

    }
}
</script>

<style scoped>

</style>
