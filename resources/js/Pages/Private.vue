<template>
    <div>
        111111
    </div>
</template>

<script>

const channel = Echo.private('private.chat.1')

channel.subscribed(() => {
    console.log('Connected')
}).listen('.chat.message', (event) => {
    console.log(event)
})

export default {
    name: "Private",

    methods: {

    },

    mounted() {

    }
}
</script>

<style scoped>

</style>
