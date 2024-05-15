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
      showDashboard: false, // Comenzar oculto
    };
  },
  methods: {
    toggleDashboard() {
      this.showDashboard = !this.showDashboard; // Cambia la visibilidad al hacer clic
    },
    checkWidth() {
      if (window.innerWidth >= 768) {
        this.showDashboard = true;
      } else {
        this.showDashboard = false;
      }
    }
  },
  mounted() {
    window.addEventListener('resize', this.checkWidth);
    this.checkWidth(); // Asegura que se muestre u oculte según el ancho al cargar
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkWidth);
  }
}
</script>
