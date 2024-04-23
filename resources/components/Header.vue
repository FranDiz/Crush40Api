<template>
    <header class="header">
     <h1 class="header__logo">Crush40</h1>
      <div class="header__buttons">
        <RouterLink to="/login" class="button">Entrar</RouterLink>
        <RouterLink to="/register" class="button">Registrarse</RouterLink>
      </div>
    </header>
  </template>
  
  <script>
  import '../css/Header.css';
    import { RouterLink } from 'vue-router';
  export default {
    components: {RouterLink },
  }
  </script>
  
  <style scoped>
  
  
  </style>
  
  