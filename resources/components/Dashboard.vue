<template>
  <nav class="dashboard" v-show="showDashboard">
    <h1 v-if="user" class="dashboard__welcome">Bienvenido, {{ user.name }}</h1>
    <h1 v-else class="dashboard__welcome">Bienvenido</h1>
    <ul class="dashboard__links">
      <router-link to="/search" class="dashboard__link">Inicio</router-link>
      <router-link to="/categories" class="dashboard__link">Explorar por categorías</router-link>
      <router-link to="/playlists" class="dashboard__link">Playlists</router-link>
      <router-link to="/contact" class="dashboard__link">Contacto</router-link>
      <router-link to="/" class="dashboard__link">¿Qué es Crush40?</router-link>
    </ul>
  </nav>
  <button class="toggle-button" @click="toggleDashboard">Mostrar/Ocultar Dashboard</button>
</template>

<script>
import '../css/Dashboard.css';

export default {
  name: 'Dashboard',
  data() {
    return {
      showDashboard: false, // Initially hidden
      user: null,
    };
  },
  computed: {
    isLoggedIn() {
      return this.user !== null; // Reactive check for user existence
    },
  },
  methods: {
    toggleDashboard() {
      this.showDashboard = !this.showDashboard;
      localStorage.setItem('showDashboard', this.showDashboard);
    },
    checkWidth() {
      // Responsive behavior can be implemented here (optional)
    },
    async fetchUser() {
      try {
        const response = await fetch('api/user', {
          method: 'GET',
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token'),
          },
        });

        if (!response.ok) {
          throw new Error('Respuesta de autenticación fallida: ' + response.status);
        }

        const data = await response.json();
        this.user = data;
      } catch (error) {
        console.error('Error al cargar los datos', error);
      }
    },
  },
  mounted() {
    window.addEventListener('resize', this.checkWidth);
    this.checkWidth(); // Check initial width
    
    const storedShowDashboard = localStorage.getItem('showDashboard');
    if (storedShowDashboard !== null) {
      this.showDashboard = storedShowDashboard === 'true';
    }

    this.fetchUser(); // Fetch user data on mount
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkWidth);
  },
};
</script>