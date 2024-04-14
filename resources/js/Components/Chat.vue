<template>
    <div>
        <Dialog v-model:visible="chatDialogue" modal
                :header="loadingChat ? 'Loading...' : recipients.map(recipient => recipient.name).join(', ')"
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
            <div v-else>
                <div style="height: 30em; overflow: auto"
                     class="chat bg-white border-gray-600 p-4 overflow-auto flex flex-col justify-between"
                >
                    <!--      Chat        -->
                    <div v-if="privateMessages.length" class="mb-3">
                        <div v-for="(message, index) in privateMessages"
                             :key="index"
                             class="my-2 mt-4"
                        >
                            <div :class="message.user_id === $page.props.user.id ? 'text-right' : 'text-left'">
                                <div
                                    class="p-button p-button-loading mb-5 card py-1 px-4"
                                    style="cursor: default;"
                                    :class="[
                                         message.user_id === $page.props.user.id ? 'bg-blue-500 text-white' : 'bg-green-300 text-black',
                                         message.loading ? 'p-disabled' : ''
                                     ]"
                                    type="button" data-pc-name="button" data-pc-section="root">
                                    <svg v-if="message.loadingKey"
                                         id="sendingMessageSpinner"
                                         width="14" height="14" viewBox="0 0 14 14" fill="none"
                                         xmlns="http://www.w3.org/2000/svg"
                                         class="p-icon p-icon-spin p-button-loading-icon pi-spin p-button-icon p-button-icon-left"
                                         aria-hidden="true" data-pc-section="loadingicon">
                                        <path
                                            d="M6.99701 14C5.85441 13.999 4.72939 13.7186 3.72012 13.1832C2.71084 12.6478 1.84795 11.8737 1.20673 10.9284C0.565504 9.98305 0.165424 8.89526 0.041387 7.75989C-0.0826496 6.62453 0.073125 5.47607 0.495122 4.4147C0.917119 3.35333 1.59252 2.4113 2.46241 1.67077C3.33229 0.930247 4.37024 0.413729 5.4857 0.166275C6.60117 -0.0811796 7.76026 -0.0520535 8.86188 0.251112C9.9635 0.554278 10.9742 1.12227 11.8057 1.90555C11.915 2.01493 11.9764 2.16319 11.9764 2.31778C11.9764 2.47236 11.915 2.62062 11.8057 2.73C11.7521 2.78503 11.688 2.82877 11.6171 2.85864C11.5463 2.8885 11.4702 2.90389 11.3933 2.90389C11.3165 2.90389 11.2404 2.8885 11.1695 2.85864C11.0987 2.82877 11.0346 2.78503 10.9809 2.73C9.9998 1.81273 8.73246 1.26138 7.39226 1.16876C6.05206 1.07615 4.72086 1.44794 3.62279 2.22152C2.52471 2.99511 1.72683 4.12325 1.36345 5.41602C1.00008 6.70879 1.09342 8.08723 1.62775 9.31926C2.16209 10.5513 3.10478 11.5617 4.29713 12.1803C5.48947 12.7989 6.85865 12.988 8.17414 12.7157C9.48963 12.4435 10.6711 11.7264 11.5196 10.6854C12.3681 9.64432 12.8319 8.34282 12.8328 7C12.8328 6.84529 12.8943 6.69692 13.0038 6.58752C13.1132 6.47812 13.2616 6.41667 13.4164 6.41667C13.5712 6.41667 13.7196 6.47812 13.8291 6.58752C13.9385 6.69692 14 6.84529 14 7C14 8.85651 13.2622 10.637 11.9489 11.9497C10.6356 13.2625 8.85432 14 6.99701 14Z"
                                            fill="currentColor"></path>
                                    </svg>
                                    <span class="p-button-label">
                                        {{ message.title }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center">
                        No messages yet
                    </div>
                </div>

                <textarea
                    v-model="inputMessage"
                    @keydown.enter.prevent="sendMessage(inputMessage)"
                    ref="messageInput"
                    class="message-input bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-300 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Your message"
                    required
                    autocomplete="off"
                />

                <!-- message character limit -->
                <div class="flex" style="justify-content: flex-end;"
                     :style="{ color: inputMessage.length > 1000 ? 'red' : 'black' }"
                >
                    <div v-if="inputMessage.length > 1000" style="margin-right: auto;">
                        Your message is too long
                    </div>
                    <div v-if="inputMessage.length > 900">
                        1000 / {{ inputMessage.length }}
                    </div>
                </div>
            </div>
        </Dialog>

        <!--   Notification about messages   -->
        <Dialog v-model:visible="showMessageNotification"
                v-if="newPrivateMessage"
                header="New message"
                :style="{ width: '25rem' }" position="bottomright" :modal="false" :draggable="false"
                class="newPrivateMessageNotification"
                :dismissableMask="true"
        >
            <div class="align-items-center gap-3 mb-5" style="font-size: 20px">
                <b>{{ newPrivateMessage.name }}</b> <br>
                {{ newPrivateMessage.title }}
            </div>
            <div class="flex justify-between">
                <Button type="button" label="Open chat"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4"
                        @click="chatDialogue = true; recipientID = newPrivateMessage.user_id"/>
            </div>
        </Dialog>
    </div>
</template>
<script>
import {ref} from "vue";

export default {
    name: "Chat",

    data() {
        return {
            loadingChat: false,
            inputMessage: '',
            recipients: [],
            countScroll: 0,
            temporaryLoadingKeys: [],
            notificationTimer: 3,
            intervalNotification: null,
            showMessageNotification: false,
        }
    },
    computed: {
        textareaStyle() {
            const lines = this.inputMessage.split('\n').length;
            const height = Math.min(lines * 1.15, 20) + 'em'; // Adjust the multiplier and maximum value as needed
            return {height};
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
        privateMessages: {
            get() {
                return this.$store.state.privateMessages;
            },
            set(value) {
                this.$store.commit('setPrivateMessages', value);
            }
        },
    },
    props: {
        newPrivateMessage: {
            type: Object,
            default: null,
        },
    },
    methods: {
        getChatMessages() {
            this.loadingChat = true;
            axios.post('/api/get-messages', [this.recipientID])
                .then(response => {
                    this.privateMessages = response.data.messages;
                    this.recipients = response.data.recipients;

                    this.scrollToBottom();

                    // focus on the input field
                    setTimeout(() => {
                        this.$refs.messageInput.focus();
                    }, 100)
                })
                .catch(error => {
                    console.error(error);
                    toast.warning(error.response.data.message, {
                        position: 'bottom-right',
                    })
                })
                .finally(() => {
                    this.loadingChat = false;
                })
        },
        sendMessage(message) {
            // remove spaces
            message = message.trim();

            if (!message || message.length > 1000) return;

            this.inputMessage = '';

            // create a unique loading key so that will be able to disable loading for a bunch of sent messages
            let newKey = this.generateRandomHash();

            // add the message through the UI
            message = {
                user_id: this.$page.props.user.id,
                title: message,
                loadingKey: newKey,
            };

            this.privateMessages.push(message)
            this.scrollToBottom();

            axios.post('/api/send-message', {
                message: message,
                recipients: this.recipients,
            })
                .then(response => {
                    // disable loading
                    this.privateMessages.forEach((item) => {
                        if (item.hasOwnProperty('loadingKey') && item.loadingKey === newKey) {
                            delete item.loadingKey;

                            // forget the key
                            const index = this.temporaryLoadingKeys.findIndex((key) => key === newKey);
                            if (index !== -1) {
                                this.temporaryLoadingKeys.splice(index, 1);
                            }
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
        scrollToBottom() {
            if (this.countScroll >= 150) return; // something went wrong...

            setTimeout(() => {
                const chat = document.querySelector('.chat');
                this.$nextTick(() => {
                    if (chat) {
                        chat.scrollTop = chat.scrollHeight;
                        this.countScroll = 0; // reset the counter
                    } else {
                        this.scrollToBottom();
                        this.countScroll++;
                    }
                });
            }, 100);

        },
        generateRandomHash() {
            let newKey = Math.random().toString(36).substring(2, 15);

            // make sure it's unique
            while (this.temporaryLoadingKeys.includes(newKey)) {
                newKey = Math.random().toString(36).substring(2, 15);
            }
            this.temporaryLoadingKeys.push(newKey);

            return newKey;
        },
        normalizeDate(date) {
            return new Date(date).toLocaleString(undefined, {hour: 'numeric', minute: 'numeric'});
        },
        closeChat() {
            // reset
            this.recipientID = null;
            this.recipients = [];
            this.privateMessages = [];
        },
        showNotification() {
            clearInterval(this.intervalNotification);
            this.notificationTimer = 10;
            this.showMessageNotification = true;

            this.intervalNotification = setInterval(() => {
                this.notificationTimer--;

                if (this.notificationTimer <= 0) {
                    // close dialogue
                    this.showMessageNotification = false;
                    clearInterval(this.intervalNotification);
                }
            }, 1000)
        }
    },
    watch: {
        chatDialogue: {
            handler(val) {
                if (val) {
                    this.getChatMessages();
                } else {
                    this.closeChat();
                }
            }
        },
    }
}
</script>
<style scoped>
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

/* change the style of the notification dialogue header   */
.p-dialog-title {
    background: red;
}

/* message text position */
.p-button {
    text-align: left !important;
}

/* TODO: make the input message field responsive to the amount of text it contains */
.message-input {
    resize: none;
    overflow-y: auto;
    max-height: 400px !important;
}

</style>
