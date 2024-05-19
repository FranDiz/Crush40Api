<template>
  <div v-if="show" class="modal-overlay" @click.self="closeModal">
    <div class="playlist-modal">
      <h3 class="playlist-modal__title">Agregar a Playlist</h3>
      <ul class="playlist-modal__list">
        <li @click="addSongToPlaylist(playlist.id, trackId)" v-for="playlist in playlists" :key="playlist.id" class="playlist-modal__item">
          {{ playlist.title }}
        </li>
      </ul>
      <p v-if="errorMessage" class="playlist-modal__error">{{ errorMessage }}</p>
      <button class="playlist-modal__close-btn" @click="closeModal">Cerrar</button>
    </div>
  </div>
</template>


<script>
import '../css/PlaylistModal.css';
export default {
  props: {
    show: {
      type: Boolean,
      required: true
    },
    trackId: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      user: null,
      playlists: [],
      errorMessage: null
    }
  },
  mounted() {
    this.getUser();
  },
  methods: {
    getUser() {
      axios.get('/api/user', {
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
      })
        .then((response) => {
          this.user = response.data;
          this.getUserPlaylists(this.user.id);
          console.log(this.user.id);
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
    },
    getUserPlaylists(userId) {
      axios.get('/api/getUserPlaylists', {
        params: {
          user_id: userId
        }
      }).then(response => {
        this.playlists = response.data;
        console.log(this.playlists);
      }).catch(error => {
        console.error('Error al obtener las playlists del usuario:', error);
      });
    },
    closeModal() {
      this.$emit('close');
    },
    addSongToPlaylist(playlistId, trackId) {
      axios.post(`http://127.0.0.1:8000/api/addSongToPlaylist`, {
        playlistId: playlistId,
        cancionId: trackId
      })
      .then(response => {
        console.log(response.data);
        this.errorMessage = null;  // Resetea el mensaje de error si la solicitud es exitosa
        this.closeModal();  // Cierra el modal después de añadir la canción
      })
      .catch(error => {
        console.error('Error al agregar la canción a la playlist:', error);
        if (error.response && error.response.status === 500) {
          this.errorMessage = 'La canción ya está añadida a la playlist';
        } else {
          this.errorMessage = 'Error al agregar la canción a la playlist';
        }
      });
    }
  }
}
</script>


<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.playlist-modal__error {
  color: red;
  margin-top: 10px;
}
</style>
