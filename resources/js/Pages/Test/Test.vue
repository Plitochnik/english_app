<template>

    <div v-if="ready_words_for_test">
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
                <h1>True: {{ true_user_answers }}</h1>
                <h1>False: {{ false_user_answers }}</h1>
            </div>
        </div>
    </div>
    <div v-else>
        <h3 class="font">
            Вернитесь в меню и выберете параметры теста
        </h3>
        <Link :href="route('index.parameters')" class="back-to-param u-font-arial">
            <u>
                Вернуться в меню
            </u>
        </Link>
    </div>


</template>

<script>


import {Link} from "@inertiajs/inertia-vue3";
import HeaderLayout from "../../Pages/HeaderLayout.vue";
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
    ],

    data() {
        return {
            test_process: false,
            is_start_animation: true,
            answers: [],
            true_user_answers: 0,
            false_user_answers: 0,
            switch_words: '',
            timer_to_check_answer: '',
            user_answer: '',
            is_test_finished: false,
            stop_animation: true,
        }
    },

    methods: {

        check_pressed_button(which_button) {
            this.user_answer = which_button
        },

        check_one_answer() {
            this.timer_to_check_answer = setInterval(() => {
                if (this.user_answer === this.ready_words_for_test[0][this.test_words[0]][5]) {
                    this.true_user_answers++
                } else {
                    this.false_user_answers++
                }

                this.user_answer = ''

            }, 9900)
        },

        stopInterval() {
            clearInterval()
            this.test_process = false
            this.switch_words = null
            this.is_test_finished = true
            this.timer_to_check_answer = null

            setTimeout(() => {
                this.stop_animation = false
            }, 1000)
        },

        showWords() {
            this.switch_words = setInterval(() => {
                if (this.test_words.length === 0) {
                    this.stopInterval()
                }

                this.ready_words_for_test.shift()
                this.test_words.shift()

            }, 10000)
        },

    },

    created: function () {
        setTimeout(() => {
            this.test_process = true
            this.is_start_animation = false
            this.check_one_answer()
            this.showWords()
        }, 4000)

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
