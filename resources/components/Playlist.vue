<template>
    <section v-if="playlist" class="playlist-details">
            <h1 class="playlist__title">{{ playlist.title }}</h1>
            <p>{{ playlist.description }}</p>
            <h3>Creada: {{ formatDate(playlist.created_at) }}</h3>
            <h3>Última Actualización: {{ formatDate(playlist.updated_at) }}</h3>
        <ul class="playlist__list">
            <li v-for="song in songs" :key="song.id" class="playlist__item">
                    <img :src="song.album.images[0].url" alt="Portada del álbum" class="playlist__cover">
                        <h4>{{ song.name }}</h4>
                        <p>Álbum: {{ song.album.name }}</p>
                        <p>Artistas: {{ song.artists.map(artist => artist.name).join(', ') }}</p>
                        <p>Duración: {{ (song.duration_ms / 60000).toFixed(2) }} minutos</p>
                        <button>
                            <a :href="song.external_urls.spotify" target="_blank" class="playlist__link">Escuchar en Spotify</a>
                        </button>
                   
            </li>
        </ul>
    </section>
    <section v-else class="playlist__loading">
        Cargando detalles de la playlist...
    </section>
</template>

<script>
import '../css/Playlist.css';
import axios from 'axios';
export default {
    props: {
        playlistId: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            playlist: null,
            songs: []
        }
    },
    mounted() {
        console.log(this.playlistId);
        this.getPlaylistDetails();
        this.getPlaylistSongs();
        console.log(this.songs);    
    },
    methods: {
        formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            return new Date(dateString).toLocaleDateString('es-ES', options);
        },
        getPlaylistDetails() {
            axios.get('/api/getPlaylistDetails', {
                params: {
                    playlistId: this.playlistId
                }
            })
                .then(response => {
                    this.playlist = response.data;
                })
                .catch(error => {
                    console.error('Error al cargar la playlist:', error);
                    // Manejo adicional de errores aquí si necesario
                });
        },
        getPlaylistSongs() {
        axios.get('/api/getPlaylistSongs', {
            params: {
                playlistId: this.playlistId
            }
        })
            .then(response => {
                response.data.forEach(song => {
                    this.getSong(song.spotify_id);  // Utilizar el spotify_id para obtener los detalles completos de cada canción.
                });
            })
            .catch(error => {
                console.error('Error al cargar las canciones de la playlist:', error);
            });
    },
        getSong(songId) {
            fetch(`/api/spotify/getSong?songId=${songId}`, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error fetching song details: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(song => {
                    this.songs.push(song);  // Añadir la canción al array songs.
                })
                .catch(error => {
                    console.error('Error obtaining song details:', error);
                });
        }

    }
}
</script>