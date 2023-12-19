<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/Admin/AuthenticatedShopDetailLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { mdiPencil, mdiPlus } from '@mdi/js'
import ConfirmModal from '@/Components/ConfirmModal.vue';
import flashMessage from '@/Utils/flashMessage';
import { onBeforeMount } from 'vue';

const props = defineProps({
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
onBeforeMount(() => {
    sessionStorage.setItem('shopId', shopId);
});
const form = useForm({});

const deleteMenu = (menuId) => {
    form.delete(route('admin.menus.destroy', {
        'shop': shopId,
        'menu': menuId,
    }), {
        onSuccess: () => {
            flashMessage('メニューを削除しました。', 'success')
        },
        onError: (e) => {
            flashMessage('削除に失敗しました。再度お試しください。', 'error')
        },
    });
};
</script>

<template>
    <Head title="メニュー一覧" />

    <AuthenticatedShopDetailLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">メニュー一覧</h2>
        </template>

        <v-card v-for="(menu, index) in props.menus" :key="menu.id" elevation="3" class="mb-3">
            <v-toolbar color="pink-lighten-5" flat />
            <v-card-text>
                <v-row>
                    <v-col class="text-right">
                        <v-btn
                            variant="text"
                            :icon="mdiPlus"
                            :href="route('admin.menus.create', {
                                shop: shopId,
                            })"
                            >
                        </v-btn>
                        <v-btn
                            variant="text"
                            :icon="mdiPencil"
                            :href="route('admin.menus.edit', {
                                shop: shopId,
                                menu: menu.id
                            })"
                            >
                        </v-btn>
                        <ConfirmModal
                            @delete:model-value="deleteMenu(menu.id)"
                            :model-value="'メニュー'"
                            />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>メニュー名</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ menu.name }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>価格</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ menu.price }}</div>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </AuthenticatedShopDetailLayout>
</template>
