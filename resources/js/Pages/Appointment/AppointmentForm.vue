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
import VueMultiselect from 'vue-multiselect'
const props = defineProps({
    appointment: {
        type: Object,
        require: true,
    },
    doctors: {
        type: Object,
        require: true,
    },
})
const form = useForm(props?.appointment?.data?.id ? "put" : "post", props?.appointment?.data?.id ? route("appointment.update", {appointment: props?.appointment?.data?.id}) : route("appointment.store"), {
    name: props?.appointment?.data?.patient?.name ?? '',
    phone_number: props?.appointment?.data?.patient?.phone_number ?? '',
    doctor_id: props?.appointment?.data?.doctor ?? '',
    appointment_date: props?.appointment?.data?.appointment_date ?? '',
});
const nameWithLabel = ({id, name}) => {
    return `${name}`
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <AuthenticatedLayout :title="appointment?.data?.id ? 'Update Appointment' : 'Add Appointment'">
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-x-3">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                            {{ appointment?.data?.id ? 'Update Appointment' : 'Add Appointment' }}</h2>
                    </div>
                </div>

                <div class="flex items-center gap-x-3">
                    <LinkPrimaryButton :route-name="route('appointment.index')">
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
                        <form class="mt-2" @submit.prevent="form.submit()">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5 mb-4">
                                <div class="mb-2">
                                    <InputLabel :is-require="true" for="name" value="Patient Name"/>

                                    <TextInput
                                        id="name"
                                        v-model="form.name"
                                        autocomplete="name"
                                        autofocus
                                        class="mt-1 block w-full"
                                        type="text"
                                    />

                                    <InputError :message="form.errors.name" class="mt-2"/>
                                </div>
                                <div class="mb-2">
                                    <InputLabel :is-require="true" for="phone_number" value="Patient Phone Number"/>

                                    <TextInput
                                        id="phone_number"
                                        v-model="form.phone_number"
                                        autocomplete="phone_number"
                                        autofocus
                                        class="mt-1 block w-full"
                                        type="text"
                                    />

                                    <InputError :message="form.errors.phone_number" class="mt-2"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5 mb-4">
                                <div class="mb-2">
                                    <InputLabel :is-require="true" class="mb-2" for="doctor_id" value="Appointment"/>
                                    <VueMultiselect
                                        v-model="form.doctor_id"
                                        :custom-label="nameWithLabel"
                                        :multiple="false"
                                        :options="doctors"
                                        label="name"
                                        placeholder="Select Appointment"
                                        track-by="name"
                                    >
                                    </VueMultiselect>
                                    <InputError :message="form.errors.doctor_id" class="mt-2"/>
                                </div>
                                <div class="mb-2">
                                    <InputLabel :is-require="true" for="appointment_date" value="Appointment Date" class="mb-2"/>

                                    <TextInput
                                        id="appointment_date"
                                        v-model="form.appointment_date"
                                        autocomplete="appointment_date"
                                        autofocus
                                        class="mt-1 block w-full"
                                        type="date"
                                    />

                                    <InputError :message="form.errors.appointment_date" class="mt-2"/>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mt-4">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    <spinner v-if="form.processing"/>
                                    {{
                                        form.processing ? "Please Wait.." : appointment?.data?.id ? "Update Appointment" : "Add Appointment"
                                    }}
                                </PrimaryButton>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
