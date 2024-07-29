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
import CurrencySymbol from "@/Components/CurrencySymbol.vue";

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({}),
    },
    invoices: {
        type: Object,
        required: true,
    },
})
let search = ref(props.filters?.search);
watch(search, (value) => {
    router.get(route('regular-invoice.index'), {search: value}, {
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
    <AuthenticatedLayout title="Invoice Management">
        <template #header>
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div>
                    <div class="flex items-center">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Invoice Management</h2>
                    </div>
                </div>
                <TextInput
                    v-model="search"
                    class="block py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-5 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                    placeholder="Search"
                    type="text"/>
                <div class="flex items-center gap-2">
                    <LinkPrimaryButton :route-name="route('regular-invoice.create')">
                        <AkPlus/>&nbsp;New Invoice
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
                        <TableHeadCell>Test Fees</TableHeadCell>
                        <TableHeadCell> Invoice Amount</TableHeadCell>
                    </TableHead>
                    <TableBody>
                        <template v-if="invoices?.data?.length">
                            <TableRow v-for="(item,key) in invoices.data" :key="item.id">
                                <TableCell> {{ key + 1 }}</TableCell>
                                <TableCell class="whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="cursor-pointer flex items-center"
                                             title="click to copy appointment id"
                                             @click="copyText(item?.invoice_number)">
                                            <span>{{ item.invoice_number }}</span>
                                            <AkCopy class="ml-2"/>
                                        </div>
                                        <a
                                            v-if="item?.invoice_file"
                                            :href="item?.invoice_file"
                                            class="flex items-center text-blue-600 hover:text-blue-800 transition-all duration-200 ease-in-out justify-center"
                                            target="_blank"
                                        >
                                            <BxSolidDownload class="ml-2"/>
                                        </a>
                                    </div>

                                </TableCell>
                                <TableCell class="whitespace-nowrap"><CurrencySymbol/>{{ item.clinical_test_amount }}</TableCell>
                                <TableCell class="whitespace-nowrap"><CurrencySymbol/>{{ item.invoice_amount }}</TableCell>
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
            <Pagination :links="invoices.meta"/>
        </div>
    </AuthenticatedLayout>
</template>
