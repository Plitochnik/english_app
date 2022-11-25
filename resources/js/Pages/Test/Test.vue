<template>

    <div v-if="ready_words_for_test">
        <div v-if="is_animation === true">
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
        <div v-if="is_animation === false" class="userform">
            <p class="howtranslate">Как переводится слово:</p>
            <div class="holder">
                <div class="forma">
                    <p class="testword">{{ test_words[1] }}</p>
                </div>
            </div>
            <div class="timer">
                <div class="numero_counting_wrapper">
                    <div class="numero_shape"></div>
                </div>
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
import {reactive} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import HeaderLayout from "../../Layouts/HeaderLayout.vue";
import "../../../../public/DuringTest/TestTimers/TestStartAnimation.css";
import "../../../../public/DuringTest/FormWords/form.scss";
import "../../../../public/DuringTest/Timer/Timer.css";


export default {

    name: "Test",

    components: {
        HeaderLayout,
        Link,
    },

    data() {
        return {
            time: '',
            is_animation: true,
        }
    },

    methods: {
        start_animation() {
            setTimeout(() => {
                this.is_animation = false
            }, 4000);

            return this.is_animation
        },

        showWord(ready_words_for_test) {
            if (i === ready_words_for_test.length) {
                clearInterval();
            }

            let i = 0;
            let test_word = 'Как переводится: ' + ready_words_for_test[i];
            i++;

            return test_word;
        },

        testTimeSet() {
            setInterval(this.showWord, 5, this.ready_words_for_test);
        },


        // animate() {
        //     document.querySelector('button').addEventListener('click', function clickHandler(e) {
        //
        //         this.removeEventListener('click', clickHandler, false);
        //
        //         e.preventDefault();
        //         var self = this;
        //         setTimeout(function () {
        //             self.className = 'loading';
        //         }, 125);
        //
        //         setTimeout(function () {
        //             self.className = 'ready';
        //         }, 4300);
        //
        //     }, false);
        // }

    },

    created: function () {
        this.start_animation()
    },

    props: [
        'ready_words_for_test',
        'true_answers',
        'test_words',
    ],

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
    color: black;
    font-family: Mulish, sans-serif;
    font-size: 37px;
    margin: auto;
    position: relative;
    top: -130px;
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


</style>
