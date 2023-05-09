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
import "../../../../css/TestsResults/testsRelusts.scss"

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


</style>

