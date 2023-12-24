<script setup>
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { mdiPencil } from '@mdi/js'
import ConfirmModal from '@/Components/ConfirmModal.vue';
import flashMessage from '@/Utils/flashMessage';

const props = defineProps({
    shops: {
        type: Array,
        required: true,
    },
});
const form = useForm({});

const deleteShop = (shopId) => {
    form.delete(route('admin.shops.destroy', {'shop': shopId}), {
        onSuccess: () => {
            flashMessage('店舗を削除しました。', 'success')
        },
        onError: (e) => {
            flashMessage('削除に失敗しました。再度お試しください。', 'error')
        },
    });
};
</script>

<template>
    <Head title="店舗一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">店舗一覧</h2>
        </template>

        <v-card v-for="(shop, index) in props.shops" :key="shop.id" elevation="3" class="mb-3 mx-auto" style="max-width: 600px;">
            <v-toolbar color="pink-lighten-5" flat />
            <v-card-text>
                <v-row>
                    <v-col class="text-right">
                        <v-btn
                            variant="text"
                            :icon="mdiPencil"
                            :href="route('admin.shops.edit', { shop: shop.id })"
                            >
                        </v-btn>
                        <ConfirmModal
                            @delete:model-value="deleteShop(shop.id)"
                            :model-value="'店舗'"
                            />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>店舗名</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ shop.name }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>住所</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ shop.address }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>電話番号</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ shop.tel }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>メールアドレス</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ shop.email }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>店舗説明</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ shop.description }}</div>
                    </v-col>
                </v-row>
                <v-btn
                    :href="route('admin.menus.index', { shop: shop.id })"
                    color="deep-purple-lighten-2"
                    type="submit"
                    class="mt-12"
                    block
                    >メニュー、スタイリストを設定する
                </v-btn>
            </v-card-text>
        </v-card>
    </AuthenticatedLayout>
</template>
