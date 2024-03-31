<template>
    <div>
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
            <div v-else>
                <div style="height: 30em; overflow: auto"
                     class="chat bg-white border-gray-600 p-4 overflow-auto flex flex-col justify-between"
                >
                    <!--      Chat        -->
                    <div v-if="messages.length" class="mb-3">
                        <div v-for="(message, index) in messages"
                             :key="index"
                             class="my-2 mt-4"
                        >
                            <div :class="message.user_id === $page.props.user.id ? 'text-right' : 'text-left'">
                                <span class="inline-block px-3 py-1 mr-2 rounded-lg"
                                      :class="message.user_id === $page.props.user.id ? 'bg-blue-500 text-white' : 'bg-green-300 text-black'">
                                  {{ message.title }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center">
                        No messages yet
                    </div>
                </div>
                <!--  text field  -->
                <input
                    v-model="inputMessage"
                    @keydown.enter="sendMessage"
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
export default {
    name: "Chat",

    data() {
        return {
            loadingChat: false,
            inputMessage: '',
            messages: [],
            countScroll: 0,
        }
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
        chatDialogue: {
            get() {
                return this.$store.state.chatDialogue;
            },
            set(value) {
                this.$store.commit('setChatDialogue', value);
            }
        },
    },
    methods: {
        getChatMessages() {
            this.loadingChat = true;
            axios.post('/api/get-messages', [this.recipientID])
                .then(response => {
                    this.messages = response.data;

                    this.scrollToBottom();
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
        sendMessage() {
            axios.post('/api/send-message', this.inputMessage)
                .then(response => {
                    // figure out the loading of the message
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
                        this.countScroll = 0;
                    } else {
                        this.scrollToBottom();
                        this.countScroll++;
                    }
                });
            }, 100);

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


</style>
