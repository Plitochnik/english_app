<template>

    <meta name="viewport" content="width=800">
    <table-test :user-name="userName"></table-test>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <Table :user-statistic="userStatistic"/>
    </div>

</template>

<script>

import {Link} from "@inertiajs/inertia-vue3";
import Table from "../Statistic/Table/Table.vue";
import "../../../../public/cssform/select.scss";
import Sidebar from "../Sidebar.vue";
import TableTest from "@/Pages/Sidebar/TableTest.vue";

export default {
    name: "Dashboard",

    components: {
        TableTest,
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
