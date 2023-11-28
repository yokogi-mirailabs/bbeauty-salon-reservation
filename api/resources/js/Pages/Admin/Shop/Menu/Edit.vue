<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/Admin/AuthenticatedShopDetailLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import flashMessage from '@/Utils/flashMessage';

const props = defineProps({
    menu: {
        type: Object,
        required: true,
    },
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
        value => {
            const pattern = /^([1-9]\d*|0)$/
            return pattern.test(value) || '数値を入力してください。'
        },
    ],
}
const form = useForm({
    name: props.menu.name,
    price: props.menu.price,
});

const submit = () => {
    form.put(route('admin.menus.update', {
        'shop': shopId,
        'menu': props.menu.id,
    }), {
        onSuccess: () => {
            flashMessage('メニューを更新しました。', 'success')
        },
        onError: (e) => {
            flashMessage('更新に失敗しました。再度お試しください。', 'error')
        },
    });
};
</script>

<template>
    <Head title="メニュー更新" />

    <AuthenticatedShopDetailLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">店舗更新</h2>
        </template>
            <v-sheet class="ma-4 py-6">
                <Link :href="route('admin.shops.index')">メニュー一覧</Link>
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="2">
                            <v-list-subheader>メニュー名</v-list-subheader>
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
                                v-model="form.price"
                                label="住所"
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
                        >更新
                    </v-btn>
                </v-form>
            </v-sheet>
    </AuthenticatedShopDetailLayout>
</template>
