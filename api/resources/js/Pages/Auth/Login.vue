<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const rules = {
    email: [
        value => !!value || 'メールアドレスは必須項目です。',
    ],
    password: [
        value => !!value || 'パスワードは必須項目です。',
    ],
}

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <v-sheet class="ma-4 py-6">
            <v-form @submit.prevent="submit">
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="form.email"
                            label="メールアドレス"
                            variant="outlined"
                            :rules="rules.email"
                            :error-messages="form.errors.email"
                            required
                            >
                        </v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="form.password"
                            label="パスワード"
                            :rules="rules.password"
                            :error-messages="form.errors.password"
                            type="password"
                            required
                            variant="outlined"
                            >
                        </v-text-field>
                    </v-col>
                </v-row>
                <Link
                    :href="route('register')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    まだアカウントをお持ちでない方はこちら
                </Link>
                <v-btn
                    color="pink-lighten-5"
                    type="submit"
                    class="mt-12"
                    block
                    >ログイン
                </v-btn>
            </v-form>
        </v-sheet>
    </GuestLayout>
</template>
