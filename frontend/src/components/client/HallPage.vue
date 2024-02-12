<template>
    <main>
    <section class="buying">
      <div class="buying__info">
        <div class="buying__info-description">
          <h2 class="buying__info-title">{{ film.name }}</h2>
          <p class="buying__info-start">Начало сеанса: {{ session.start_time }}</p>
          <p class="buying__info-hall">Зал {{ hall.hall_number }}</p>          
        </div>
        <div class="buying__info-hint">
          <p>Тапните дважды,<br>чтобы увеличить</p>
        </div>
      </div>
      <div class="buying-scheme">
        <div class="buying-scheme__wrapper">
            <div class="buying-scheme__row"
                v-for="i in hall.rows_count"
                :key="i"
            >
                <span
                    :class="chairType(i, j)"
                    v-for="j in hall.seats_in_row_count"
                    :key="j"
                    @click="onSelectChair(i, j)"
                ></span>
            </div>  
        </div>
        <div class="buying-scheme__legend">
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value">250</span>руб)</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value">350</span>руб)</p>            
          </div>
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>                    
          </div>
        </div>
      </div>
      <button class="acceptin-button" @click="onReserveClick" >Забронировать</button>
    </section>     
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import apiRequest from '@/axios.js';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const sessionId = route.params.sessionId;

const session = ref({});
const film = ref({});
const hall = ref({});
const selectedChairs = ref([]);

onMounted(async () => {
    try {
        const response = await apiRequest.get(`/sessions/${sessionId}`);
        session.value = response.data.session;
        film.value = response.data.session.film;
        hall.value = response.data.session.hall;
        session.value.start_time = session.value.start_time.split(':').slice(0, 2).join(':');
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
});

const chairType = ((i, j) => {
    let current = hall.value.seats.find(item => item.row_number === i && item.seat_number === j)
    if (current.is_free !== 1) {
        return 'buying-scheme__chair buying-scheme__chair_taken' 
    } else {
        if (selectedChairs.value.includes(current.id)) {
            return `buying-scheme__chair buying-scheme__chair_selected`
        }
        return `buying-scheme__chair buying-scheme__chair_${current.type}`
    }
});

const onSelectChair = ((i, j) => {
    let current = hall.value.seats.find(item => item.row_number === i && item.seat_number === j);
    if(selectedChairs.value.includes(current.id)) {
            selectedChairs.value = selectedChairs.value.filter(item => item !== current.id);
    } else {
        selectedChairs.value.push(current.id);
    }
    chairType(i, j);
});

const onReserveClick = (async () => {
  if (selectedChairs.value.length > 0) {
    try {
        const response = await apiRequest.put('/seats/' + selectedChairs.value.join(','), {
      })
        if (response.data.success) {
          router.push({ name: 'payment-client', params: { sessionId, seatsId: selectedChairs.value.join(',') } });
        }
    } catch (error) {
        console.error('Ошибка при бронировании:', error);
    }
  }
});
</script>