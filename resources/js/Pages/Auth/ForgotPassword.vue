<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TabComponent from "@/Components/Tab.vue";
import Input from "@/Components/Input.vue";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Forgot Password" />

    <!-- Flash status message -->
    <div v-if="status" class="mb-4 text-sm font-medium text-green-600 text-center">
        {{ status }}
    </div>

    <!-- Page Container -->
    <div class="min-h-screen bg-blue-950 px-4 py-8 flex flex-col justify-center items-center gap-8">

        <!-- Logo -->
        <div class="w-full flex justify-center">
            <img
                src="https://fleetfox.eu/wp-content/uploads/2024/08/fleetfox-logo-orange-white-landscape-2.png"
                alt="FleetFoxLogo"
                class="w-40 sm:w-50 md:w-40 lg:w-80"
            />
        </div>

        <!-- Form Section -->
        <div class="w-full max-w-lg border border-orange-500 p-10 rounded-3xl">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-200 via-orange-500 to-red-500">
                    Forgot your password?
                </h1>
                <p class="mb-4 text-sm text-white">
                    No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </p>
            </div>

            <form class="space-y-6" @submit.prevent="submit">
                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    label="Email"
                />

                <InputError class="mt-2" :message="form.errors.email" />

                <div class="pt-5">
                    <PrimaryButton
                        class="w-full relative inline-flex items-center justify-center p-0.5 text-sm font-medium rounded-lg group bg-gradient-to-br from-orange-400 to-orange-500"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Email Password Reset Link
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>

