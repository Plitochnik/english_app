<template>

    <Head title="Start"/>

    <div class="holder">
        <div class="whiteBlock">
            <div class="parameters">
                <div class="font text-center">
                    <p class="text-4xl">Test parameters</p>
                </div>
                <div class="gameMode mt-7">
                    <Button @click="expandPanel('local')" icon="pi pi-user" class="p-button" label="Local"
                            :class="{ 'selectedMode': selectedMode === 'local', 'nonSelectedMode': selectedMode !== 'local' }"/>
                    <Button @click="expandPanel('online')" id="online-mode" icon="pi pi-users" class="p-button"
                            label="Online"
                            :class="{ 'selectedMode': selectedMode === 'online', 'nonSelectedMode': selectedMode !== 'online' }"/>
                </div>

                <form @submit.prevent="submit">
                    <div class="products">
                        <div class="form">
                            <div class="mt-2 text-red-600">
                                {{ checker_home_lang }}
                            </div>
                            <div class="mt-1 font">
                                Test from
                            </div>
                            <div class="mt-1 home_language">
                                <Dropdown v-model="home_language" :options="languages" filter
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
                                </Dropdown>
                            </div>
                        </div>
                        <div>
                            <hr style="border-color: #7d7d7d; position: relative; top: 10px;">
                        </div>
                        <div class="form">
                            <div class="YourLan">
                                <div class="mt-3 text-red-600">
                                    {{ checker_test_lang }}
                                </div>
                                <div class="font">
                                    Test to
                                </div>
                            </div>
                            <div class="choose">
                                <div class="mt-1 test_language">
                                    <Dropdown v-model="test_language" :options="languages" filter
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
                                    </Dropdown>
                                </div>
                                <div>
                                    <div>
                                        <div class="mt-3 position-absolute mb-2 font">{{ picked }}</div>
                                    </div>
                                    <div>
                                        <input type="radio" id="one" value="Upper-Intermediate"
                                               v-model="picked"/>
                                        <label class="ml-1 mb-2 mr-4" for="one">В1-В2</label>

                                        <input type="radio" id="two" value="Advanced" v-model="picked"/>
                                        <label class="ml-1" for="two">С1-С2</label>
                                    </div>
                                </div>
                                <!--                                    <start-online-game-button></start-online-game-button>-->
                                <start-test-button></start-test-button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <div class="onlineGameSetUp text-center">
            <div class="text-4xl">Online game</div>
            <div class="mt-6">
                <div v-if="isGeneratingKey" class="mt-7">
                    <div style="display: flex; justify-content: center">
                        <Skeleton width="150px" height="150px"></Skeleton>
                    </div>

                    <div style="display: flex">
                        <Skeleton height="2rem" class="mt-2"></Skeleton>
                        <Skeleton size="2rem" class="mt-2 ml-2"></Skeleton>
                    </div>
                </div>
                <div v-else-if="!gameKey && !isGeneratingKey" class="mt-6">
                    <Button aria-label="copy"
                            @click.prevent="generateQR"
                            class="bg-blue-500 hover:bg-blue-600 text-white"
                            label="Generate code"/>
                </div>
                <div class="gameCredentials">
                    <canvas id="qr"/>
                    <div v-if="gameKey" style="display: flex" class="mt-2">
                        <InputText v-model="gameKey" disabled class="pl-2" style="cursor: text"/>
                        <Button @click="copyKey" :icon="isKeyCopied ? 'pi pi-check' :'pi pi-copy'" aria-label="copy"
                                class="copyKeyButton ml-2"/>
                    </div>
                </div>
            </div>

            <div v-if="gameKey">
                <div class="text-left flex mt-3">
                    <InputSwitch v-model="isPrivateGame"/>
                    <span class="ml-2">Private game</span>
                </div>
                <!--  list of friends  -->
                <div v-if="friends.length" class="friends mt-5">
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
            home_language: null,
            test_language: '',
            picked: 'Upper-Intermediate',
            checker_test_lang: '',
            checker_home_lang: '',
            selectedMode: 'local',
            gameKey: null,
            isGeneratingKey: false,
            friends: [],
            isKeyCopied: false,
            gettingFriends: false,
            isPrivateGame: false,
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
        generateQR() {
            this.isGeneratingKey = true;

            setTimeout(() => {
                // generate secret key
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                this.gameKey = Array.from({length: 16}, () => characters[Math.floor(Math.random() * characters.length)]).join('');

                this.gameKey = 'http://plitlang.com:8878?key=' + this.gameKey;

                // generate QR code
                new QRious({
                    element: document.getElementById('qr'),
                    value: this.gameKey,
                    size: 150
                });

                this.isGeneratingKey = false;
            }, 500);
        },
        expandPanel(mode) {
            if (this.selectedMode === mode) return;

            this.selectedMode = mode;

            if (mode === 'online') {
                // increase the width
                let width = 0;
                document.querySelector('.onlineGameSetUp').style.display = 'block';

                this.extendSizeInterval = setInterval(() => {
                    if (width >= 400) {
                        clearInterval(this.extendSizeInterval);
                    } else {
                        width += 20;
                        document.querySelector('.onlineGameSetUp').style.width = width + 'px';
                    }
                    console.log('hi');
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
                    console.log('hi');
                }, 4)
            }
        },
        copyKey() {
            this.isKeyCopied = true;

            if (navigator.clipboard) {
                // copy "gameKey" to the clipboard
                navigator.clipboard.writeText(this.gameKey).then(() => {
                    console.log('game key copied');
                });
            } else {
                // Fallback for browsers that don't support the Clipboard API
                let textarea = document.createElement('textarea');
                textarea.value = this.gameKey;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    console.log('game key copied');
                } catch (err) {
                    console.log('Fallback: Oops, unable to copy', err);
                }
                document.body.removeChild(textarea);
            }

            setTimeout(() => {
                this.isKeyCopied = false;
            }, 2000);
        },
        submit() {
            if (this.home_language === '' && this.test_language !== '') {
                this.checker_home_lang = 'Choose your home language'
            } else {
                this.checker_home_lang = ''
            }

            if (this.test_language === '' && this.home_language !== '') {
                this.checker_test_lang = 'Choose the language you want to take the test'
            } else {
                this.checker_test_lang = ''
            }

            if (this.test_language === '' && this.home_language === '') {
                this.checker_home_lang = 'Please select languages'
            }

            if (this.test_language === this.home_language &&
                this.home_language !== ''
                && this.test_language !== '') {
                this.checker_home_lang = 'Languages must be different'
            } else {
                this.$inertia.post('/single_test', {
                    home_language: this.home_language,
                    test_language: this.test_language,
                    picked: this.picked,
                })
            }

        },
    },

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
    transition: background 0.5s, color 0s;
}

.p-button.nonSelectedMode:hover {
    background-color: #e3e3e3;
    border: #e3e3e3;
    transition: background-color 0.5s, color 0.5s;
}

.p-button {
    padding: 0.5rem 1rem;
}

.p-button.selectedMode:hover {
    background: #1e4bb1;
}

.gameMode {
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
