<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/Admin/AuthenticatedShopDetailLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { mdiPencil, mdiPlus } from '@mdi/js'
import ConfirmModal from '@/Components/ConfirmModal.vue';
import flashMessage from '@/Utils/flashMessage';
import { onBeforeMount } from 'vue';
import { STYLIST_POST_TYPE, STYLIST_POST_TYPE_TEXT } from '@/Consts/stylistPostType';
import FullCalendar from '@/Components/Calendar.vue';

const props = defineProps({
    stylist: {
        type: Object,
        required: true,
    },
    reservations: {
        type: Array,
        required: true,
    },
    routeParams: {
        type: Object,
        required: true,
    },
});
const shopId = props.routeParams.parameters.shop;

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

        <v-card elevation="3" class="mb-3">
            <v-card-text>
                <FullCalendar
                    :reservations="props.reservations"
                    :isAdmin="true"
                />
            </v-card-text>
        </v-card>
    </AuthenticatedShopDetailLayout>
</template>
