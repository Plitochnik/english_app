<template>
    <div>
        User Profile
    </div>
    <Link :href="route('index.parameters')">Go back</Link>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "Profile",

    components: {
        Link,
    }


}
</script>

<style scoped>

</style>
