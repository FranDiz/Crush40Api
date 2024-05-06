<template>
    <section class="user-profile" v-if="user !== null">
        <h2>Perfil de {{ user.name }}:</h2>
        <article>
            <p>Nombre: {{ user.name }}</p>
            <p>Correo electrónico: {{ user.email }}</p>
        </article>
        <section v-if="favorites.length">
            <h3>Favoritos:</h3>
            <ul class="profile___favorites">
                <li class="profile___favorite" v-for="song in favorites" :key="song.id">
                    {{ song.name }} - {{ songDuration(song.duration_ms) }}<br>
                     <img class="profile___favorite-cover" :src="song.album.images[0].url" alt="Cover Image" style="width: 100px;">
                    <!-- Botón para eliminar el favorito -->
                    <button class="profile___favorite-button"@click="deleteFavorite(song.id)">Eliminar</button>
            </li>

            </ul>
        </section>
        <p v-else>No hay favoritos disponibles.</p>
    </section>
    <p v-else>No hay datos de usuario disponibles.</p>
</template>


<script>
import '../css/Profile.css'
export default {
    data() {
        return {
            user: null,
            favorites: []  // Aquí se almacenarán los favoritos
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
            return this.fetchFavorites(data.id);
        })
        .catch((error) => {
            console.error('Error al cargar los datos', error);
        });
    },
    methods: {
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
                this.favorites = [];
                data.forEach(song => {
                    this.getSong(song.id);
                });
            })
            .catch(error => {
                console.error('Error al cargar los favoritos', error);
            });
        },
        getSong(songId) {
            fetch(`/api/spotify/getSong?songId=${songId}`, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                },
            })
            .then(response => response.json())
            .then(song => {
                this.favorites.push(song);
            })
            .catch(error => console.error('Error al obtener detalles de la canción', error));
        },
        deleteFavorite(songId) {
    fetch(`/api/favorites/deleteFavorite`, {
        method: 'DELETE',
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            userId: this.user.id,
            favoriteId: songId
        })
    })
    .then(response => {
        if (!response.ok) {
            console.log("a")
            throw new Error('Error al eliminar el favorito: ' + response.status);
        }
        return response.json();
    })
    .then(() => {
        // Actualizar la lista de favoritos eliminando el elemento eliminado
        this.favorites = this.favorites.filter(song => song.id !== songId);
    })
    .catch(error => console.error('Error al eliminar el favorito', error));
}
    },
    computed: {
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
};
</script>
