<script setup>
import {computed, defineProps} from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    links: Object
})

const currentPage = props.links.current_page;
const lastPage = props.links.last_page;
const paginationLinks = computed(()=>props.links.links);
const prevPageUrl = paginationLinks.value.find(link => link.label === 'Previous')?.url;
const nextPageUrl = paginationLinks.value.find(link => link.label === 'Next')?.url;
</script>

<template>
    <div v-if="paginationLinks.length > 3" class="mt-6 flex flex-wrap items-center justify-between">
        <div class="text-gray-500 dark:text-gray-400 mb-2">
            <p class="font-medium text-gray-700 dark:text-gray-100">
                Page <span>{{ currentPage }}</span> of <span>{{ lastPage }}</span>
            </p>
        </div>
        <div class="overflow-x-auto py-2">
          <div class="inline-flex rounded-md shadow whitespace-nowrap">
            <Link
                v-if="prevPageUrl"
                :href="prevPageUrl"
                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
            >
                Previous
            </Link>
            <template v-for="(link,index) in paginationLinks" :key="index" class="">
                <div v-if="!link.url"
                     :class="['px-4 py-2 text-sm font-medium border', link.active ? 'bg-blue-700 text-white border-blue-700 dark:bg-blue-500 dark:text-white dark:border-blue-500' : 'text-gray-900 bg-white border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white']"
                     v-html="link.label"/>
                <Link v-else

                             :class="['px-4 py-2 text-sm font-medium border', link.active ? 'bg-blue-700 text-white border-blue-700 dark:bg-blue-500 dark:text-white dark:border-blue-500' : 'text-gray-900 bg-white border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white']"
                             :href="link.url"
                             v-html="link.label"/>
            </template>
            <Link
                v-if="nextPageUrl"
                :href="nextPageUrl"
                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
            >
                Next
            </Link>
        </div>
        </div>
    </div>
</template>
