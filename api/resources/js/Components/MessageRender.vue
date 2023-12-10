<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/AuthenticatedShopDetailLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { mdiPencil, mdiPlus } from '@mdi/js'
import ConfirmModal from '@/Components/ConfirmModal.vue';
import MessageRender from '@/Components/MessageRender.vue';
import flashMessage from '@/Utils/flashMessage';
import { onBeforeMount, onMounted, ref, computed } from 'vue';
import axios from 'axios';
import Echo from 'laravel-echo';

const props = defineProps({
    messageHistory: {
        type: Object,
        required: true,
    },
    stylist: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
});
</script>
<template>
    <div v-if="props.messageHistory.from_user" class="user-comment user-wrapper">
        <pre class="text-subtitle-1">{{ props.messageHistory.body }}</pre>
        <div class="text-subtitle-2">{{ props.user.name }}</div>
    </div>
    <div v-else class="stylist-comment stylist-wrapper">
        <span class="text-subtitle-2">{{ props.stylist.name }}</span>
        <pre class="text-subtitle-1">{{ props.messageHistory.body }}</pre>
    </div>
</template>

<style scoped>
.user-wrapper {
    display: flex;
    justify-content: end;
}
.stylist-wrapper {
    display: flex;
    justify-content: start;
}
.user-comment,
.stylist-comment {
    margin: 10px 0;
}

.user-comment pre {
    display: inline-block;
    position: relative;
    margin: 0 10px 0 0;
    padding: 8px;
    /* max-width: 250px; */
    overflow-wrap: break-word;
    white-space: pre-wrap;
    border-radius: 12px;
    background: #FFCCFF	;
    font-size: 15px;
    word-break: break-all;
}

.user-comment pre:after {
    content: "";
    position: absolute;
    top: 3px;
    right: -19px;
    border: 8px solid transparent;
    border-left: 18px solid #FFCCFF	;
    --webkit-transform: rotate(-35deg);
    transform: rotate(-35deg);
}

.stylist-comment pre {
    display: inline-block;
    position: relative;
    margin: 0 0 0 10px;
    padding: 8px;
    /* max-width: 250px; */
    overflow-wrap: break-word;
    white-space: pre-wrap;
    border-radius: 12px;
    background: #FF99FF;
    font-size: 15px;
    word-break: break-all;
}

.stylist-comment pre:after {
    content: "";
    position: absolute;
    top: 3px;
    left: -19px;
    border: 8px solid transparent;
    border-right: 18px solid #FF99FF;
    --webkit-transform: rotate(35deg);
    transform: rotate(35deg);
}
.user-comment .align {
    justify-content: end;
}

.stylist-comment .align {
    justify-content: start;
}
</style>