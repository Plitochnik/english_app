<template>

    <div class="header"></div>
    <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
    <label for="openSidebarMenu" class="sidebarIconToggle">
        <div class="spinner diagonal part-1"></div>
        <div class="spinner horizontal"></div>
        <div class="spinner diagonal part-2"></div>
    </label>
    <div id="sidebarMenu" style="display: flex; flex-direction: column; justify-content: space-between; height: 94%;">
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
            <li class="dashboard" style="padding: 0;">
                <Link :href="route('dashboard')" target="_blank" class="flex">
                    <i class="pi pi-chart-bar mr-4" style="font-size: 1rem"/>
                    Dashboard
                </Link>
            </li>
            <li class="settings" style="padding: 0">
                <Link :href="route('show.friends')" target="_blank" class="flex">
                    <i class="pi pi-users mr-4" style="font-size: 1rem"/>
                    Friends
                </Link>
            </li>
            <li class="settings" style="padding: 0">
                <Link :href="route('profile.show')" target="_blank" class="flex">
                    <i class="pi pi-cog mr-4" style="font-size: 1rem"/>
                    Account
                </Link>
            </li>
        </ul>
        <a v-if="$page.props.user" @click="logout" class="logout" style="margin-top: auto;">
            <button type="submit" class="flex" style="white-space: nowrap; width: 100%">
                <i class="pi pi-sign-out mr-2" style="font-size: 1rem"/>
                Log out
            </button>
        </a>

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
import {ref} from 'vue';

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
        detectCurrentModule(module) {
            const url = window.location.href;
            return url.includes(module);
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
                        this.handleNewPrivateMessage(res.message, res.sender);
                    })
            }
        },
        leaveChannels() {
            Echo.leave('invite-from.' + this.$page.props.user.id)
        },
        closePanel() {
            document.querySelector('.sidebarIconToggle').click();
        },
        handleNewPrivateMessage(message, sender) {
            // TODO: add the friend check in the backend 'channel

            this.newPrivateMessage = {
                title: message.title,
                name: sender.name,
                user_id: sender.id,
                created_at: message.created_at
            };

            // if the current user is looking at the chat then add the new message to the UI, otherwise only show a notification
            if (this.recipientID) {
                this.privateMessages.push(this.newPrivateMessage)
                this.$refs.chatComponent.scrollToBottom();
                this.$refs.chatComponent.setMessageAsSeen(message.id);
            } else {
                this.$refs.chatComponent.showNotification();
            }
        },
    },

}
</script>

<style>
* {
    font-family: 'Mulish', sans-serif;
}

.p-badge-warning {
    background: #fdb500 !important;
}

/*.p-dialog {
    font-family: 'Nunito', sans-serif;
}*/

/* change the style of the notification dialogue header   */
.newPrivateMessageNotification .p-dialog-title {
    font-size: 20px;
    color: black;
    /*remove bold text*/
    font-weight: normal;
}

.blue-button {
    color: #ffffff;
    background: #2563ea;
    border: 1px solid #2563ea;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    transition: background-color 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s, outline-color 0.2s;
    border-radius: 6px;
    outline-color: transparent;
}

.blue-button:hover {
    background: #1e4bb1;
}

</style>
