<template>

    <Head title="Start"/>

    <div class="holder">
        <div class="whiteBlock">
            <div class="parameters">
                <div class="font text-center">
                    <p class="text-5xl font-semibold">Test parameters</p>
                </div>
                <TabView>
                    <TabPanel v-for="tab in tabs" :key="tab.id" :header="tab.title">
                        <div v-if="tab.id === 1">
                            <form @submit.prevent="submit">
                                <div class="products">
                                    <div class="form">
                                        <div class="mt-2 text-red-600">
                                            {{ checker_home_lang }}
                                        </div>
                                        <div class="mt-1 font">
                                            <div>
                                                Your language
                                            </div>
                                        </div>
                                        <div class="mt-1 home_language">
                                            <Dropdown v-model="home_language" :options="languages" filter
                                                      optionLabel="name" placeholder="Select a language"
                                                      class="w-full md:w-14rem">
                                                <template #value="slotProps">
                                                    <span v-if="slotProps.value" style="display: ruby-text; text-align: left;">
                                                        <img :alt="slotProps.value.label"
                                                             src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png"
                                                             :class="`mr-2 flag flag-${slotProps.value.code.toLowerCase()}`"
                                                             style="width: 18px" />
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
                                                Test for
                                            </div>
                                        </div>
                                        <div class="choose">
                                            <div class="mt-1 test_language">
                                                <Dropdown v-model="test_language" :options="languages" filter
                                                          optionLabel="name" placeholder="Select a language"
                                                          class="w-full md:w-14rem">
                                                    <template #value="slotProps">
                                                    <span v-if="slotProps.value" style="display: ruby-text; text-align: left;">
                                                        <img :alt="slotProps.value.label"
                                                             src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png"
                                                             :class="`mr-2 flag flag-${slotProps.value.code.toLowerCase()}`"
                                                             style="width: 18px" />
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
                    </TabPanel>
                </TabView>

            </div>
        </div>
    </div>

</template>
<script>
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import StartOnlineGameButton from "@/Pages/Form/PartsOfForm/StartOnlineGameButton.vue";
import StartTestButton from "@/Pages/Form/PartsOfForm/StartTestButton.vue";
import LeftPannel from '@/Layouts/LeftPannel.vue';

export default {
    name: "ParamForm",
    components: {
        Head,
        StartTestButton,
        StartOnlineGameButton,
        Link,
    },
    layout: LeftPannel,
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
            tabs: [
                {id: 1, title: 'Local', content: 'Tab 1 Content'},
                {id: 2, title: 'With Friends', content: 'Tab 2 Content'},
            ],
        }
    },
    mounted() {
    },
    props: [
        'user_name',
    ],
    methods: {
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
.holder {
    background: radial-gradient(#eff3f6, #8ec0f9);
    height: 100vh;
    width: 100vw;
    display: flex;
    justify-content: center;
    align-items: center;
}

.whiteBlock {
    background-color: white;
    width: 550px;
    height: 70%;
    padding: 40px;
    border-radius: 20px;
}

.parameters {
    height: 100%;
    width: 100%;
}

.font {
    font-family: Mulish, sans-serif;
}


</style>
