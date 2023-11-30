<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { STYLIST_POST_TYPE, STYLIST_POST_TYPE_TEXT } from '@/Consts/stylistPostType';
import { START_TIME_TYPE, START_TIME_TYPE_TEXT } from '@/Consts/startTimeType';
import FullCalendar from '@/Components/Calendar.vue';
import { useForm } from '@inertiajs/vue3';
import ConfirmModal from '@/Components/ConfirmModal.vue';
import { computed, ref } from 'vue';

const props = defineProps({
    reservations: {
        type: Array,
        required: true,
    },
    routeParams: {
        type: Object,
        required: true,
    },
});
console.log(props.reservations)
const form = useForm({});
const menus = (reservation) => {
    return reservation.payment_histories.map((payment) => {
        return payment.menu;
    })
}
</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">過去の予約</h2>
        </template>

        <v-card v-for="(reservation, index) in props.reservations" :key="reservation.id" elevation="3" class="mb-3">
            <v-card-text>
                <v-row>
                    <v-col class="text-right">
                        <ConfirmModal
                            @delete:model-value="cancelReservation(reservation.id)"
                            />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>店舗名</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ reservation.shop.name }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>開始時刻</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <v-list-item>
                            <v-list-item-title>{{ START_TIME_TYPE_TEXT[reservation.start_time_type] }}</v-list-item-title>
                        </v-list-item>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>注文内容</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <v-row v-for="(menu, index) in menus(reservation)">
                            <v-col cols="4">
                                <v-list-subheader>{{ menu.name }}</v-list-subheader>
                            </v-col>
                            <v-col cols="8">
                                <v-list-item>
                                    <v-list-item-title>{{ menu.price}}</v-list-item-title>
                                </v-list-item>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-btn class="text-subtitle-1" variant="flat" block @click="isOpen = false">閉じる</v-btn>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </AuthenticatedLayout>
</template>