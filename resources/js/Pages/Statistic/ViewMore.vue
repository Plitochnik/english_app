<template>

<!--    <meta name="viewport" content="width=800">-->
    <Head title="Details"/>
    <section class="py-20 lg:py-[110px]">
        <div class="container mx-auto">
            <div class="mx-8 flex flex-wrap">
                <div class="w-full px-2">
                    <div class="mytable max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                            <tr class="bg-gray-800 text-center">
                                <th class="w-1/6 min-w-[160px] border-l border-transparent py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4">
                                    Test word
                                </th>
                                <th class="w-1/6 min-w-[160px] py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4">
                                    Your answer
                                </th>
                                <th class="w-1/6 min-w-[160px] py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4">
                                    True answer
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in true_ids">
                                <td class="border-b border-l border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium">
                                    {{ test_word[index] }}
                                </td>
                                <td v-if="data === '0'"
                                    class="bg-red-300 text-dark border-b border-[#E8E8E8] text-center text-base font-medium">
                                    {{ user_answer[index] }}
                                </td>
                                <td v-else
                                    class="bg-green-300 text-dark border-b border-[#E8E8E8] text-center text-base font-medium">
                                    {{ user_answer[index] }}
                                </td>
                                <td class="text-dark border-b border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium">
                                    {{ true_answer[index] }}
                                </td>
                            </tr>
                            <div
                                class="bg-gray-300 text-dark border-b border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium">
                                Total:
                                <b>{{ true_counts }} / 10</b>
                            </div>
                            </tbody>
                        </table>
                    </div>
                    <Link href="/dashboard"
                          class="back-button inline-flex items-center px-8 py-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        Go back
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {Head, Link} from "@inertiajs/inertia-vue3";

export default {
    name: "ViewMore",

    components: {
        Link,
        Head,
    },

    props: [
        'test_word',
        'true_answer',
        'user_answer',
        'true_ids',
        'true_counts',
    ],
}
</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Mulish:wght@700&display=swap');

:root {
    --background-color: #edeef0;
    --color: #000000;
    --light-theme: #ffffff;
}


body {
    font-family: "Mulish", sans-serif;
    background: radial-gradient(#eff3f6, #8ec0f9);
}
</style>

<style scoped>
.mytable {
    position: relative;
    bottom: 100px;
}

.back-button {
    position: absolute;
    right: 5%;
}

</style>
