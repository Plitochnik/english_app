<template>

</template>

<script>
export default {
    name: "VocabularyGame",
    mounted() {
        this.joinGame();
    },
    methods: {
        joinGame() {
            let key = this.getURLParam("game-id");
            console.log(key);
        },
        getURLParam(param) {
            let url = window.location.href
                .slice(window.location.href.indexOf("?") + 1);

            let key = url.split("=")[1];

            // join the game
        }
    }
}
</script>
<style scoped>

</style>
