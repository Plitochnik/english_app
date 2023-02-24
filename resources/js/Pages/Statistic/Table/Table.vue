<template>

    <section class="py-20 lg:py-[120px]">
        <div class="container mx-auto">
            <div class="-mx-4 flex flex-wrap">
                <div class="w-full px-4">
                    <div class="mytable max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                            <tr class="bg-blue-600 text-center">
                                <th class="w-1/6 min-w-[160px] border-l border-transparent py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4">
                                    Результат
                                </th>
                                <th class="w-1/6 min-w-[160px] py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4">
                                    Язык
                                </th>
                                <th class="w-1/6 min-w-[160px] py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4">
                                    Верные ответы
                                </th>
                                <th class="w-1/6 min-w-[160px] py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4">
                                    Дата
                                </th>
                                <th class="w-1/6 min-w-[160px] border-r border-transparent py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4">
                                    Подробнее
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="statistic in userStatistic">
                                <td class="text-dark border-b border-l border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium">
                                    <div v-if="statistic.percent <= 30" class="text-red-600">
                                        {{ statistic.percent }} %
                                    </div>
                                    <div v-else-if="statistic.percent >= 90" class="text-green-500">
                                        {{ statistic.percent }} %
                                    </div>
                                    <div v-else>
                                        {{ statistic.percent }} %
                                    </div>
                                </td>
                                <td class="text-dark border-b border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium">
                                    {{ statistic.home_lang }} -> {{ statistic.test_lang }}
                                </td>
                                <td class="text-dark border-b border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium">
                                    {{ statistic.true_answers }} / 10
                                </td>
                                <td class="text-dark border-b border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium">
                                    {{ moment(statistic.created_at).format("DD-MM-YYYY (HH:mm)") }}
                                </td>
                                <td class="text-dark border-b border-r border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium">
                                    <Link :href="route('dashboard.details', statistic.id)"
                                       class="border-primary text-primary hover:bg-blue-500 inline-block rounded border py-2 px-6 hover:text-white">
                                        View
                                    </Link>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import moment from "moment";

export default {
    name: "Table",

    components: {
        Link,
    },

    data() {
        return {
            moment: moment
        }
    },

    props: [
        'userStatistic',
    ],



}
</script>

<style scoped>
.mytable {
    position: relative;
    bottom: 100px;
}
</style>
