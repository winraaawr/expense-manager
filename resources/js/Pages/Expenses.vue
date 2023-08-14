<template>
    <Head title="Expenses" />

    <div class="py-16 sm:py-14">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div
                        class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:items-center justify-between"
                    >
                        <h1 class="font-bold text-xl">Expenses</h1>
                        <h1 class="font-bold sm:text-lg">
                            Expenses Management > Expenses
                        </h1>
                    </div>
                    <div class="flex flex-col space-y-4 pt-6 pb-2">
                        <Flash v-if="$page.props.flash.message" />
                        <!-- table here -->
                        <ExpensesTable
                            :categories="categories"
                            :expenses="expenses"
                        />
                        <div class="flex flex-row justify-end">
                            <!-- add button here -->
                            <AddExpenses :categories="categories" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import Flash from "@/Components/Flash.vue";
import { Head } from "@inertiajs/vue3";
import AddExpenses from "@/Components/Expenses/AddExpenses.vue";
import ExpensesTable from "@/Components/Expenses/ExpensesTable.vue";

const props = defineProps({
    expenses: Array,
    categories: Array,
});
</script>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    layout: AuthenticatedLayout,
};
</script>
