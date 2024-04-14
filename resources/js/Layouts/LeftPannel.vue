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
        <Chat
            ref="chatComponent"
            :newPrivateMessage="newPrivateMessage"
        />
    </div>
    <slot/>
</template>


<script>

import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import Chat from "@/Components/Chat.vue";
import "../../../public/cssform/sidebar.css";
import "../../../public/cssform/select.scss";
import {useToast} from "vue-toastification";
import { ref } from 'vue';

const toast = useToast();

export default {
    name: "TableTest",

    data() {
        return {
            newPrivateMessage: null,
        }
    },

    components: {
        Link,
        Chat,
    },

    computed: {
        privateMessages: {
            get() {
                return this.$store.state.privateMessages;
            },
            set(value) {
                this.$store.commit('setPrivateMessages', value);
            }
        },
        recipientID: {
            get() {
                return this.$store.state.recipientID;
            },
            set(value) {
                this.$store.commit('setRecipientID', value);
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

                // private messages
                Echo.private('messages-for-user.' + this.$page.props.user.id)
                    .listen('.private.messages', res => {
                        this.handleNewPrivateMessage(res.message, res.sender, res.created_at);
                    })
            }
        },
        leaveChannels() {
            Echo.leave('invite-from.' + this.$page.props.user.id)
        },
        closePanel() {
            document.querySelector('.sidebarIconToggle').click();
        },
        handleNewPrivateMessage(message, sender, created_at) {
            // TODO: fix the issue of returning using through the event
            // TODO: fix the multiple notifications issue
            // TODO: add the friend check in the backend 'channel'

            this.newPrivateMessage = {title: message, name: sender.name, user_id: sender.id, created_at: created_at};

            // if the current user is looking at the chat then add the new message to the UI, otherwise only show a notification
            if (this.recipientID) {
                this.privateMessages.push(this.newPrivateMessage)
                this.$refs.chatComponent.scrollToBottom();
            } else {
                this.$refs.chatComponent.showNotification();
            }
        },
    },

}
</script>

<style>

.p-badge-warning {
    background: #fdb500 !important;
}

.p-dialog {
    font-family: 'Nunito', sans-serif;
}

/* change the style of the notification dialogue header   */
.newPrivateMessageNotification .p-dialog-title {
    font-size: 20px;
    color: black;
    /*remove bold text*/
    font-weight: normal;
}

</style>
