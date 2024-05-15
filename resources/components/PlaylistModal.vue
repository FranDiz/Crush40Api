<template>
    <div v-if="show" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h3>Agregar a Playlist</h3>
        <p>ID de la canción: {{ trackId }}</p>
        <!-- Aquí puedes añadir más contenido como un formulario para seleccionar la playlist -->
        <button @click="closeModal">Cerrar</button>
      </div>
    </div>
  </template>
  
  <script>
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
      closeModal() {
        this.$emit('close');
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
  
  .modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
  }
  </style>
  