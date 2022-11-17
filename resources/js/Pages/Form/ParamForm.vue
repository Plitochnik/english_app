<template>

    <HeaderLayout></HeaderLayout>


    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div
                class="absolute inset-0 bg-gradient-to-r from-blue-300 to-blue-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
            </div>
            <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
                <div class="max-w-md mx-auto">
                    <div class="font">
                        <p class="text-5xl font-semibold">Параметры вашего теста</p>
                    </div>
                    <form @submit.prevent="submit">
                        <div class="products">
                            <div class="form">
                                <div class="font">
                                    <div>
                                        Ваш язык: {{ home_language }}
                                    </div>
                                </div>
                                <div class="home_language">
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
                                    <div class="mt-3 font">
                                        Тест на: {{ test_language }}
                                    </div>
                                </div>
                                <div class="choose">
                                    <div class="test_language">
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
                                        <div class="">
                                            <input type="radio" id="one" value="Upper-Intermediate" v-model="picked"/>
                                            <label class="ml-1 position-relative mb-2 mr-4" for="one">В1-В2</label>

                                            <input type="radio" id="two" value="Advanced" v-model="picked"/>
                                            <label class="ml-1" for="two">С1-С2</label>
                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="btn">
                                            <button type="submit" class="shop-now">Начать тест</button>
                                            <!--                                            <Link :href="route('test.process')"></Link>-->
                                            <div class="snowflake-grid to-left">
                                                <div class="snowflake-item border-bottom border-right">
                                                    <div class="sub-items border-right border-bottom pull-down">
                                                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                                                    </div>
                                                </div>
                                                <div class="snowflake-item border-bottom border-left">
                                                    <div class="sub-items border-right border-bottom r-90 pull-down-right">
                                                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                                                    </div>
                                                </div>
                                                <div class="snowflake-item border-top border-right">
                                                    <div class="sub-items border-right border-bottom r-270 pull-right">
                                                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                                                    </div>
                                                </div>
                                                <div class="snowflake-item border-top border-left">
                                                    <div class="sub-items border-right border-bottom r-180 pull-left">
                                                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="snowflake-grid to-right">
                                                <div class="snowflake-item border-bottom border-right">
                                                    <div class="sub-items border-right border-bottom pull-down">
                                                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                                                    </div>
                                                </div>
                                                <div class="snowflake-item border-bottom border-left">
                                                    <div
                                                        class="sub-items border-right border-bottom r-90 pull-down-right"
                                                    >
                                                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                                                    </div>
                                                </div>
                                                <div class="snowflake-item border-top border-right">
                                                    <div class="sub-items border-right border-bottom r-270 pull-right">
                                                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                                                    </div>
                                                </div>
                                                <div class="snowflake-item border-top border-left">
                                                    <div class="sub-items border-right border-bottom r-180 pull-left">
                                                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

import {Link} from "@inertiajs/inertia-vue3";
import {reactive} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import HeaderLayout from "../../Layouts/HeaderLayout.vue";
// import "../../../../public/cssform/parameter.css";
import "../../../../public/cssform/select.scss";
// import $ from 'jquery'


export default {

    components: {
        HeaderLayout,
    },

    data() {
        return {
            home_language: '',
            test_language: '',
            picked: 'Upper-Intermediate',
        }
    },


    methods: {
        submit() {
            this.$inertia.post('/test', {
                home_language: this.home_language,
                test_language: this.test_language,
                picked: this.picked
            })
            console.log('It works');
        },
    },

    props: [
        'ready_words_for_test',
    ],


}

</script>

<style scoped>

.font {
    font-family: Mulish, sans-serif;
}

</style>
