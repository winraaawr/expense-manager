<template>
    <nav
        class="sm:pl-64 fixed top-0 w-full bg-white shadow-sm border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                        type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                </div>
                <div class="flex flex-row items-center">
                    <span class="hidden sm:block mr-4 text-sm text-gray-800 dark:text-white">Welcome to Expense
                        Manager</span>
                    <Link :href="route('logout')" method="post" as="button" class="text-sm text-gray-800/60 dark:text-white">
                    Log out
                    </Link>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-12 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <Link :href="route('profile.edit')"
                        class="flex flex-row space-x-4 p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="h-9 w-9 bg-gray-800 rounded-full"></span>
                        <div class="flex flex-col space-y-0">
                            <span class="">{{ user.name }}</span>
                            <span class="text-xs">{{ role }}</span>
                        </div>
                    </Link>
                </li>
                <li>
                    <Link :href="route('dashboard')" :class="$page.url === '/dashboard' ? 'bg-blue-500 text-white hover:bg-blue-600': 'text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700'"
                        class="flex items-center p-2 rounded-lg dark:text-white group">
                        <font-awesome-icon icon="fa-solid fa-chart-pie" class="ml-3" /><span class="ml-3">Dashboard</span>
                    </Link>
                </li>
                <li v-if="$page.props.auth.user.role_id === 1">
                    <a
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group mb-2">
                        <span class="ml-3">User Management</span>
                    </a>
                    <ul class="space-y-2">

                        <li><Link :href="route('roles')" :class="$page.url === '/roles' ? 'bg-blue-500 text-white hover:bg-blue-600': 'text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                class="flex items-center p-2 rounded-lg group">
                                <font-awesome-icon icon="fa-solid fa-user-gear" class="ml-3" /><span class="ml-3">Roles</span>
                            </Link></li>
                        <li><Link :href="route('users')" :class="$page.url === '/users' ? 'bg-blue-500 text-white hover:bg-blue-600': 'text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                class="flex items-center p-2 rounded-lg group">
                                <font-awesome-icon icon="fa-solid fa-users" class="ml-3" /><span class="ml-3">Users</span>
                        </Link></li>
                    </ul>
                </li>
                <li>
                    <a
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group mb-2">
                        <span class="ml-3">Expenses Management</span>
                    </a>
                    <ul class="space-y-2">

                        <li v-if="$page.props.auth.user.role_id === 1">
                            <Link :href="route('categories')" :class="$page.url === '/categories' ? 'bg-blue-500 text-white hover:bg-blue-600': 'text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                class="flex items-center p-2 rounded-lg group">
                                <font-awesome-icon icon="fa-solid fa-comment-dollar" class="ml-3" /><span class="ml-3">Expenses Categories</span>
                        </Link></li>
                        <li><Link :href="route('expenses')" :class="$page.url === '/expenses' ? 'bg-blue-500 text-white hover:bg-blue-600': 'text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                class="flex items-center p-2 rounded-lg group">
                                <font-awesome-icon icon="fa-solid fa-money-check-dollar" class="ml-3" /><span class="ml-3">Expenses</span>
                        </Link></li>
                    </ul>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, computed } from 'vue'
import { initFlowbite } from 'flowbite'
import { router, usePage } from '@inertiajs/vue3'
import axios from 'axios'

onMounted(() => {
    initFlowbite();
})

const role = ref('User Role');

const page = usePage();
const user = page.props.auth.user

async function getRole(){
    let response = await axios.get(route('roles.show'));
    role.value = response.data.role_name;
}

getRole();


</script>
