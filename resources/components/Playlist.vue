<template>

</template>

<script>
import axios from 'axios';  
export default{
    props: {
        playlistId: {
            type: Number,
            required: true
        }
    },
    data(){
        return{
            playlist:null,
            songs:[]
        }
    },
    mounted(){
        this.getPlaylistDetails();
        this.getPlaylistSongs();
    },
    methods: {
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
                this.songs = response.data;
            })
            .catch(error => {
                console.error('Error al cargar las canciones de la playlist:', error);
                // Manejo adicional de errores aquí si necesario
            });
        }
    }
}
</script>