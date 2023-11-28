<script setup>
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import flashMessage from '@/Utils/flashMessage';

const rules = {
    name: [
        value => !!value || '店舗名は必須項目です。',
    ],
    address: [
        value => !!value || '住所は必須項目です。',
    ],
    tel: [
        value => !!value || '電話番号は必須項目です。',
    ],
    email: [
        value => !!value || 'メールアドレスは必須項目です。',
        value => {
            const pattern =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || '正しい形式で入力してください。'
        }
    ],
    description: [
        value => !!value || '店舗説明は必須項目です。',
    ],
}
const form = useForm({
    name: '',
    address: '',
    tel: '',
    email: '',
    description: '',
});

const submit = () => {
    form.post(route('admin.shops.store'), {
        onSuccess: () => {
            flashMessage('店舗を作成しました。', 'success')
        },
        onError: (e) => {
            flashMessage('作成に失敗しました。再度お試しください。', 'error')
        },
    });
};
</script>

<template>
    <Head title="店舗作成" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">店舗作成</h2>
        </template>
            <v-sheet class="ma-4 py-6">
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>店舗名</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-text-field
                                v-model="form.name"
                                label="店舗名"
                                :rules="rules.name"
                                :error-messages="form.errors.name"
                                variant="outlined"
                                required
                                >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>住所</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-text-field
                                v-model="form.address"
                                label="住所"
                                :rules="rules.address"
                                :error-messages="form.errors.address"
                                required
                                variant="outlined"
                                >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>電話番号</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-text-field
                                v-model="form.tel"
                                label="電話番号"
                                :rules="rules.tel"
                                :error-messages="form.errors.tel"
                                type="tel"
                                variant="outlined"
                                required
                                >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>メールアドレス</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-text-field
                                v-model="form.email"
                                label="メールアドレス"
                                :rules="rules.email"
                                :error-messages="form.errors.email"
                                type="email"
                                variant="outlined"
                                required
                                >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>店舗説明</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-textarea
                                v-model="form.description"
                                label="店舗説明"
                                :rules="rules.description"
                                :error-messages="form.errors.description"
                                variant="outlined"
                                auto-grow
                                required
                                ></v-textarea>
                        </v-col>
                    </v-row>
                    <v-btn
                        color="pink-lighten-5"
                        type="submit"
                        class="mt-12"
                        block
                        >作成
                    </v-btn>
                </v-form>
            </v-sheet>
    </AuthenticatedLayout>
</template>
