<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/Admin/AuthenticatedShopDetailLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import flashMessage from '@/Utils/flashMessage';
import { STYLIST_POST_TYPE, STYLIST_POST_TYPE_TEXT } from '@/Consts/stylistPostType';

const props = defineProps({
    stylist: {
        type: Object,
        required: true,
    },
    menus: {
        type: Array,
        required: true,
    },
    routeParams: {
        type: Object,
        required: true,
    },
});
const shopId = props.routeParams.parameters.shop;
const postItems = Object.values(STYLIST_POST_TYPE_TEXT);

const rules = {
    name: [
        value => !!value || 'スタイリスト名は必須項目です。',
    ],
    description: [
        value => !!value || 'スタイリスト詳細は必須項目です。',
    ],
    job_post: [
        value => !!value || '役職は必須項目です。',
    ],
    speciality: [
        value => !!value || '得意なものは必須項目です。',
    ],
    working_year: [
        value => !!value || '美容師歴は必須項目です。',
        value => {
            const pattern = /^([1-9]\d*|0)$/
            return pattern.test(value) || '数値を入力してください。'
        },
    ],
    menus: [
        value => !!value || '担当メニューは必須項目です。',
    ],
}
const form = useForm({
    name: props.stylist.name,
    description: props.stylist.description,
    job_post: props.stylist.post,
    speciality: props.stylist.speciality,
    working_year: props.stylist.working_year,
    menus: [props.menus[0].id],
});

const submit = () => {
    form.put(route('admin.stylists.update', {
        'shop': shopId,
        'stylist': props.stylist.id,
    }), {
        onSuccess: () => {
            flashMessage('スタイリストを更新しました。', 'success')
        },
        onError: (e) => {
            flashMessage('更新に失敗しました。再度お試しください。', 'error')
        },
    });
};
</script>

<template>
    <Head title="スタイリスト更新" />

    <AuthenticatedShopDetailLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">スタイリスト更新</h2>
        </template>
            <v-sheet class="ma-4 py-6">
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>スタイリスト名</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-text-field
                                v-model="form.name"
                                label="スタイリスト名"
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
                            <v-list-subheader>スタイリスト詳細</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-textarea
                                v-model="form.description"
                                label="スタイリスト詳細"
                                :rules="rules.description"
                                :error-messages="form.errors.description"
                                variant="outlined"
                                auto-grow
                                required
                                ></v-textarea>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>役職</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-radio-group
                                v-model="form.job_post"
                                inline
                                >
                                <v-radio
                                    v-for="(item, index) in postItems"
                                    :label="item"
                                    :value="index"
                                ></v-radio>
                            </v-radio-group>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>得意なもの</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-text-field
                                v-model="form.speciality"
                                label="得意なもの"
                                :rules="rules.speciality"
                                :error-messages="form.errors.speciality"
                                required
                                variant="outlined"
                                >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>美容師歴</v-list-subheader>
                        </v-col>
                        <v-col cols="10">
                            <v-text-field
                                v-model="form.working_year"
                                label="美容師歴"
                                :rules="rules.working_year"
                                :error-messages="form.errors.working_year"
                                required
                                type="number"
                                variant="outlined"
                                >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row v-if="props.menus.length !== 0">
                    <v-col cols="2">
                        <v-list-subheader>担当メニュー</v-list-subheader>
                    </v-col>
                    <v-col cols="10">
                        <v-select
                            v-model="form.menus"
                            label="担当メニュー"
                            multiple
                            chips
                            item-color="success"
                            :rules="rules.menus"
                            :error-messages="form.errors.menus"
                            :items="props.menus"
                            item-title="name"
                            item-value="id"
                            ></v-select>
                    </v-col>
                </v-row>
                    <v-btn
                        color="pink-lighten-5"
                        type="submit"
                        class="mt-12"
                        block
                        >更新
                    </v-btn>
                </v-form>
            </v-sheet>
    </AuthenticatedShopDetailLayout>
</template>
