<template>
    <div class="grid grid-cols-1 gap-2 lg:grid-cols-2 w-full py-16">
        <!-- List -->
        <div class="col-span-1 relative overflow-x-auto sm:rounded-lg">
            <table
                class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-white uppercase bg-blue-500 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Expense Categories
                        </th>
                        <th scope="col" class="px-6 py-3">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="expense in expenses"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-slate-100 dark:hover:bg-gray-700"
                    >
                        <td class="px-6 py-4">{{ expense.category_name }}</td>
                        <td class="px-6 py-4">${{ formatNumber(expense.total_amount) }}</td>
                    </tr>
                    <tr v-if="expenses.length < 1">
                        <td colspan="2" class="px-6 py-16 italic text-center"> No expense record found.</td>
                    </tr>
                </tbody>
                <tr v-if="total != 0" class="bg-gray-200">
                    <td class="px-6 py-4 font-bold">Total Expenses: </td>
                    <td class="px-6 py-4">${{ formatNumber(total) }}</td>
                </tr>
            </table>
        </div>
        <!-- Pie Chart -->
        <div class="col-span-1">
            <Pie v-if="labels.length != 0 && data.length !=0" :data="chartData" :options="chartOptions" />
            <span v-else class="text-sm italic text-gray-800/50 flex flex-col items-center justify-center h-full w-full border-2 rounded-lg min-h-[250px]">No expense record to show.</span>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps } from "vue";
import { Pie } from "vue-chartjs";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { monetaryFormat } from "@/utilities";

ChartJS.register(ArcElement, Tooltip, Legend);

const props = defineProps({
    expenses: Array,
});

function formatNumber(value){
    return monetaryFormat(value);
}

let labels = [], data = [], total = 0;

function extractData() {
    for (let i = 0; i < props.expenses.length; i++) {
        labels.push(props.expenses[i].category_name);
        data.push(Math.round(props.expenses[i].total_amount*100)/100);
        total = total + props.expenses[i].total_amount;
    }
}
extractData()

const chartData = ref({
    labels: labels,
    datasets: [
        {
            backgroundColor: [
                "#ec4899",
                "#06b6d4",
                "#f97316",
                "#22c55e",
                "#a855f7",
                "#ef4444",
                "#d946ef",
                "#f59e0b",
                "#6366f1",
                "#f43f5e",
            ],
            data: data,
        },
    ],
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
};

</script>
