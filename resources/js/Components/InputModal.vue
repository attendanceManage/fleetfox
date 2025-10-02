<template>
    <div class="relative z-0">
        <component
        :is="props.isTextarea ? 'textarea' : 'input'"
        :type="props.isTextarea ? undefined : props.type "
        :id="props.id"
        :rows="props.isTextarea ? props.rows : undefined"
        :placeholder="''"
        :value="props.modelValue"
        @input="$emit('update:modelValue',$event.target.value)"
        class="block w-full px-0 text-blue-950 pt-4 pb-2 bg-transparent border-0 border-b-2 border-gray-700
        appearance-none focus:outline-none focus:ring-0 peer"
        :class="inputBorderClass"
        required
        />
        <label
        :for="props.id"
        class="absolute text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]
        peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
         peer-focus:scale-75 peer-focus:-translate-y-6"
        :class="labelColorClass"
        >
        {{ props.label }}
    </label>
    </div>

    <div class="hidden">
        focus:border-orange-500
        focus:border-orange-500
        focus:border-orange-500
        peer-focus:border-orange-500
        peer-focus:border-orange-500
        peer-focus:border-orange-500
    </div>

  <div class="hidden">
    focus:border-orange-500
    focus:border-orange-500
    focus:border-orange-500
    peer-focus:border-orange-500
    peer-focus:border-orange-500
    peer-focus:border-orange-500
  </div>
</template>
<script setup>
import { computed } from 'vue';

const props=defineProps({
    modelValue:String,
    label:String,
    id:String,
    type:{
        type:String,
        default:'text'
    },
    borderColor:{
        type:String,
        default:'orange'
    },

})

defineEmits(['update:modelValue']);

const inputBorderClass=computed(()=>`focus:border-${props.borderColor}-500`)
const labelColorClass=computed(()=>`peer-focus:text-${props.borderColor}-500`)
</script>
