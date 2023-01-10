<template>

    <header class="flex items-center justify-center u-custom-color-1 u-header">
        <div class="u-align-left u-clearfix u-sheet u-sheet-1">
            <Link :href="route('index.parameters')"
                  class="font u-btn u-btn-round">
                Start test
            </Link>
            <Link href="/login"
                  class="ml-3 font u-border-2 u-border-hover-palette-1">
                Jetstream_Login
            </Link>
            <Link href="/register"
                  class="ml-3 font u-border-2 u-border-hover-palette-1">
                Jetstream_Register
            </Link>
        </div>
    </header>


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
