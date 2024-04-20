<template>
    <div class="form min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>

<style scoped>
.form {
    background: radial-gradient(#eff3f6, #8ec0f9);
}
.form {
    background: radial-gradient(#eff3f6, #8ec0f9);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

@media (max-width: 600px) {
    .form {
        flex-direction: column;
    }
}
</style>
