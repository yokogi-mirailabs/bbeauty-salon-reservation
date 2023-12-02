<template>
    <Bar :data="data" :options="options" />
</template>

<script>
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js'
import { Bar } from 'vue-chartjs'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

export default {
    name: 'App',
    components: {
        Bar
    },
    props: {
        title: {
            type: String,
            default: ''
        },
        labels: {
            type: Array,
            default: []
        },
        data: {
            type: Array,
            default: []
        },
        amountAll: {
            type: Number,
            default: 0
        },
        backgroundColor: {
            type: String,
            default: '#FF99CC'
        }
    },
    setup(props) {
        const data = {
            labels: props.labels,
            datasets: [
                {
                    label: props.title,
                    backgroundColor: props.backgroundColor,
                    data: props.data
                }
            ]
        }

        const options = {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: props.title ? true : false,
                    align: 'start',
                    labels: {
                        boxWidth: 0
                    }
                }
            },
        }

        return {
            data,
            options,
        }
    },
}
</script>
