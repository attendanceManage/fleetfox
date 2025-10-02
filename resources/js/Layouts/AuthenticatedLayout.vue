<script setup>
import {ref} from "vue";
import LayoutHeader from '@/Components/LayoutHeader.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link} from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

</script>
<template>
    <div class="flex bg-gray-100 dark:bg-gray-900 dark:text-white min-h-screen font-sans">
        <LayoutHeader/>
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <header
                class="h-16 bg-blue-950 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-4 shadow-sm">
                <div class="flex items-center space-x-4">
                    <!-- Mobile Menu Button -->
                    <button id="sidebarToggle" class="md:hidden text-gray-600 dark:text-gray-300 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <span class="text-lg font-semibold">Dashboard</span>
                </div>
                <div>
                    <button id="toggleDark" class="text-gray-600 dark:text-gray-300 hover:text-blue-500 transition">🌓
                    </button>
                </div>
            </header>
            <!-- Page Content -->


        </div>

    </div>

</template>
<script>

const sidebarToggle = document.getElementById('sidebarToggle');
const mobileSidebar = document.getElementById('mobileSidebar');
const closeSidebar = document.getElementById('closeSidebar');
const toggleDark = document.getElementById('toggleDark');


sidebarToggle?.addEventListener('click', () => {
    mobileSidebar.classList.remove('hidden');
});


closeSidebar?.addEventListener('click', () => {
    mobileSidebar.classList.add('hidden');
});

toggleDark?.addEventListener('click', () => {
    document.documentElement.classList.toggle('dark');
    localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
});

// Initialize dark mode from localStorage
if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
}

</script>
