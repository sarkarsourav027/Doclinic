<script setup>
import {computed, onUnmounted, ref} from 'vue';
import {Link, usePage,Head} from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import navigation from "@/routes/router";
import {FaAngleDown, FaAngleRight, FaBarsStaggered} from "@/utils/icons";
import {toast} from "vue3-toastify";

const props = defineProps({
    title: String,
});

const routes = computed(() => navigation)


const authUser = usePage().props.auth.user;
const isSidebarOpen = ref(false);

const sideMenu = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
}
const handleResize = () => {
    isSidebarOpen.value = window.innerWidth < 769;
};
window.addEventListener('resize', handleResize);
handleResize();
onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
})
const toggleDropdown = (label) => {
    navigation.forEach(item => {
        if (item.label === label) {
            item.isOpen = !item.isOpen;
        } else {
            item.isOpen = false;
        }
    });
}
</script>

<template>
    <Head :title="title"/>
    <div>
        <aside :class="[ isSidebarOpen ? 'translate-x-[-250px]' : 'w-[250px]']"
               class="h-screen overflow-y-scroll bg-white fixed z-[999] left-0 top-0 shadow transition-all scrollbar-none">
            <div class="sticky bg-white top-0 left-0 py-5 flex items-center justify-center px-5">
                <h2 class="text-center text-xl font-bold">
                    <Link :href="route('dashboard')">
                        <ApplicationLogo/>
                    </Link>
                </h2>
                <button
                    class="w-4 h-4 rounded-full border border-gray-400 p-0.5 flex items-center justify-center lg:hidden xl:hidden"
                    @click="sideMenu">
                    <span class="w-2 h-2 rounded-full block bg-black"></span>
                </button>
            </div>
            <div class="px-2 py-3">
                <ul class="flex flex-col mb-3">
                    <li v-for="link in routes" :key="link.label" class="mb-0.5">
                        <div v-if="link.children">
                            <div class="px-4 py-3 cursor-pointer flex items-center gap-2 font-medium text-sm"
                                 @click="toggleDropdown(link.label)">
                                <component :is="link.icon" class="text-lg"/>
                                {{ link.label }}
                                <FaAngleDown v-if="link.isOpen" class="ml-auto"/>
                                <FaAngleRight v-else class="ml-auto"/>
                            </div>
                            <ul v-if="link.isOpen" class="pl-4">
                                <li v-for="child in link.children" :key="child.label" class="mb-0.5">
                                    <Link
                                        :class="{ 'text-white bg-gray-900': route().current(child.route)}"
                                        :href="route(child.route)"
                                        class="px-4 py-3 hover:text-white hover:bg-gray-900 rounded-md flex items-center gap-2 font-medium text-sm cursor-pointer">
                                        <component :is="child.icon" class="text-lg"/>
                                        {{ child.label }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                        <Link v-else
                              :class="{ 'text-white bg-gray-900': route().current(link.route)}"
                              :href="route(link.route)"
                              class="px-4 py-3 hover:text-white hover:bg-gray-900 rounded-md flex items-center gap-2 font-medium text-sm cursor-pointer"
                              @click="toggleDropdown(link.label)">
                            <component :is="link.icon" class="text-lg"/>
                            {{ link.label }}
                        </Link>
                    </li>
                </ul>
            </div>
        </aside>
        <div
            :class="[ isSidebarOpen ? 'lg:w-[calc(100%-0px)] lg:translate-x-[0px]' : 'lg:w-[calc(100%-250px)] lg:translate-x-[250px]']">
            <header
                class="flex justify-between py-5 px-3 lg:px-8 sticky top-0 left border-b bg-white z-[9999] slide-fade-enter-active transition-all">
                <div class="flex gap-4 items-center">
                    <button @click="sideMenu()">
                        <FaBarsStaggered/>
                    </button>
                </div>
                <div class="">
                    <ul class="flex items-center gap-4 lg:gap-6">
                        <li v-if="authUser" class="relative">
                            <!-- Profile dropdown -->
                            <Dropdown align="right" class="cursor-pointer group" width="48">
                                <template #trigger>
                                    <div
                                        class="flex items-center px-3 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                        type="button">
                                        <img
                                            :src="`https://ui-avatars.com/api/?name=${(authUser?.name ?? 'John')}`"
                                            alt="Profile Image" class="h-8 w-8 rounded-full">
                                        <FaAngleDown class="ms-2 -me-0.5 h-4 w-4"/>
                                    </div>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" as="button" method="post">
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </li>
                    </ul>
                </div>
            </header>
            <section class="bg-gray-100 min-h-screen w-full py-8 px-10 relative slide-fade-enter-active">

                <!-- Page Heading -->
                <div v-if="$slots.header" class="">
                    <slot name="header"/>
                </div>

                <slot></slot>
            </section>
        </div>
    </div>
</template>
