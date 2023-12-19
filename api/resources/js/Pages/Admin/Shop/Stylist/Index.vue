<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/Admin/AuthenticatedShopDetailLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { mdiPencil, mdiPlus } from '@mdi/js'
import ConfirmModal from '@/Components/ConfirmModal.vue';
import flashMessage from '@/Utils/flashMessage';
import { onBeforeMount } from 'vue';
import { STYLIST_POST_TYPE, STYLIST_POST_TYPE_TEXT } from '@/Consts/stylistPostType';

const props = defineProps({
    stylists: {
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

const deleteStylist = (stylistId) => {
    form.delete(route('admin.stylists.destroy', {
        'shop': shopId,
        'stylist': stylistId,
    }), {
        onSuccess: () => {
            flashMessage('スタイリストを削除しました。', 'success')
        },
        onError: (e) => {
            flashMessage('削除に失敗しました。再度お試しください。', 'error')
        },
    });
};
</script>

<template>
    <Head title="スタイリスト一覧" />

    <AuthenticatedShopDetailLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">スタイリスト一覧</h2>
        </template>

        <v-card v-for="(stylist, index) in props.stylists" :key="stylist.id" elevation="3" class="mb-3">
            <v-toolbar color="pink-lighten-5" flat />
            <v-card-text>
                <v-row>
                    <v-col class="text-right">
                        <v-btn
                            variant="text"
                            :icon="mdiPlus"
                            :href="route('admin.stylists.create', {
                                shop: shopId,
                            })"
                            >
                        </v-btn>
                        <v-btn
                            variant="text"
                            :icon="mdiPencil"
                            :href="route('admin.stylists.edit', {
                                shop: shopId,
                                stylist: stylist.id
                            })"
                            >
                        </v-btn>
                        <ConfirmModal
                            @delete:model-value="deleteStylist(stylist.id)"
                            :model-value="'スタイリスト'"
                            />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>スタイリスト名</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ stylist.name }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>スタイリスト説明</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ stylist.description }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>役職</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ STYLIST_POST_TYPE_TEXT[stylist.job_post] }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>得意なもの</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ stylist.speciality }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>美容師歴</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ stylist.working_year }}年</div>
                    </v-col>
                </v-row>
                <v-btn
                    :href="route('admin.stylists.show', {
                        shop: shopId,
                        stylist: stylist.id,
                    })"
                    color="deep-purple-lighten-2"
                    type="submit"
                    class="mt-12"
                    block
                    >スタイリスト予定確認
                </v-btn>
            </v-card-text>
        </v-card>
    </AuthenticatedShopDetailLayout>
</template>
