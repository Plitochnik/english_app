<template>

    <!--    <meta name="viewport" content="width=600">-->
    <Head title="Dashboard"/>
    <table-test :user-name="userName"></table-test>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <Table
            :user-statistic="userStatistic"
        />
    </div>

</template>

<script>

import {Head, Link} from "@inertiajs/inertia-vue3";
import Table from "../Statistic/Table/Table.vue";
import "../../../../public/cssform/select.scss";
// import Sidebar from "../Sidebar.vue";
import TableTest from "@/Pages/Sidebar/TableTest.vue";

export default {
    name: "Dashboard",

    components: {
        Link,
        Head,
        TableTest,
        // Sidebar,
        Table,
    },

    props: [
        'userName',
        'userStatistic',
    ],

    mounted() {
        Echo.channel('test-ws')
            .listen('.test-message', res => {
                console.log(res)
            })
    }
}

</script>

<style scoped>


</style>
