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

const props = defineProps({
    clinicalTest: {
        type: Object,
        require: true,
    },
})
const form = useForm(props?.clinicalTest?.data?.id ? "put" : "post", props?.clinicalTest?.data?.id ? route("clinical-test.update", {clinical_test: props?.clinicalTest?.data?.id}) : route("clinical-test.store"), {
    name: props?.clinicalTest?.data?.name ?? '',
    amount: props?.clinicalTest?.data?.amount ?? '',
});
</script>

<template>
    <AuthenticatedLayout :title="clinicalTest?.data?.id ? 'Update Clinical Test' : 'Add Clinical Test'">
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-x-3">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                            {{ clinicalTest?.data?.id ? 'Update Clinical Test' : 'Add Clinical Test' }}</h2>
                    </div>
                </div>

                <div class="flex items-center gap-x-3">
                    <LinkPrimaryButton :route-name="route('clinical-test.index')">
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
                            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-5 mb-3">
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
                                    <InputLabel :is-require="true" for="amount" value="Amount"/>

                                    <TextInput
                                        id="amount"
                                        v-model="form.amount"
                                        autocomplete="amount"
                                        autofocus
                                        class="mt-1 block w-full"
                                        type="text"
                                    />

                                    <InputError :message="form.errors.amount" class="mt-2"/>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mt-4">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    <spinner v-if="form.processing"/>
                                    {{
                                        form.processing ? "Please Wait.." : clinicalTest?.data?.id ? "Update Clinical Test" : "Add Clinical Test"
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
