<template>

    <meta name="viewport" content="width=800">
    <table-test :user-name="userName"></table-test>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mytable bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Table :user-statistic="userStatistic"/>
                </div>
            </div>
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
