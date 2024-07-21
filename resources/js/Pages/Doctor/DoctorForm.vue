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
import SelectInput from "@/Components/SelectInput.vue";
const props = defineProps({
    doctor: {
        type: Object,
        require: true,
    },
    doctorTypes: {
        type: Object,
        require: true,
    },
    daysOfWeek: {
        type: Object,
        require: true,
    },
})
const form = useForm(props?.doctor?.data?.id ? "put" : "post", props?.doctor?.data?.id ? route("doctor.update", {doctor: props?.doctor?.data?.id}) : route("doctor.store"), {
    name: props?.doctor?.data?.name ?? '',
    phone_number: props?.doctor?.data?.phone_number ?? '',
    available_days: props?.doctor?.data?.available_days?.map(value => ({id: value, name: value})) ?? '',
    doctor_type: props?.doctor?.data?.doctor_type ?? '',
});
const nameWithLabel = ({id, name}) => {
    return `${name}`
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <AuthenticatedLayout :title="doctor?.data?.id ? 'Update Doctor' : 'Add Doctor'">
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-x-3">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                            {{ doctor?.data?.id ? 'Update Doctor' : 'Add Doctor' }}</h2>
                    </div>
                </div>

                <div class="flex items-center gap-x-3">
                    <LinkPrimaryButton :route-name="route('doctor.index')">
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
                                    <InputLabel :is-require="true" for="name" value="Name"/>

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
                                    <InputLabel :is-require="true" for="phone_number" value="Phone Number"/>

                                    <TextInput
                                        id="name"
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
                                    <InputLabel :is-require="true" for="doctor_type" value="Doctor Type" class="mb-2"/>

                                    <SelectInput v-model="form.doctor_type" :options="doctorTypes" class="w-full cursor-pointer"/>

                                    <InputError :message="form.errors.doctor_type" class="mt-2"/>
                                </div>
                                <div class="mb-2">
                                    <InputLabel :is-require="true" class="mb-2" for="available_days" value="Available Days"/>
                                    <VueMultiselect
                                        v-model="form.available_days"
                                        :custom-label="nameWithLabel"
                                        :multiple="true"
                                        :options="daysOfWeek"
                                        label="name"
                                        placeholder="Select Days"
                                        track-by="name"
                                    >
                                    </VueMultiselect>
                                    <InputError :message="form.errors.available_days" class="mt-2"/>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mt-4">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    <spinner v-if="form.processing"/>
                                    {{
                                        form.processing ? "Please Wait.." : doctor?.data?.id ? "Update Doctor" : "Add Doctor"
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
