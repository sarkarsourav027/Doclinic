<script setup>
defineProps({
    value: {
        type: String,
    },
    isRequire: {
        type: Boolean,
    },
});
</script>

<template>
    <label class="block font-medium text-sm text-gray-700">
        <span v-if="value">{{ value }}<span v-if="isRequire" class="text-red-500 ms-1">*</span></span>
        <span v-else><slot /></span>
    </label>
</template>
