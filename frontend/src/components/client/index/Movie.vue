<template>
    <section class="movie">
        <div class="movie__info">
            <div class="movie__poster">
                <img class="movie__poster-image" :alt="props.film.name" :src="props.film.path_to_image">
            </div>
            <div class="movie__description">
                <h2 class="movie__title">{{ props.film.name }}</h2>
                <p class="movie__synopsis">{{ props.film.description }}</p>
                <p class="movie__data">
                    <span class="movie__data-duration">{{ props.film.duration }}</span>
                    <span> | </span>
                    <span class="movie__data-origin">{{ props.film.production_country }}</span>
                </p>
            </div>
        </div>  

        <div class="movie-seances__hall" 
            v-for="hall in halls" 
            :key="hall.id"
        >
            <h3 class="movie-seances__hall-title">Зал {{ hall.hall_number}}</h3>
            <ul class="movie-seances__list">
                <li class="movie-seances__time-block"
                    v-for="session in filteredSessions(hall)" 
                    :key="session.id"
                >
                    <router-link class="movie-seances__time" 
                        :to="{ name: 'hall-client', params: { sessionId: session.id } }"
                    >
                        {{ session.start_time.split(':').slice(0, 2).join(':') }}
                    </router-link>
                </li>
            </ul>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, defineProps, computed } from 'vue';
import apiRequest from '@/axios.js';

const props = defineProps({
    film: {
        type: Object,
    }
});

const halls = ref([]);

// название картинки к фильму берется из БД, а хранятся они в папке assets
// const srcToImg = ref(require(`@/assets/client/img/${props.film.path_to_image}`));

onMounted(async () => {
    try {
        const response = await apiRequest.get('/halls');
        // фильтруем залы, в которых показывает только данный фильм
        halls.value = response.data.halls.filter(hall => {
           return hall.is_active && hall.sessions.some(session => session.film_id === props.film.id);
        })
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
});

// фильтруем сеансы для данного фильма
const filteredSessions = (hall) => {
  return hall.sessions.filter(session => session.film_id === props.film.id);
};
</script>