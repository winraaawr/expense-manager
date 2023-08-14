<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import Sidebar from '@/Components/Dashboard/Sidebar.vue';
</script>

<template>
    <Sidebar />
    <!-- Page Content -->
    <main class="bg-slate-200 min-h-screen sm:p-4 sm:ml-64">
        <slot />
    </main>
</template>
