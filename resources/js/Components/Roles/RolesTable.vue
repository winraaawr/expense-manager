<template>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-white uppercase bg-blue-500 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="px-6 py-3">Display Name</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Created at</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="role in roles"
                    :key="role.id"
                    @click="showUpdateRole(role)"
                    class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-slate-100 dark:hover:bg-gray-700"
                >
                    <th
                        scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        {{ role.role_name }}
                    </th>
                    <td scope="col" class="px-6 py-4">
                        {{ role.description }}
                    </td>
                    <td class="px-6 py-4">{{ formatDate(role.created_at) }}</td>
                </tr>
                <tr v-if="roles.length < 1">
                    <th colspan="4" class="italic px-6 py-16 font-medium text-gray-800/50 whitespace-nowrap dark:text-white text-center">No role found.</th>
                </tr>
            </tbody>
        </table>
    </div>

    <Modal class="absolute" v-if="isShownModalRole" size="lg" @close="closeUpdateRole">
        <template #header>
            <div class="flex items-center text-lg">Update Role</div>
        </template>
        <template #body>
            <form>
                <div class="grid grid-cols-1 sm:grid-cols-3 mb-2">
                    <label for="role">Display Name</label>
                    <input
                        type="text"
                        id="role"
                        name="role"
                        class="col-span-2 px-2 py-1 rounded-md disabled:cursor-not-allowed disabled:bg-gray-200 disabled:text-gray-800/50"
                        v-model="form.role_name"
                        :disabled="form.id === 1"
                    />
                    <div v-if="form.errors.role_name" class="col-span-1"></div>
                    <div
                        v-if="form.errors.role_name"
                        class="col-span-2 text-red-500 text-sm"
                    >
                        {{ form.errors.role_name }}
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3">
                    <label for="description">Description</label>
                    <input
                        type="text"
                        id="description"
                        name="description"
                        class="col-span-2 px-2 py-1 rounded-md disabled:cursor-not-allowed disabled:bg-gray-200 disabled:text-gray-800/50"
                        v-model="form.description"
                        :disabled="form.id === 1"
                    />
                    <div
                        v-if="form.errors.description"
                        class="col-span-1"
                    ></div>
                    <div
                        v-if="form.errors.description"
                        class="col-span-2 text-red-500 text-sm"
                    >
                        {{ form.errors.description }}
                    </div>
                </div>
            </form>
        </template>
        <template #footer>
            <div class="flex flex-row justify-between">
                <div class="flex items-center">
                    <button
                        v-if="form.id != 1"
                        @click="deleteRole(form.id)"
                        type="button"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800"
                    >
                        Delete
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <button
                        @click="closeUpdateRole"
                        type="button"
                        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800"
                    >
                        Cancel
                    </button>
                    <button
                        v-if="form.id != 1"
                        @click="submitUpdateRole"
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
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { dateFormatter } from "@/utilities";

const isShownModalRole = ref(false);

const props = defineProps({
    roles: Array,
});

const form = useForm({
    id: "",
    role_name: "",
    description: "",
});

function showUpdateRole(data) {
    form.id = data.id;
    form.role_name = data.role_name;
    form.description = data.description;
    isShownModalRole.value = true;
}

function closeUpdateRole() {
    isShownModalRole.value = false;
}

function submitUpdateRole() {
    form.put(route("roles.update", form.id), {
        onSuccess: () => {
            form.reset();
            closeUpdateRole();
        },
        onError: (error) => {
            console.log(error);
        }
    });
}

const deleteMsg =
    "Deleting this role will also delete users currently assigned to this role? Do you want to continue?";
function deleteRole(id) {
    if (confirm(deleteMsg)) {
        router.delete(route("roles.destroy", id), {
            onSuccess: () => {
                closeUpdateRole();
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
