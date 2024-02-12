import axios from 'axios';

const apiRequest = axios.create({
    baseURL: 'http://localhost:8080/api',
    timeout: 100000, // Устанавливаем таймаут запроса (в миллисекундах)
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Credentials': true
      // Другие заголовки, если необходимо
    },
});

export default apiRequest;