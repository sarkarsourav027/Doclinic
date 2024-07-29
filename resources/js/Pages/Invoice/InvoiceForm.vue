<script setup>
import {useForm} from 'laravel-precognition-vue-inertia';
import LinkPrimaryButton from "@/Components/Buttons/LinkPrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {BxArrowBack} from "@/utils/icons.js"
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Spinner from "@/Components/Spinner.vue";
import {toast} from "vue3-toastify";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import RadioInput from "@/Components/RadioInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import {ref} from "vue";
import TableHead from "@/Components/Table/TableHead.vue";
import TableHeadCell from "@/Components/Table/TableHeadCell.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableCell from "@/Components/Table/TableCell.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import SelectInput from "@/Components/SelectInput.vue";

const isGstBill = ref(false);
const props = defineProps({
    select_clinical_tests: {type: Object, require: true},
    clinical_tests: {type: Object, require: true},
});

const totalBillingAmount = ref(0);
const clinicalTestTotalAmount = ref(0);
const givenGstPercentage = ref(0);
const gstAmountAfterSelectGst = ref(0);

const form = useForm("post", route("regular-invoice.store"), {
    name: '',
    phone_number: '',
    email: '',
    address: '',
    invoice_date: '',
    payment_mode: '',
    is_gst_bill: false,
    gst_percentage: 0,
    clinical_test_amount: clinicalTestTotalAmount.value ?? 0,
    gst_amount: gstAmountAfterSelectGst.value ?? 0,
    invoice_amount: totalBillingAmount.value ?? 0,
    clinical_test_information: [{test_id: null, amount: null}],
});

const formConfig = {
    replace: true,
    preserveScroll: true,
    onBefore: () => {
        form.clinical_test_amount = clinicalTestTotalAmount.value;
        form.invoice_amount = totalBillingAmount.value;
        form.gst_amount = gstAmountAfterSelectGst.value;
    },
    onSuccess: (page) => {
        form.reset();
        toast("Invoice added successfully.", {type: 'success'});
    }
};
const updateBillingAmounts = () => {
    clinicalTestTotalAmount.value = form.clinical_test_information.reduce((sum, item) => {
        const amount = parseFloat(item.amount);
        return sum + (isNaN(amount) ? 0 : amount);
    }, 0);

    gstAmountAfterSelectGst.value = (clinicalTestTotalAmount.value * givenGstPercentage.value) / 100;
    totalBillingAmount.value = clinicalTestTotalAmount.value + gstAmountAfterSelectGst.value + parseFloat(form.doctor_fees || 0);

    form.clinical_test_amount = clinicalTestTotalAmount.value;
    form.invoice_amount = totalBillingAmount.value;
    form.gst_amount = gstAmountAfterSelectGst.value;
};

const handleGstBillCheck = (e) => {
    isGstBill.value = e;
    if (!e) {
        gstAmountAfterSelectGst.value = 0;
        givenGstPercentage.value = 0;
        form.gst_percentage = 0;
        form.gst_amount = 0;
        updateBillingAmounts();
    }
};

const findSelectedTestById = (id, array) => array.find(item => item.id === parseInt(id)) || null;

const handleSelectClinicalTest = (event, index) => {
    const selectedTest = findSelectedTestById(event, props.clinical_tests.data);
    form.clinical_test_information[index].amount = selectedTest.amount;
    updateBillingAmounts();
};

const addRow = () => {
    form.clinical_test_information.push({test_id: null, amount: null});
    updateBillingAmounts();
};

const removeRow = (index) => {
    form.clinical_test_information.splice(index, 1);
    updateBillingAmounts();
};

const handleChangeGstPercentage = (event) => {
    givenGstPercentage.value = event.target.value;
    updateBillingAmounts();
};

</script>
<template>
    <AuthenticatedLayout title="Add Invoice">
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-x-3">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Add Invoice</h2>
                    </div>
                </div>

                <div class="flex items-center gap-x-3">
                    <LinkPrimaryButton :route-name="route('invoice.index')">
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
                        <form class="mt-2" @submit.prevent="form.submit(formConfig)">
                            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-5 mb-4">
                                <div class="mb-2">
                                    <InputLabel :is-require="true" for="name" value="Patient Name"/>

                                    <TextInput
                                        id="name"
                                        v-model="form.name"
                                        autocomplete="name"
                                        class="mt-1 block w-full"
                                        type="text"
                                    />

                                    <InputError :message="form.errors.name" class="mt-2"/>
                                </div>
                                <div class="mb-2">
                                    <InputLabel :is-require="true" for="phone_number" value="Patient Contact"/>

                                    <TextInput
                                        id="phone_number"
                                        v-model="form.phone_number"
                                        autocomplete="phone_number"
                                        class="mt-1 block w-full"
                                        type="text"
                                    />

                                    <InputError :message="form.errors.phone_number" class="mt-2"/>
                                </div>
                                <div class="mb-2">
                                    <InputLabel :is-require="false" for="email" value="Patient Email"/>

                                    <TextInput
                                        id="email"
                                        v-model="form.email"
                                        autocomplete="email"
                                        autofocus
                                        class="mt-1 block w-full"
                                        type="text"
                                    />

                                    <InputError :message="form.errors.email" class="mt-2"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5 mb-4">
                                <div class="mb-2">
                                    <InputLabel :is-require="false" for="address" value="Patient Address"/>

                                    <TextAreaInput
                                        v-model="form.address"
                                        class="mt-2 block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg placeholder-gray-400 pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                        placeholder="Patient Address"
                                        type="text"/>

                                    <InputError :message="form.errors.address" class="mt-2"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-5 mb-4">
                                <div class="mb-2">
                                    <InputLabel :is-require="true" for="invoice_date" value="Invoice Date"/>

                                    <TextInput
                                        id="invoice_date"
                                        v-model="form.invoice_date"
                                        autocomplete="invoice_date"
                                        autofocus
                                        class="mt-1 block w-full"
                                        type="date"
                                    />

                                    <InputError :message="form.errors.invoice_date" class="mt-2"/>
                                </div>
                                <div class="mb-2">
                                    <InputLabel :is-require="true" for="payment_mode" value="Payment Mode"/>

                                    <div class="flex mt-1 space-x-4">
                                        <RadioInput
                                            v-model="form.payment_mode"
                                            class="cursor-pointer"
                                            name="payment_mode"
                                            value="Cash"/>
                                        <RadioInput
                                            v-model="form.payment_mode"
                                            class="cursor-pointer"
                                            name="payment_mode"
                                            value="Online"/>
                                    </div>

                                    <InputError :message="form.errors.payment_mode" class="mt-2"/>
                                </div>
                                <div class="mb-2">
                                    <InputLabel :is-require="false" for="is_gst_bill" value="GST Invoice"/>
                                    <Checkbox v-model:checked="form.is_gst_bill" class="cursor-pointer"
                                              name="is_gst_bill"
                                              @update:checked="handleGstBillCheck"/>
                                    <InputError :message="form.errors.is_gst_bill" class="mt-2"/>
                                </div>
                                <div v-if="isGstBill" class="mb-2">
                                    <InputLabel :is-require="true" for="gst_percentage" value="GST Percentage"/>

                                    <TextInput
                                        id="gst_percentage"
                                        v-model="form.gst_percentage"
                                        autocomplete="gst_percentage"
                                        autofocus
                                        class="mt-1 block w-full"
                                        type="text"
                                        @input="(e) => handleChangeGstPercentage(e)"
                                    />

                                    <InputError :message="form.errors.gst_percentage" class="mt-2"/>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full md:w-1/1 px-3 mb-6 md:mb-0">
                                    <div class="flex justify-between">
                                        <label class="block tracking-wide text-gray-700 text-sm font-bold mb-2">Service
                                            Information</label>
                                        <button
                                            class="items-center whitespace-nowrap px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                            type="button"
                                            @click="addRow"
                                        >Add Row
                                        </button>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <Table class="w-full border mt-2" hoverable striped
                                               striped-columns>
                                            <TableHead class="border-b bg-gray-200">
                                                <TableHeadCell>Clinical Test</TableHeadCell>
                                                <TableHeadCell>Amount</TableHeadCell>
                                                <TableHeadCell>Action</TableHeadCell>
                                            </TableHead>
                                            <TableBody>
                                                <TableRow
                                                    v-for="(row, index) in form.clinical_test_information"
                                                    :key="index">
                                                    <TableCell>
                                                        <SelectInput
                                                            v-model="form.clinical_test_information[index].test_id"
                                                            :options="select_clinical_tests" class="w-full"
                                                            @update:model-value="event => handleSelectClinicalTest(event, index)"/>
                                                        <InputError
                                                            :message="form.errors[`clinical_test_information.${index}.test_id`]"
                                                            class="mt-2"
                                                        />
                                                    </TableCell>
                                                    <TableCell>
                                                        <TextInput
                                                            v-model="form.clinical_test_information[index].amount"
                                                            class="mt-1 block w-full"
                                                            readonly
                                                            type="text"
                                                        />
                                                        <InputError
                                                            :message="form.errors[`clinical_test_information.${index}.amount`]"
                                                            class="mt-2"
                                                        />
                                                    </TableCell>
                                                    <TableCell
                                                        class="text-right w-2">
                                                        <DangerButton
                                                            v-if="form.clinical_test_information.length > 1"
                                                            type="button"
                                                            @click="removeRow(index)"
                                                        >Remove
                                                        </DangerButton>
                                                    </TableCell>
                                                </TableRow>
                                            </TableBody>
                                        </Table>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-4 mt-4">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    <spinner v-if="form.processing"/>
                                    {{
                                        form.processing ? "Please Wait.." : "Add Invoice"
                                    }}
                                </PrimaryButton>
                                <div class="text-right font-bold">
                                    Total Amount: ₹ {{ parseFloat(totalBillingAmount).toFixed(2) }}
                                </div>
                            </div>

                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
