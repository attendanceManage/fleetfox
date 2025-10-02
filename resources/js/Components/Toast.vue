<script setup>
import { onMounted, ref } from 'vue'

const props = defineProps({
    message: String,
    type: {
        type: String,
        default: 'success'
    }
})

const show = ref(true)

onMounted(() => {
    setTimeout(() => {
        show.value = false
    }, 3000)
})

const colors = {
    success: {
        bg: 'bg-green-100',
        border: 'border-green-300',
        text: 'text-green-800',
        icon: 'text-green-600'
    },
    error: {
        bg: 'bg-red-100',
        border: 'border-red-300',
        text: 'text-red-800',
        icon: 'text-red-600'
    }
}
</script>

<template>
    <div
        v-if="show"
        class="fixed top-4 right-4 z-50 flex items-center space-x-2 px-4 py-3 rounded shadow-lg"
        :class="[colors[type].bg, colors[type].border, colors[type].text, 'border']"
        role="alert"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24"
             :class="colors[type].icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <span>{{ message }}</span>
    </div>
</template>
