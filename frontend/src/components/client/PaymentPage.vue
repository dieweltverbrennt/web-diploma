<template>
    <main>
        <section class="ticket">
        
        <header class="tichet__check">
            <h2 class="ticket__check-title">Вы выбрали билеты:</h2>
        </header>
        
        <div class="ticket__info-wrapper">
            <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">{{ film.name }}</span></p>
            <p class="ticket__info">Места: <span class="ticket__details ticket__chairs">{{ seats.join(', ') }}</span></p>
            <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{ hall.hall_number }}</span></p>
            <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">{{ session.start_time }}</span></p>

            <div v-if="isPaid">
                <!-- <img class="ticket__info-qr" src="@/assets/client/img/qr-code.png"> -->
                <qrcode-vue class="ticket__info-qr" :text="qrCodeData"></qrcode-vue>

                <p class="ticket__hint">Покажите QR-код нашему контроллеру для подтверждения бронирования.</p>
                <p class="ticket__hint">Приятного просмотра!</p>
            </div>

            <div v-else>
                <p class="ticket__info">Стоимость: <span class="ticket__details ticket__cost">{{ price }}</span> рублей</p>

                <button class="acceptin-button" @click="onGetCodeClick">Получить код бронирования</button>

                <p class="ticket__hint">После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите QR-код нашему контроллёру у входа в зал.</p>
                <p class="ticket__hint">Приятного просмотра!</p>
            </div>
        </div>
        </section>     
    </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import apiRequest from '@/axios.js';
import { useRoute } from 'vue-router';
import QrcodeVue from 'vue-qrcode-component';

const route = useRoute();
const sessionId = route.params.sessionId;
const seatsIds = route.params.seatsId;

const session = ref({});
const film = ref({});
const hall = ref({});
const seats = ref([]);
let price = ref(null);
const isPaid = ref(false);
const qrCodeData = ref('');

onMounted(async () => {
    try {
        const responseSession = await apiRequest.get(`/sessions/${sessionId}`);
        session.value = responseSession.data.session;
        film.value = responseSession.data.session.film;
        hall.value = responseSession.data.session.hall;
        session.value.start_time = session.value.start_time.split(':').slice(0, 2).join(':');

        const responseSeats = await apiRequest.get(`/seats/${seatsIds}`);
        price.value = 0;
        if(responseSeats.data.seats) {
            responseSeats.data.seats.forEach(element => {
                seats.value.push(element.seat_number);
                price.value += element.price;
            });
        }
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
});

const onGetCodeClick = (() => {
    isPaid.value = true;
    console.log(seats)
    qrCodeData.value = `Места: ${seatsIds}, Сеанс: ${sessionId}`
});
</script>

<style>
    .ticket__info-qr {
        height: 100%;
    }
</style>