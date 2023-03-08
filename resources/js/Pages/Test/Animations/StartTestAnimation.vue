<template>
    <div class="start-animation">
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
    </div>
</template>

<script>
export default {
    name: "StartTestAnimation",

    props: [
        'is_start_animation',
    ],

}
</script>

<style scoped>

</style>
