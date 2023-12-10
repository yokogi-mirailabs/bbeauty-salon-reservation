<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/Admin/AuthenticatedShopDetailLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { onBeforeMount, onMounted, ref, computed } from 'vue';
import axios from 'axios';
import MessageRender from '@/Components/MessageRender.vue';

const props = defineProps({
    messageHistories: {
        type: Array,
        required: false,
    },
    routeParams: {
        type: Object,
        required: true,
    },
    stylists: {
        type: Array,
        required: false,
    },
    users: {
        type: Array,
        required: false,
    },
});
const shopId = props.routeParams.parameters.shop.id;
onBeforeMount(() => {
    sessionStorage.setItem('shopId', shopId);
});
onMounted(() => {
    getMessages();

    window.Echo.channel('message')
        .listen('MessageHistoryCreated', (e) => {

            getMessages();

        });
});
const messageHistories = ref(props.messageHistories);
const stylists = ref(props.stylists);
const stylistId = ref(stylists.value[0].id)
const selectedStylist = computed(() => {
    return stylists.value.find((stylist) => stylist.id === stylistId.value);
});
const users = ref(props.users);
const userId = ref(users.value[0].id)
const selectedUser = computed(() => {
    return users.value.find((user) => user.id === userId.value);
});
const getMessages = (stylist_id) => {
    if (typeof stylist_id === 'number') {
        stylistId.value = stylist_id
    }
    axios.get(route('api.message_histories.index', {
        'shop': shopId,
        'user_id': userId.value,
        'stylist_id': stylistId.value,
    })).then((response) => {
            console.log(response.data);
            messageHistories.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
};
const getMessagesFromUser = (user_id) => {
    if (typeof user_id === 'number') {
        userId.value = user_id
    }
    axios.get(route('api.message_histories.index', {
        'shop': shopId,
        'user_id': userId.value,
        'stylist_id': stylistId.value,
    })).then((response) => {
            console.log(response.data);
            messageHistories.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
};
const submit = () => {
    axios.post(route('api.message_histories.store', {
        'shop': shopId,
        'user_id': userId.value,
        'stylist_id': stylistId.value,
        'from_user': 0,
    }), form )
    .then((response) => {
        window.Echo.channel('message')
            .listen('MessageHistoryCreated', (e) => {

                axios.get(route('api.message_histories.index', {
                    'shop': shopId,
                    'user_id': response.data.user_id,
                    'stylist_id': response.data.stylist_id,
                })).then((response) => {
                        console.log(response.data);
                        messageHistories.value = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            });
    })
    .catch((error) => {
        console.log(error);
    });
};
const form = useForm({
    body: '',
});
</script>

<template>
    <Head title="トーク一覧" />

    <AuthenticatedShopDetailLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">トーク一覧</h2>
        </template>

        <v-sheet>
            <v-row>
                <v-col cols="2">
                    <v-list-subheader>スタイリスト</v-list-subheader>
                </v-col>
                <v-col cols="8">
                    <v-select
                        @update:modelValue="getMessages"
                        v-model="stylistId"
                        label="スタイリスト"
                        chips
                        item-color="success"
                        :items="stylists"
                        item-title="name"
                        item-value="id"
                        ></v-select>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="2">
                    <v-list-subheader>ユーザー</v-list-subheader>
                </v-col>
                <v-col cols="8">
                    <v-select
                        @update:modelValue="getMessagesFromUser"
                        v-model="userId"
                        label="ユーザー"
                        chips
                        item-color="success"
                        :items="users"
                        item-title="name"
                        item-value="id"
                        ></v-select>
                </v-col>
            </v-row>
        </v-sheet>
        <v-card class="w-50 mx-auto px-5">
            <template v-for="(messageHistory, index) in messageHistories" :key="messageHistory.id" elevation="3" class="mb-3">
                <MessageRender
                    :messageHistory="messageHistory"
                    :user="selectedUser"
                    :stylist="selectedStylist"
                />
            </template>
        </v-card>
        <v-form @submit.prevent="submit">
            <v-row>
                <v-col cols="4">
                    <v-list-subheader>新規メッセージ</v-list-subheader>
                </v-col>
                <v-col cols="8">
                    <v-text-field
                        v-model="form.body"
                        label="新規メッセージ"
                        variant="outlined"
                        required
                        >
                    </v-text-field>
                </v-col>
            </v-row>
        </v-form>
    </AuthenticatedShopDetailLayout>
</template>
