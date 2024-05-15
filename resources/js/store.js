import { createStore } from 'vuex';
import axios from 'axios';  // Asegúrate de tener axios instalado para hacer llamadas HTTP

// Crear un nuevo store
const store = createStore({
  state() {
    return {
      user: {
        loggedIn: !!localStorage.getItem('token'),  // Inicializa loggedIn según si hay un token
        data: null
      }
    };
  },
  mutations: {
    setLoggedIn(state, value) {
      state.user.loggedIn = value;
    },
    setUser(state, data) {
      state.user.data = data;
    }
  },
  actions: {
    initializeUser({ commit }) {
      const token = localStorage.getItem('token');
      if (token) {
        axios.get('/api/user', {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        })
        .then(response => {
          commit('setLoggedIn', true);
          commit('setUser', response.data);
          console.log('User data:', response.data);
        })
        .catch(() => {
          localStorage.removeItem('token');  // En caso de error, eliminar el token si no es válido
          commit('setLoggedIn', false);
          commit('setUser', null);
        });
      } else {
        commit('setLoggedIn', false);
        commit('setUser', null);
      }
    }
  },
  getters: {
    user: state => state.user
  }
});

export default store;
