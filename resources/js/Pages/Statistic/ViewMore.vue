<template>
    <section class=" py-20 lg:py-[110px]">
        <div class="container mx-auto">
            <div class="mx-8 flex flex-wrap">
                <div class="w-full px-2">
                    <div class="mytable max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                            <tr class="bg-green-600 text-center">
                                <th class="w-1/6 min-w-[160px] border-l border-transparent py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4">
                                    Проверочное слово
                                </th>
                                <th class="w-1/6 min-w-[160px] py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4">
                                    Ваш ответ
                                </th>
                                <th class="w-1/6 min-w-[160px] py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4">
                                    Правельный ответ
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in true_ids">
                                <td class="text-dark border-b border-l border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium">
                                    {{ test_word[index] }}
                                </td>
                                <td v-if="data === '0'" class="bg-red-200 text-dark border-b border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium">
                                    {{ user_answer[index] }}
                                </td>
                                <td v-else class="bg-green-200 text-dark border-b border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium">
                                    {{ user_answer[index] }}
                                </td>
                                <td class="text-dark border-b border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium">
                                    {{ true_answer[index] }}
                                </td>
                            </tr>
                            <div class="bg-gray-300 text-dark border-b border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium">
                                Всего:
                                <b>{{ true_counts }} / 10</b>
                            </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="underline">
        <Link :href="route('dashboard')">
            Back
        </Link>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "ViewMore",

    components: {
        Link,
    },

    props: [
        'test_word',
        'true_answer',
        'user_answer',
        'true_ids',
        'true_counts',
    ],

    data() {
        return {}
    },


}
</script>

<style scoped>
.mytable {
    position: relative;
    bottom: 100px;
}
</style>
