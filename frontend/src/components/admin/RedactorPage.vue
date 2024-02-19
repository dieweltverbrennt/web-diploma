<template>
    <main class="conf-steps">
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened" @click="halls = !halls">
        <h2 class="conf-step__title">Управление залами</h2>
      </header>
      <div class="conf-step__wrapper" v-if="halls">
        <p class="conf-step__paragraph">Доступные залы:</p>
        <ul class="conf-step__list">
          <li v-for="(item, index) in hallsDataNew" :key="index">Зал {{ item.hall_number }}
            <button class="conf-step__button conf-step__button-trash" @click="deleteHall(item.id)"></button>
          </li>
        </ul>
        <button class="conf-step__button conf-step__button-accent" @click="createNewHall">Создать зал</button>
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened" @click="hallConf = !hallConf">
        <h2 class="conf-step__title">Конфигурация залов</h2>
      </header>
      <div class="conf-step__wrapper" v-if="hallConf">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">
          <li v-for="(item, index) in hallsDataNew" :key="index">
            <input type="radio" class="conf-step__radio" name="chairs-hall" :value="item.hall_number" v-model="selectedHall"><span class="conf-step__selector">Зал {{ item.hall_number }}</span>
          </li>
        </ul>
        <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
        <div class="conf-step__legend">
          <label class="conf-step__label">Рядов, шт<input type="number" class="conf-step__input" v-if="currentHall" :placeholder="currentHall.rows_count" v-model="currentHall.rows_count"></label>
          <span class="multiplier">x</span>
          <label class="conf-step__label">Мест, шт<input type="number" class="conf-step__input" v-if="currentHall" :placeholder="currentHall.seats_in_row_count" v-model="currentHall.seats_in_row_count"></label>
        </div>
        <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
        <div class="conf-step__legend">
          <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
          <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
          <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
          <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
        </div>  
        
        <div class="conf-step__hall">
          <div class="conf-step__hall-wrapper" v-if="currentHall">
            <div class="conf-step__row" v-for="(item, index) in currentHall.rows_count" :key="index">
              <span :class="chairType(item, item_num)" class="conf-step__chair" v-for="(item_num, index) in currentHall.seats_in_row_count" :key="index" @click="changeChairType(item, item_num)"></span>
            </div> 

            
          </div>  
        </div>
        
        <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular" @click="resetHallsChanges">Отмена</button>
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" @click.prevent="saveHallsChanges">
        </fieldset>                 
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened" @click="prices = !prices">
        <h2 class="conf-step__title">Конфигурация цен</h2>
      </header>
      <div class="conf-step__wrapper" v-if="prices">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">
          <li v-for="(item, index) in hallsDataNew" :key="index">
            <input type="radio" class="conf-step__radio" name="prices-hall" :value="item.hall_number" v-model="selectedHallPrices"><span class="conf-step__selector">Зал {{ item.hall_number }}</span>
          </li>
        </ul>
          
        <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="number" min="0" class="conf-step__input" placeholder="0" v-model="newStandartPrices[selectedHallPrices]"></label>
            за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
          </div>  
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="number" class="conf-step__input" placeholder="0" v-model="newVipPrices[selectedHallPrices]"></label>
            за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
          </div>  
        
        <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular" @click="resetPriceChanges">Отмена</button>
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" @click.prevent="savePriceChanges"> 
        </fieldset>  
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened" @click="sessions = !sessions">
        <h2 class="conf-step__title">Сетка сеансов</h2>
      </header>
      <div class="conf-step__wrapper" v-if="sessions">
        <p class="conf-step__paragraph">
          <button class="conf-step__button conf-step__button-accent" @click="openCreateModal">Добавить фильм</button>
        </p>

        <CreateModal v-if="isOpenCreateModal" @closeCreateModal="isOpenCreateModal = false" @addFilm="addFilm"/>

        <div class="conf-step__movies">
          <div class="conf-step__movie" v-for="(item, index) in filmsData" :key="index" @click="openRedactModal(item)">
            <img class="conf-step__movie-poster" alt="poster" :src="item.path_to_image">
            <h3 class="conf-step__movie-title">{{ item.name }}</h3>
            <p class="conf-step__movie-duration">{{ item.duration }}</p>
          </div>
        </div>

        <RedactModal v-if="isOpenRedactModal" @closeRedactModal="isOpenRedactModal = false" :film="selectedFilm" :halls="hallsData" :newSessions="newSessions" @deleteSession="deleteSession" @addSession="addSession"/>
 
        <div class="conf-step__seances">

          <div class="conf-step__seances-hall" v-for="(item, index) in hallsData" :key="index">
            <h3 class="conf-step__seances-title">Зал {{ item.hall_number }}</h3>

            <div class="conf-step__seances-timeline">
              <div v-for="(el, i) in item.sessions" :key="i">
                <div class="conf-step__seances-movie" v-if="!sessionsToDelete.includes(el.id)" :style="sessionStyle(el)">
                  <p class="conf-step__seances-movie-title">{{ el.film.name }}</p>
                  <p class="conf-step__seances-movie-start">{{ el.start_time.split(':').slice(0, 2).join(':') }}</p>
                </div>
              </div>

              <div v-for="(el, i) in newSessions" :key="i">
                <div v-if="el.hallId === item.id" class="conf-step__seances-movie" :style="newSessionStyle(el)">
                  <p class="conf-step__seances-movie-title">{{ el.filmName }}</p>
                  <p class="conf-step__seances-movie-start">{{ el.start }}</p>
                </div>
              </div>

            </div>
          </div>
        </div>
        
        <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular" @click="resetSessionsChanges">Отмена</button>
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" @click.prevent="saveSessionsChanges">
        </fieldset>  
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened" @click="sale = !sale">
        <h2 class="conf-step__title">Открыть продажи</h2>
      </header>
      <div class="conf-step__wrapper text-center" v-if="sale">
        <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
        <button v-if="isActiveHalls" class="conf-step__button conf-step__button-accent" @click="openSales">Открыть продажу билетов</button>
        <button v-else class="conf-step__button conf-step__button-accent" @click="closeSales">Приостановить продажу билетов</button>
      </div>
    </section>    
  </main>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import apiRequest from '@/axios.js';
import CreateModal from '@/components/admin/redactor/ModalCreate.vue';
import RedactModal from '@/components/admin/redactor/ModalRedact.vue';
// Управление вкладками
const halls = ref(false);
const hallConf = ref(false);
const prices = ref(false);
const sessions = ref(true);
const sale = ref(false);
// Управление ценами на места
const selectedHallPrices = ref(null);
const standartPrices = ref({});
const vipPrices = ref({});
const newStandartPrices = ref({});
const newVipPrices = ref({});
// Данные кинозалов
const hallsData = ref([]);
const hallsDataNew = ref([]);
const selectedHall = ref(null);
const seatsChanges = ref([]);
const changedSeatsIds = ref([]);
const newSeats = ref([]);
const deletedSeats = ref([]);
const currentHall = computed(() => {
    if(hallsDataNew.value.length > 0) {
        const current = hallsDataNew.value.find(item => item.hall_number === selectedHall.value);
        return current;
    }
});
// Данные фильмов
const filmsData = ref({});
const sessionStyle = (item) => {
  const timeStart = item.start_time.split(':');
  const startH = timeStart[0] * 30;
  const startM = timeStart[1] * 2;
  const duration = parseInt(item.film.duration.split(' ')[0]) / 2;
  return `width: ${duration}px; background-color: rgb(133, 255, 137); left: ${startH + startM}px;`;
};
const newSessionStyle = (item) => {
  const timeStart = item.start.split(':');
  const startH = parseInt(timeStart[0]) * 30;
  const startM = parseInt(timeStart[1]) * 2;
  return `width: ${item.duration}px; background-color: #85ffd3; left: ${startH + startM}px;`;
}
const isOpenCreateModal = ref(false);
const isOpenRedactModal = ref(false);
const selectedFilm = ref(null);
// Данные сеансов
const sessionsToDelete = ref([]);
const newSessions = ref([]);
// Активны ли залы
const isActiveHalls = computed(() => {
  const notActive = hallsData.value.find(item => item.is_active === 0);
  if(notActive) {
    return true;
  }
  return false;
});

onMounted(async () => {
    try {
        const response = await apiRequest.get(`/halls`);
        hallsData.value = response.data.halls;
        hallsDataNew.value = JSON.parse(JSON.stringify(hallsData.value));
        selectedHall.value = 1;
        selectedHallPrices.value = 1;
        hallsData.value.forEach(item => {
          if(item.seats.find(item => item.type === 'standart')) {
            standartPrices.value[item.hall_number] = item.seats.find(item => item.type === 'standart').price;
            newStandartPrices.value[item.hall_number] = item.seats.find(item => item.type === 'standart').price;
          } else {
            standartPrices.value[item.hall_number] = 0;
            newStandartPrices.value[item.hall_number] = 0;
          }
          if(item.seats.find(item => item.type === 'vip')) {
            vipPrices.value[item.hall_number] = item.seats.find(item => item.type === 'vip').price;
            newVipPrices.value[item.hall_number] = item.seats.find(item => item.type === 'vip').price;
          } else {
            vipPrices.value[item.hall_number] = 0;
            newVipPrices.value[item.hall_number] = 0;
          }
        })
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }

    try {
      const response = await apiRequest.get(`/films`);
      filmsData.value = response.data.films;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
});

// Конфигурации кинозалов
const createNewHall = async () => {
    try {
        const response = await apiRequest.post(`/halls`, {
            hall_number: null,
            rows_count: null,
            seats_in_row_count: null,
            seat_count: null
        });
        hallsData.value = response.data.halls;
        hallsDataNew.value = JSON.parse(JSON.stringify(hallsData.value));
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};
const deleteHall = async (id) => {
    try {
        const response = await apiRequest.post(`/halls/${id}`, {
            _method: 'DELETE'
        });
        hallsData.value = response.data.halls;
        hallsDataNew.value = JSON.parse(JSON.stringify(hallsData.value));
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};
const chairType = (row, seat) => {
  const current = currentHall.value.seats.find(item => item.row_number === row && item.seat_number == seat);
  if(current === undefined) {
    currentHall.value.seats.push({ row_number: row, seat_number: seat, type: 'standart', hall_id: currentHall.value.id });
    newSeats.value.push({ row_number: row, seat_number: seat, type: 'standart', hall_id: currentHall.value.id });
    return 'conf-step__chair_standart';
  }
  return 'conf-step__chair_' + current.type;
};
const changeChairType = (row, seat) => {
  const current = currentHall.value.seats.find(item => item.row_number === row && item.seat_number == seat);
  if(current.type === 'standart') {
    current.type = 'vip';
  } else if (current.type === 'vip') {
    current.type = 'disabled';
  } else {
    current.type = 'standart';
  }
  if(current.id) {
    changedSeatsIds.value = changedSeatsIds.value.filter(item => item !== current.id)
    changedSeatsIds.value.push(current.id);
    seatsChanges.value = seatsChanges.value.filter(item => item.id !== current.id);
    seatsChanges.value.push({ id: current.id, type: current.type });
  } else {
    const newCurrentSeat = newSeats.value.find(item => item.row_number === row && item.seat_number == seat);
    newCurrentSeat.type = current.type;
  }
};
const resetHallsChanges = () => {
  hallsDataNew.value = hallsData.value;
};
const saveHallsChanges = async () => {
  const initialData = hallsData.value.find(item => item.id === currentHall.value.id);
  // если количество рядов уменьшилось, записываем в массив лишние места
  if(initialData.rows_count > currentHall.value.rows_count) {
    currentHall.value.seats.forEach(item => {
      if(item.row_number >  currentHall.value.rows_count) {
        deletedSeats.value.push(item.id);
      }
    });
  } 
  // если количество сидений в ряду уменьшилось, записываем в массив лишние места
  if(initialData.seats_in_row_count > currentHall.value.seats_in_row_count) {
    currentHall.value.seats.forEach(item => {
      if(item.seat_number > currentHall.value.seats_in_row_count)
        deletedSeats.value.push(item.id);
    })
  }
  // проверяем, если есть удаленные места то удаляем их
  if(deletedSeats.value.length > 0) {
    try {
        const response = await apiRequest.post(`/seats/${deletedSeats.value.join(',')}`, {
            _method: 'DELETE'
        });
    } catch (error) {
        console.error('Ошибка при удалении данных:', error);
    }
  }
  // проверяем, если появились новые места, то добавляем их
  if(newSeats.value.length > 0) {
    try {
        const response = await apiRequest.post(`/seats`, {
            seats: newSeats.value
        });
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
  }
  // проверяем, если есть измененные типы мест и обновляем их
  if(seatsChanges.value.length > 0) {
    try {
        const response = await apiRequest.put(`/seats/${changedSeatsIds.value.join(',')}`, {
            seats: seatsChanges.value
        });
    } catch (error) {
        console.error('Ошибка при получении удалении:', error);
    }
  }
  // обновляем данные зала и получаем новый массив с обновленными местами
  try {
    const response = await apiRequest.put(`/halls/${currentHall.value.id}`, {
        rows: currentHall.value.rows_count,
        seats: currentHall.value.seats_in_row_count
    });
    hallsData.value = response.data.halls;
  } catch (error) {
    console.error('Ошибка при получении данных:', error);
  }
};
// Конфигурации цен
const resetPriceChanges = () => {
  newStandartPrices.value[selectedHallPrices.value] = standartPrices.value[selectedHallPrices.value];
  newVipPrices.value[selectedHallPrices.value] = vipPrices.value[selectedHallPrices.value];
};
const savePriceChanges = async () => {
  const hallId = hallsData.value.find(item => item.hall_number === selectedHallPrices.value).id;
  if(newStandartPrices.value[selectedHallPrices.value] !== standartPrices.value[selectedHallPrices.value]) {
    try {
        const response = await apiRequest.put(`/seats/${selectedHallPrices.value}`, {
            hall: hallId,
            price: newStandartPrices.value[selectedHallPrices.value],
            type: 'standart'
        });
        // hallsData.value.seats = response.data;
    } catch (error) {
        console.error('Ошибка при изменении цен:', error);
    }
  }
  if(newVipPrices.value[selectedHallPrices.value] !== vipPrices.value[selectedHallPrices.value]) {
    try {
        const response = await apiRequest.put(`/seats/${selectedHallPrices.value}`, {
            hall: hallId,
            price: newVipPrices.value[selectedHallPrices.value],
            type: 'vip'
        });
    } catch (error) {
        console.error('Ошибка при изменении цен:', error);
    }
  }
};
// Конфигурации сеансов
const openCreateModal = () => {
  isOpenCreateModal.value = true;
};
const openRedactModal = (item) => {
  selectedFilm.value = item;
  isOpenRedactModal.value = true;
};
const addFilm = async (film) => {
  try {
    const formData = new FormData();
    formData.append('name', film.name);
    formData.append('description', film.description);
    formData.append('productionCountry', film.productionCountry);
    formData.append('duration', film.duration);
    formData.append('poster', film.poster);
    const response = await apiRequest.post(`/films`, formData, {
        headers:{
          'Content-Type': 'multipart/form-data'
        },
    });
    filmsData.value = response.data.films;
  } catch (error) {
    console.error('Ошибка при создании фильма:', error);
  }
};
const deleteSession = (item) => {
  if(typeof(item) === 'number') {
    sessionsToDelete.value.push(item);
  } else {
    newSessions.value.forEach((el, index) => {
      if(el.start === item.start && el.end === item.end && el.filmId === item.filmId && el.hallId === item.hallId) {
         newSessions.value.splice(index, 1);
      }
    });
  }
};
const addSession = (props) => {
  newSessions.value.push(props);
};
const resetSessionsChanges = async () => {
  sessionsToDelete.value = [];
  newSessions.value = [];
};
const saveSessionsChanges = async () => {
  if(sessionsToDelete.value.length > 0) {
    try {
        const response = await apiRequest.post(`/sessions/${sessionsToDelete.value.join(',')}`, {
            _method: 'DELETE'
        });
        hallsData.value = response.data.halls;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
  }
  // 
  if(newSessions.value.length > 0) {
    try {
        const response = await apiRequest.post(`/sessions`, {
          sessions: newSessions.value
        });
        hallsData.value = response.data.halls;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
  }
};
// Открытие продажи билетов - Смена статуса зала
const openSales = async () => {
  const closedHallsIds = [];
  hallsData.value.forEach(item => {
    if(item.is_active === 0) {
      closedHallsIds.push(item.id);
    }
  })
  try {
        const response = await apiRequest.put(`/halls/${closedHallsIds.join(',')}`, {
          isActive: 1
        });
        hallsData.value = response.data.halls;
        hallsDataNew.value = JSON.parse(JSON.stringify(hallsData.value));
    } catch (error) {
        console.error('Ошибка при открытии продаж', error);
    }
};
const closeSales = async () => {
  const openedHallsIds = [];
    hallsData.value.forEach(item => {
      openedHallsIds.push(item.id);
    })
    try {
        const response = await apiRequest.put(`/halls/${openedHallsIds.join(',')}`, {
          isActive: 0
        });
        hallsData.value = response.data.halls;
        hallsDataNew.value = JSON.parse(JSON.stringify(hallsData.value));
    } catch (error) {
        console.error('Ошибка при закрытии продаж', error);
    }
};
</script>
