<template>
  <div class="client">
    <header class="page-header">
      <h1 class="page-header__title">Идём<span>в</span>кино</h1>
    </header>

    <router-view/>
  </div>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'ClientView',
  components: {
  }
}
</script>

<style>
@import '@/assets/client/normalize.css';
@import '@/assets/client/styles.css';
</style>
