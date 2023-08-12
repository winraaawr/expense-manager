<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-16 sm:py-14">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <div class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:items-center justify-between">
                            <h1 class="font-bold text-xl">My Expenses</h1>
                            <h1 class="font-bold sm:text-lg">Dashboard</h1>
                        </div>
                        <!-- Chart Component Here -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
