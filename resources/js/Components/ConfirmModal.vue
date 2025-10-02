<!-- ConfirmModal.vue -->
<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
            <h3 class="text-lg font-semibold mb-4">{{ title }}</h3>
            <p class="mb-6">{{ message }}</p>
            <div class="flex justify-end space-x-3">
                <button @click="cancel" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                <button @click="confirm" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: Boolean,
        title: { type: String, default: 'Confirm Deletion' },
        message: { type: String, default: 'Are you sure you want to delete this?' },
    },
    emits: ['confirm', 'cancel'],
    methods: {
        confirm() {
            this.$emit('confirm')
        },
        cancel() {
            this.$emit('cancel')
        },
    },
}
</script>
