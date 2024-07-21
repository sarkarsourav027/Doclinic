<script setup>
import {Link} from "@inertiajs/vue3"
import {defineProps} from 'vue';

defineProps({
    routeName: {
        type: String,
    },
});
</script>
<template>
    <Link
        :href="routeName"
        class="shadow hover:shadow-lg transition-shadow duration-300 inline-flex hover:bg-yellow-600 items-center px-4 py-2 bg-yellow-500 text-white dark:bg-yellow-500 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs dark:text-gray-300 uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 ease-in-out"
    >
        <slot />
    </Link>
</template>
