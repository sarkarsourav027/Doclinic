<script setup>

import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {BxSolidDownload, AkPlus, AkCopy} from "@/utils/icons.js"
import LinkPrimaryButton from "@/Components/Buttons/LinkPrimaryButton.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import TableHeadCell from "@/Components/Table/TableHeadCell.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableCell from "@/Components/Table/TableCell.vue";
import Pagination from "@/Components/Pagination.vue";
import TextInput from "@/Components/TextInput.vue";
import Badge from "@/Components/Badge/Badge.vue";
import {toast} from "vue3-toastify";

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({}),
    },
    billings: {
        type: Object,
        required: true,
    },
})
let search = ref(props.filters?.search);
watch(search, (value) => {
    router.get(route('billing.index'), {search: value}, {
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
    <AuthenticatedLayout title="Billing Management">
        <template #header>
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div>
                    <div class="flex items-center">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Billing Management</h2>
                    </div>
                </div>
                <TextInput
                    v-model="search"
                    class="block py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-5 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                    placeholder="Search"
                    type="text"/>
                <div class="flex items-center">
                    <LinkPrimaryButton :route-name="route('billing.create')">
                        <AkPlus/>&nbsp;Add Billing
                    </LinkPrimaryButton>
                </div>
            </div>
        </template>
        <div class="mx-auto mt-6">
            <div class="overflow-x-auto">
                <Table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" hoverable striped
                       striped-columns>
                    <TableHead class="whitespace-nowrap">
                        <TableHeadCell> #</TableHeadCell>
                        <TableHeadCell> Invoice Number</TableHeadCell>
                        <TableHeadCell> Patient</TableHeadCell>
                        <TableHeadCell> Doctor</TableHeadCell>
                        <TableHeadCell>Doctor Fees</TableHeadCell>
                        <TableHeadCell>Clinical Test</TableHeadCell>
                        <TableHeadCell>Test Fees</TableHeadCell>
                        <TableHeadCell>File</TableHeadCell>
                        <TableHeadCell> Billing Amount</TableHeadCell>
                    </TableHead>
                    <TableBody>
                        <template v-if="billings?.data?.length">
                            <TableRow v-for="(item,key) in billings.data" :key="item.id">
                                <TableCell> {{ key + 1 }}</TableCell>
                                <TableCell class="whitespace-nowrap">
                                    <div class="flex items-center cursor-pointer"
                                         title="click to copy appointment id" @click="copyText(item?.invoice_number)">
                                        <span>{{ item.invoice_number }}</span>
                                        <AkCopy class="ml-2"/>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="flex gap-1">
                                          <span class="flex flex-wrap items-center gap-2 w-10">
                                            <img
                                                :src="`https://ui-avatars.com/api/?name=${(item?.appointment?.patient?.name ?? 'John')}`"
                                                alt="Patient Image" class="w-8 rounded-full">
                                          </span>
                                        <span class="text-left whitespace-nowrap">
                                            <p class="text-black">{{ item?.appointment?.patient?.name }}</p>
                                            <p class="text-black">{{ item?.appointment?.patient?.phone_number }}</p>
                                      </span>
                                    </div>
                                </TableCell>
                                <TableCell class="whitespace-nowrap">
                                    <div class="flex gap-1">
                                          <span class="flex flex-wrap items-center gap-2 w-10">
                                            <img
                                                :src="item?.appointment?.doctor?.avatar && item?.appointment?.doctor?.avatar !== '' ? item?.appointment?.doctor?.avatar  : `https://ui-avatars.com/api/?name=${(item?.doctor?.name ?? 'John')}`"
                                                alt="Doctor Image" class="w-8 rounded-full">
                                          </span>
                                        <span class="text-left whitespace-nowrap">
                                            <p class="text-black">{{ item?.appointment?.doctor?.name }}</p>
                                            <p class="text-black">{{ item?.appointment?.doctor?.phone_number }}</p>
                                            <p class="text-amber-400 uppercase">{{
                                                    item?.appointment?.doctor?.doctor_type
                                                }}</p>
                                      </span>
                                    </div>
                                </TableCell>
                                <TableCell class="whitespace-nowrap">{{ item.doctor_fees }}</TableCell>
                                <TableCell>
                                    <span v-if="item?.appointment?.clinical_test?.length">
                                        <span v-for="test in item?.appointment?.clinical_test" :key="test.id">
                                            <Badge class="bg-fuchsia-700 whitespace-nowrap">
                                                {{ test.name }}
                                            </Badge>
                                        </span>
                                    </span>
                                    <span v-else>NA</span>
                                </TableCell>
                                <TableCell class="whitespace-nowrap">{{ item.clinical_test_amount }}</TableCell>
                                <TableCell class="whitespace-nowrap">{{ item.billing_amount }}</TableCell>
                                <TableCell class="whitespace-nowrap">
                                    <a
                                        v-if="item?.invoice_file"
                                        :href="item?.invoice_file"
                                        class="flex items-center text-blue-600 hover:text-blue-800 transition-all duration-200 ease-in-out justify-center"
                                        target="_blank"
                                    >
                                        <BxSolidDownload/>&nbsp;
                                        Download
                                    </a>
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
            <Pagination :links="billings.meta"/>
        </div>
    </AuthenticatedLayout>
</template>
