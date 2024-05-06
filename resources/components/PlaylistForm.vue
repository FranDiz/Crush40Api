<template>
    <form @submit.prevent="createPlaylist" class="playlist-form">
        <h2 class="playlist-title">Crear Playlist</h2>

            <label for="title" class="playlist-label">Nombre de la Playlist:</label>
            <input type="text" id="title" v-model="title" name="title" class="playlist-input" required>

            <label for="description" class="playlist-label">Descripción:</label>
            <textarea id="description" v-model="description" name="description" class="playlist-input" rows="4" cols="50" required></textarea>

            <input type="submit" value="Crear Playlist" class="playlist-submit">
    </form>
</template>

<script>
import axios from 'axios'
import '../css/PlaylistForm.css'
export default{
    data() {
        return {
            user:null,
            title:'',
            description:''
        }
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
    },
    methods: {
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
            .then(response => response.json())
            .then(data => {
                console.log('Playlist creada:', data);
            })
            .catch(error => {
                console.error('Error al crear la playlist:', error);
            });
        }
    }
}

</script>
<style >

</style>