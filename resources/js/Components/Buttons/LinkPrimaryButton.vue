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
          class="shadow hover:shadow-lg transition-shadow duration-300 inline-flex items-center px-4 py-2 background-primary-t dark:bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-blue-800 uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 ease-in-out whitespace-nowrap"
    >
        <slot />
    </Link>
</template>
