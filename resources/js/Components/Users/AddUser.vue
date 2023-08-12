<template>
    <button
        @click="showAddUser"
        class="block w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button"
    >
        Add User
    </button>
    <Modal size="lg" v-if="isShownAddUser" @close="closeAddUser">
        <template #header>
            <div class="flex items-center text-lg">Add Role</div>
        </template>
        <template #body>
            <form>
                <!-- content form -->
                <div class="grid grid-cols-1 sm:grid-cols-3 mb-2">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="col-span-2 px-2 py-1 rounded-md"
                        v-model="form.name"
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
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="col-span-2 px-2 py-1 rounded-md"
                        v-model="form.email"
                    />
                    <div
                        v-if="form.errors.email"
                        class="col-span-1"
                    ></div>
                    <div
                        v-if="form.errors.email"
                        class="col-span-2 text-red-500 text-sm"
                    >
                        {{ form.errors.email }}
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3">
                    <label for="role">Role</label>
                    <!-- <input type="text" id="description" name="description" class="col-span-2 px-2 py-1 rounded-md"
                        v-model="form.email" /> -->
                    <select id="role" name="role" class="col-span-2 px-2 py-1 rounded-md" v-model="form.role_id">
                        <option v-for="role in roles" :value="role.id">{{ role.role_name }}</option>
                    </select>
                    <div v-if="form.errors.role_id" class="col-span-1"></div>
                    <div v-if="form.errors.role_id" class="col-span-2 text-red-500 text-sm">
                        {{ form.errors.role_id }}
                    </div>
                </div>
            </form>
        </template>
        <template #footer>
            <div class="flex flex-row justify-end space-x-2">
                <button
                    @click="closeAddUser"
                    type="button"
                    class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800"
                >
                    Cancel
                </button>
                <button
                    :disabled="form.processing"
                    @click="submitRole()"
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
import { useForm } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";

const isShownAddUser = ref(false);

function closeAddUser() {
    isShownAddUser.value = false;
    console.log(isShownAddUser.value);
}
function showAddUser() {
    isShownAddUser.value = true;
    console.log(isShownAddUser.value);
}

const props = defineProps({
    roles: Array,
});

const form = useForm({
    name: '',
    email: '',
    role_id: '',
});

function submitRole() {
    form.post(route("roles.store"), {
        onSuccess: () => {
            form.reset();
            closeAddUser();
        },
    });
}
</script>
