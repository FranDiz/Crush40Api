<template>
    <form class="form___register" @submit.prevent="login" :disabled="!isFormValid">
        <div class="form___head">
            <h2 class="form___title">Entrar en Crush40</h2>
            <router-link to="/" class="button">Volver</router-link>
        </div>

        <label for="email" class="form___label" >Correo electrónico:</label>
        <input type="email" id="email" v-model="email" @blur="validateEmail" required class="form___input">
        <span v-if="emailError" class="error-message">Formato de correo electrónico inválido</span>

        <label for="password" class="form___label">Contraseña:</label>
        <input type="password" id="password" v-model="password" @blur="validatePassword" required class="form___input">
        <span v-if="passwordError" class="error-message">La contraseña debe tener al menos 8 caracteres</span>



        <button type="submit" class="form___submit" >Entrar</button>
    </form>
</template>

<script>
import '../css/Form.css';

export default {
    data() {
        return {
            password: '',
            email: '',
            passwordError: false,
            emailError: false
        };
    },
    computed: {
        isFormValid() {
            return !!this.passwordError && !this.emailError &&  this.password && this.email; // Update the condition to include checking if the form fields are empty
        }
    },
    methods: {
        login(){
            axios
                .post('api/login',{
                    email:this.email,
                    password: this.password,
                })
                .then((response)=>{
                    alert(response.data.token)
                    localStorage.setItem('token', response.data.token)
                    this.$router.push({name: 'Profile'})
                })
                .catch((error)=>{
                    alert("Error inicio de sesión")
                    console.log('Error de inicio de sesión', error)
                })
        },
        validatePassword() {
            this.passwordError = this.password.length < 8;
        },
        validateEmail() {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            this.emailError = !regex.test(this.email);
        }
    }
};
</script>

<style scoped>
.error-message {
    color: red;
}
</style>