<script setup>
import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {CaView, AkCopy} from "@/utils/icons.js"
import TableHead from "@/Components/Table/TableHead.vue";
import TableHeadCell from "@/Components/Table/TableHeadCell.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableCell from "@/Components/Table/TableCell.vue";
import Pagination from "@/Components/Pagination.vue";
import TextInput from "@/Components/TextInput.vue";
import moment from "moment"
import {toast} from "vue3-toastify";
import LinkPrimaryButton from "@/Components/Buttons/LinkPrimaryButton.vue";

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({}),
    },
    patient: {
        type: Object,
        required: true,
    },
})
let search = ref(props.filters?.search);
watch(search, (value) => {
    router.get(route('patient.index'), {search: value}, {
        preserveState: true,
        replace: true,
    });
});
const copyText = (link) => {
    const textToCopy = link;

    const textArea = document.createElement("textarea");
    textArea.value = textToCopy;
    document.body.appendChild(textArea);

    textArea.select();
    document.execCommand("copy");
    document.body.removeChild(textArea);

    if (document.queryCommandSupported("copy")) {
        toast(`Text copied to clipboard: ${textToCopy}`, {
            theme: 'colored',
            type: 'success',
        })
    } else {
        toast(`Copying to clipboard is not supported in this browser.`, {
            theme: 'colored',
            type: 'warning',
        })
        console.error("Copying to clipboard is not supported in this browser.");
    }
}
</script>

<template>
    <AuthenticatedLayout title="Patient Management">
        <template #header>
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div>
                    <div class="flex items-center">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Patient Management</h2>
                    </div>
                </div>
                <TextInput
                    v-model="search"
                    class="block py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-5 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                    placeholder="Search"
                    type="text"/>
            </div>
        </template>
        <div class="mx-auto mt-6">
            <div class="overflow-x-auto">
                <Table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" hoverable striped
                       striped-columns>
                    <TableHead class="whitespace-nowrap">
                        <TableHeadCell> #</TableHeadCell>
                        <TableHeadCell> Patient Id</TableHeadCell>
                        <TableHeadCell> Patient</TableHeadCell>
                        <TableHeadCell> Contact</TableHeadCell>
                        <TableHeadCell> Joined</TableHeadCell>
                        <TableHeadCell> Action</TableHeadCell>
                    </TableHead>
                    <TableBody>
                        <template v-if="patient?.data?.length">
                            <TableRow v-for="(item,key) in patient.data" :key="item.id">
                                <TableCell> {{ key + 1 }}</TableCell>
                                <TableCell class="whitespace-nowrap">
                                    <div class="flex items-center cursor-pointer"
                                         title="click to copy appointment id" @click="copyText(item?.patient_id)">
                                        <span>{{ item.patient_id }}</span>
                                        <AkCopy class="ml-2"/>
                                    </div>
                                </TableCell>
                                <TableCell>{{ item?.name }}</TableCell>
                                <TableCell class="whitespace-nowrap">{{ item.phone_number }}</TableCell>
                                <TableCell>
                                    {{ moment(item?.created_at).format('DD MMM YYYY hh:mm A') }}
                                </TableCell>
                                <TableCell class="flex justify-end items-center gap-2 px-4 py-1">
                                    <LinkPrimaryButton
                                        :route-name="route('patient.show',{ patient: item.id })">
                                        <CaView/>&nbsp;View
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
            <Pagination :links="patient.meta"/>
        </div>
    </AuthenticatedLayout>
</template>
