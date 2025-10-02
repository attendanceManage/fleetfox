<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex  px-1 pt-1 border-orange-600   font-medium leading-5 text-gray-900 focus:outline-none focus:border-orange-600 transition duration-150 ease-in-out'
        : 'inline-flex  px-1 pt-1 border-orange-600   font-medium leading-5 text-gray-900 focus:outline-none focus:border-orange-600 transition duration-150 ease-in-out'

);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
