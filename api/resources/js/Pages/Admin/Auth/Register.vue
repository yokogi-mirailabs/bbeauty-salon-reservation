<script setup>
import GuestLayout from '@/Layouts/Admin/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const rules = {
    name: [
        value => !!value || '名前は必須項目です。',
    ],
    email: [
        value => !!value || 'メールアドレスは必須項目です。',
    ],
    password: [
        value => !!value || 'パスワードは必須項目です。',
    ],
    password_confirmation: [
        value => !!value || 'パスワード確認は必須項目です。',
    ],
}

const submit = () => {
    form.post(route('admin.register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <v-sheet class="ma-4 py-6">
            <v-form @submit.prevent="submit">
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="form.name"
                            label="名前"
                            variant="outlined"
                            :rules="rules.name"
                            :error-messages="form.errors.name"
                            required
                            >
                        </v-text-field>
                    </v-col>
                </v-row>
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
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="form.password_confirmation"
                            label="パスワード確認"
                            :rules="rules.password_confirmation"
                            :error-messages="form.errors.password_confirmation"
                            type="password"
                            required
                            variant="outlined"
                            >
                        </v-text-field>
                    </v-col>
                </v-row>
                <Link
                    :href="route('admin.login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    すでに登録されている方はこちら
                </Link>
                <v-btn
                    color="pink-lighten-5"
                    type="submit"
                    class="mt-12"
                    block
                    >会員登録
                </v-btn>
            </v-form>
        </v-sheet>
    </GuestLayout>
</template>
