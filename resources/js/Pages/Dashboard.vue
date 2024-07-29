<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    IoOutlineFlask,
    CaStethoscope,
    LiWheelchair,
    BsPlusSquare,
    ClNoteEdit
} from "@/utils/icons.js";
import TableHead from "@/Components/Table/TableHead.vue";
import TableHeadCell from "@/Components/Table/TableHeadCell.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TableCell from "@/Components/Table/TableCell.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import Pagination from "@/Components/Pagination.vue";
import {ref, watch} from "vue";
import {router, Link} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import LinkPrimaryButton from "@/Components/Buttons/LinkPrimaryButton.vue";

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({}),
    },
    clinical_test_count: {
        type: Number,
        required: true,
    },
    total_doctors: {
        type: Number,
        required: true,
    },
    total_patients: {
        type: Number,
        required: true,
    },
    today_appointment_count: {
        type: Number,
        required: true,
    },
    today_appointment: {
        type: Object,
        required: true,
    },
})
let search = ref(props.filters?.search);
watch(search, (value) => {
    router.get(route('dashboard.index'), {search: value}, {
        preserveState: true,
        replace: true,
    });
});
</script>

<template>

    <AuthenticatedLayout title="Dashboard">

        <div class="flex flex-wrap">
            <Link :href="route('clinical-test.index')" class="w-full xl:w-1/4 p-4 cursor-pointer">
                <div class="background-primary-t p-4 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <h4 class="text-lg font-semibold mb-2">Clinical Test</h4>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-indigo-500 text-3xl"><IoOutlineFlask/></span>
                        </div>
                        <h2 class="text-4xl font-bold my-0">{{ clinical_test_count }}</h2>
                    </div>
                </div>
            </Link>
            <Link :href="route('doctor.index')" class="w-full xl:w-1/4 p-4 cursor-pointer">
                <div class="background-primary-t p-4 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <h4 class="text-lg font-semibold mb-2">Total Doctors</h4>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-yellow-500 text-3xl"><CaStethoscope/></span>
                        </div>
                        <h2 class="text-4xl font-bold my-0">{{ total_doctors }}</h2>
                    </div>
                </div>
            </Link>
            <Link :href="route('patient.index')" class="w-full xl:w-1/4 p-4 cursor-pointer">
                <div class="background-primary-t p-4 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <h4 class="text-lg font-semibold mb-2">Total Patients</h4>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-blue-500 text-3xl"><LiWheelchair/></span>
                        </div>
                        <h2 class="text-4xl font-bold my-0">{{ total_patients }}</h2>
                    </div>
                </div>
            </Link>
            <Link :href="route('appointment.index')" class="w-full xl:w-1/4 p-4 cursor-pointer">
                <div class="background-primary-t     p-4 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <h4 class="text-lg font-semibold mb-2">Today's Appointments</h4>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-green-500 text-3xl">
                                <BsPlusSquare/>
                            </span>
                        </div>
                        <h2 class="text-4xl font-bold my-0">{{ today_appointment_count }}</h2>
                    </div>
                </div>
            </Link>
        </div>
        <div class="bg-white rounded-lg overflow-hidden">
            <div class="bg-white px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                <h4 class="text-lg font-semibold">Today's Appointment</h4>
                <div class="relative">
                    <TextInput v-model="search" placeholder="Search" type="text"/>
                </div>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <Table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" hoverable striped
                           striped-columns>
                        <TableHead class="whitespace-nowrap">
                            <TableHeadCell> #</TableHeadCell>
                            <TableHeadCell> Patient Name</TableHeadCell>
                            <TableHeadCell> Contact</TableHeadCell>
                            <TableHeadCell> Doctor</TableHeadCell>
                            <TableHeadCell> Action</TableHeadCell>
                        </TableHead>
                        <TableBody>
                            <template v-if="today_appointment?.data?.length">
                                <TableRow v-for="(item,key) in today_appointment.data" :key="item.id">
                                    <TableCell> {{ key + 1 }}</TableCell>
                                    <TableCell> {{ item?.patient?.name }}</TableCell>
                                    <TableCell> {{ item.patient?.phone_number }}</TableCell>
                                    <TableCell> {{ item.doctor?.name }}</TableCell>
                                    <TableCell
                                        class="flex justify-center items-center gap-2 px-4 py-1">
                                        <LinkPrimaryButton
                                            :route-name="route('appointment.edit',{ appointment: item.id })">
                                            <ClNoteEdit/>&nbsp;Edit
                                        </LinkPrimaryButton>
                                    </TableCell>
                                </TableRow>
                            </template>
                            <template v-else>
                                <TableRow>
                                    <TableCell class="text-center py-4" colspan="6">
                                        No Data Available
                                    </TableCell>
                                </TableRow>
                            </template>
                        </TableBody>
                    </Table>
                </div>
                <Pagination :links="today_appointment.meta"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
