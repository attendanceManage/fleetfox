<script>

import {defineComponent} from "vue";
import {Link} from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

export default defineComponent({
    components: {ApplicationLogo, Link}
})

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
<template>
    <!-- Mobile Sidebar -->
    <div id="mobileSidebar" class="fixed inset-0 bg-black/50 z-40 hidden">
        <aside class="w-64 bg-white dark:bg-gray-800 h-full shadow-md">
            <div class="h-16 flex items-center justify-between px-4 border-b dark:border-gray-700">
                <Link :href="route('dashboard')">
                    <ApplicationLogo
                        class="block h-9 w-auto fill-current text-orange-600 hover:bg-green-600 transition duration-300 "
                    />
                </Link>
                <button id="closeSidebar" class="text-gray-600 dark:text-gray-300">
                    ✕
                </button>
            </div>
            <nav class="p-4 space-y-2">
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-orange-600 text-white">
                        <span class="mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                             fill="currentColor">
                            <path
                                d="M12 3C12.5523 3 13 3.44771 13 4L13 10C13 10.5523 12.5523 11 12 11L4 11C3.44772 11 3 10.5523 3 10L3 4C3 3.44772 3.44772 3 4 3L12 3ZM20 3C20.5523 3 21 3.44771 21 4L21 10C21 10.5523 20.5523 11 20 11L16 11C15.4477 11 15 10.5523 15 10L15 4C15 3.44771 15.4477 3 16 3L20 3ZM20 13C20.5523 13 21 13.4477 21 14L21 20C21 20.5523 20.5523 21 20 21L12 21C11.4477 21 11 20.5523 11 20L11 14C11 13.4477 11.4477 13 12 13L20 13ZM3 14C3 13.4477 3.44772 13 4 13L8 13C8.55229 13 9 13.4477 9 14L9 20C9 20.5523 8.55229 21 8 21L4 21C3.44772 21 3 20.5523 3 20L3 14Z"></path>
                        </svg>
                        </span>
                    Dashboard
                </a>
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-orange-600 text-white">
                        <span class="mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                             fill="currentColor"><path
                            d="M19 4H5V20H19V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H19.9997C20.5519 2 20.9996 2.44772 20.9997 3L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM11.2929 13.1213L15.5355 8.87868L16.9497 10.2929L11.2929 15.9497L7.40381 12.0607L8.81802 10.6464L11.2929 13.1213Z"></path></svg>
                        </span>
                    Task
                </a>

                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-orange-600 text-white">
                        <span class="mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                             fill="currentColor"><path
                            d="M18.6175 13.0317C17.7315 13.6424 16.6575 14 15.5 14C12.4624 14 10 11.5376 10 8.5C10 5.46243 12.4624 3 15.5 3C18.5376 3 21 5.46243 21 8.5C21 9.6575 20.6424 10.7315 20.0317 11.6175L22.7071 14.2929L21.2929 15.7071L18.6175 13.0317ZM3 4H8V6H3V4ZM3 11H8V13H3V11ZM3 18H21V20H3V18Z"></path></svg>
                        </span>
                    Category
                </a>

                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-orange-600 text-white">
                      <span class="mr-2">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path
                         d="M5.32943 3.27158C6.56252 2.8332 7.9923 3.10749 8.97927 4.09446C9.96652 5.08171 10.2407 6.51202 9.80178 7.74535L20.6465 18.5902L18.5252 20.7115L7.67936 9.86709C6.44627 10.3055 5.01649 10.0312 4.02952 9.04421C3.04227 8.05696 2.7681 6.62665 3.20701 5.39332L5.44373 7.63C6.02952 8.21578 6.97927 8.21578 7.56505 7.63C8.15084 7.04421 8.15084 6.09446 7.56505 5.50868L5.32943 3.27158ZM15.6968 5.15512L18.8788 3.38736L20.293 4.80157L18.5252 7.98355L16.7574 8.3371L14.6361 10.4584L13.2219 9.04421L15.3432 6.92289L15.6968 5.15512ZM8.62572 12.9333L10.747 15.0546L5.79729 20.0044C5.2115 20.5902 4.26175 20.5902 3.67597 20.0044C3.12464 19.453 3.09221 18.5793 3.57867 17.99L3.67597 17.883L8.62572 12.9333Z"></path></svg>
                      </span>
                    Settings
                </a>
            </nav>
        </aside>
    </div>
</template>

