<script setup>

import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ClNoteEdit, AkPlus} from "@/utils/icons.js"
import LinkPrimaryButton from "@/Components/Buttons/LinkPrimaryButton.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import TableHeadCell from "@/Components/Table/TableHeadCell.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableCell from "@/Components/Table/TableCell.vue";
import Pagination from "@/Components/Pagination.vue";
import TextInput from "@/Components/TextInput.vue";
import moment from "moment"
const props = defineProps({
    filters: {
        type: Object,
        default: () => ({}),
    },
    accounts: {
        type: Object,
        required: true,
    },
})
let search = ref(props.filters?.search);
watch(search, (value) => {
    router.get(route('account.index'), {search: value}, {
        preserveState: true,
        replace: true,
    });
});
</script>

<template>
    <AuthenticatedLayout title="Account Management">
        <template #header>
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div>
                    <div class="flex items-center">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Account Management</h2>
                    </div>
                </div>
                <TextInput
                    v-model="search"
                    class="block py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-5 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                    placeholder="Search"
                    type="text"/>
                <div class="flex items-center">
                    <LinkPrimaryButton :route-name="route('account.create')">
                        <AkPlus/>&nbsp;Add Account
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
                        <TableHeadCell> Account</TableHeadCell>
                        <TableHeadCell> Designation</TableHeadCell>
                        <TableHeadCell> Joined</TableHeadCell>
                        <TableHeadCell> Action</TableHeadCell>
                    </TableHead>
                    <TableBody>
                        <template v-if="accounts?.data?.length">
                            <TableRow v-for="(item,key) in accounts.data" :key="item.id">
                                <TableCell> {{ key + 1 }}</TableCell>
                                <TableCell>
                                    <div class="flex gap-4">
                                          <span class="flex flex-wrap items-center gap-2 w-10">
                                            <img :src="`https://ui-avatars.com/api/?name=${(item?.name ?? 'John')}`"
                                                 alt="Account Image" class="w-8 rounded-full">
                                          </span>
                                        <span class="text-left">
                                            <p class="text-black">{{ item?.name }}</p>
                                            <p class="text-black">{{ item?.email }}</p>
                                            <p class="text-black">{{ item?.phone_number }}</p>
                                      </span>
                                    </div>
                                </TableCell>
                                <TableCell class="whitespace-nowrap">{{item?.designation}}</TableCell>
                                <TableCell>
                                    {{ moment(item?.created_at).format('DD MMM YYYY hh:mm A') }}
                                </TableCell>
                                <TableCell class="flex justify-center items-center gap-2 px-4 py-1">
                                    <LinkPrimaryButton
                                        :route-name="route('account.edit',{ account: item.id })">
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
            <Pagination :links="accounts.meta"/>
        </div>
    </AuthenticatedLayout>
</template>
