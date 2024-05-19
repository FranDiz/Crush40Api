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
.contact {
    display: flex;
    width: 100%;
    flex-direction: column;
    justify-content: center;
    align-items:baseline;
    margin: 0 auto;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.contact h1 {
    font-size: 24px;
    margin-bottom: 10px;
}

.contact p {
    font-size: 16px;
    margin-bottom: 20px;
}

.contact-form .form-group {
    margin-bottom: 20px;
}

.contact-form label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.contact-form input[type="text"],
.contact-form input[type="email"],
.contact-form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    background-color: #17012a;
    border-radius: 5px;
    font-size: 16px;
    color: #fff; /* Cambia el color del texto a blanco */
}

.contact-form textarea {
    resize: vertical; /* Permitir la redimensión vertical */
}

.contact-form button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.contact-form button:hover {
    background-color: #0056b3;
}

.error-message {
    color: #ff0000; /* Color rojo para los mensajes de error */
    font-size: 14px;
}
</style>
