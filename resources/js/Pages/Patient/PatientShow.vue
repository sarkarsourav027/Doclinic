<script setup>
import {AkCopy, BxArrowBack, BxSolidDownload} from "@/utils/icons";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LinkPrimaryButton from "@/Components/Buttons/LinkPrimaryButton.vue";
import moment from "moment/moment.js";
import LinkWarningButton from "@/Components/Buttons/LinkWarningButton.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableHeadCell from "@/Components/Table/TableHeadCell.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TableCell from "@/Components/Table/TableCell.vue";
import Badge from "@/Components/Badge/Badge.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import {ClNoteEdit} from "@/utils/icons.js";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    patient: {
        type: Object,
        required: true,
    },
    appointments: {
        type: Object,
        required: true,
    },
})
console.log('props',props.appointments)
</script>

<template>
    <AuthenticatedLayout title="Patient Details">
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-x-3">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Patient Details</h2>
                    </div>
                </div>

                <div class="flex items-center gap-x-3">
                    <LinkPrimaryButton :route-name="route('patient.index')">
                        <BxArrowBack/>&nbsp;Back
                    </LinkPrimaryButton>
                </div>
            </div>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto space-y-6">
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                >
                    <section>
                        <div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 items-center">
                                <div
                                    class="mb-4 text-center bg-gray-300 p-2 rounded-sm h-full flex flex-col justify-center">
                                    <h4 class="font-bold text-sm mb-2 capitalize">Patient Id</h4>
                                    <p class="text-sm text-gray-500 uppercase mb-2">
                                        {{ patient?.data?.patient_id }}
                                    </p>
                                </div>
                                <div
                                    class="mb-4 text-center bg-gray-300 p-2 rounded-sm h-full flex flex-col justify-center">
                                    <h4 class="font-bold text-sm mb-2 capitalize">Name</h4>
                                    <p class="text-sm text-gray-500 uppercase">
                                        {{ patient?.data?.name }}
                                    </p>
                                </div>
                                <div
                                    class="mb-4 text-center bg-gray-300 p-2 rounded-sm h-full flex flex-col justify-center">
                                    <h4 class="font-bold text-sm mb-2 capitalize">Contact</h4>
                                    <p class="text-sm text-gray-500 uppercase">
                                        {{ patient?.data?.phone_number }}
                                    </p>
                                </div>
                                <div
                                    class="mb-4 text-center bg-gray-300 p-2 rounded-sm h-full flex flex-col justify-center">
                                    <h4 class="font-bold text-sm mb-2 capitalize">Joined</h4>
                                    <p class="text-sm text-gray-500 uppercase">
                                        {{ moment(patient?.data?.created_at).format('DD MMM YYYY hh:mm A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div

                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                >
                    <section>
                        <div>
                            <div class="grid grid-cols-1 lg:grid-cols-1 gap-5">
                                <div class="overflow-x-auto">
                                <div class="mb-4">
                                    <h2 class="font-bold text-lg mb-2 capitalize">Appointments</h2>
                                    <Table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" hoverable striped
                                           striped-columns>
                                        <TableHead class="whitespace-nowrap">
                                            <TableHeadCell> #</TableHeadCell>
                                            <TableHeadCell> Appointment Id</TableHeadCell>
                                            <TableHeadCell> Doctor</TableHeadCell>
                                            <TableHeadCell> Appointment</TableHeadCell>
                                            <TableHeadCell> Clinical Test</TableHeadCell>
                                            <TableHeadCell> Action</TableHeadCell>
                                        </TableHead>
                                        <TableBody>
                                            <template v-if="appointments?.data?.length">
                                                <TableRow v-for="(item,key) in appointments.data" :key="item.id">
                                                    <TableCell> {{ key + 1 }}</TableCell>
                                                    <TableCell class="whitespace-nowrap">
                                                        <div class="flex items-center cursor-pointer"
                                                             title="click to copy appointments id" @click="copyText(item?.appointment_id)">
                                                            <span>{{ item.appointment_id }}</span>
                                                            <AkCopy class="ml-2"/>
                                                        </div>
                                                    </TableCell>
                                                    <TableCell class="whitespace-nowrap">
                                                        <div class="flex gap-1">
                                                              <span class="flex flex-wrap items-center gap-2 w-10">
                                                                <img
                                                                    :src="item?.doctor?.avatar && item?.doctor?.avatar !== '' ? item?.doctor?.avatar  : `https://ui-avatars.com/api/?name=${(item?.doctor?.name ?? 'John')}`"
                                                                    alt="Doctor Image" class="w-8 rounded-full">
                                                              </span>
                                                                                <span class="text-left">
                                                                <p class="text-black">{{ item?.doctor?.name }}</p>
                                                                <p class="text-black">{{ item?.doctor?.phone_number }}</p>
                                                                <p class="text-amber-400 uppercase">{{ item?.doctor?.doctor_type }}</p>
                                                          </span>
                                                        </div>
                                                    </TableCell>
                                                    <TableCell class="whitespace-nowrap">
                                                        {{ moment(item?.appointment_date).format('DD MMM YYYY') }}
                                                    </TableCell>
                                                    <TableCell>
                                                        <span v-if="item?.clinical_test?.length">
                                                            <span v-for="test in item.clinical_test" :key="test.id">
                                                                <Badge class="bg-fuchsia-700">
                                                                    {{ test.name }}
                                                                </Badge>
                                                            </span>
                                                        </span>
                                                        <span v-else>NA</span>
                                                    </TableCell>
                                                    <TableCell class="flex justify-center items-center gap-2 px-4 py-1">
                                                        <LinkWarningButton
                                                            :route-name="route('appointment.edit',{ appointment: item.id })">
                                                            <ClNoteEdit/>&nbsp;Edit
                                                        </LinkWarningButton>
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
                                <Pagination :links="appointments.meta"/>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
