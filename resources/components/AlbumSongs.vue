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
          <button>+ Playlist</button>
          <button>
            <a :href="item.external_urls.spotify" target="_blank">Escuchar en Spotify</a>
          </button>
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
      product: null,
      favorites: [],
      user: null  // Añadir el usuario al estado local del componente
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
        // Adicionalmente puedes manejar errores específicos del estado HTTP si es necesario:
        if (error.response) {
          // La solicitud fue hecha y el servidor respondió con un código de estado
          // que cae fuera del rango de 2xx
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
        } else if (error.request) {
          // La solicitud fue hecha pero no se recibió respuesta
          console.log(error.request);
        } else {
          // Algo más causó un error en la solicitud
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
        albumId: this.albumId  // Usar data en lugar de params para enviar datos en POST
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
          this.favorites = data
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
        userId: this.user.id,  // Usando el ID del usuario desde el estado local
        favoriteId: trackId
      }).then(response => {
        console.log('Favorite added!', response.data);
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
  },

    addPlaylist() {
      console.log(this.user);
    }

  }
}
</script>
