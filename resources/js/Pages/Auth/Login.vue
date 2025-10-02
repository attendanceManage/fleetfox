<script setup>
import {Head, Link} from '@inertiajs/vue3';
import TabComponent from '@/Components/Tab.vue';


</script>

<template>
    <Head title="SignUp" />
    <div class="min-h-screen bg-blue-950 py-12 px-4 sm:px-6 lg:px-8 flex  grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="md:col-span-1"></div>
        <div class="md:col-span-4 ">
            <!--FleetFox Image Start -->
            <div>
                <img
                    src="https://fleetfox.eu/wp-content/uploads/2024/08/fleetfox-logo-orange-white-landscape-2.png"
                    alt="FleetFoxLogo"
                    class="w-full  w-40 sm:w-800 md:w-64 lg:w-80 h-auto "/>
            </div>
            <div>
                <img
                    src="https://fleetfox.eu/wp-content/uploads/2024/08/fleetfox-car-washing.jpg"
                    alt="FleetFox Description"
                    class="opacity-50 w-full mt-12 max-w-lg rounded-xl shadow-xl object-cover"/>
            </div>
            <!--FleetFox Image End-->
        </div>
        <div class="md:col-span-1"></div>
        <div class="md:col-span-6 ">
            <TabComponent/>

        </div>
    </div>
</template>
