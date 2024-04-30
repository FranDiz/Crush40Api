<template>
  <header class="header">
    <h1 class="header__logo">Crush40</h1>
    <div class="header__buttons">
      <!-- Mostrar botones de login/register si no hay usuario logueado -->
      <template v-if="!isLoggedIn">
        <RouterLink to="/login" class="button">Entrar</RouterLink>
        <RouterLink to="/register" class="button">Registrarse</RouterLink>
      </template>
      <!-- Mostrar botones de perfil/cerrar sesión si hay usuario logueado -->
      <template v-else>
        <RouterLink to="/profile" class="button">Perfil</RouterLink>
        <button @click="logout" class="button">Cerrar sesión</button>
      </template>
    </div>
  </header>
</template>

<script>
import '../css/Header.css';
import { RouterLink } from 'vue-router';

export default {
  components: { RouterLink },
  data() {
    return {
      isLoggedIn: false, // Inicialmente no hay usuario logueado
    };
  },
  mounted() {
    // Verificar si hay un token de autenticación en el localStorage
    const token = localStorage.getItem('token');
    if (token) {
      this.isLoggedIn = true; // Si hay token, entonces hay un usuario logueado
    }
  },
  methods:{
    logout() {
    console.log("a")
  fetch('/logout', {
    method: 'POST',
    headers: {
      'Authorization': 'Bearer ' + localStorage.getItem('token') // Also added a space after 'Bearer'
    },
  })
  .then(() => {
    localStorage.removeItem('token');
    this.$router.push({name:'Login'});
  })
  .catch((error) => { // Removed extra parenthesis
    console.error('Error al cerrar sesión', error);
  });
  this.isLoggedIn = false; // Update the login state
}
  }
};
</script>