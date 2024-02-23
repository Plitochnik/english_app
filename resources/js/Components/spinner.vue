<template>

<div
    class="loader"
    :style="{
        border: '5px solid ' + circleColor,
        borderTop: '5px solid ' + color,
        width: size + 'px',
        height: size + 'px',
    }"
>
</div>

</template>
<script>
export default {
    name: "Friends",
    data() {
        return {

        }
    },
    components: {

    },
    props: {
        type: {
            type: String,
            default: 'standard'
        },
        size: {
            type: String,
            default: '50'
        },
        borderWeight: {
            type: String,
            default: '4'
        },
        color: {
            type: String,
            default: 'blue'
        },
        circleColor: {
            type: String,
            default: 'white'
        },
    },
    mounted() {

    },
    methods: { },
}
</script>
<style scoped>
.loader {
    border-radius: 50%;
    animation: spin 1s linear infinite;
    position: absolute;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
