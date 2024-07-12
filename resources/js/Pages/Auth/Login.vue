<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors
            :errors="loginForm.errors"
            class="mb-4"
        />

        <div
            v-if="props.status"
            class="mt-4 font-medium text-sm text-green-600"
        >
            {{ props.status }}
        </div>

        <form
            class="flex flex-col justify-between gap-6"
            @submit.prevent="submit"
        >
            <div class="h-max">
                <div class="h-max">
                    <jet-label
                        for="email"
                        value="Email"
                    />
                    <jet-input
                        id="email"
                        v-model="loginForm.email"
                        autofocus
                        class="mt-1 block w-full"
                        required
                        type="email"
                    />
                </div>

                <div class="mt-4">
                    <jet-label
                        for="password"
                        value="Password"
                    />
                    <jet-input
                        id="password"
                        v-model="loginForm.password"
                        autocomplete="current-password"
                        class="mt-1 block w-full"
                        required
                        type="password"
                    />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <jet-checkbox
                            v-model="loginForm.remember"
                            :checked="loginForm.remember"
                            name="remember"
                        />
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>
            </div>

            <div
                class="flex-none w-full flex flex-col items-center justify-between gap-4"
            >
                <JetButton
                    :class="{ 'opacity-25': loginForm.processing || !fieldIsFilled }"
                    :disabled="loginForm.processing || !fieldIsFilled"
                    class="grow w-full"
                    variety="success"
                >
                    Log in with Email
                </JetButton>
                <div
                    class="w-full flex items-end justify-between underline text-sm text-gray-600 hover:text-gray-900"
                >
                    <Link
                        :href="route('register')"
                        class="flex-none"
                    >
                        Don't have an account?
                    </Link>
                    <Link
                        v-if="props.canResetPassword"
                        :href="route('password.request')"
                        class="flex-none"
                    >
                        Forgot password?
                    </Link>
                </div>
                <span class="border-t border-solid border-gray-200 w-full mt-2 pt-2 text-center">OR</span>
                <a
                    :href="route('auth.google')"
                    class="grow w-full mb-2"
                >
                    <JetButton
                        class="w-full"
                        type="button"
                        variety="secondary"
                    >
                        <div
                            class="w-full flex justify-center items-center gap-4"
                        >
                            <img
                                alt="Google Logo"
                                class="h-8 inline"
                                src="/images/third-party-logos/google-logo.png"
                            > Log in with Google
                        </div>
                    </JetButton>
                </a>
                <a
                    :href="route('auth.outlook')"
                    class="grow w-full"
                >
                    <JetButton
                        class="w-full"
                        type="button"
                        variety="secondary"
                    >
                        <div
                            class="w-full inline-flex justify-center items-center gap-4"
                        >
                            <img
                                alt="Microsoft Logo"
                                class="h-8 inline"
                                src="/images/third-party-logos/microsoft-logo.png"
                            > Log in with Microsoft
                        </div>
                    </JetButton>
                </a>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script setup>
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {computed} from "vue";
import {route} from 'ziggy-js';

import JetAuthenticationCard from '@/Components/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import JetButton from "@/Components/Button.vue";
import JetCheckbox from '@/Components/Checkbox.vue';
import JetInput from '@/Components/TextInput.vue';
import JetLabel from '@/Components/InputLabel.vue';
import JetValidationErrors from '@/Components/ValidationErrors.vue';

const props = withDefaults(defineProps(), {
    canResetPassword: false,
    status: undefined,
});

const loginForm = useForm({
    email: '',
    password: '',
    remember: false,
});

const fieldIsFilled = computed(() => loginForm.email && loginForm.password);

const readmeDocsRoute = (routeString, params) => {
    const urlParams = new URLSearchParams(window.location.search);
    const readmeDocs = !!(Number(urlParams.get('readme_docs')) ?? 0);
    const redirectParam = urlParams.get('redirect');

    if (readmeDocs) {
        if (redirectParam) {
            return route(routeString, {
                readme_docs: 1,
                redirect: redirectParam,
                ...params
            });
        }
        return route(routeString, {
            readme_docs: 1,
            ...params
        });
    }

    return undefined;
};
const getOAuthRoute = (driver) => {
    return readmeDocsRoute('redirectToGoogle', {driver: driver}) ?? route('redirectToGoogle', {driver: driver});
};
const submit = () => {
    const loginRoute = readmeDocsRoute('readme.login') ?? route('login');

    loginForm
        /*.transform(data => ({
            ...data,
            remember: loginForm.remember ? 'on' : '',
        }))*/
        .post(loginRoute, {
            onFinish: () => loginForm.reset('password'),
        });
};

</script>
