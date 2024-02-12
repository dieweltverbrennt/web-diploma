<template>
    <div class="modal-background">
        <div class="modal-form">
            <div class="modal-form__header" @click="closeCreateModal">&#10006;</div>

            <div class="conf-step__legend modal-form__legend">
                <label class="conf-step__label modal-form__label">Название фильма<input v-model="film.name" type="text" class="conf-step__input modal-form__input" placeholder="Введите название фильма" required></label>
            </div>  
            <div class="conf-step__legend modal-form__legend">
                <label class="conf-step__label modal-form__label">Описание фильма<textarea v-model="film.description" class="conf-step__input modal-form__textarea" placeholder="Введите описание фильма" required></textarea></label>
            </div>
            <div class="conf-step__legend modal-form__legend">
                <label class="conf-step__label modal-form__label">Страна производства<input v-model="film.productionCountry" type="text" class="conf-step__input modal-form__input" placeholder="Введите страну производства" required></label>
            </div>  
            <div class="conf-step__legend modal-form__legend">
                <label class="conf-step__label modal-form__label">Длительность в минутах<input v-model="film.duration" type="text" class="conf-step__input modal-form__input" placeholder="Введите длительность фильма" required></label>
            </div> 
            <div class="conf-step__legend modal-form__legend">
                <label class="conf-step__label modal-form__label">Постер<input v-model="film.poster" type="text" class="conf-step__input modal-form__input" placeholder="Введите название постера фильма (он должен находиться в папках)" required></label>
            </div> 

            <input type="submit" value="Добавить" class="conf-step__button conf-step__button-accent" @click.prevent="addFilm"> 
        </div>
    </div>
</template>

<script setup>
import { defineEmits, ref } from 'vue';

const emits = defineEmits(['closeCreateModal', 'addFilm']);

const film = ref({
    name: '',
    description: '',
    productionCountry: '',
    duration: '',
    poster: ''
})

const closeCreateModal = () => {
    emits('closeCreateModal');
};
const addFilm = () => {
    emits('addFilm', film.value);
    emits('closeCreateModal');
};
</script>

<style lang="scss">
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
}
</style>
