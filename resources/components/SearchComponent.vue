<template>
  <form class="search-form" @submit.prevent="search">
    <select v-model="searchType" class="search-form__type">
      <option value="track">Canción</option>
      <option value="artist">Artista</option>
      <option value="album">Álbum</option>
    </select>
    <input class="search-form__input" type="text" v-model="query" placeholder="Buscar una canción" />
    <button type="submit" class="search-form__button">Buscar</button>
  </form>
  <ul v-if="results" class="search-results">
    <li v-for="result in results" :key="result.id" class="search-results__item">
      <template v-if="searchType === 'track' && result.album && result.album.images && result.album.images.length > 0">
        <router-link :to="`/product/${result.id}`" class="search-results__link">
          <img :src="result.album.images[0].url" alt="Portada del álbum" class="search-results__image" />
        </router-link>
        <span class="search-results__title">{{ result.name }} por {{ result.artists[0].name }}</span>
      </template>
      <template v-else-if="searchType === 'artist' && result.images && result.images.length > 0">
        <router-link :to="`/product/${result.id}`" class="search-results__link">
          <img :src="result.images[0].url" alt="Imagen del artista" class="search-results__image" />
        </router-link>
        <span class="search-results__title">{{ result.name }}</span>
      </template>
      <template v-else-if="searchType === 'album' && result.images && result.images.length > 0">
        <router-link :to="`/product/${result.id}`" class="search-results__link">
          <img :src="result.images[0].url" alt="Portada del álbum" class="search-results__image" />
        </router-link>
        <span class="search-results__title">{{ result.name }} de {{ result.artists[0].name }}</span>
      </template>
    </li>
  </ul>
</template>
  

<script>
import axios from 'axios'
import '../css/SearchComponent.css'
export default {
  data() {
    return {
      query: '',
      results: null,
      searchType: 'track'
    };
  },
  methods: {
    search() {
      if (!this.query) return;
      axios.get(`/spotify/search`, {
        params: {
          type: this.searchType,
          query: this.query
        }
      }).then(response => {
        switch (this.searchType) {
          case 'track':
            this.results = response.data.tracks.items;
            break;
          case 'artist':
            this.results = response.data.artists.items;
            break;
          case 'album':
            this.results = response.data.albums.items;
            break;
          default:
            this.results = [];
        }
      }).catch(error => {
        console.error('Search failed:', error);
      });
    }
  }
}
</script>


<style scoped>

</style>
