<script setup>
import FullCalendar from '@fullcalendar/vue3'
import { useForm, usePage } from '@inertiajs/vue3';
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import { ref, onBeforeMount, computed } from 'vue'
import interactionPlugin from '@fullcalendar/interaction'
import dayjs from "dayjs";
import flashMessage from '@/Utils/flashMessage';
import { START_TIME_TYPE_TEXT } from '@/Consts/startTimeType.js';
import { mdiDelete } from '@mdi/js'

const props = defineProps({
    reservations: {
        type: Array,
        required: true,
    },
    isAdmin: {
        type: Boolean,
        required: true,
    },
});
const page = usePage()
const user = computed(() => page.props.auth.user.name)
const form = useForm({
    event: {
        name: '',
    }
});
onBeforeMount(() => {
    console.log(props.reservations)
    props.reservations.map((reservation) => {
        form.event.name = reservation.user.name
        let startTime = dayjs(`${reservation.date}: ${START_TIME_TYPE_TEXT[reservation.start_time_type]}`).format('YYYY-MM-DDTHH:mm:ss')
        startTime = startTime+'Z'
        events.push({
            id: reservation.id,
            title: reservation.user.name+'様',
            date: reservation.date,
            color: '#424242',
            start: startTime,
            allDay: false
        })
    })
    console.log(events)
})
const events = [
    {
        title: '休憩時間',
        color: '#FF1744',
        date: '2023-11-28',
        startTime: '11:00',
        endTime: '12:00',
        allDay: false
    },
]
const handleEventClick = (clickInfo) => {
    if (clickInfo.event.title === '休憩時間') {
        if (props.isAdmin) {
            return;
        }
        flashMessage('従業員の休憩時間です。他の時間を選択なさってください。', 'error')
        return;
    }
    let reservationId = clickInfo.event.id
    eventId = reservationId
    let menus = []
    props.reservations.map((reservation) => {
        if (reservation.id == reservationId) {
            console.log(reservation)
            reservation.payment_histories.map((paymentHistory) => {
                menus.push(paymentHistory.menu)
            })
        }
    })
    isOpen.value = true;
    console.log(dayjs(clickInfo.event.startStr).add('hours', 1))
    form.event = {
        name: clickInfo.event.title,
        date: dayjs(clickInfo.event.startStr).format('Y-M-D'),
        color: '#424242',
        startTime: dayjs(clickInfo.event.startStr).format('YYYY-MM-DD:HH:mm:ss'),
        endTime: dayjs(clickInfo.event.startStr).add(1, 'hours').format('YYYY-MM-DD:HH:mm:ss'),
        menus: menus,
    }
}
let eventId = 0
let calendarApi = null
const isPushed = ref(false)
const calendarOptions = {
    locale: 'ja',
    timeZone: 'UTC',
    plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin ],
    headerToolbar: {
        left: 'prev,next',
        center: 'title',
        right: ''
    },
    droppable: false,
    editable: false,
    selectable: true,
    initialView: 'timeGridWeek',
    select: function(selectInfo) {
        if (props.isAdmin || isPushed.value) {
            return
        }
        calendarApi = selectInfo.view.calendar

        calendarApi.unselect()

        console.log(dayjs(selectInfo.startStr).format('YYYY-MM-DD:HH:mm'))
        const startStr = dayjs(selectInfo.startStr).subtract(9, 'hours').format('HH:mm:ss')
        const endStr = dayjs(selectInfo.startStr).add(8, 'hours').format('HH:mm:ss')
        if (selectInfo.startStr.substring(14, 16) === '30') {
            flashMessage('時間は1時間単位で選択してください。', 'error')
            return
        }
        form.event.value = {
            title: user.value,
            date: dayjs(selectInfo.startStr).format('YYYY-MM-DD'),
            startTime: startStr,
            endTime: endStr,
            allDay: selectInfo.allDay
        }
        eventId = Math.random().toString(32).substring(2)
        calendarApi.addEvent({
            id: eventId,
            title: user.value,
            start: selectInfo.startStr,
            allDay: selectInfo.allDay
        })
        isPushed.value = true
        emits('update:event', form.event)
    },
    eventClick: handleEventClick,
    // eventsSet: handleEvents,
    events: events,
    // dateClick: function(info) {
    //     alert('clicked ' + info.dateStr)
    //     console.log(info)
    //     events.push({ title: 'Taro', date: info.dateStr })
    // },
    // eventClick: function(info) {
    //     console.log(info)
    //     alert('clicked ' + info.dateStr)
    // },
    allDaySlot: false,
    eventShortHeight: 60,
    slotMinTime: '10:00:00',
    slotMaxTime: '23:00:00',
    
    // initialView: 'timeGridLimitedDay',
    // views: {
    //     timeGridLimitedDay: {
    //         type: 'timeGrid',
    //         duration: { days: 4 },
    //         eventShortHeight: '02:00'
    //     }
    // }
}
const isOpen = ref(false);
const emits = defineEmits([
    'delete:modelValue',
    'update:event'
]);
const deleteEvent = (id) => {
    const event = calendarApi.getEventById( id )
    event.remove();
    isOpen.value = false;
    isPushed.value = false;
}
</script>
<template>
    <FullCalendar :options="calendarOptions" />
    <v-dialog
        v-model="isOpen"
        width="500px"
        >
        <v-card class="px-8 pt-4">
            <v-row>
                <v-col class="text-right">
                    <v-btn
                        variant="text"
                        :icon="mdiDelete"
                        @click="deleteEvent(eventId)"
                        >
                    </v-btn>
                </v-col>
            </v-row>
            <v-card-text v-if="form.event.name !== '休憩時間'" class="mb-4 text-center">
                予約詳細
            </v-card-text>
            <v-card-text v-else class="mb-4 text-center">
                休憩時間
            </v-card-text>
            
            <v-row v-if="form.event.name !== '休憩時間'">
                <v-col cols="4">
                    <v-list-subheader>お名前</v-list-subheader>
                </v-col>
                <v-col cols="8">
                    <v-list-item>
                        <v-list-item-title>{{ form.event.name }}</v-list-item-title>
                    </v-list-item>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="4">
                    <v-list-subheader>開始時刻</v-list-subheader>
                </v-col>
                <v-col cols="8">
                    <v-list-item>
                        <v-list-item-title>{{ form.event.startTime }}</v-list-item-title>
                    </v-list-item>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="4">
                    <v-list-subheader>終了時刻</v-list-subheader>
                </v-col>
                <v-col cols="8">
                    <v-list-item>
                        <v-list-item-title>{{ form.event.endTime }}</v-list-item-title>
                    </v-list-item>
                </v-col>
            </v-row>
            <v-row v-if="props.isAdmin">
                <v-col cols="4">
                    <v-list-subheader>注文内容</v-list-subheader>
                </v-col>
                <v-col cols="8">
                    <v-row v-for="(menu, index) in form.event.menus">
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
        </v-card>
    </v-dialog>
</template>
