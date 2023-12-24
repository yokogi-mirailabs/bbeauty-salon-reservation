<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/Admin/AuthenticatedShopDetailLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import FullCalendar from '@/Components/Calendar.vue';
import { computed } from 'vue';

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

const menus = computed(() => {
    return props.stylist.menus;
});
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
        <v-sheet class="text-h6">
            担当メニュー
        </v-sheet>
        <v-row>
            <v-col v-for="(menu, index) in menus" cols="3">
                <v-checkbox
                    v-model="form.menus"
                    :label="menu.name"
                    color="deep-purple-lighten-2"
                    :value="menu"
                    hide-details
                    disabled
                ></v-checkbox>
            </v-col>
        </v-row>
    </AuthenticatedShopDetailLayout>
</template>
