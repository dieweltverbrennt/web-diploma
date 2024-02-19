<template>
    <div class="modal-background">
        <div class="modal-form">
            <div class="modal-form__header" @click="closeRedactModal">&#10006;</div>

            <h2 class="conf-step__title modal-form__title">{{ film.name }}</h2>

            <h2>Сеансы</h2>

            <ul class="conf-step__list">
                <li v-for="(item, index) in film.sessions" :key="index">{{ item.start_time.split(':').slice(0, 2).join(':') }} - {{ item.end_time.split(':').slice(0, 2).join(':') }} |  Зал {{ item.hall.hall_number }}
                    <button class="conf-step__button conf-step__button-trash" @click="deleteSession(item.id)"></button>
                </li>
                <div v-for="(item, index) in newSessions" :key="index">
                <li v-if="item.filmName == film.name">{{ item.start }} - {{ item.end }} |  Зал {{ item.hallNumber }}
                    <button class="conf-step__button conf-step__button-trash" @click="deleteSession(item)"></button>
                </li>
                </div>
            </ul>

            <div class="modal-form__wrapper" v-if="isOpenSessionForm">
                <div class="conf-step__legend">
                    <label class="conf-step__label">Начало сеанса<input type="text" class="conf-step__input" placeholder="HH:MM" v-model="start" @input="validateStartTime"></label>
                    ---- <label class="conf-step__label">Конец сеанса<input type="text" class="conf-step__input" :value="end" placeholder="HH:MM"></label>
                </div>  
                <div class="conf-step__legend">
                    <label class="conf-step__label">Зал
                    <select class="conf-step__input" v-model="selectedHall">
                        <option v-for="(option, index) in halls" :key="index" :value="option.id">{{ option.hall_number }}</option>
                    </select>
                    </label>
                </div>  
                <input type="submit" value="Подтвердить" class="conf-step__button conf-step__button-accent modal-form__submit" @click.prevent="addSession"> 
            </div>            

            <button class="conf-step__button conf-step__button-accent modal-form__add-button" @click="isOpenSessionForm = true">Добавить сеанс</button>
        </div>
    </div>
</template>

<script setup>
import { defineEmits, ref, defineProps, onMounted, computed } from 'vue';

const props = defineProps({
    film: Object,
    halls: Object,
    newSessions: Array
});
const isOpenSessionForm = ref(false);
const durationHour = computed(() => {
    const duration = props.film.duration.split(' ')[0];
    return parseInt(Math.floor(duration/60));
});
const durationMinutes = computed(() => {
    const duration = props.film.duration.split(' ')[0];
    return parseInt(duration % 60);
});
const start = ref(null);
const end = computed(() => {
    if (start.value) {
        if (start.value.length === 5) {
            const startH = parseInt(start.value.split(':')[0]);
            const startM = parseInt(start.value.split(':')[1]);
            let endH = startH + durationHour.value;
            if (endH < 10) {
                endH = '0' + endH;
            }
            let endM = startM + durationMinutes.value;
            if (endM < 10) {
                endM = '0' + endM
            }
            return `${endH}:${endM}`;
        }
    }
});
const selectedHall = ref(1);

// onMounted(() => {
// });

const emits = defineEmits(['closeRedactModal', 'deleteSession', 'addSession']);

const closeRedactModal = () => {
    emits('closeRedactModal');
};
const deleteSession = (item) => {
    emits('deleteSession', item);
};
const validateStartTime = () => {
    start.value = start.value.replace(/[^\d:]/g, '');
    start.value = start.value.slice(0, 5);
    if (start.value.length === 2) {
        start.value += ':';
    }
};
const addSession = () => {
    const hallNum = props.halls.find(item => item.id === selectedHall.value);
    emits('addSession', {
        start: start.value,
        end: end.value,
        filmId: props.film.id,
        filmName: props.film.name,
        duration: props.film.duration,
        hallId: selectedHall.value,
        hallNumber: hallNum.hall_number
    });
    isOpenSessionForm.value = false;
};

</script>

<style lang="scss">
h2 {
    margin-bottom: 20px;
}
.modal-background {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1000;
    background-color: rgba(0, 0, 0, 0.304);
}
.modal-form {
    position: fixed;
    width: 826px;
    background-color: rgba(234, 233, 235);
    z-index: 10000;
    top: 50%;
    bottom: auto;
    left: 50%;
    right: auto;
    transform: translate(-50%, -50%);
    border-radius: 5px;
    padding: 30px;

    &__header {
        float: right;
        font-size: 30px;
        cursor: pointer;
    }

    &__title {
        margin-bottom: 30px;
        font-size: 20px;
    }

    &__label {
        font-size: 16px;
    }

    &__input {
        width: 400px;
    }

    &__textarea {
        resize: none;
        width: 400px;
    }

    &__wrapper {
        margin-top: 30px;
    }

    &__submit {
        background-color: #fff !important;
        color: #000 !important;
    }

}
</style>
