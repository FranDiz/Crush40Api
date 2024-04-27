<template>
  <nav class="dashboard" v-show="showDashboard">
    <h1 class="dashboard__welcome">Bienvenido</h1>
    <ul class="dashboard__links">
      <router-link to="/" class="dashboard__link">Inicio</router-link>
      <router-link to="/categories" class="dashboard__link">Explorar por categorías</router-link>
      <router-link to="/playlists" class="dashboard__link">Playlists</router-link>
      <router-link to="/contact" class="dashboard__link">Contacto</router-link>
      <router-link to="/about" class="dashboard__link">¿Qué es Crush40?</router-link>
    </ul> 
  </nav>
</template>

<script>
import '../css/Dashboard.css';

export default {
  name: 'Dashboard',
  data() {
    return {
      showDashboard: true, // Se muestra por defecto
    };
  },
  methods: {
    toggleDashboard() {
      this.showDashboard = !this.showDashboard; // Cambia la visibilidad al hacer clic
    },
    checkWidth() {
      // Esto ahora asegura que el Dashboard siempre se muestre
      // porque antes lo ocultaba en pantallas menores de 768px.
      this.showDashboard = true; 
    }
  },
  mounted() {
    window.addEventListener('resize', this.checkWidth);
    this.checkWidth(); // Asegura que se muestre al cargar
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkWidth);
  }
}
</script>

<style scoped>

</style>