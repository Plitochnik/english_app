<template>
    <div v-if="typeof ready_words_for_test">
        <div v-if="is_start_animation === true">
            <div class="countdown">
                <div class="number">
                    <h2>3</h2>
                </div>

                <div class="number">
                    <h2>2</h2>
                </div>

                <div class="number">
                    <h2>1</h2>
                </div>

                <div class="number">
                    <h2>Start!</h2>
                </div>
            </div>
        </div>
        <div v-if="test_process === true" class="userform">
            <p class="howtranslate">Как переводится слово:</p>
            <div class="holder">
                <div class="forma">
                    <p class="testword">{{ test_words[0] }}</p>
                    <form id="myForm" class="testbuttons">
                        <div>
                            <button @click.prevent="check_pressed_button(0)" id="button_1" type="button"
                                    class="elemline_1 mr-3 px-9 py-3 bg-blue-600 rounded-md text-white outline-none shadow-lg transform active:scale-75 transition-transform focus:outline-none focus:bg-yellow-400">
                                {{ ready_words_for_test[0][test_words[0]][0] }}
                            </button>
                            <button @click.prevent="check_pressed_button(1)" id="button_2" type="button"
                                    class="elemline_1 mr-3 px-9 py-3 bg-blue-600 rounded-md text-white outline-none shadow-lg transform active:scale-75 transition-transform focus:outline-none focus:bg-yellow-400">
                                {{ ready_words_for_test[0][test_words[0]][1] }}
                            </button>
                            <button @click.prevent="check_pressed_button(2)" id="button_3" type="button"
                                    class="elemline_1 mr-3 px-9 py-3 bg-blue-600 rounded-md text-white outline-none-4 shadow-lg transform active:scale-75 transition-transform focus:outline-none focus:bg-yellow-400">
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
            <div>
                <div class="timer">
                    <div class="numero_counting_wrapper">
                        <div class="numero_shape"></div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="is_test_finished === true">
            <div v-if="stop_animation === true" class="countdown">
                <div class="number">
                    <h2>Stop</h2>
                </div>
            </div>
            <div v-else>
                <h1>True: {{ user_points.true_answers }}</h1>
                <h1>False: {{ user_points.false_answers }}</h1>
            </div>
        </div>
    </div>
    <div v-else>
        <h3 class="font">
            Вернитесь в меню и выберете параметры теста
        </h3>
        <Link :href="route('parameters')" class="back-to-param u-font-arial">
            <u>
                Вернуться в меню
            </u>
        </Link>
    </div>


</template>

<script>


import {Link} from "@inertiajs/inertia-vue3";
import HeaderLayout from "../../Pages/HeaderLayout.vue";
import "../../../../public/cssform/select.scss";
import "../../../../public/DuringTest/TestTimers/TestStartAnimation.css";
import "../../../../public/DuringTest/FormWords/form.scss";
import "../../../../public/DuringTest/Timer/Timer.css";

export default {

    name: "Test",

    components: {
        HeaderLayout,
        Link,
    },

    props: [
        'ready_words_for_test',
        'test_words',
        'true_answers',
        'chosen_languages',
        'user_status',
    ],

    data() {
        return {
            count: 0,
            test_process: false,
            is_start_animation: true,
            answers: [],
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

    created: function () {
        setTimeout(() => {
            this.test_process = true
            this.is_start_animation = false
            this.showWords()
            this.check_one_answer()

            this.values_for_statistic.test_word = this.test_words.join()
            this.values_for_statistic.true_answer = this.true_answers.join()
        }, 4000)
    },

    methods: {
        check_pressed_button(which_button) {
            this.pressed_button = which_button
            this.user_answer = which_button
        },

        check_one_answer() {
            this.interval_to_check_answer_function = setInterval(() => {
                if (this.count === 10) {
                    this.stopInterval()
                    return
                }

                if (this.user_answer === this.ready_words_for_test[0][this.test_words[0]][5]) {
                    this.values_for_statistic.true_ids += this.values_for_statistic.true_count

                    this.user_points.true_answers++
                } else {
                    this.values_for_statistic.true_ids += this.values_for_statistic.false_count

                    this.user_points.false_answers++
                }

                if (this.user_answer === null) {
                    this.values_for_statistic.user_answer += '0,'
                }

                if (this.pressed_button !== null) {
                    this.values_for_statistic.user_answer += this.ready_words_for_test[0][this.test_words[0]][this.pressed_button] + this.values_for_statistic.coma
                }

                this.pressed_button = null
                this.user_answer = null

                this.count++
            }, 900)
        },

        showWords() {
            this.interval_to_show_words_function = setInterval(() => {
                this.ready_words_for_test.shift()
                this.test_words.shift()
            }, 1000)
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

        calculateUserResult() {
            this.user_result_in_percents = 10 * this.user_points.true_answers
        },

        sendRequestToDashboard() {
            if (this.user_status !== null) {
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


}

</script>

<style scoped>

.font {
    display: flex;
    justify-content: center;
    font-family: Mulish, sans-serif;
    position: relative;
    top: 300px;
}

.back-to-param {
    display: flex;
    justify-content: center;
    position: relative;
    top: 290px;
    color: #aba8a8;
    font-size: 17px;
}

.holder {
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.forma {
    background-color: white;
    width: 700px;
    height: 350px;
    display: flex;
    border-radius: 20px;
}

.testword {
    display: block;
    color: black;
    font-family: Mulish, sans-serif;
    font-size: 37px;
    margin: auto;
    position: relative;
    top: -130px;
    left: 180px;
}

.howtranslate {
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    top: 370px;
}

.timer {
    display: block;
    position: relative;
    top: -650px;
    right: 290px;
}

.testbuttons {
    display: block;
}

.elemline_1 {
    display: inline-block;
    position: relative;
    top: 240px;
    right: 180px;
    margin-bottom: auto;
}

.elemline_2 {
    display: inline-block;
    position: relative;
    top: 245px;
    right: 130px;
    margin-bottom: auto;
}

.elemline_1 button {
    display: block;
}

.elemline_2 button {
    display: block;
}


</style>
