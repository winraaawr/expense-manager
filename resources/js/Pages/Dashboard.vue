<script setup>
import { Head } from "@inertiajs/vue3";
import { defineProps } from "vue"
import MyExpenses from "@/Components/Dashboard/MyExpenses.vue"

const props = defineProps({
    expenses: Array,
})

console.log(props.expenses);
</script>
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    layout: AuthenticatedLayout,
};
</script>

<template>
    <Head title="Dashboard" />

    <div class="pt-16 sm:pt-14">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sm:min-h-[400px]">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div
                        class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:items-center justify-between"
                    >
                        <h1 class="font-bold text-xl">My Expenses</h1>
                        <h1 class="font-bold sm:text-lg">Dashboard</h1>
                    </div>
                    <div class="">
                        <MyExpenses :expenses="expenses"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
