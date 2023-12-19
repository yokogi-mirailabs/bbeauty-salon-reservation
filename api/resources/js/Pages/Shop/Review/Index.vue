<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/AuthenticatedShopDetailLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { mdiPencil } from '@mdi/js'
import ConfirmModal from '@/Components/ConfirmModal.vue';
import flashMessage from '@/Utils/flashMessage';
import { onBeforeMount } from 'vue';

const props = defineProps({
    reviews: {
        type: Array,
        required: true,
    },
    routeParams: {
        type: Object,
        required: true,
    },
});
const form = useForm({
    'good_flag': false,

});
const shopId = props.routeParams.parameters.shop.id;
onBeforeMount(() => {
    sessionStorage.setItem('shopId', shopId);
});

const deleteReview = (reviewId) => {
    form.delete(route('reviews.destroy', {
        'shop': shopId,
        'review': reviewId,
    }), {
        onSuccess: () => {
            flashMessage('レビューを削除しました。', 'success')
        },
        onError: (e) => {
            flashMessage('削除に失敗しました。再度お試しください。', 'error')
        },
    });
};
</script>

<template>
    <Head title="レビュー一覧" />

    <AuthenticatedShopDetailLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">レビュー一覧</h2>
        </template>

        <v-card v-for="(review, index) in props.reviews" :key="review.id" elevation="3" class="mb-3">
            <v-toolbar color="pink-lighten-5" flat />
            <v-card-text>
                <v-row>
                    <v-col class="text-right">
                        <v-btn
                            variant="text"
                            :icon="mdiPencil"
                            :href="route('reviews.edit', {
                                shop: shopId,
                                review: review.id,
                            })"
                            >
                        </v-btn>
                        <ConfirmModal
                            @delete:model-value="deleteReview(review.id)"
                            :model-value="'レビュー'"
                            />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader></v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div v-if="review.good_flag" class="text-subtitle-1">良い評価</div>
                        <div v-else class="text-subtitle-1">悪い評価</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>評価</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <v-rating
                            hover
                            readonly
                            :length="5"
                            :size="29"
                            :model-value="review.evaluation"
                            :active-color="review.good_flag ? 'light-green-accent-2' : 'red-darken-3'"
                            />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>レビュー内容</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ review.body }}</div>
                    </v-col>
                </v-row>
                <v-btn
                    :href="route('reviews.create', {
                        shop: shopId,
                    })"
                    color="deep-purple-lighten-2"
                    type="submit"
                    class="mt-12"
                    block
                    >レビューを作成する
                </v-btn>
            </v-card-text>
        </v-card>
    </AuthenticatedShopDetailLayout>
</template>
