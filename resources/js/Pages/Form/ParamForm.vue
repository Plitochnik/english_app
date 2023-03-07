<template>

<!--    <meta name="viewport" content="width=700">-->
    <Head title="Start"/>

    <table-test :user-name="user_name"></table-test>

    <div class="param min-h-screen py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl"></div>
            <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
                <div class="max-w-md mx-auto">
                    <div class="font">
                        <p class="text-5xl font-semibold">Параметры вашего теста</p>
                    </div>
                    <form @submit.prevent="submit">
                        <div class="products">
                            <div class="form">
                                <div class="mt-2 text-red-600">
                                    {{ checker_home_lang }}
                                </div>
                                <div class="mt-1 font">
                                    <div>
                                        Ваш язык: {{ home_language }}
                                    </div>
                                </div>
                                <div class="mt-1 home_language">
                                    <select v-model="home_language">
                                        <option disabled value="">Выберете язык</option>
                                        <option>Ukrainian</option>
                                        <option>Russian</option>
                                        <option>English</option>
                                        <option>Spanish</option>
                                    </select>
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
                                        Тест на: {{ test_language }}
                                    </div>
                                </div>
                                <div class="choose">
                                    <div class="mt-1 test_language">
                                        <select v-model="test_language">
                                            <option disabled value="">Выберете язык</option>
                                            <option>Ukrainian</option>
                                            <option>Russian</option>
                                            <option>English</option>
                                            <option>Spanish</option>
                                        </select>
                                    </div>
                                    <div>
                                        <div>
                                            <div class="mt-3 position-absolute mb-2 font">{{ picked }}</div>
                                        </div>
                                        <div>
                                            <input type="radio" id="one" value="Upper-Intermediate" v-model="picked"/>
                                            <label class="ml-1 position-relative mb-2 mr-4" for="one">В1-В2</label>

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
        </div>
    </div>
</template>

<script>
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import "../../../../public/cssform/select.scss";
import Login from "../Auth/Login.vue";
import DropdownLink from "../../Components/DropdownLink.vue";
import Dropdown from "../../Components/Dropdown.vue";
import TableTest from "../../Pages/Sidebar/TableTest.vue";
import Banner from "@/Components/Banner.vue";
import StartOnlineGameButton from "@/Pages/Form/PartsOfForm/StartOnlineGameButton.vue";
import StartTestButton from "@/Pages/Form/PartsOfForm/StartTestButton.vue";


export default {

    name: "ParamForm",

    components: {
        Head,
        StartTestButton,
        StartOnlineGameButton,
        Banner,
        Dropdown,
        DropdownLink,
        Link,
        Login,
        TableTest,
    },

    props: [
        'user_name',
    ],

    data() {
        return {
            home_language: '',
            test_language: '',
            picked: 'Upper-Intermediate',
            checker_test_lang: '',
            checker_home_lang: '',
        }
    },

    methods: {
        submit() {
            if (this.home_language === '' && this.test_language !== '') {
                this.checker_home_lang = 'Выберете ваш родной язык'
            } else {
                this.checker_home_lang = ''
            }

            if (this.test_language === '' && this.home_language !== '') {
                this.checker_test_lang = 'Выберете язык на который вы хотите пройти тест'
            } else {
                this.checker_test_lang = ''
            }

            if (this.test_language === '' && this.home_language === '') {
                this.checker_home_lang = 'Выберете пожалуйста языки'
            }

            if (this.test_language === this.home_language &&
                this.home_language !== ''
                && this.test_language !== '') {
                this.checker_home_lang = 'Языки должны быть разные'
            } else {
                this.$inertia.post('/single_test', {
                    home_language: this.home_language,
                    test_language: this.test_language,
                    picked: this.picked,
                })
            }

        },

        myMethod() {

            // Since you returned `toast` from setup(), you can access it now
            this.toast.info("I'm an info toast!");
        }
    },

}

</script>

<style scoped>

.font {
    font-family: Mulish, sans-serif;
}

.param {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}


.multiplayer-button {
    margin: auto;
    position: absolute;
    left: 320px;
    top: 360px;
}


</style>
