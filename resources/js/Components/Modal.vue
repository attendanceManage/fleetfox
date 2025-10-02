<!-- resources/js/Components/Modal.vue -->
<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button
                @click="$emit('close')"
                class="absolute top-2 right-2 text-gray-500 hover:text-black text-xl"
            >
                ×
            </button>
            <div class="text-xl font-semibold mb-4 text-orange-600">
                <slot name="title" />
            </div>
            <div>
                <slot name="content" />
            </div>
        </div>
    </div>
</template>
