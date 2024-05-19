<template>
    <section class="error-page">
      <h1 class="error-page__title">404</h1>
      <a target="_blank"><div class="box"><div class="elem"></div></div></a>
      <p class="error-page__message">No hemos podido encontrar la página que estás buscando.</p>
      <RouterLink to="/" class="error-page__button">Volver a la página principal</RouterLink>
    </section>
  </template>
  
  <script>
  import '../css/disc.css'
  export default {
    name: 'ErrorPage'
  };
  </script>
  
  <style scoped>
  .error-page {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content:first baseline;
    height: 100vh;
    text-align: center;
    color: #333;
    padding: 20px;
  }
  .error-page__title {
    font-size: 2.5em;
    margin-bottom: 20px;
  }
  .error-page__message {
    font-size: 1.2em;
    margin-bottom: 30px;
  }
  .error-page__button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
  }
  .error-page__button:hover {
    background-color: #0056b3;
  }
  </style>
  