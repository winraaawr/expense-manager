<script setup>
import { defineProps } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Flash from "@/Components/Flash.vue"
import UsersTable from "@/Components/Users/UsersTable.vue"
import { Head } from '@inertiajs/vue3';
import AddUser from '@/Components/Users/AddUser.vue';

const props = defineProps({
    users: Array,
    roles: Array,
})
console.log(props.users);
</script>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    layout: AuthenticatedLayout,
};
</script>

<template>
    <Head title="Users" />

        <div class="py-16 sm:py-14">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <div class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:items-center justify-between">
                            <h1 class="font-bold text-xl">Users</h1>
                            <h1 class="font-bold sm:text-lg">User Management > Users</h1>
                        </div>
                        <div class="flex flex-col space-y-4 pt-6 pb-2">
                            <Flash v-if="$page.props.flash.message" />
                            <UsersTable :users="users" :roles="roles" />
                            <div class="flex flex-row justify-end">
                                <AddUser :roles="roles" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>