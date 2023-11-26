<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/Admin/AuthenticatedShopDetailLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import flashMessage from '@/Utils/flashMessage';

const props = defineProps({
    routeParams: {
        type: Object,
        required: true,
    },
});
const shopId = props.routeParams.parameters.shop;

const rules = {
    name: [
        value => !!value || 'メニュー名は必須項目です。',
    ],
    price: [
        value => !!value || '価格は必須項目です。',
    ],
}
const form = useForm({
    name: '',
    price: '',
});

const submit = () => {
    form.post(route('admin.menus.store', {'shop': shopId}), {
        onSuccess: () => {
            flashMessage('メニューを作成しました。', 'success')
        },
        onError: (e) => {
            flashMessage('作成に失敗しました。再度お試しください。', 'error')
        },
    });
};
</script>

<template>
    <Head title="メニュー作成" />

    <AuthenticatedShopDetailLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">メニュー作成</h2>
        </template>
            <v-sheet class="ma-4 py-6">
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>メニュー名</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-text-field
                                v-model="form.name"
                                label="メニュー名"
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
                            <v-list-subheader>価格</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-text-field
                                v-model="form.price"
                                label="価格"
                                :rules="rules.price"
                                :error-messages="form.errors.price"
                                required
                                variant="outlined"
                                >
                            </v-text-field>
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
    </AuthenticatedShopDetailLayout>
</template>
