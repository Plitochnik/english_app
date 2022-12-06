<template>

    <body class="u-body u-xl-mode" data-lang="ru">
    <header class="flex items-center justify-center u-custom-color-1 u-header" id="sec-0683" data-animation-name="" data-animation-duration="0"
            data-animation-delay="0" data-animation-direction="">
        <div class="u-align-left u-clearfix u-sheet u-sheet-1">
            <Link :href="route('index.parameters')"
                  class="font u-btn u-btn-round u-button-style u-custom-font u-hover-palette-1-light-1 u-palette-1-base u-radius-50 u-btn-1">
                Start test
            </Link>
            <Link :href="route('index.signin')"
                  class="ml-3 font u-border-2 u-border-hover-palette-1-base u-border-palette-1-base u-btn u-btn-round u-button-style u-hover-palette-1-base u-none u-radius-50 u-btn-2">
                Sign in
            </Link>
        </div>
    </header>
    </body>

</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";


export default {
    name: "HeaderLayout",

    components: {
        Link,
    },

}

</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Mulish:wght@700&display=swap');


.font {
    font-family: Mulish, sans-serif;
}

</style>
