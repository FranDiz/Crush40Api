<template>
  <form class="form__container" @submit.prevent="search">
    <input class="form__search-input" type="text" v-model="query" placeholder="Explorar por categoría" @input="search" />
  </form>
  <ul class="results__categories">
    <router-link :to="`/category/${category.id}`" v-for="category in filteredCategories" :key="category.id" class="category__container">
      <img :src="category.icons[0].url" :alt="category.name" class="category__img" />
      <span class="category__name">{{ category.name }}</span>
    </router-link>
  </ul>
</template>
  
  <script>
  import '../css/CategoryExplorer.css';
  
  export default {
    data() {
      return {
        categories: [],
        filteredCategories: [],
        token: '',
        CLIENT_ID: 'b94ff936eb4b484397fabf9f5822d61d',
        CLIENT_SECRET: '23237797c4354eae8b699e6691d8efa2',
        query: ''
      };
    },
  
    mounted() {
      this.fetchToken()
        .then(token => {
          this.token = token;
          this.fetchCategories();
        })
        .catch(error => {
          console.error('Error fetching token:', error);
        });
    },
  
    methods: {
      async fetchToken() {
        let parametrosAutor = {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'grant_type=client_credentials&client_id=' + this.CLIENT_ID + '&client_secret=' + this.CLIENT_SECRET
        };
        try {
          const response = await fetch('https://accounts.spotify.com/api/token', parametrosAutor);
          const data = await response.json();
          this.token = data.access_token;
          return this.token;
        } catch (error) {
          console.error('Failed to fetch token:', error);
        }
      },
  
      async fetchCategories() {
        let allCategories = [];
        let offset = 0;
        const limit = 50; // Definir el límite por página
        try {
          // Realizar solicitudes de paginación hasta que todas las categorías hayan sido obtenidas
          while (true) {
            const response = await fetch(`https://api.spotify.com/v1/browse/categories?limit=${limit}&offset=${offset}`, {
              headers: {
                Authorization: 'Bearer ' + this.token,
              },
            });
            const data = await response.json();
            const fetchedCategories = data.categories.items;
            allCategories = [...allCategories, ...fetchedCategories];
            // Si el número de categorías obtenidas es menor que el límite por página, hemos alcanzado el final
            if (fetchedCategories.length < limit) {
              break;
            }
            offset += limit; // Incrementar el offset para la próxima solicitud de paginación
          }
          this.categories = allCategories;
          this.filteredCategories = [...this.categories];
        } catch (error) {
          console.error('Failed to fetch music categories:', error);
        }
      },
  
      search() {
        const query = this.query.toLowerCase();
        if (query.trim() === '') {
          this.filteredCategories = [...this.categories]; // If the query is empty, show all categories
        } else {
          this.filteredCategories = this.categories.filter(category => {
            return category.name.toLowerCase().includes(query); // Filter categories whose name includes the search query
          });
        }
      }
    }
  };
  </script>
  
  <style>
  </style>
  