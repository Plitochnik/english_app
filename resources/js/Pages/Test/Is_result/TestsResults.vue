<template>
    <div class="card">
        <h3>Your result:</h3>
        <p> True answers: <b>{{ trueAnswers }}</b><br>
            False answers: <b>{{ falseAnswers }}</b>
        </p>
        <Link :href="route('home')" class="button-continue">
            <button>
                Continue
            </button>
        </Link>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import {useToast} from "vue-toastification";

const toast = useToast();

export default {
    name: "TestsResults",

    components: {
        Link,
    },

    props: [
        'trueAnswers',
        'falseAnswers',
    ],

    mounted() {
        if (this.trueAnswers >= 8) {
            toast.success('Well Done! \nYour Result more than 80%', {
                timeout: 2000,
                position: 'top-center',
            })
        }
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
    height: 100vh;
}

$primaryFont: "Mulish", sans-serif;
$backgroundColor: #eceff1;
$primaryColor: #81c784;

.card {
    background-color: $backgroundColor;
    border-radius: 30px;
    text-align: center;
    padding: 15px;
    max-width: 375px;
    margin: 100px auto;

    b {
        color: black;
    }

    h3 {
        font-family: $primaryFont;
        font-size: 2rem;
        line-height: 2.2rem;
        color: darken($backgroundColor, 80%);
        font-weight: bold;
        margin: 30px 0;
    }

    p {
        font-family: $primaryFont;
        font-size: 1rem;
        line-height: 1.3rem;
        color: darken($backgroundColor, 50%);
        margin: 30px auto;
        max-width: 80%;
    }

    button {
        font-family: $primaryFont;
        font-size: 1.1rem;
        font-weight: bold;
        padding: 15px 80px;
        border-radius: 25px;
        color: white;
        border: 0;
        margin: 30px 0;
        outline: none;
        background-color: $primaryColor;
        box-shadow: 10px 10px 10px darken(rgba(red($primaryColor), green($primaryColor), blue($primaryColor), 0.2), 2%), -10px -10px 10px lighten(rgba(red($primaryColor), green($primaryColor), blue($primaryColor), 0.2), 2%);
        transition: ease all 0.3s;
        cursor: pointer;

        &:hover {
            box-shadow: 20px 20px 20px darken(rgba(red($primaryColor), green($primaryColor), blue($primaryColor), 0.1), 2%), -20px -20px 20px lighten(rgba(red($primaryColor), green($primaryColor), blue($primaryColor), 0.1), 2%);
            transform: translateY(-3px);
        }

        &:active {
            transform: scale(0.9);
            box-shadow: inset -1px -1px 3px darken(rgba(red($primaryColor), green($primaryColor), blue($primaryColor), 0.3), 2%), -20px -20px 20px lighten(rgba(red($primaryColor), green($primaryColor), blue($primaryColor), 0), 2%);
        }
    }
}

</style>

