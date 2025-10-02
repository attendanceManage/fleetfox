<script setup>
import Input from '@/Components/Input.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <div
        class="py-12 flex  flex items-center w-full max-w-lg">
        <div class="w-full max-w-lg border border-orange-500 p-10 rounded-3xl">
            <div class="text-center mb-10">
                <h1
                    class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-200 via-orange-500 to-red-500"
                >
                    FleetFox Sign In
                </h1>
            </div>
            <Head title="Log in"/>

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <Input
                        v-model="form.email"
                        id="email"
                        label="Email "
                        type="email"
                        borderColor="orange"
                    />
                    <InputError class="mt-2" :message="form.errors.email"/>
                </div>

                <div class="mt-4">

                    <Input
                        v-model="form.password"
                        id="password"
                        label="Password "
                        type="password"
                        borderColor="orange"
                    />
                    <InputError class="mt-2" :message="form.errors.password"/>
                </div>

                <div class="mt-4 block">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember"/>
                        <span class="ms-2 text-sm text-gray-600"
                        >Remember me</span
                        >
                    </label>
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <PrimaryButton
                        class="w-full relative inline-flex items-center justify-center p-0.5 text-sm font-medium rounded-lg group bg-gradient-to-br from-orange-400 to-orange-500"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Sign In
                    </PrimaryButton>
                </div>
                <div class="mt-4 flex items-center justify-end">
                    <Link
                        :href="route('password.request')"
                        class="rounded-md text-sm text-orange-600 underline hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Forgot your password?
                    </Link>

                </div>
            </form>

        </div>
    </div>
</template>
