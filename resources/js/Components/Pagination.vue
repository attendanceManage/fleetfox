<script setup>
import {Head, Link,router} from '@inertiajs/vue3';

const props = defineProps({
    links: Array,
});

function goToPage(url) {
    if (!url) return;
    const params = new URL(url).searchParams;
    const page = params.get('page') || 1;
    router.get(route('categories'), { page }, { preserveState: true, replace: true });
}
</script>

<template>
    <nav class="mt-6 flex justify-end space-x-2" role="navigation" aria-label="Pagination Navigation">

        <button
            v-for="link in links"
            :key="link.label"
            :disabled="!link.url"
            class="px-3 py-1 border  border-blue-950 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-100"
            :class="{ 'bg-orange-600 text-white': link.active }"
            @click="goToPage(link.url)"
            v-html="link.label"
        ></button>
    </nav>
</template>

