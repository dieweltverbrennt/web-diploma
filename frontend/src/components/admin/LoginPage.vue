<template>
    <section class="login">
      <header class="login__header">
        <h2 class="login__title">Авторизация</h2>
      </header>
      <div class="login__wrapper">
        <form class="login__form" accept-charset="utf-8">
          <label class="login__label" for="email">
            E-mail
            <input class="login__input" type="email" placeholder="example@domain.xyz" name="email" required v-model="emailValue">
          </label>
          <label class="login__label" for="pwd">
            Пароль
            <input class="login__input" type="password" placeholder="" name="password" autocomplete="on" required v-model="passwordValue">
          </label>
          <div class="text-center">
            <input value="Авторизоваться"  @click="onClick" type="submit" class="login__button">
          </div>
        </form>
      </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import apiRequest from '@/axios.js';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const emailValue = ref('');
const passwordValue = ref('');

const setEmail = (value) => {
  emailValue.value = value;
};
const setPassword = (value) => {
  passwordValue.value = value;
};

const onClick = ( (e) => {
    e.preventDefault();
    apiRequest.post('/login', {
      email: emailValue.value,
      password: passwordValue.value,
      withCredentials: true
    }).then(response => {
      if(response.data.token) {
        localStorage.setItem('token', response.data.token);
        apiRequest.get('/access', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        }).then(response => {
          if(response.data.success) {
            router.push({ name: 'redactor-admin' });
          }
        })
      } else {
        console.error('Неверный логин или пароль')
      }
    })
});
</script>
