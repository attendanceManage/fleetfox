<script setup>
import {ref} from "vue";
import LayoutHeader from '@/Components/LayoutHeader.vue';
import SubHeader from '@/Components/SubHeader.vue';
import LayoutHeaderMobile from '@/Components/LayoutHeaderMobile.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Head, Link} from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
</script>
<template>
    <Head title="Settings" />
    <div class="flex bg-gray-100 dark:bg-gray-900 dark:text-white min-h-screen font-sans">
        <LayoutHeader/>
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <SubHeader title="Settings"/>
            <!-- Page Content -->

            Settings
        </div>
        <LayoutHeaderMobile/>
    </div>
</template>
