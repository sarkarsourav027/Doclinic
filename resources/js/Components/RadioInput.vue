<script setup>
import {ref} from 'vue';

// Define the props with type
const props = defineProps({
    modelValue: {
        type: String,
        required: true
    },
    value: {
        type: String,
        required: true
    },
    name: {
        type: String,
        required: true
    }
});

// Define the emits with type
const emit = defineEmits(['update:modelValue']);

// Define a ref for the radio input element
const input = ref(null);

// Expose the focus method
defineExpose({
    focus: () => {
        if (input.value) {
            input.value.focus();
        }
    },
});

// Function to handle the change event
const onChange = (event) => {
    const target = event.target;
    if (target) {
        emit('update:modelValue', target.value);
    }
};
</script>

<template>
    <label class="inline-flex items-center">
        <input
            ref="input"
            type="radio"
            :name="name"
            :value="value.toLocaleLowerCase()"
            :checked="modelValue === value"
            class="form-radio cursor-pointer"
            @change="onChange"
        />
        <span class="ml-2">{{ value }}</span>
    </label>
</template>
