<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    IoOutlineFlask,
    CaStethoscope,
    LiWheelchair, BsPlusSquare,
} from "@/utils/icons.js";
</script>

<template>

    <AuthenticatedLayout title="Dashboard">

        <div class="flex flex-wrap">
            <div class="w-full xl:w-1/4 p-4 cursor-pointer">
                <div class="bg-indigo-100 p-4 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <h4 class="text-lg font-semibold mb-2">Clinical Test</h4>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-indigo-500 text-3xl"><IoOutlineFlask/></span>
                        </div>
                        <h2 class="text-4xl font-bold my-0">27</h2>
                    </div>
                </div>
            </div>
            <div class="w-full xl:w-1/4 p-4 cursor-pointer">
                <div class="bg-yellow-100 p-4 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <h4 class="text-lg font-semibold mb-2">Total Doctors</h4>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-yellow-500 text-3xl"><CaStethoscope/></span>
                        </div>
                        <h2 class="text-4xl font-bold my-0">27</h2>
                    </div>
                </div>
            </div>
            <div class="w-full xl:w-1/4 p-4 cursor-pointer">
                <div class="bg-blue-100 p-4 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <h4 class="text-lg font-semibold mb-2">Total Patients</h4>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-blue-500 text-3xl"><LiWheelchair/></span>
                        </div>
                        <h2 class="text-4xl font-bold my-0">67</h2>
                    </div>
                </div>
            </div>
            <div class="w-full xl:w-1/4 p-4 cursor-pointer">
                <div class="bg-green-100 p-4 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <h4 class="text-lg font-semibold mb-2">Today's Appointments</h4>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-green-500 text-3xl">
                                <BsPlusSquare/>
                            </span>
                        </div>
                        <h2 class="text-4xl font-bold my-0">27</h2>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
