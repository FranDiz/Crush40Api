<template>
  <section class="album">
    <div class="album__info">
      <img v-if="product" :src="product.images[0].url" alt="album cover" class="album__cover">
      <h2 v-if="product" class="album__title">{{ product.name }}</h2>
    </div>
    <ul v-if="product" class="album__list">
      <li v-for="item in product.tracks.items" :key="item.id" class="album__item">
        {{ item.name }} - {{ songDuration(item.duration_ms) }}
        <nav>
          <button v-if="isFavorite(item.id)" @click="deleteFavorites(item.id)">- Favoritos</button>
          <button v-else @click="addFavorites(item.id)">+ Favoritos</button>
          <button @click="openModal(item.id)">+ Playlist</button>
          <button>
            <a :href="item.external_urls.spotify" target="_blank">Escuchar en Spotify</a>
          </button>
        </nav>
      </li>
    </ul>
    <ul v-else class="album__loading">
      <li>Cargando...</li>
    </ul>
    <PlaylistModal v-if="modalTrackId" :show="showModal" :trackId="modalTrackId" @close="closeModal" />
  </section>
</template>

<script>
import axios from 'axios';
import PlaylistModal from './PlaylistModal.vue';
import '../css/AlbumSongs.css';

export default {
  components: {
    PlaylistModal
  },
  props: {
    albumId: {
      type: String,
      required: true
    }
  },

  data() {
    return {
      product: null,
      favorites: [],
      user: null,
      showModal: false,
      modalTrackId: null
    };
  },
  
  computed: {
    songDuration() {
      return function (duration_ms) {
        if (typeof duration_ms !== 'number') return '';
        const durationInSeconds = duration_ms / 1000;
        const minutes = Math.floor(durationInSeconds / 60);
        const seconds = Math.floor(durationInSeconds % 60);
        return `${minutes}:${seconds.toString().padStart(2, '0')}`;
      };
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

    this.getSongs();
    this.saveSongs();
  },

  methods: {
    getSongs() {
      axios.get('/api/spotify/getAlbumTracks', {
        params: {
          albumId: this.albumId
        }
      }).then(response => {
        this.product = response.data;
      }).catch(error => {
        console.error('Error fetching album tracks:', error);
      });
    },

    saveSongs() {
      axios.post('/api/spotify/saveAlbumTracks', {
        albumId: this.albumId
      }).then(response => {
        console.log('Tracks saved to database:', response.data);
      }).catch(error => {
        console.error('Error saving tracks:', error);
      });
    },
    fetchFavorites(userId) {
      fetch(`/api/favorites/getUserFavorites?userId=${userId}`, {
        method: 'GET',
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token'),
        },
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Error al obtener favoritos: ' + response.status);
          }
          return response.json();
        })
        .then(data => {
          this.favorites = data;
          console.log(this.favorites);
        })
        .catch(error => {
          console.error('Error al cargar los favoritos', error);
        });
    },
    isFavorite(trackId) {
      return this.favorites.some(favorite => favorite.id === trackId);
    },
    addFavorites(trackId) {
      axios.post('/api/favorites/addFavorite', {
        userId: this.user.id,
        favoriteId: trackId
      }).then(response => {
        console.log('Favorite added!', response.data);
        this.fetchFavorites(this.user.id);
      }).catch(error => {
        console.error('Error adding favorite:', error);
      });
    },
    deleteFavorites(trackId) {
      fetch(`/api/favorites/deleteFavorite`, {
        method: 'DELETE',
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token'),
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          userId: this.user.id,
          favoriteId: trackId
        })
      })
      .then(response => {
        this.fetchFavorites(this.user.id);
      })
      .catch(error => {
        console.error('Error deleting favorite:', error);
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
  }
}
</script>
