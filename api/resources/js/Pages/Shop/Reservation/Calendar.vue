<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/AuthenticatedShopDetailLayout.vue';
import { STYLIST_POST_TYPE, STYLIST_POST_TYPE_TEXT } from '@/Consts/stylistPostType';
import FullCalendar from '@/Components/Calendar.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, ref, onBeforeMount, onMounted } from 'vue';
import axios from 'axios';
import flashMessage from '@/Utils/flashMessage';

const props = defineProps({
    stylists: {
        type: Array,
        required: true,
    },
    payjpPublicKey: {
        type: String,
        required: true,
    },
    routeParams: {
        type: Object,
        required: true,
    },
});
console.log(props)
const shopId = props.routeParams.parameters.shop.id;
console.log(shopId);
console.log(props.routeParams)
onBeforeMount(() => {
    sessionStorage.setItem('shopId', shopId);
});
const form = useForm({
    stylist: {
        name: '',
    },
    menus: [],
    event: null,
    payjp_token: '',
});
const setStylist = (stylist) => {
    axios.get(route('api.reservations.index', {
        shop: shopId,
        stylist: stylist.id,
    })).then((res) => {
        reservations.value = res.data.reservations;
        calendarKey.value += 1;
    })
    form.stylist = stylist;
}
const reservations = ref([])
const menus = computed(() => {
    if (form.stylist.name === '') {
        return [];
    }
    return props.stylists.find((stylist) => stylist.id === form.stylist.id).menus;
});
const price = computed(() => {
    if (form.menus.length === 0) {
        return 0;
    }
    return form.menus.reduce((sum, menu) => {
        return sum + menu.price;
    }, 0);
});
const setEvent = (e) => {
    console.log(e.value)
    form.event = e.value;
}
const confirm = () => {
    form.payjp_token = document.querySelector('input[name="payjp-token"]').value || '';
    form.post(route('reservations.store', {
        shop: shopId,
    }), {
        onSuccess: () => {
            flashMessage('予約を作成しました', 'success')
        },
        onError: (e) => {
            flashMessage('作成に失敗しました。入力内容をご確認ください。', 'error')
        },
        onFinish: () => {
            form.event = null;
        },
    });
}
const calendarKey = ref(0);
const isOpen = ref(false);

const payjpArea = ref(null);
let script = null;

const insertPayjpScript = () => {
    script = document.createElement('script');
    script.src = 'https://checkout.pay.jp/';
    script.setAttribute('class', 'payjp-button');
    script.setAttribute('data-partial', true);
    script.setAttribute('data-key', props.payjpPublicKey);
    script.setAttribute('data-text', 'クレジットカード情報を入力');
    script.setAttribute('data-submit-text', '登録');
    payjpArea.value.appendChild(script);
}

onMounted(() => {
    insertPayjpScript();
});
</script>
<template>
    <AuthenticatedShopDetailLayout>
        <v-row>
            <v-col class="text-right">
                <v-dialog
                    v-model="isOpen"
                    width="auto"
                    >
                    <v-card class="pt-4">
                        <v-card-text class="mb-4">
                            予約を確定します。よろしいですか？
                        </v-card-text>
                        <v-card-actions class="pb-0">
                            <v-row>
                                <v-col cols="6">
                                    <v-btn class="text-subtitle-1" variant="flat" block @click="isOpen = false">閉じる</v-btn>
                                </v-col>
                                <v-col cols="6">
                                    <v-btn class="text-subtitle-1" variant="flat" block color="red" @click="confirm()">はい</v-btn>
                                </v-col>
                            </v-row>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-col>
        </v-row>
        <v-carousel
            cycle
            height="200"
            hide-delimiter-background
            show-arrows="hover"
        >
            <v-carousel-item
                v-for="(stylist, i) in props.stylists"
                :key="i"
                >
                <v-sheet
                    @click="form.stylist = stylist"
                    color="white"
                    height="100%"
                >
                    <div @click="setStylist(stylist)" class="d-flex fill-height justify-center align-center">
                        <div>
                            <p>{{ stylist.name }}</p>
                            <p>{{ STYLIST_POST_TYPE_TEXT[stylist.job_post] }}/指名料なし ({{ stylist.working_year }}年目)</p>
                            <p>{{ stylist.description }}</p>
                        </div>
                    </div>
                </v-sheet>
            </v-carousel-item>
        </v-carousel>
        <div class="text-caption text-right" color="red">※最初にスタイリストを選択してください</div>
        <v-sheet class="text-h5 pb-6">
            選択中のスタイリスト: {{ form.stylist.name }}
        </v-sheet>
            <FullCalendar
                :key="calendarKey"
                :reservations="reservations"
                :isAdmin="false"
                @update:event="setEvent($event)"
                />
        <v-sheet class="text-h5 pt-6">
            担当メニュー
        </v-sheet>
        <v-row style="min-height: 80px;">
            <v-col v-for="(menu, index) in menus" cols="4">
                <v-checkbox
                    v-model="form.menus"
                    :label="menu.name"
                    color="deep-purple-lighten-2"
                    :value="menu"
                    hide-details
                ></v-checkbox>
            </v-col>
        </v-row>
        <v-sheet>
            計: {{ price }} 円
        </v-sheet>
        <div ref="payjpArea"></div>
        <v-btn
            @click="isOpen = true"
            color="deep-purple-lighten-2"
            type="submit"
            class="mt-12"
            block
            >予約を確定する
        </v-btn>
    </AuthenticatedShopDetailLayout>
</template>
