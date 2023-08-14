<template>
    <button
        @click="showAddRole"
        class="block w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button"
    >
        Add Role
    </button>
    <Modal class="absolute" size="lg" v-if="isShownAddRole" @close="closeAddRole">
        <template #header>
            <div class="flex items-center text-lg">Add Role</div>
        </template>
        <template #body>
            <form>
                <!-- content form -->
                <div class="grid grid-cols-1 sm:grid-cols-3 mb-2">
                    <label for="role">Display Name</label>
                    <input
                        type="text"
                        id="role"
                        name="role"
                        class="col-span-2 px-2 py-1 rounded-md"
                        v-model="form.role_name"
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
                        class="col-span-2 px-2 py-1 rounded-md"
                        v-model="form.description"
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
            <div class="flex flex-row justify-end space-x-2">
                <button
                    @click="closeAddRole"
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

const isShownAddRole = ref(false);

function closeAddRole() {
    isShownAddRole.value = false;
    console.log(isShownAddRole.value);
}
function showAddRole() {
    isShownAddRole.value = true;
    console.log(isShownAddRole.value);
}

const props = defineProps({
    roles: Array,
});

const form = useForm({
    role_name: "",
    description: "",
});

function submitRole() {
    form.post(route("roles.store"), {
        onSuccess: () => {
            form.reset();
            closeAddRole();
        },
    });
}
</script>
