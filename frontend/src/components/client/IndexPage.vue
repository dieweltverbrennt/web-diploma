<script setup>
import { ref, onMounted } from 'vue';
import apiRequest from '@/axios.js';
import Movie from '@/components/client/index/Movie.vue';

const filmsData = ref([]);

onMounted(async () => {
    try {
        const response = await apiRequest.get('/films');
        filmsData.value = response.data.films;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
});
</script>

<template>
    <div>
        <nav class="page-nav">
            <a class="page-nav__day page-nav__day_today" href="#">
                <span class="page-nav__day-week">Пн</span><span class="page-nav__day-number">31</span>
            </a>
            <a class="page-nav__day" href="#">
                <span class="page-nav__day-week">Вт</span><span class="page-nav__day-number">1</span>
            </a>
            <a class="page-nav__day page-nav__day_chosen" href="#">
                <span class="page-nav__day-week">Ср</span><span class="page-nav__day-number">2</span>
            </a>
            <a class="page-nav__day" href="#">
                <span class="page-nav__day-week">Чт</span><span class="page-nav__day-number">3</span>
            </a>
            <a class="page-nav__day" href="#">
                <span class="page-nav__day-week">Пт</span><span class="page-nav__day-number">4</span>
            </a>
            <a class="page-nav__day page-nav__day_weekend" href="#">
                <span class="page-nav__day-week">Сб</span><span class="page-nav__day-number">5</span>
            </a>
            <a class="page-nav__day page-nav__day_next" href="#">
            </a>
        </nav>

        <main>

            <Movie 
                v-for="(film) in filmsData" 
                :key="film.id"
                :film="film"
            />
        </main>
    </div>
</template>