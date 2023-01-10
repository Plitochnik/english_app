<template>
    <section class="bg-white py-20 lg:py-[110px]">
        <div class="container mx-auto">
            <div class="mx-8 flex flex-wrap">
                <div class="w-full px-2">
                    <div class="mytable max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                            <tr class="bg-blue-600 text-center">
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
                            <tr>
                                <td class="text-dark border-b border-l border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium">
                                    1111
                                </td>
                                <td class="text-dark border-b border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium">
                                    111
                                </td>
                                <td class="text-dark border-b border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium">
                                    1111
                                </td>
                            </tr>
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
        'test_details',
    ],

}
</script>

<style scoped>
.mytable {
    position: relative;
    bottom: 100px;
}
</style>
