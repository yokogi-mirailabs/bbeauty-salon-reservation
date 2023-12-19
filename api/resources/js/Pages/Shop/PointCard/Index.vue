<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/AuthenticatedShopDetailLayout.vue';
import { STYLIST_POST_TYPE, STYLIST_POST_TYPE_TEXT } from '@/Consts/stylistPostType';
import { START_TIME_TYPE, START_TIME_TYPE_TEXT } from '@/Consts/startTimeType';
import FullCalendar from '@/Components/Calendar.vue';
import { useForm } from '@inertiajs/vue3';
import ConfirmModal from '@/Components/ConfirmModal.vue';
import { computed, ref } from 'vue';

const props = defineProps({
    pointCard: {
        type: Object,
        required: true,
    },
    routeParams: {
        type: Object,
        required: true,
    },
});
</script>
<template>
    <AuthenticatedShopDetailLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ポイントカード</h2>
            <span>５ポイント貯めると割引クーポンが配布されます。</span>
        </template>

        <v-timeline side="end" align="start">
            <v-timeline-item
                v-for="point in props.pointCard.point"
                dot-color="pink"
                size="small"
            >
                <div class="d-flex">
                    <strong class="me-4">{{ point }}ポイント目！</strong>
                    <div>
                    <strong v-if="point % 5 === 0">おめてとうございます！割引クーポンが配布されました。</strong>
                    <div class="text-caption">
                        ご来店ありがとうございました。
                    </div>
                    </div>
                </div>
            </v-timeline-item>

        </v-timeline>
    </AuthenticatedShopDetailLayout>
</template>
