<template>
    <h2 v-if="user !== null">Perfil usuario:</h2>
    <section v-if="user !== null">
        <p>Nombre: {{ user.name }}</p>
        <p>Correo electrónico: {{ user.email }}</p>
    </section>
</template>

<script>
export default {
    data() {
        return {
            user: null,
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
    },
};
</script>