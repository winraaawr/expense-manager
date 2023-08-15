<template>
    <button
        @click="showAddExpenses"
        class="block w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button"
    >
        Add Expense
    </button>
    <Modal class="absolute" size="lg" v-if="isShownAddExpenses" @close="closeAddExpenses">
        <template #header>
            <div class="flex items-center text-lg">Add New Expense</div>
        </template>
        <template #body>
            <form>
                <!-- content form -->
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
            <div class="flex flex-row justify-end space-x-2">
                <button
                    @click="closeAddExpenses"
                    type="button"
                    class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800"
                >
                    Cancel
                </button>
                <button
                    :disabled="form.processing"
                    @click="submitExpenses()"
                    type="button"
                    class="text-white bg-emerald-700 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-blue-800"
                >
                    Save
                </button>
            </div>
        </template>
    </Modal>
</template>

<script setup>
import { ref, defineProps } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";
import { justNumbers } from '@/utilities'

const page = usePage();
const user = page.props.auth.user;
const isShownAddExpenses = ref(false);

function closeAddExpenses() {
    isShownAddExpenses.value = false;
    console.log(isShownAddExpenses.value);
}
function showAddExpenses() {
    isShownAddExpenses.value = true;
    console.log(isShownAddExpenses.value);
}

const props = defineProps({
    categories: Array,
    user: Array,
});

const form = useForm({
    category_id: "",
    amount: "",
    user_id: user.id,
    entry_date: "",
});

function submitExpenses() {
    form.post(route("expenses.store"), {
        onSuccess: () => {
            form.reset();
            closeAddExpenses();
        },
        onError: (error) => {
            console.log(error);
        }
    });
}

function disableLetters(e){
    return justNumbers(e);
}
</script>
