<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/Admin/AuthenticatedShopDetailLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import BarChart from '@/Components/BarChart.vue';
import flashMessage from '@/Utils/flashMessage';
import { onBeforeMount, ref, computed } from 'vue';
import dayjs from "dayjs";

const props = defineProps({
    labels: {
        type: Array,
        required: false,
    },
    userLabels: {
        type: Array,
        required: false,
    },
    amounts: {
        type: Array,
        required: false,
    },
    userAmounts: {
        type: Array,
        required: false,
    },
    amountAll: {
        type: Number,
        required: false,
    },
    stylists: {
        type: Array,
        required: false,
    },
    users: {
        type: Object,
        required: false,
    },
    start: {
        type: String,
        required: false,
    },
    end: {
        type: String,
        required: false,
    },
    routeParams: {
        type: Object,
        required: true,
    },
});
console.log(props)
const shopId = props.routeParams.parameters.shop;
console.log(shopId)
onBeforeMount(() => {
    sessionStorage.setItem('shopId', shopId);
});
const form = useForm({
    stylist_id: props.stylists[0].id ?? null,
    user_id: props.users[0].id ?? null,
});

const start = ref(props.start ?? null);
const end = ref(props.end ?? null);
const stylists = ref(props.stylists);
console.log(stylists.value)
const users = ref(props.users);
const labels = computed(() => {
    return props.labels;
})
const userLabels = computed(() => {
    return props.userLabels;
})
const amounts = computed(() => {
    return props.amounts;
})
const userAmounts = computed(() => {
    return props.userAmounts;
})
let chartKey = ref(0);
let userChartKey = ref(0);
const submit = () => {
    form.post(route('admin.analyze', {
        'shop': shopId,
        'start': start.value,
        'end': end.value,
    }), {
        onSuccess: () => {
            chartKey.value += 1;
            userChartKey.value += 1;
            console.log(props)
        },
        onError: (e) => {
            // flashMessage('削除に失敗しました。再度お試しください。', 'error')
        },
    });
};
const title = computed(() => {
    if (start.value === null || end.value === null) {
        return '売上分析';
    }
    return `${start.value} ~ ${end.value}の売上分析`
});
</script>

<template>
    <Head title="分析" />

    <AuthenticatedShopDetailLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">分析</h2>
        </template>
        <v-sheet class="ma-4 py-6">
            <v-form @submit.prevent="submit">
                <v-row>
                    <v-col cols="2">
                        <v-list-subheader>開始</v-list-subheader>
                    </v-col>
                    <v-col cols="10">
                        <v-text-field
                            v-model="start"
                            label="開始"
                            variant="outlined"
                            required
                            type="date"
                            >
                        </v-text-field>
                    </v-col>
                    <v-col cols="2">
                        <v-list-subheader>終了</v-list-subheader>
                    </v-col>
                    <v-col cols="10">
                        <v-text-field
                            v-model="end"
                            label="終了"
                            variant="outlined"
                            required
                            type="date"
                            >
                        </v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-row>
                            <v-col cols="2">
                                <v-list-subheader>スタイリスト</v-list-subheader>
                            </v-col>
                            <v-col cols="10">
                                <v-select
                                    v-model="form.stylist_id"
                                    label="スタイリスト"
                                    chips
                                    item-color="success"
                                    :items="stylists"
                                    item-title="name"
                                    item-value="id"
                                    ></v-select>
                            </v-col>
                        </v-row>
                        <BarChart
                            :key="chartKey"
                            :title="title"
                            :labels="labels"
                            :data="amounts"
                            :amountAll="props.amountAll"
                        />
                    </v-col>
                    <v-col cols="6">
                        <v-row>
                            <v-col cols="2">
                                <v-list-subheader>ユーザー</v-list-subheader>
                            </v-col>
                            <v-col cols="10">
                                <v-select
                                    v-model="form.user_id"
                                    label="ユーザー"
                                    chips
                                    item-color="success"
                                    :items="users"
                                    item-title="name"
                                    item-value="id"
                                    ></v-select>
                            </v-col>
                        </v-row>
                        <BarChart
                            :key="userChartKey"
                            title="ユーザーごとの売上"
                            :labels="userLabels"
                            :data="userAmounts"
                        />
                    </v-col>
                </v-row>
                <v-btn
                    color="pink-lighten-5"
                    type="submit"
                    class="mt-12"
                    block
                    >分析
                </v-btn>
                </v-form>
        </v-sheet>
    </AuthenticatedShopDetailLayout>
</template>
