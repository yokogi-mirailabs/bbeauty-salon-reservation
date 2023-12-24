<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/AuthenticatedShopDetailLayout.vue';
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
    body: [
        value => !!value || 'レビュー内容は必須項目です。',
    ],
    evaluation: [
        value => !!value || '評価は必須項目です。',
        value => {
            const pattern = /^([1-9]\d*|0)$/
            return pattern.test(value) || '数値を入力してください。'
        },
    ],
}
const form = useForm({
    good_flag: true,
    evaluation: 0,
    body: '',
});

const submit = () => {
    form.post(route('reviews.store', {'shop': shopId}), {
        onSuccess: () => {
            flashMessage('レビューを作成しました。', 'success')
        },
        onError: (e) => {
            flashMessage('作成に失敗しました。入力内容をご確認ください。', 'error')
        },
    });
};
</script>

<template>
    <Head title="レビュー作成" />

    <AuthenticatedShopDetailLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">レビュー作成</h2>
        </template>
            <v-sheet class="ma-4 py-6">
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>良い評価としてレビューを投稿する</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-checkbox
                                v-model="form.good_flag"
                                label="良い評価としてレビューを投稿する"
                                color="pink-lighten-5"
                                hide-details
                            ></v-checkbox>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>評価</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-rating
                                hover
                                :length="5"
                                :size="29"
                                v-model="form.evaluation"
                                active-color="pink-lighten-5"
                                />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>レビュー内容</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-text-field
                                v-model="form.body"
                                label="レビュー内容"
                                :rules="rules.body"
                                :error-messages="form.errors.body"
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
