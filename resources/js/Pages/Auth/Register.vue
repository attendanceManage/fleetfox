<script setup>
import Input from '@/Components/Input.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>

    <Head title="SignUp" />
    <div
        class="py-12 flex  flex items-center ">
        <div class="w-full max-w-lg border border-orange-500 p-10 rounded-3xl">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-200 via-orange-500 to-red-500">
                    Become A Fleet User
                </h1>
            </div>
        <form @submit.prevent="submit">
            <div>
                <Input
                    id="name"
                    label="Name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">


                <Input
                    label="Email"
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">

                <Input
                    label="Password"
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <Input
                    label="Password Confirm"
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="pt-5">


                <PrimaryButton
                    class="w-full relative inline-flex items-center justify-center p-0.5 text-sm font-medium rounded-lg group bg-gradient-to-br from-orange-400 to-orange-500"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
                <div class="mt-4 flex items-center justify-end">
                    <Link
                        :href="route('login')"
                        class="rounded-md text-sm text-orange-600 underline hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Already registered?
                    </Link>
                </div>

            </div>
        </form>
        </div>
    </div>
</template>
