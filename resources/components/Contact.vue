<template>
    <section class="contact">
        <h1>¡Gracias por tu interés en Crush40! Utiliza el formulario a continuación para ponerte en contacto con nosotros.</h1>
        
        <form class="contact-form" @submit.prevent="submitForm">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input v-model="formData.name" type="text" name="name" id="name" class="form-control" placeholder="Ingresa tu nombre">
                <span v-if="formErrors.name !== null" class="error-message">Por favor, ingresa tu nombre</span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input v-model="formData.email" type="email" name="email" id="email" class="form-control" placeholder="Ingresa tu correo electrónico">
                <span v-if="formErrors.email !== null" class="error-message">Por favor, ingresa tu correo electrónico</span>
            </div>
            <div class="form-group">
                <label for="message">Mensaje:</label>
                <textarea v-model="formData.message" name="message" id="message" class="form-control" rows="5" placeholder="Escribe tu mensaje aquí"></textarea>
                <span v-if="formErrors.message !== null" class="error-message">Por favor, escribe tu mensaje</span>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
        </form>
    </section>
</template>

<script>
import '../css/ContactForm.css';
export default {
    data() {
        return {
            formData: {
                name: '',
                email: '',
                message: ''
            },
            formErrors: {
                name: null,
                email: null,
                message: null
            }
        };
    },
    methods: {
        submitForm() {
            // Validar el formulario antes de enviarlo
            if (!this.validateForm()) {
                // Si la validación falla, no envíes el formulario
                return;
            }

            // Envía el formulario
            this.sendForm();
        },
        validateForm() {
            // Reinicia los errores
            this.resetFormErrors();

            // Realiza la validación de cada campo
            let valid = true;
            if (!this.formData.name) {
                this.formErrors.name = 'Por favor, ingresa tu nombre';
                valid = false;
            }
            if (!this.formData.email) {
                this.formErrors.email = 'Por favor, ingresa tu correo electrónico';
                valid = false;
            }
            if (!this.formData.message) {
                this.formErrors.message = 'Por favor, escribe tu mensaje';
                valid = false;
            }

            return valid; // Devuelve true si el formulario es válido
        },
        sendForm() {
            // Envía el formulario y realiza otras acciones necesarias

            // Después de enviar el formulario, reinicia los datos
            this.resetFormData();

            // Muestra un mensaje de éxito o redirige a una página de agradecimiento si es necesario
        },
        resetFormData() {
            // Reinicia los datos del formulario
            this.formData.name = '';
            this.formData.email = '';
            this.formData.message = '';
        },
        resetFormErrors() {
            // Reinicia los errores del formulario
            this.formErrors.name = null;
            this.formErrors.email = null;
            this.formErrors.message = null;
        }
    }
};
</script>

<style scoped>
.error-message {
    color: #ff0000; /* Color rojo para los mensajes de error */
    font-size: 14px;
}
</style>



<style scoped>

</style>
