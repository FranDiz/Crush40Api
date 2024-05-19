<template>
  <div>
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
          <div @click="openModal(result.id)" class="search-results__link">
            <img :src="result.album.images[0].url"  alt="Portada del álbum" class="search-results__image" />
          </div>
          <span class="search-results__title">{{ result.name }} por {{ result.artists[0].name }}</span>
        </template>
        <template v-else-if="searchType === 'artist' && result.images && result.images.length > 0">
          <router-link :to="`/product/${result.id}`" class="search-results__link">
            <img :src="result.images[0].url" alt="Imagen del artista" class="search-results__image" />
          </router-link>
          <span class="search-results__title">{{ result.name }}</span>
        </template>
        <template v-else-if="searchType === 'album' && result.images && result.images.length > 0">
          <router-link :to="`/album/${result.id}`" class="search-results__link">
            <img :src="result.images[0].url" alt="Portada del álbum" class="search-results__image" />
          </router-link>
          <span class="search-results__title">{{ result.name }} de {{ result.artists[0].name }}</span>
        </template>
      </li>
    </ul>
    <PlaylistModal v-if="modalTrackId" :show="showModal" :trackId="modalTrackId" @close="closeModal" />
  </div>
</template>
  
<script>
import axios from 'axios';
import '../css/SearchComponent.css';
import PlaylistModal from './PlaylistModal.vue';

export default {
  components: {
    PlaylistModal
  },
  data() {
    return {
      query: '',
      results: null,
      searchType: 'track',
      user: null,
      showModal: false,
      modalTrackId: null
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
            console.log(this.results);
            break;
          case 'artist':
            this.results = response.data.artists.items;
            break;
          case 'album':
            this.results = response.data.albums.items;
            console.log(this.results);
            break;
          default:
            this.results = [];
        }
      }).catch(error => {
        console.error('Search failed:', error);
      });
    },
    openModal(trackId) {
      this.modalTrackId = trackId;
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.modalTrackId = null;
    }
  },
  mounted() {
    axios.get('/api/user', {
      headers: {
        'Authorization': 'Bearer ' + localStorage.getItem('token')
      }
    })
      .then((response) => {
        this.user = response.data;
        this.fetchFavorites(this.user.id);
      })
      .catch((error) => {
        console.error('Error al cargar los datos del usuario', error);
        if (error.response) {
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
        } else if (error.request) {
          console.log(error.request);
        } else {
          console.log('Error', error.message);
        }
      });
  }
}
</script>
