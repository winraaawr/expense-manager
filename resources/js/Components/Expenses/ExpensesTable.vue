<template>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-white uppercase bg-blue-500 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="px-6 py-3">Expense Category</th>
                    <th v-if="user.role_id == 1" scope="col" class="px-6 py-3">User</th>
                    <th scope="col" class="px-6 py-3">Amount</th>
                    <th scope="col" class="px-6 py-3">Entry Date</th>
                    <th scope="col" class="px-6 py-3">Created at</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="expense in expenses"
                    :key="expense.id"
                    @click="showUpdateExpense(expense)"
                    class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-slate-100 dark:hover:bg-gray-700"
                >
                    <th
                        scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        {{ expense.category.category_name }}
                    </th>
                    <td v-if="user.role_id == 1" scope="col" class="px-6 py-4">
                        {{ expense.user.name }}
                    </td>
                    <td scope="col" class="px-6 py-4">
                        ${{ formatNumber(expense.amount) }}
                    </td>
                    <td scope="col" class="px-6 py-4">
                        {{ formatDate(expense.entry_date) }}
                    </td>
                    <td class="px-6 py-4">{{ formatDate(expense.created_at) }}</td>
                </tr>
                <tr v-if="expenses.length < 1" class="">
                    <th colspan="4" class="italic px-6 py-16 font-medium text-gray-800/50 whitespace-nowrap dark:text-white text-center">
                        No expense record found.
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <Modal v-if="isShownModalRole" size="lg" @close="closeUpdateExpense">
        <template #header>
            <div class="flex items-center text-lg">Update Expenses</div>
        </template>
        <template #body>
            <form>
                <div v-if="user.role_id == 1" class="grid grid-cols-1 sm:grid-cols-3 mb-3">
                    <label for="amount">User</label>
                    <span class="text-gray-800/50">{{ belongsTo }}</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 mb-2">
                    <label for="category">Category</label>
                    <select
                        id="category"
                        name="category"
                        class="col-span-2 px-2 py-1 rounded-md"
                        v-model="form.category_id"
                    >
                        <option
                            v-for="category in categories"
                            :value="category.id"
                        >
                            {{ category.category_name }}
                        </option>
                    </select>
                    <div
                        v-if="form.errors.category_id"
                        class="col-span-1"
                    ></div>
                    <div
                        v-if="form.errors.category_id"
                        class="col-span-2 text-red-500 text-sm"
                    >
                        {{ form.errors.category_id }}
                    </div>
                </div>


                <div class="grid grid-cols-1 sm:grid-cols-3 mb-2">
                    <label for="amount">Amount</label>
                    <input
                        type="number"
                        id="amount"
                        name="amount"
                        class="col-span-2 px-2 py-1 rounded-md"
                        v-model="form.amount"
                        min="0"
                        @keypress="disableLetters"
                    />
                    <div v-if="form.errors.amount" class="col-span-1"></div>
                    <div
                        v-if="form.errors.amount"
                        class="col-span-2 text-red-500 text-sm"
                    >
                        {{ form.errors.amount }}
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3">
                    <label for="date">Entry Date</label>
                    <input
                        type="date"
                        id="date"
                        name="date"
                        class="col-span-2 px-2 py-1 rounded-md"
                        v-model="form.entry_date"
                    />
                    <div v-if="form.errors.entry_date" class="col-span-1"></div>
                    <div
                        v-if="form.errors.entry_date"
                        class="col-span-2 text-red-500 text-sm"
                    >
                        {{ form.errors.entry_date }}
                    </div>
                </div>
            </form>
        </template>
        <template #footer>
            <div class="flex flex-row justify-between">
                <div class="flex items-center">
                    <button
                        @click="deleteExpense(form.id)"
                        type="button"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800"
                    >
                        Delete
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <button
                        @click="closeUpdateExpense"
                        type="button"
                        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800"
                    >
                        Cancel
                    </button>
                    <button
                        @click="submitUpdateExpense"
                        :disabled="form.processing"
                        type="button"
                        class="text-white bg-emerald-700 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-blue-800"
                    >
                        Update
                    </button>
                </div>
            </div>
        </template>
    </Modal>
</template>

<script setup>
import { ref, defineProps } from "vue";
import { Modal } from "flowbite-vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { dateFormatter, justNumbers, monetaryFormat } from "@/utilities.js"

const page = usePage();
const user = page.props.auth.user;
const isShownModalRole = ref(false);
const belongsTo = ref('');

const props = defineProps({
    expenses: Array,
    categories: Array,
});

console.log(props.expenses);

const form = useForm({
    id: "",
    amount: "",
    category_id: "",
    user_id: user.id,
    entry_date: "",
});

function showUpdateExpense(data) {
    belongsTo.value = data.user.name;
    form.id = data.id;
    form.amount = data.amount;
    form.category_id = data.category_id;
    form.user_id = data.user_id;
    form.entry_date = data.entry_date;
    isShownModalRole.value = true;
}

function closeUpdateExpense() {
    isShownModalRole.value = false;
}

function submitUpdateExpense() {
    form.put(route("expenses.update", form.id), {
        onSuccess: () => {
            form.reset();
            closeUpdateExpense();
        },
        onError: (error) => {
            console.log(error);
        }
    });
    console.log(form)
}

const deleteMsg =
    "Are you sure you want to delete this expense record?";
function deleteExpense(id) {
    if (confirm(deleteMsg)) {
        router.delete(route("expenses.destroy", id), {
            onSuccess: () => {
                closeUpdateExpense();
            },
            onError: (error) => {
                console.error(error);
            },
        });
    }
}

function formatDate(date){
    return dateFormatter(date);
}

function disableLetters(e){
    return justNumbers(e);
}

function formatNumber(value){
    return monetaryFormat(value);
}
</script>
