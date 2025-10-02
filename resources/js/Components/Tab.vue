<template>
  <div class="min-h-screen w-full max-w-2xl mx-auto mt-3 mr-3">
    <!-- Tabs Header -->
    <div class="flex flex-wrap  font-medium">
      <button
          v-for="(tab, index) in tabs"
          :key="index"
          @click="activeTab = index"
          class="flex items-center">
    <span
        :class="[
        'px-4 sm:px-6 lg:px-10 py-2 mb-px  text-2xl font-medium ',
        activeTab === index
          ? 'border-b-2 border-orange-500 text-orange-600'
          : 'text-gray-500 hover:text-white'
      ]">
      {{ tab.name }}
    </span>
        <span
            v-if="index == 0"
            class="px-4 text-white text-lg hidden md:inline-block"
        >
      OR
    </span>
      </button>
    </div>
    <!-- Tabs Content -->
    <div class="w-full max-w-3xl mx-auto mt-3 mr-3">
      <div v-if="activeTab === 0">
        <Login/>
      </div>
      <div v-if="activeTab === 1">
        <SignUp/>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'


import Login from '@/Components/Login.vue';
import SignUp from '@/Pages/Auth/Register.vue';
const tabs = [
  {name: 'SIGN IN ', content: ''},
  {name: 'SIGN UP', content: ''}
]
const activeTab = ref(0)
</script>
