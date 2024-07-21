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
    <Link :href="routeName"
          class="shadow hover:shadow-lg transition-shadow duration-300 inline-flex items-center px-4 py-2 bg-blue-700 dark:bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-blue-800 uppercase tracking-widest hover:bg-blue-800 dark:hover:bg-white focus:bg-blue-800 dark:focus:bg-white active:bg-blue-900 dark:active:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-blue-800 ease-in-out whitespace-nowrap"
    >
        <slot />
    </Link>
</template>
