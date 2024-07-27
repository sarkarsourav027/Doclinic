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
import SelectInput from "@/Components/SelectInput.vue";
import {toast} from "vue3-toastify";

const props = defineProps({
    account: {
        type: Object,
        require: true,
    },
    accountDesignation: {
        type: Object,
        require: true,
    },
})
const form = useForm(props?.account?.data?.id ? "put" : "post", props?.account?.data?.id ? route("account.update", {account: props?.account?.data?.id}) : route("account.store"), {
    designation: props?.account?.data?.designation ?? '',
    name: props?.account?.data?.name ?? '',
    email: props?.account?.data?.email ?? '',
    phone_number: props?.account?.data?.phone_number ?? '',
    password: '',
});
const nameWithLabel = ({id, name}) => {
    return `${name}`
}
const formConfig = {
    replace: true,
    preserveScroll: true,
    onSuccess: (page) => {
        form.reset();
        toast(props?.account?.data?.id ? "Account updated successfully." : "Account created successfully.", {
            type: 'success',
        })
    }
}
</script>

<template>
    <AuthenticatedLayout :title="account?.data?.id ? 'Update Account' : 'Add Account'">
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-x-3">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                            {{ account?.data?.id ? 'Update Account' : 'Add Account' }}</h2>
                    </div>
                </div>

                <div class="flex items-center gap-x-3">
                    <LinkPrimaryButton :route-name="route('account.index')">
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
                                    <InputLabel :is-require="true" class="mb-2" for="designation" value="Designation"/>

                                    <SelectInput v-model="form.designation" :options="accountDesignation"
                                                 class="w-full"/>
                                    <InputError :message="form.errors.designation" class="mt-2"/>
                                </div>
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
                                    <InputLabel :is-require="true" for="email" value="Email"/>

                                    <TextInput
                                        id="phone_number"
                                        v-model="form.email"
                                        autocomplete="email"
                                        autofocus
                                        class="mt-1 block w-full"
                                        type="email"
                                    />

                                    <InputError :message="form.errors.email" class="mt-2"/>
                                </div>
                                <div class="mb-2">
                                    <InputLabel :is-require="true" for="phone_number" value="Phone Number"/>

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
                                    <InputLabel :is-require="true" for="password" value="Password"/>

                                    <TextInput
                                        id="password"
                                        v-model="form.password"
                                        autocomplete="phone_number"
                                        autofocus
                                        class="mt-1 block w-full"
                                        type="password"
                                    />

                                    <InputError :message="form.errors.password" class="mt-2"/>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mt-4">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    <spinner v-if="form.processing"/>
                                    {{
                                        form.processing ? "Please Wait.." : account?.data?.id ? "Update Account" : "Add Account"
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
