<template>
    <body>
    <div class="font">
        <div>
            <h3 class="text-xl mb-2">
                Return to the menu and select test parameters
            </h3>
            <Link :href="route('home')" class="back-to-param">
                <u>
                    Back to menu
                </u>
            </Link>
        </div>
    </div>
    </body>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "WrongRoute",

    components: {
        Link,
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
body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.font {
    text-align: center;
    line-height: 20px;
}

.back-to-param {
    color: grey;
}

</style>
