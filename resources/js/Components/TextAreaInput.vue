<script setup>
import { ref } from 'vue';

// Define the props with type
const props = defineProps({
    modelValue: {
        type: String,
        required: true
    }
});

// Define the emits with type
const emit = defineEmits(['update:modelValue']);

// Define a ref for the textarea element
const input = ref(null);

// Expose the focus method
defineExpose({
    focus: () => {
        if (input.value) {
            input.value.focus();
        }
    },
});

// Function to handle the input event
const onInput = (event) => {
    const target = event.target;
    if (target) {
        emit('update:modelValue', target.value);
    }
};
</script>

<template>
  <textarea
      ref="input"
      :value="modelValue"
      class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
      @input="onInput"
  ></textarea>
</template>
