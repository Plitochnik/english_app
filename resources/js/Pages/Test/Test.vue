<template>
    <Head title="Test"/>

    <div v-if="is_user_chose_params === true">
        <start-test-animation :is_start_animation="is_start_animation"></start-test-animation>
        <div v-if="test_process === true" class="userform">
            <div class="holder">
                <div class="timer">
                    <div class="numero_counting_wrapper">
                        <div class="numero_shape"></div>
                    </div>
                </div>
                <p class="howtranslate">Как переводится слово:</p>
                <p class="testword">{{ test_words[0] }}</p>
                <form id="myForm" class="testbuttons">
                    <div>
                        <button @click.prevent="check_pressed_button(0)" id="button_1" type="button"
                                class="elemline_1 mr-3 px-9 py-3 bg-blue-600 rounded-md text-white outline-none shadow-lg transform active:scale-75 transition-transform focus:bg-yellow-400">
                            {{ ready_words_for_test[0][test_words[0]][0] }}
                        </button>
                        <button @click.prevent="check_pressed_button(1)" id="button_2" type="button"
                                class="elemline_1 mr-3 px-9 py-3 bg-blue-600 rounded-md text-white outline-none shadow-lg transform active:scale-75 transition-transform second_button">
                            {{ ready_words_for_test[0][test_words[0]][1] }}
                        </button>
                        <button @click.prevent="check_pressed_button(2)" id="button_3" type="button"
                                class="elemline_1 mt-2 mr-3 px-9 py-3 bg-blue-600 rounded-md text-white outline-none-4 shadow-lg transform active:scale-75 transition-transform focus:outline-none focus:bg-yellow-400">
                            {{ ready_words_for_test[0][test_words[0]][2] }}
                        </button>
                    </div>
                    <div>
                        <button @click.prevent="check_pressed_button(3)" id="button_4" type="button"
                                class="elemline_1 mr-3 px-9 py-3 bg-blue-600 rounded-md text-white outline-none-4 shadow-lg transform active:scale-75 transition-transform focus:outline-none focus:bg-yellow-400">
                            {{ ready_words_for_test[0][test_words[0]][3] }}
                        </button>
                        <button @click.prevent="check_pressed_button(4)" id="button_5" type="button"
                                class="elemline_1 mr-3 px-9 py-3 bg-blue-600 rounded-md text-white outline-none-4 shadow-lg transform active:scale-75 transition-transform focus:outline-none focus:bg-yellow-400">
                            {{ ready_words_for_test[0][test_words[0]][4] }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="is_test_finished === true">
            <div v-if="stop_animation === true" class="text-animation">
                <div class="countdown">
                    <div class="number">
                        <h2>Stop</h2>
                    </div>
                </div>
            </div>
            <div v-else>
                <tests-results :true-answers="user_points.true_answers"
                               :false-answers="user_points.false_answers">
                </tests-results>
            </div>
        </div>
    </div>
    <div v-else>
        <wrong-route></wrong-route>
    </div>


</template>

<script>

import {Head, Link} from "@inertiajs/inertia-vue3";
import StartTestAnimation from "@/Pages/Test/Animations/StartTestAnimation.vue";
import WrongRoute from "./No_result/WrongRoute.vue";
import TestsResults from "../Test/Is_result/TestsResults.vue";
import "../../../../public/DuringTest/TestTimers/TestStartAnimation.css";
import "../../../../public/DuringTest/Timer/Timer.css";
import {useToast} from "vue-toastification";

const toast = useToast();

export default {

    name: "Test",

    components: {
        Link,
        Head,
        StartTestAnimation,
        WrongRoute,
        TestsResults,
    },

    props: [
        'user_ready_for_test',
        'ready_words_for_test',
        'test_words',
        'true_answers',
        'chosen_languages',
        'user_status',
    ],

    data() {
        return {
            isDirty: false,
            is_user_chose_params: false,
            count: 1,
            test_process: false,
            is_start_animation: true,
            user_points: {
                true_answers: 0,
                false_answers: 0,
            },
            pressed_button: null,
            interval_to_check_answer_function: null,
            interval_to_show_words_function: null,
            user_answer: null,
            is_test_finished: false,
            stop_animation: true,
            user_result_in_percents: null,
            values_for_statistic: {
                true_ids: '',
                true_count: '1,',
                false_count: '0,',
                test_word: null,
                true_answer: '',
                user_answer: '',
                coma: ',',
            },
        }
    },

    created() {

        window.addEventListener("beforeunload", this.confirmExit);

        this.is_user_chose_params = this.user_ready_for_test

        if (this.is_user_chose_params === true) {
            setTimeout(() => {
                this.test_process = true
                this.is_start_animation = false
                this.showWords()
                this.check_one_answer()

                this.values_for_statistic.test_word = this.test_words.join()
                this.values_for_statistic.true_answer = this.true_answers.join()
            }, 4000)
        }
    },

    beforeUnmount() {
        window.removeEventListener("beforeunload", this.confirmExit);
    },

    methods: {

        check_pressed_button(which_button) {
            this.pressed_button = which_button
            this.user_answer = which_button
        },

        check_one_answer() {
            this.interval_to_check_answer_function = setInterval(() => {
                let true_answer = this.ready_words_for_test[0][this.test_words[0]][this.ready_words_for_test[0][this.test_words[0]][5]]

                if (this.user_answer === this.ready_words_for_test[0][this.test_words[0]][5]) {
                    this.values_for_statistic.true_ids += this.values_for_statistic.true_count

                    toast.success('Excellent', {
                        timeout: 2000,
                    })

                    this.user_points.true_answers++
                } else {
                    this.values_for_statistic.true_ids += this.values_for_statistic.false_count

                    toast.error('Oops. Right one was: ' + true_answer, {
                        icon: false,
                        timeout: 2000,
                    })

                    this.user_points.false_answers++
                }

                if (this.user_answer === null) {
                    this.values_for_statistic.user_answer += '0,'
                }

                if (this.pressed_button !== null) {
                    this.values_for_statistic.user_answer += this.ready_words_for_test[0][this.test_words[0]][this.pressed_button] + this.values_for_statistic.coma
                }

                if (this.count === 10) {
                    this.stopInterval()
                    return
                }

                this.pressed_button = null
                this.user_answer = null

                this.count++

            }, 9900)
        },

        showWords() {
            this.interval_to_show_words_function = setInterval(() => {
                for (let i = 1; i <= 5; i++) {
                    document.getElementById('button_' + i).blur();
                }

                this.ready_words_for_test.shift()
                this.test_words.shift()
            }, 10000)
        },

        stopInterval() {
            this.test_process = false
            this.is_test_finished = true
            clearInterval(this.interval_to_show_words_function);
            clearInterval(this.interval_to_check_answer_function);

            this.calculateUserResult()

            setTimeout(() => {
                this.stop_animation = false
                this.sendRequestToDashboard()
            }, 1000)
        },

        userLeavesPage() {
            this.test_process = false
            this.is_test_finished = true
            clearInterval(this.interval_to_show_words_function);
            clearInterval(this.interval_to_check_answer_function);
        },

        confirmExit(event) {
            event.preventDefault();
            event.returnValue = "";
            alert("Are you sure you want to leave the page?");
        },

        calculateUserResult() {
            this.user_result_in_percents = 10 * this.user_points.true_answers
        },

        sendRequestToDashboard() {
            if (this.user_status === 1) {
                this.$inertia.post('/dashboard', {
                    user_id: this.user_status,
                    percent: this.user_result_in_percents,
                    test_word: this.values_for_statistic.test_word,
                    user_answer: this.values_for_statistic.user_answer,
                    true_answer: this.values_for_statistic.true_answer,
                    true_ids: this.values_for_statistic.true_ids,
                    home_lang: this.chosen_languages.home_language,
                    test_lang: this.chosen_languages.test_language,
                    true_answers: this.user_points.true_answers,
                    false_answers: this.user_points.false_answers,
                })
            }
        },


    },

    mounted() {
        onpopstate = (event) => {
            this.userLeavesPage()
        };
    }

}

</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Mulish:wght@700&display=swap');

:root {
    --background-color: #edeef0;
    --color: #000000;
    --light-theme: #ffffff;
}


body {
    font-family: "Mulish", sans-serif;
    background: radial-gradient(#eff3f6, #8ec0f9);
}
</style>

<style scoped>

.second_button:focus {
    background-color: yellow;
}

.holder {
    background-color: white;
    border-radius: 20px;
    max-width: 700px;
    height: 390px;
    margin: 0 auto;
    text-align: center;
    position: relative;
    top: 150px;
    left: 0;
    right: 0;
}

.howtranslate {
    font-size: 15px;
    display: inline-block;
    position: absolute;
    top: 15px;
    left: 0;
    right: 0;
}

.testword {
    display: inline-block;
    color: black;
    font-family: Mulish, sans-serif;
    font-size: 37px;
    position: absolute;
    margin: 20px 0px 0px 0px;
    top: 15px;
    left: 0;
    right: 0;
}

.testbuttons {
    position: absolute;
    top: 200px;
    left: 0;
    right: 0;
}

@media (min-width: 470px) {
    .testbuttons {
        position: absolute;
        top: 240px;
        left: 0;
        right: 0;
    }
}

.testbuttons div {
    margin: 10px 10px 10px 10px;
}

.timer {
    position: absolute;
    top: 25px;
    left: 8px;

}


</style>
