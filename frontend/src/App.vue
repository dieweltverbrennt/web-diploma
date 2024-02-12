<template>
  <div>
    <router-view/>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  setup() {
    // const data = ref([]);

    // const fetchData = async () => {
    //   const apiUrl = 'http://localhost:8080/api/halls';
    //   const headers = {
    //     'Content-Type': 'application/json',
    //   };
    //   try {
    //     const response = await axios.get(apiUrl, { headers });
    //     data.value = response.data;
    //     console.log(response);
    //   } catch (error) {
    //     console.error('Error fetching data:', error);
    //   }
    // };

    // onMounted(() => {
    //   fetchData();
    // });

    // return {
    //   data
    // };
  },
}
</script>

<style lang="scss">
</style>
