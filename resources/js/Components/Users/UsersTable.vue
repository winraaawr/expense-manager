<template>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-white uppercase bg-blue-500 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email Address</th>
                    <th scope="col" class="px-6 py-3">Role</th>
                    <th scope="col" class="px-6 py-3">Created at</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="user in users"
                    :key="user.id"
                    @click="showUpdateUser(user)"
                    class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-slate-100 dark:hover:bg-gray-700"
                >
                    <th
                        scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        {{ user.name }}
                    </th>
                    <td scope="col" class="px-6 py-4">
                        {{ user.email }}
                    </td>
                    <td scope="col" class="px-6 py-4">
                        {{ user.role.role_name }}
                    </td>
                    <td class="px-6 py-4">{{ formatDate(user.created_at) }}</td>
                </tr>
                <tr v-if="users.length < 1">
                    <th
                        colspan="4"
                        class="italic px-6 py-16 font-medium text-gray-800/50 whitespace-nowrap dark:text-white text-center"
                    >
                        No user account found.
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <Modal v-if="isShownModalUser" size="lg" @close="closeUpdateUser">
        <template #header>
            <div class="flex items-center text-lg">Update User</div>
        </template>
        <template #body>
            <form>
                <div class="grid grid-cols-1 sm:gap-2 sm:grid-cols-3 mb-2">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="col-span-2 px-2 py-1 rounded-md disabled:cursor-not-allowed disabled:bg-gray-200 disabled:text-gray-800/50"
                        v-model="form.name"
                        :disabled="currentRoleID === 1"
                    />
                    <div v-if="form.errors.name" class="col-span-1"></div>
                    <div
                        v-if="form.errors.name"
                        class="col-span-2 text-red-500 text-sm"
                    >
                        {{ form.errors.name }}
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 mb-2">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="col-span-2 px-2 py-1 rounded-md disabled:cursor-not-allowed disabled:bg-gray-200 disabled:text-gray-800/50"
                        v-model="form.email"
                        :disabled="currentRoleID === 1"
                    />
                    <div v-if="form.errors.email" class="col-span-1"></div>
                    <div
                        v-if="form.errors.email"
                        class="col-span-2 text-red-500 text-sm"
                    >
                        {{ form.errors.email }}
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3">
                    <label for="role">Role</label>
                    <select
                        id="role"
                        name="role"
                        class="col-span-2 px-2 py-1 rounded-md disabled:cursor-not-allowed disabled:bg-gray-200 disabled:text-gray-800/50"
                        v-model="form.role_id"
                        :disabled="currentRoleID === 1"
                    >
                        <option v-for="role in roles" :value="role.id">
                            {{ role.role_name }}
                        </option>
                    </select>
                    <div v-if="form.errors.role_id" class="col-span-1"></div>
                    <div
                        v-if="form.errors.role_id"
                        class="col-span-2 text-red-500 text-sm"
                    >
                        {{ form.errors.role_id }}
                    </div>
                </div>
            </form>
        </template>
        <template #footer>
            <div class="flex flex-row justify-between">
                <div class="flex items-center">
                    <button
                        v-if="currentRoleID != 1"
                        @click="deleteUser(form.id)"
                        type="button"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800"
                    >
                        Delete
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <button
                        @click="closeUpdateUser"
                        type="button"
                        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800"
                    >
                        Cancel
                    </button>
                    <button
                        v-if="currentRoleID != 1"
                        @click="submitUpdateUser"
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

const isShownModalUser = ref(false);

const props = defineProps({
    users: Array,
    roles: Array,
});

const currentRoleID = ref(null);

const form = useForm({
    id: "",
    name: "",
    email: "",
    role_id: "",
});

function showUpdateUser(data) {
    isShownModalUser.value = true;
    currentRoleID.value = data.role_id;
    form.id = data.id;
    form.name = data.name;
    form.email = data.email;
    form.role_id = data.role_id;
    console.log(data.id);
}

function closeUpdateUser() {
    isShownModalUser.value = false;
    form.reset();
    form.clearErrors();
}

function submitUpdateUser() {
    form.put(route("users.update", form.id), {
        onSuccess: () => {
            form.reset();
            closeUpdateUser();
        },
        onError: (error) => {
            console.log(error);
        },
    });
}

const deleteMsg = "Are you sure you want to delete this user?";

function deleteUser(id) {
    if (confirm(deleteMsg)) {
        router.delete(route("users.destroy", id), {
            onSuccess: () => {
                closeUpdateUser();
            },
            onError: (error) => {
                console.error(error);
            },
        });
    }
}

function formatDate(date) {
    return dateFormatter(date);
}
</script>
