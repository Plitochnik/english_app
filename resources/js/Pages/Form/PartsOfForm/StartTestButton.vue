<template>
    <div class="mt-5">
        <div class="btn start-test-button">
            <button type="submit" class="shop-now">Start test</button>
            <div class="snowflake-grid to-left">
                <div class="snowflake-item border-bottom border-right">
                    <div class="sub-items border-right border-bottom pull-down">
                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                    </div>
                </div>
                <div class="snowflake-item border-bottom border-left">
                    <div
                        class="sub-items border-right border-bottom r-90 pull-down-right">
                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                    </div>
                </div>
                <div class="snowflake-item border-top border-right">
                    <div class="sub-items border-right border-bottom r-270 pull-right">
                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                    </div>
                </div>
                <div class="snowflake-item border-top border-left">
                    <div class="sub-items border-right border-bottom r-180 pull-left">
                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                    </div>
                </div>
            </div>
            <div class="snowflake-grid to-right">
                <div class="snowflake-item border-bottom border-right">
                    <div class="sub-items border-right border-bottom pull-down">
                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                    </div>
                </div>
                <div class="snowflake-item border-bottom border-left">
                    <div
                        class="sub-items border-right border-bottom r-90 pull-down-right"
                    >
                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                    </div>
                </div>
                <div class="snowflake-item border-top border-right">
                    <div class="sub-items border-right border-bottom r-270 pull-right">
                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                    </div>
                </div>
                <div class="snowflake-item border-top border-left">
                    <div class="sub-items border-right border-bottom r-180 pull-left">
                        <div class="m-w-15 m-h-15 border-right border-bottom m-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "StartTestButton",

    components: {
        Link,
    }
}
</script>

<style scoped>

</style>
