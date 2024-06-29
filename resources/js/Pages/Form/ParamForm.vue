<template>

    <Head title="Start"/>

    <div class="holder">
        <div class="whiteBlock">
            <div class="parameters">
                <div class="font text-center">
                    <p class="text-4xl">Test parameters</p>
                </div>

                <!--  game mode  -->
                <div style="display: grid" class="mt-7">
                    <span>Game mode</span>
                    <div class="flex mt-1">
                        <div class="selectPanel">
                            <Button @click="expandPanel(false)" icon="pi pi-user" label="Local"
                                    :class="{ 'selectedMode': !testObject.is_online, 'nonSelectedMode': testObject.is_online }"/>
                            <Button @click="expandPanel(true)" icon="pi pi-users"
                                    label="Online"
                                    :class="{ 'selectedMode': testObject.is_online, 'nonSelectedMode': !testObject.is_online }"/>
                        </div>
                    </div>
                </div>

                <!--  number of players  -->
                <div v-if="testObject.is_online"
                     style="display: grid" class="mt-4"
                >
                    <span>Number of players</span>
                    <div class="flex mt-1">
                        <div class="selectPanel">
                            <Button v-for="(n, index) in 3" @click="testObject.players_count = (index + 2)"
                                    :label="(index + 2).toString()"
                                    :class="{ 'selectedMode': testObject.players_count === (index + 2), 'nonSelectedMode': testObject.players_count !== (index + 2) }"/>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="validate">
                    <div class="form mt-4">
                        <div class="mt-2 text-red-600">
                            {{ checker_home_lang }}
                        </div>
                        <div class="mt-1 font">
                            Test from
                        </div>
                        <div class="mt-1 testObject.test_from">
                            <!--                            <Dropdown v-model="testObject.test_from" :options="languages" filter
                                                                  optionLabel="name" placeholder="Select a language"
                                                                  class="w-full md:w-14rem">
                                                            <template #value="slotProps">
                                                                <span v-if="slotProps.value"
                                                                      style="display: ruby-text; text-align: left;">
                                                                    <img :alt="slotProps.value.label"
                                                                         src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png"
                                                                         :class="`mr-2 flag flag-${slotProps.value.code.toLowerCase()}`"
                                                                         style="width: 18px"/>
                                                                    <div>{{ slotProps.value.name }} </div>
                                                                </span>
                                                                <span v-else>
                                                                    {{ slotProps.placeholder }}
                                                                </span>
                                                            </template>
                                                            <template #option="slotProps">
                                                                <div style="display: contents">
                                                                    <img :alt="slotProps.option.label"
                                                                         src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png"
                                                                         :class="`mr-2 flag flag-${slotProps.option.code.toLowerCase()}`"
                                                                         style="width: 18px"/>
                                                                    <div>{{ slotProps.option.name }}</div>
                                                                </div>
                                                            </template>
                                                        </Dropdown>-->
                        </div>
                    </div>
                    <div>
                        <hr style="border-color: #7d7d7d; position: relative; top: 10px;">
                    </div>
                    <div class="form mt-4">
                        <div class="mt-3 text-red-600">
                            {{ checker_test_lang }}
                        </div>
                        <div class="font">
                            Test to
                        </div>
                        <div>
                            <div class="mt-1 testObject.test_to">
                                <!--                                <Dropdown v-model="testObject.test_to" :options="languages" filter
                                                                          optionLabel="name" placeholder="Select a language"
                                                                          class="w-full md:w-14rem">
                                                                    <template #value="slotProps">
                                                                                    <span v-if="slotProps.value"
                                                                                          style="display: ruby-text; text-align: left;">
                                                                                        <img :alt="slotProps.value.label"
                                                                                             src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png"
                                                                                             :class="`mr-2 flag flag-${slotProps.value.code.toLowerCase()}`"
                                                                                             style="width: 18px"/>
                                                                                        <div>{{ slotProps.value.name }} </div>
                                                                                    </span>
                                                                        <span v-else>
                                                                                        {{ slotProps.placeholder }}
                                                                                    </span>
                                                                    </template>
                                                                    <template #option="slotProps">
                                                                        <div style="display: contents">
                                                                            <img :alt="slotProps.option.label"
                                                                                 src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png"
                                                                                 :class="`mr-2 flag flag-${slotProps.option.code.toLowerCase()}`"
                                                                                 style="width: 18px"/>
                                                                            <div>{{ slotProps.option.name }}</div>
                                                                        </div>
                                                                    </template>
                                                                </Dropdown>-->
                            </div>
                            <div>
                                <div>
                                    <div class="mt-3 position-absolute mb-2 font">{{
                                            testObject.language_level
                                        }}
                                    </div>
                                </div>
                                <div>
                                    <input type="radio" id="one" value="Upper-Intermediate"
                                           v-model="testObject.language_level"/>
                                    <label class="ml-1 mb-2 mr-4" for="one">В1-В2</label>

                                    <input type="radio" id="two" value="Advanced"
                                           v-model="testObject.language_level"/>
                                    <label class="ml-1" for="two">С1-С2</label>
                                </div>
                            </div>
                            <!--                                    <start-online-game-button></start-online-game-button>-->
                            <start-test-button></start-test-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="onlineGameSetUp text-center">
            <div class="text-4xl">Online game</div>
            <div class="mt-6">
                <!-- generate code button -->
                <div v-if="!testObject.key && !generatingKey" class="mt-6">
                    <Button aria-label="copy"
                            @click.prevent="generateKey"
                            class="bg-blue-500 hover:bg-blue-600 text-white"
                            label="Generate code"/>
                </div>
                <!-- generating qr code skeleton -->
                <div v-else-if="generatingKey" class="mt-7">
                    <div style="display: flex; justify-content: center">
                        <Skeleton width="150px" height="150px"></Skeleton>
                    </div>

                    <div style="display: flex">
                        <Skeleton height="2rem" class="mt-2"></Skeleton>
                        <Skeleton size="2rem" class="mt-2 ml-2"></Skeleton>
                    </div>

                    <div style="display: flex" class="mt-7">
                        <Skeleton width="5rem" class="mb-2" height="19px"></Skeleton>
                    </div>
                </div>
                <!-- actual code -->
                <div class="gameCredentials">
                    <canvas id="qr"/>
                    <div v-if="testObject.key && !generatingKey"
                         style="display: flex; width: 100%; justify-content: center" class="mt-2">
                        <InputText v-model="shareGameURL" disabled class="pl-2" style="cursor: text; width: 67%"/>
                        <Button @click="copyKey" :icon="isKeyCopied ? 'pi pi-check' :'pi pi-copy'" aria-label="copy"
                                class="copyKeyButton ml-2"/>
                    </div>
                </div>
            </div>

            <div v-if="testObject.key && !generatingKey">
                <div class="text-left flex mt-7">
                    <InputSwitch v-model="testObject.is_private"
                                 @click="testObject.is_private = !testObject.is_private"/>
                    <span class="ml-2">Private game</span>
                </div>
                <!--  list of friends  -->
                <div v-if="friends.length && testObject.is_private" class="friends mt-7">
                    <div v-for="user in friends" :key="user.id" class="friendRow rounded-lg">
                        <div class="flex py-2 ml-1">
                            <!--    user's image or just first letter of their name     -->
                            <div v-if="user.profile_photo_path" class="flex-shrink-0">
                                <img :src="user.profile_photo_path" class="w-10 h-10 rounded-full">
                            </div>
                            <div v-else
                                 class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-500 text-white">
                                {{ user.name.charAt(0) }}
                            </div>

                            <div class="ml-4 text-xl font-medium text-gray-900">
                                {{ user.name }}
                            </div>
                            <div class="ml-auto">
                                <Button :loading="user.loading" :disabled="user.added"
                                        :label="user.status ? user.status : 'Give access'" type="button"
                                        class="card flex justify-content-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 mr-1"/>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  skeleton loading users  -->
                <div v-else-if="!friends.length && gettingFriends" class="mt-5">
                    <div v-for="n in 5">
                        <div class="flex items-center py-2">
                            <Skeleton shape="circle" size="2.6rem" class="mr-2"></Skeleton>
                            <Skeleton width="7rem" class="ml-2"></Skeleton>
                            <Skeleton class="ml-auto" width="8.5rem" height="2.3rem"></Skeleton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import StartOnlineGameButton from "@/Pages/Form/PartsOfForm/StartOnlineGameButton.vue";
import StartTestButton from "@/Pages/Form/PartsOfForm/StartTestButton.vue";
import LeftPannel from '@/Layouts/LeftPannel.vue';
import QRious from 'qrious';

export default {
    name: "ParamForm",
    data() {
        return {
            languages: [
                {name: 'Ukrainian', code: 'UA'},
                {name: 'Russian', code: 'RU'},
                {name: 'English', code: 'UK'},
                {name: 'Spanish', code: 'ES'}
            ],
            testObject: {
                is_online: true,
                is_private: false,
                total_questions: 10,
                test_from: 'Russian',
                test_to: 'Russian',
                players_count: 2,
                language_level: 'Upper-Intermediate',
                key: null,
            },
            shareGameURL: null,
            checker_test_lang: '',
            checker_home_lang: '',
            generatingKey: false,
            friends: [],
            isKeyCopied: false,
            gettingFriends: false,
        }
    },
    components: {
        Head,
        StartTestButton,
        StartOnlineGameButton,
        Link,
    },
    layout: LeftPannel,
    methods: {
        generateKey() {
            // if user is not logged in, redirect to login page
            if (!this.$page.props.user) {
                this.$inertia.visit('/login');
                return;
            }

            // if (!this.validate()) {
            //     return;
            // }

            this.generatingKey = true;

            // generate secret key
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            this.testObject.key = Array.from({length: 16}, () => characters[Math.floor(Math.random() * characters.length)]).join('');
            this.shareGameURL = window.location.href + 'vocabulary-game?game-id=' + this.testObject.key;

            this.setUpGame();
        },
        setUpGame() {
            axios.post('/api/set-up-game', this.testObject)
                .then(response => {
                    // generate QR code
                    new QRious({
                        element: document.getElementById('qr'),
                        value: this.shareGameURL,
                        size: 150
                    });
                })
                .catch(error => {
                    console.error(error);
                    toast.warning(error.response.data.message, {
                        position: 'bottom-right',
                    })
                })
                .finally(() => {
                    this.generatingKey = false;
                })
        },
        expandPanel(isOnline) {
            if (this.testObject.is_online === isOnline) return;

            this.testObject.is_online = isOnline;

            if (isOnline) {
                // increase the width
                let width = 0;
                document.querySelector('.onlineGameSetUp').style.display = 'block';
                this.testObject.players_count = 2;

                this.extendSizeInterval = setInterval(() => {
                    if (width >= 400) {
                        clearInterval(this.extendSizeInterval);
                    } else {
                        width += 20;
                        document.querySelector('.onlineGameSetUp').style.width = width + 'px';
                    }
                }, 4)
            } else {
                // decrease the width
                let width = 400;

                this.extendSizeInterval = setInterval(() => {
                    if (width <= 0) {
                        clearInterval(this.extendSizeInterval);
                        document.querySelector('.onlineGameSetUp').style.display = 'none';
                    } else {
                        width -= 20;
                        document.querySelector('.onlineGameSetUp').style.width = width + 'px';
                    }
                }, 4)
            }
        },
        copyKey() {
            this.isKeyCopied = true;

            if (navigator.clipboard) {
                // copy "testObject.key" to the clipboard
                navigator.clipboard.writeText(this.shareGameURL);
            } else {
                // Fallback for browsers that don't support the Clipboard API
                let textarea = document.createElement('textarea');
                textarea.value = this.shareGameURL;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                } catch (err) {
                    console.log('Fallback: Oops, unable to copy', err);
                }
                document.body.removeChild(textarea);
            }

            setTimeout(() => {
                this.isKeyCopied = false;
            }, 2000);
        },
        validate() {
            /*if (this.testObject.test_from === '' && this.testObject.test_to !== '') {
                this.checker_home_lang = 'Choose your home language'
                return false;
            } else {
                this.checker_home_lang = ''
            }

            if (this.testObject.test_to === '' && this.testObject.test_from !== '') {
                this.checker_test_lang = 'Choose the language you want to take the test'
                return false;
            } else {
                this.checker_test_lang = ''
            }

            if (this.testObject.test_to === '' && this.testObject.test_from === '') {
                this.checker_home_lang = 'Please select languages'
                return false;
            }

            if (this.testObject.test_to === this.testObject.test_from &&
                this.testObject.test_from !== ''
                && this.testObject.test_to !== '') {
                this.checker_home_lang = 'Languages must be different'
                return false;
            }*/

            this.$inertia.visit('/vocabulary-game?game-id=' + this.testObject.key);

            return true;

            /* this.$inertia.post('/single_test', {
                 testObject.test_from: this.testObject.test_from,
                 testObject.test_to: this.testObject.test_to,
                 testObject.language_level: this.testObject.language_level,
             })*/
        },
        fetchFriends() {
            this.gettingFriends = true;

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
                    this.gettingFriends = false;
                });
        },
    },
    watch: {
        'testObject.is_private': {
            handler(val) {
                if (val && !this.friends.length) {
                    this.fetchFriends();
                }
            }
        }
    }
}

</script>

<style scoped>
.friendRow:hover {
    background: #e7e7e7;
}

.friends {
    overflow-y: scroll;
    overflow-x: hidden;
    height: 300px;
    width: 100%;
}

/* make the scroll bar having a blue and green gradient color */
.friends::-webkit-scrollbar {
    width: 10px;
}

.friends::-webkit-scrollbar-track {
    background: transparent;
}

.friends::-webkit-scrollbar-thumb {
    background: #ffe800;
    border-radius: 10px;
}

.copyKeyButton {
    background: #e8e8e8;
}

.copyKeyButton:hover {
    background: #dcdcdc;
}

.gameCredentials {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.QRcode {
    width: 150px;
    height: 150px;
}

.whiteBlock {
    background-color: white;
    width: 550px;
    height: 70%;
    padding: 40px;

    /* in online mode is selected, otherwise border-radius: 20px; */
    border-radius: 20px 0px 0px 20px;
}

.onlineGameSetUp {
    /*display: none;*/
    background-color: white;
    width: 450px;
    height: 70%;
    padding: 30px;
    border-radius: 0 20px 20px 0;
    border-left: solid 1px;
}

.p-button.selectedMode {
    background: #2563ea;
    border: #2563ea;
    color: white;
    transition: background 0.5s, color 0s;
}

.p-button.nonSelectedMode {
    color: black;
    background: white;
    border: white;
    transition: background 0.4s, color 0s;
}

.p-button.nonSelectedMode:hover {
    background-color: #e3e3e3;
    border: #e3e3e3;
    transition: background-color 0.5s, color 0.5s;
}

.p-button {
    padding: 0.5rem 1rem;
}

.selectPanel {
    border: solid 1px black;
    display: inline-flex;
    border-radius: 6px;
    color: white;
}

.holder {
    background: radial-gradient(#eff3f6, #8ec0f9);
    height: 100vh;
    width: 100vw;
    display: flex;
    justify-content: center;
    align-items: center;
}

.parameters {
    height: 100%;
    width: 100%;
}


</style>
