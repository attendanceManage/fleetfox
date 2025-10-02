
    <script setup>
        defineProps({
            title: {
                type: String,
            }
        });
    </script>
    <template>
    <header
        class="h-16 bg-blue-950 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-4 shadow-sm">
        <div class="flex items-center space-x-4">
            <!-- Mobile Menu Button -->
            <button id="sidebarToggle" class="md:hidden text-gray-600 dark:text-gray-300 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="text-lg font-semibold text-white"> {{ title }}</span>
        </div>
        <div>
            <button id="toggleDark" class="text-gray-600 dark:text-gray-300 hover:text-blue-500 transition">🌓
            </button>
        </div>
    </header>
</template>
<script setup lang="ts">
</script>
