<template>
  <section class="album">
    <div class="album__info">
      <img v-if="product" :src="product.images[0].url" alt="album cover" class="album__cover">
      <h2 v-if="product" class="album__title">{{ product.name }}</h2>
    </div>
    <ul v-if="product" class="album__list">
      <li v-for="item in product.tracks.items" :key="item.id" class="album__item">
        {{ item.name }} - {{ songDuration(item.duration_ms) }}
        <nav  >
          <button @click="addFavorites(item.id)">+ Favoritos</button>
            <button>+ Playlist</button>
        </nav>
      </li>
    </ul>
    <ul v-else class="album__loading">
      <li>Cargando...</li>
    </ul>
  </section>
</template>

<script>
import axios from 'axios';  
import { mapState } from 'vuex';
import '../css/AlbumSongs.css'

export default {
  props: {
    albumId: {
      type: String,
      required: true
    }
  },

  data() {
    return {
      product: null
    };
  },

  computed: {
    ...mapState({
      userId: state => state.user.data.id  // Asumiendo que el ID del usuario está en state.user.data.id
    }),
    songDuration() {
      return function(duration_ms) {
        if (typeof duration_ms !== 'number') return '';
        const durationInSeconds = duration_ms / 1000;
        const minutes = Math.floor(durationInSeconds / 60);
        const seconds = Math.floor(durationInSeconds % 60);
        return `${minutes}:${seconds.toString().padStart(2, '0')}`;
      };
    }
  },

  mounted() {
    this.getSongs();
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

    addFavorites(trackId) {
      axios.post('/api/favorites/addFavorite', {
        userId: this.userId,  // Usando el ID del usuario desde la store
        favoriteId: trackId   // El ID de la pista que se va a favoritos
      }).then(response => {
        console.log('Favorite added!', response.data);
      }).catch(error => {
        console.error('Error adding favorite:', error);
      });
    }
  }
}
</script>
