<template>

<!--    <AppLayout>-->
<!--        <template #header>-->
<!--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">-->
<!--                Dashboard-->
<!--            </h2>-->
<!--        </template> -->

    <sidebar :user-name="userName"></sidebar>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mytable bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Table :user-statistic="userStatistic"/>
                </div>
            </div>
        </div>

<!--    </AppLayout>-->
</template>

<script>

import {Link} from "@inertiajs/inertia-vue3";
import AppLayout from "../../Layouts/AppLayout.vue";
import Table from "../Statistic/Table/Table.vue";
import "../../../../public/cssform/select.scss";
import Sidebar from "../Sidebar.vue";

export default {
    name: "Dashboard",

    components: {
        Sidebar,
        Table,
        Link,
    },

    props: [
        'userName',
        'userStatistic',
    ],

}

</script>

<style scoped>


</style>
