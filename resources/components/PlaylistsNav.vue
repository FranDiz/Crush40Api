<template>
      <form @submit.prevent="createPlaylist" class="playlist-form">
        <h2 class="playlist-title">Crear Playlist</h2>

            <label for="title" class="playlist-label">Nombre de la Playlist:</label>
            <input type="text" id="title" v-model="title" name="title" class="playlist-input" required>

            <label for="description" class="playlist-label">Descripción:</label>
            <textarea id="description" v-model="description" name="description" class="playlist-input" rows="4" cols="50" required></textarea>

            <input type="submit" value="Crear Playlist" class="playlist-submit">
    </form>
  <div class="playlists-container">
    <h2 class="playlists-title">Playlists</h2>
    <ul class="search-results">
      <li v-for="playlist in playlists" :key="playlist.id" class="search-results__item" @click="goToPlaylist(playlist.id)">
        <div class="playlist-info">
          <div class="search-results__title">{{ playlist.title }}</div>
          <div>{{ playlist.description || 'Sin descripción' }}</div>
        </div>
      </li>
    </ul>
    <div v-if="playlists.length === 0">
      No hay playlists disponibles.
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user:null,
      title:'',
      description:'',
      playlists: [],
      error: null,
    };
  },
  mounted() {
    fetch('api/user', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
            },
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Respuesta de autenticación fallida: ' + response.status);
            }
            return response.json();
            
        })
        .then((data) => {
            this.user = data;
        })
        .catch((error) => {
            console.error('Error al cargar los datos', error);
        });
    this.fetchPlaylists();
  },
  methods: {
    fetchPlaylists() {
      axios.get('/api/getPlaylists')
        .then(response => {
          this.playlists = response.data;
        })
        .catch(error => {
          console.error('Hubo un error al obtener las playlists:', error);
        });
    },
    goToPlaylist(id) {
      this.$router.push({ name: 'Playlist', params: { id: id } });
    },
    createPlaylist() {
    fetch('/api/createPlaylist', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        body: JSON.stringify({
            title: this.title,
            description: this.description,
            user_id: this.user.id  // Asegúrate de que user.id esté disponible
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Respuesta de creación de playlist fallida: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Playlist creada:', data);
        // Limpiar los campos del formulario
        this.title = '';
        this.description = '';
        // Recargar la lista de playlists
        this.fetchPlaylists();
    })
    .catch(error => {
        console.error('Error al crear la playlist:', error);
    });
}

  }
}
</script>


<style scoped>
.playlists-container {
  align-items: baseline;
  box-sizing: border-box;
  margin-top: 10px;
  padding: 20px;
  border: 2px solid #00d5ff;
  border-radius: 0.5em;
  box-shadow: 
      0 0 1px #00d5ff,
      0 0 3px #00d5ff,
      inset 0 0 1px #00d5ff,
      inset 0 0 3px #00d5ff;
  background-color: #170528;
  color: #ccc;
  overflow: hidden;
}

.playlists-title {
  color: #ffffff;
  margin-bottom: 20px;
} 

.search-results {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1em;
  list-style: none;
}

.search-results__item {
  text-align: center;
  padding: 10px;
  border: 2px solid #00d5ff;
  box-shadow: 
      0 0 5px #00d5ff,
      0 0 10px #00d5ff,
      inset 0 0 5px #00d5ff,
      inset 0 0 10px #00d5ff;
  transition: border 0.4s, box-shadow 0.4s;
}

.search-results__item:hover {
  transform: scale(1.00);
  border: 4px solid #12fcff;
  box-shadow: 
      0 0 10px #00d5ff,
      0 0 20px #00d5ff,
      inset 0 0 10px #00d5ff,
      inset 0 0 20px #00d5ff;
}

@media (max-width: 768px) {
  .search-results {
    grid-template-columns: 1fr; /* Se cambia a 1 columna en pantallas más pequeñas */
  }
}

</style>

  