<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});``
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
        <div class="button">
            <slot />
        </div>
    </button>
</template>

<style scoped>
.button {
    clear: both;
    display: inline-block;
    overflow: hidden;
    white-space: nowrap;
}
</style>
