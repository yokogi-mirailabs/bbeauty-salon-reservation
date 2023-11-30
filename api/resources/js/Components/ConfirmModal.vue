<script setup>
import { ref } from 'vue';
import { mdiDelete } from '@mdi/js'
const props = defineProps({
    modelValue: {
        type: String,
        required: false,
    },
});
const isOpen = ref(false);
const emits = defineEmits([
    'delete:modelValue',
]);
const close = () => {
    isOpen.value = false;
    emits('delete:modelValue')
}
</script>
<template>
    <v-btn
        variant="text"
        :icon="mdiDelete"
        @click="isOpen = true"
        >
    </v-btn>

    <v-dialog
        v-model="isOpen"
        width="auto"
        >
    <v-card class="pt-4">
        <v-card-text class="mb-4">
        {{ props.modelValue }}を削除します。よろしいですか？
        </v-card-text>
        <v-card-actions class="pb-0">
            <v-row>
                <v-col cols="6">
                    <v-btn class="text-subtitle-1" variant="flat" block @click="isOpen = false">閉じる</v-btn>
                </v-col>
                <v-col cols="6">
                    <v-btn class="text-subtitle-1" variant="flat" block color="red" @click="close()">はい</v-btn>
                </v-col>
            </v-row>
        </v-card-actions>
    </v-card>
    </v-dialog>
</template>
