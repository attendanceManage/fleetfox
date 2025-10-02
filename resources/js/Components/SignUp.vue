<template>
  <div
      class="py-12 flex  flex items-center ">
    <div class="w-full max-w-lg border border-orange-500 p-10 rounded-3xl">
      <div class="text-center mb-10">
        <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-200 via-orange-500 to-red-500">
          Become A Fleet User
        </h1>
      </div>

      <form class="space-y-6" @submit.prevent="submitForm">

        <Input
            v-model="form.email"
            id="email"
            label="Email"
            type="email"
            borderColor="orange"
        />
        <Input
            v-model="form.name"
            id="name"
            label="Name"
            borderColor="orange"
        />
        <Input
            v-model="form.password"
            id="password"
            label="Password"
            borderColor="orange"
        />
        <Input
            v-model="form.confirm_password"
            id="confirm_password"
            label="Confirm Password"
            borderColor="orange"
        />
        <div class="pt-5">
          <button type="submit"
                  class="w-full relative inline-flex items-center justify-center p-0.5 text-sm font-medium rounded-lg group bg-gradient-to-br from-orange-400 to-orange-500">
            <span
                class="relative w-full px-5 py-3 transition-all ease-in duration-75 rounded-md group-hover:bg-opacity-0 flex items-center justify-center"
                :class="{
                'text-white': !isSubmitting,
                'text-gray-400': isSubmitting,
              }"
            >

              {{ isSubmitting ? "Sign up ..." : "Sign Up" }}
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import {ref} from "vue";
import Input from '@/Components/Input.vue';


const form = ref({
  name: "",
  email: "",
  password: "",
  confirm_password: ""
});


const isSubmitting = ref(false);

const submitForm = async () => {
  isSubmitting.value = true;

  const templateParams = {
    name: form.value.name,
    email: form.value.email,
    subject: form.value.subject,
    message: form.value.message,
  }

}
</script>
