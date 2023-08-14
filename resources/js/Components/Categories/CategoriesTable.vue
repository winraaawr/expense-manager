<template>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-white uppercase bg-blue-500 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Display Name</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Created at</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories" :key="category.id" @click="showUpdateCategory(category)"
                    class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-slate-100 dark:hover:bg-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ category.category_name }}
                    </th>
                    <td scope="col" class="px-6 py-4">
                        {{ category.description  }}
                    </td>
                    <td class="px-6 py-4">{{ formatDate(category.created_at) }}</td>
                </tr>
                <tr v-if="categories.length < 1" class="">
                    <th colspan="4" class="italic px-6 py-16 font-medium text-gray-800/50 whitespace-nowrap dark:text-white text-center">
                        No expense category found.
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <Modal v-if="isShownModalCategory" size="lg" @close="closeUpdateCategory">
        <template #header>
            <div class="flex items-center text-lg">Update User</div>
        </template>
        <template #body>
            <form>
                <div class="grid grid-cols-1 sm:grid-cols-3 mb-2">
                    <label for="category">Display Name</label>
                    <input type="text" id="category" name="category" class="col-span-2 px-2 py-1 rounded-md"
                        v-model="form.category_name" />
                    <div v-if="form.errors.category_name" class="col-span-1"></div>
                    <div v-if="form.errors.category_name" class="col-span-2 text-red-500 text-sm">
                        {{ form.errors.category_name }}
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 mb-2">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" class="col-span-2 px-2 py-1 rounded-md"
                        v-model="form.description" />
                    <div v-if="form.errors.description" class="col-span-1"></div>
                    <div v-if="form.errors.description" class="col-span-2 text-red-500 text-sm">
                        {{ form.errors.description }}
                    </div>
                </div>
            </form>
        </template>
        <template #footer>
            <div class="flex flex-row justify-between">
                <div class="flex items-center">
                    <button @click="deleteUser(form.id)" type="button"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800">
                        Delete
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <button @click="closeUpdateCategory" type="button"
                        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800">
                        Cancel
                    </button>
                    <button @click="submitUpdateCategory" :disabled="form.processing" type="button"
                        class="text-white bg-emerald-700 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-blue-800">
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
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { dateFormatter } from '@/utilities.js'

const props = defineProps({
    categories: Array,
})

const isShownModalCategory = ref(false);
const form = useForm({
    id: "",
    category_name: "",
    description: "",
});

function showUpdateCategory(data) {
    isShownModalCategory.value = true;
    form.id = data.id;
    form.category_name = data.category_name
    form.description = data.description
}

function closeUpdateCategory() {
    isShownModalCategory.value = false;
    form.reset();
    form.clearErrors();
}

function submitUpdateCategory(){
    form.put(route("categories.update", form.id), {
        onSuccess: () => {
            form.reset();
            closeUpdateCategory();
        },
        onError: (error) =>{
            console.log(error)
        }
    });
}

const deleteMsg = "Deleting this category will also delete expenses assigned to this category. Do you wish to continue?";

function deleteUser(id) {
    if (confirm(deleteMsg)) {
        router.delete(route("categories.destroy", id), {
            onSuccess: () => {
                closeUpdateCategory();
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
</script>
