<template>
    <div id="data-container" class="row">
        <div id="codi" class="col-4">
            <div>Codi</div>
            <div>#{{ codiTrucada }}</div>
        </div>
        <div id="timer" class="col-4">{{ timer }}</div>
        <div id="dataHora" class="col-4">
            <div>{{ currentDay }}</div>
            <div>{{ currentTime }}</div>
        </div>
    </div>
</template>
<script>
import moment from 'moment/moment.js';
import 'moment/locale/ca'
export default {
    emits: [
        'carta-durada'
    ],
    props: {
        codiTrucada: {
            type: String
        },
        isLoaded: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            startTime: null,
            timer: '',
            currentDay: '',
            currentTime: '',
            elapsedSeconds: 0
        }
    },
    watch: {
        isLoaded(cartaIdLoaded) {
            if (cartaIdLoaded){
                this.startTimer()
            }
        }
    },
    methods: {
        startTimer() {
            this.startTime = moment()
            const self = this
            const updateTime = () => {
                const currentTime = moment()
                const elapsedTime = currentTime.diff(this.startTime)
                const duration = moment.duration(elapsedTime)
                const minutes = duration.minutes()
                const seconds = duration.seconds()
                const formattedSeconds = (seconds < 10 ? '0' : '') + seconds //Add leading 0 if seconds are less than 10
                self.timer = minutes + ':' + formattedSeconds
                this.elapsedSeconds = Math.floor(duration.asSeconds())
                this.$emit('carta-durada', this.elapsedSeconds)
            }
            updateTime()
            setInterval(updateTime, 1000)
        },
        getDayTime() {
            moment.locale('ca')
            this.currentDay = moment().format('LL')
            this.currentTime = moment().format('h:mm a')

            const updateCurrentTime = () => {
                this.currentTime = moment().format('h:mm a')
                const secondsUntilNextMinute = 60 - moment().seconds()
                setTimeout(updateCurrentTime, secondsUntilNextMinute * 1000)
                }

            setTimeout(updateCurrentTime, (60 - moment().seconds()) * 1000)
        }
    },
    mounted() {
        this.getDayTime()
    },
}
</script>
<style scoped>
    #data-container {
        display: flex;
        width: 100%;
        height: 100%;
        margin: 0;
        border-radius: 5px;
        background-color: #373737;
    }
    #codi, #timer, #dataHora {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #codi, #dataHora {
        color: white;
    }
    #codi, #dataHora{
        display: flex;
        flex-direction: column;
    }
    #timer {
        font-size: 50px;
        animation: colorTransition 100s forwards
    }

    @keyframes colorTransition {
        0% {
            color: hsl(120, 100%, 40%)
        }
        50% {
            color: hsl(50, 100%, 50%)
        }
        100% {
            color: hsl(0, 100%, 50%)
        }
    }
</style>