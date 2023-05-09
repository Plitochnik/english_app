<template>

    <Head title="Start"/>

    <table-test :user-name="user_name"></table-test>

    <body>
    <div class="container">
        <div class="whiteSheet">
            <div class="max-w-md mx-auto">
                <div class="font">
                    <p class="text-5xl font-semibold">Select test parameters</p>
                </div>
                <form @submit.prevent="submit">
                    <div class="products">
                        <div class="form">
                            <div class="mt-2 text-red-600">
                                {{ checker_home_lang }}
                            </div>
                            <div class="mt-1 font">
                                <div>
                                    Your language: {{ home_language }}
                                </div>
                            </div>
                            <div class="mt-1 home_language">
                                <select v-model="home_language">
                                    <option disabled value="">Choose language</option>
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
                                    Test for: {{ test_language }}
                                </div>
                            </div>
                            <div class="choose">
                                <div class="mt-1 test_language">
                                    <select v-model="test_language">
                                        <option disabled value="">Choose language</option>
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
        <div class="blueSheet"></div>
    </div>
    </body>


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

body {
    height: 100%;
    margin: 0;
}


.container {
    height: 100%;
    width: 100%;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: red;
}

.whiteSheet {
    background-color: white;
    padding: 50px;
    width: 550px;
    height: auto;
    max-height: 80vh; /* Максимальная высота окна - 80% высоты видимой области */
    border-radius: 25px;
    overflow-y: auto;
    z-index: 999;
}

.blueSheet {
    position: absolute;
    background-color: #2865ea;
    width: 550px;
    height: 100%;
    border-radius: 25px;
    transform: rotate(6deg); /* Применяем поворот на 40 градусов */

}

.font {
    font-family: Mulish, sans-serif;
}

.multiplayer-button {
    margin: auto;
    position: absolute;
    left: 320px;
    top: 360px;
}


</style>
