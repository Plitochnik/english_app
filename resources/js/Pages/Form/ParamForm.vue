<template>

    <HeaderLayout></HeaderLayout>

    <main class="center position-absolute">
        <section class="payment-form dark">
            <div class="container">
                <form @submit.prevent="submit">
                    <div class="products">
                        <h3 class="title">Параметры</h3>
                        <div class="form">
                            <div class="YourLan">
                                <h5 class="text-bg-1">Ваш язык: {{ home_language }}</h5>
                            </div>
                            <select class="w-25 form-select" v-model="home_language">
                                <!--                                <option disabled value="">Ваш язык</option>-->
                                <option>Ukrainian</option>
                                <option>Russian</option>
                                <option>English</option>
                                <option>Spanish</option>
                            </select>
                        </div>
                        <div class="hrLine">
                            <hr style="border-color: #484646; top: 10px;">
                        </div>
                        <div class="form">
                            <div class="YourLan">
                                <h5 class="text-bg-1">Тест на: {{ test_language }}</h5>
                            </div>
                            <div class="choose">
                                <select class="w-25 form-select" v-model="test_language">
                                    <!--                                    <option disabled value="">Тест на:</option>-->
                                    <option>English</option>
                                    <option>Ukrainian</option>
                                    <option>Russian</option>
                                    <option>Spanish</option>
                                </select>
                                <div class="buttonGo">
                                    <div class="m-3">
                                        <button
                                            class="w-32 bg-white tracking-wide text-gray-800 font-bold rounded border-b-2 border-blue-500 hover:border-blue-600 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 inline-flex items-center button-new"
                                            type="submit">
                                            <span class="mx-auto">Go</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <slot/>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import {reactive} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import HeaderLayout from "../../Layouts/HeaderLayout.vue";

export default {

    components: {
        HeaderLayout,
    },

    data() {
        return {
            home_language: '',
            test_language: '',
        }
    },

    methods: {
        submit() {
            this.$inertia.post('/parameters', {home_language: this.home_language, test_language: this.test_language})
        },
    },


}

</script>

<style scoped>

.center {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
}

</style>
