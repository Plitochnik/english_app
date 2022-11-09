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
                                <div class="YourLan">
                                    <h5 class="text-bg-1">Ваш язык: {{ home_language }}</h5>
                                </div>
                                <div class="home_language">
                                    <div id="app-cover_1">
                                        <div id="select-box">
                                            <input type="checkbox" id="options-view-button">
                                            <div id="select-button" class="brd">
                                                <div id="selected-value">
                                                    <span>Выберете язык</span>
                                                </div>
                                                <div id="chevrons">
                                                    <i class="fas fa-chevron-up"></i>
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                            </div>
                                            <div id="options">
                                                <div class="option">
                                                    <input class="s-c top" type="radio" name="1_platform"
                                                           v-model="home_language" value="Ukrainian">
                                                    <input class="s-c bottom" type="radio" name="1_platform"
                                                           v-model="home_language" value="Ukrainian">
                                                    <i class="fab fa-codepen"></i>
                                                    <span class="label">Ukrainian</span>
                                                    <span class="opt-val">Ukrainian</span>
                                                </div>
                                                <div class="option">
                                                    <input class="s-c top" type="radio" name="1_platform"
                                                           v-model="home_language" value="Russian">
                                                    <input class="s-c bottom" type="radio" name="1_platform"
                                                           v-model="home_language" value="Russian">
                                                    <i class="fab fa-dribbble"></i>
                                                    <span class="label">Russian</span>
                                                    <span class="opt-val">Russian</span>
                                                </div>
                                                <div class="option">
                                                    <input class="s-c top" type="radio" name="1_platform"
                                                           v-model="home_language" value="English">
                                                    <input class="s-c bottom" type="radio" name="1_platform"
                                                           v-model="home_language" value="English">
                                                    <i class="fab fa-dribbble"></i>
                                                    <span class="label">English</span>
                                                    <span class="opt-val">English</span>
                                                </div>
                                                <div class="option">
                                                    <input class="s-c top" type="radio" name="1_platform"
                                                           v-model="home_language" value="Spanish">
                                                    <input class="s-c bottom" type="radio" name="1_platform"
                                                           v-model="home_language" value="Spanish">
                                                    <i class="fab fa-dribbble"></i>
                                                    <span class="label">Spanish</span>
                                                    <span class="opt-val">Spanish</span>
                                                </div>

                                                <div id="option-bg"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <hr style="border-color: #7d7d7d; position: relative; top: 10px;">
                            </div>
                            <div class="form">
                                <div class="YourLan">
                                    <h5 class="text-bg-1">Тест на: {{ test_language }}</h5>
                                </div>
                                <div class="choose">
                                    <div class="test_language">
                                        <div id="app-cover_2">
                                            <div id="select-box">
                                                <input type="checkbox" id="options-view-button">
                                                <div id="select-button" class="brd">
                                                    <div id="selected-value">
                                                        <span>Выберете язык</span>
                                                    </div>
                                                    <div id="chevrons">
                                                        <i class="fas fa-chevron-up"></i>
                                                        <i class="fas fa-chevron-down"></i>
                                                    </div>
                                                </div>
                                                <div id="options">
                                                    <div class="option">
                                                        <input class="s-c top" type="radio" name="2_platform"
                                                               v-model="test_language" value="Ukrainian">
                                                        <input class="s-c bottom" type="radio" name="2_platform"
                                                               v-model="test_language" value="Ukrainian">
                                                        <i class="fab fa-codepen"></i>
                                                        <span class="label">Ukrainian</span>
                                                        <span class="opt-val">Ukrainian</span>
                                                    </div>
                                                    <div class="option">
                                                        <input class="s-c top" type="radio" name="2_platform"
                                                               v-model="test_language" value="Russian">
                                                        <input class="s-c bottom" type="radio" name="2_platform"
                                                               v-model="test_language" value="Russian">
                                                        <i class="fab fa-dribbble"></i>
                                                        <span class="label">Russian</span>
                                                        <span class="opt-val">Russian</span>
                                                    </div>
                                                    <div class="option">
                                                        <input class="s-c top" type="radio" name="2_platform"
                                                               v-model="test_language" value="English">
                                                        <input class="s-c bottom" type="radio" name="2_platform"
                                                               v-model="test_language" value="English">
                                                        <i class="fab fa-dribbble"></i>
                                                        <span class="label">English</span>
                                                        <span class="opt-val">English</span>
                                                    </div>
                                                    <div class="option">
                                                        <input class="s-c top" type="radio" name="2_platform"
                                                               v-model="test_language" value="Spanish">
                                                        <input class="s-c bottom" type="radio" name="2_platform"
                                                               v-model="test_language" value="Spanish">
                                                        <i class="fab fa-dribbble"></i>
                                                        <span class="label">Spanish</span>
                                                        <span class="opt-val">Spanish</span>
                                                    </div>

                                                    <div id="option-bg"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <div class="position-absolute mb-2 font">{{ picked }}</div>
                                        </div>
                                        <div class="">
                                            <input type="radio" id="one" value="Upper-Intermediate" v-model="picked"/>
                                            <label class="position-relative mb-2 mr-4" for="one">В1-В2</label>

                                            <input type="radio" id="two" value="Advanced" v-model="picked"/>
                                            <label for="two">С1-С2</label>
                                        </div>

                                    </div>
                                    <div class="bg-white p-4">
                                        <button
                                            class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-md"
                                            type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                            </svg>

                                            Go
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <slot/>
    </div>



</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import {reactive} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import HeaderLayout from "../../Layouts/HeaderLayout.vue";
// import "../../../../public/cssform/parameter.css";
import "../../../../public/cssform/select.scss";
import $ from 'jquery'


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

    mounted() {
        $('select.dropdown').each(function() {

            var dropdown = $('<div />').addClass('dropdown selectDropdown');

            $(this).wrap(dropdown);

            var label = $('<span />').text($(this).attr('placeholder')).insertAfter($(this));
            var list = $('<ul />');

            $(this).find('option').each(function() {
                list.append($('<li />').append($('<a />').text($(this).text())));
            });

            list.insertAfter($(this));

            if($(this).find('option:selected').length) {
                label.text($(this).find('option:selected').text());
                list.find('li:contains(' + $(this).find('option:selected').text() + ')').addClass('active');
                $(this).parent().addClass('filled');
            }

        });

        $(document).on('click touch', '.selectDropdown ul li a', function(e) {
            e.preventDefault();
            var dropdown = $(this).parent().parent().parent();
            var active = $(this).parent().hasClass('active');
            var label = active ? dropdown.find('select').attr('placeholder') : $(this).text();

            dropdown.find('option').prop('selected', false);
            dropdown.find('ul li').removeClass('active');

            dropdown.toggleClass('filled', !active);
            dropdown.children('span').text(label);

            if(!active) {
                dropdown.find('option:contains(' + $(this).text() + ')').prop('selected', true);
                $(this).parent().addClass('active');
            }

            dropdown.removeClass('open');
        });

        $('.dropdown > span').on('click touch', function(e) {
            var self = $(this).parent();
            self.toggleClass('open');
        });

        $(document).on('click touch', function(e) {
            var dropdown = $('.dropdown');
            if(dropdown !== e.target && !dropdown.has(e.target).length) {
                dropdown.removeClass('open');
            }
        });

// light
        $('.switch input').on('change', function(e) {
            $('.dropdown, body').toggleClass('light', $(this).is(':checked'));
        });

    },

    methods: {
        submit() {
            this.$inertia.post('/parameters', {home_language: this.home_language, test_language: this.test_language})
        },
    },


}

</script>

<style scoped>


</style>
