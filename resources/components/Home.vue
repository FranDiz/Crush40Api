<template>
  <section class="presentation">
    <header class="presentation-header">
      <h1 class="presentation-title">Bienvenido a Mi Aplicación de Música</h1>
      <p class="presentation-subtitle">La mejor experiencia para gestionar y disfrutar tu música</p>
    </header>
    <article class="presentation-content">
      <section class="presentation-description">
        <p>Descubre nuevas canciones, organiza tus playlists y comparte tu música con amigos.</p>
      </section>
      <section class="presentation-features">
        <h2>Funcionalidades Principales</h2>
        <ul class="features-list">
          <li class="features-item">
            <i class="icon fas fa-music"></i>
            <div class="feature-text">
              <h3>Explorar Música</h3>
              <p>Busca y descubre nuevas canciones y artistas.</p>
            </div>
          </li>
          <li class="features-item">
            <i class="icon fas fa-playlist"></i>
            <div class="feature-text">
              <h3>Crear Playlists</h3>
              <p>Organiza tu música en listas de reproducción personalizadas.</p>
            </div>
          </li>
          <li class="features-item">
            <i class="icon fas fa-share"></i>
            <div class="feature-text">
              <h3>Compartir Música</h3>
              <p>Comparte tus canciones y playlists con amigos.</p>
            </div>
          </li>
          <li class="features-item">
            <i class="icon fas fa-headphones-alt"></i>
            <div class="feature-text">
              <h3>Escuchar en Streaming</h3>
              <p>Con Spotify, disfruta de tu música favorita en cualquier momento y lugar.</p>
            </div>
          </li>
        </ul>
      </section>
    </article>
  </section>
</template>

<script>
export default {
  name: 'Presentation'
}
</script>

<style scoped>
.presentation {
  display: flex;
  flex-direction: column;
  align-items: center;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  width: 100%;
  margin: auto;
  height: 100vh;
  border: 2px solid #12fcff;
  box-shadow: 0 0 1px #00d5ff, 0 0 3px #00d5ff, inset 0 0 1px #00d5ff, inset 0 0 3px #00d5ff;
  border-radius: 0.5em;
  margin-top: 10px;
}

.presentation-header {
  margin-bottom: 40px;
}

.presentation-title {
  font-size: 3em;
  font-weight: bold;
  margin-bottom: 10px;
}

.presentation-subtitle {
  font-size: 1.5em;
  font-weight: 300;
  margin-bottom: 30px;
}

.presentation-description {
  font-size: 1.2em;
  margin-bottom: 50px;
}

.presentation-features {
  text-align: left;
  margin: 0 auto;
  max-width: 800px;
}

.features-list {
  list-style: none;
  padding: 0;
}

.features-item {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.icon {
  font-size: 2em;
  margin-right: 20px;
}

.feature-text h3 {
  font-size: 1.5em;
  margin-bottom: 5px;
}

.feature-text p {
  font-size: 1em;
  margin: 0;
}
@media only screen and (max-width: 768px) {
    .presentation {
        width: auto; /* Adjust width as needed for mobile */
        padding: 10px; /* Reduce padding for smaller screens */
    }

    .presentation-features {
        max-width: 100%; /* Allow full width on mobile */
    }
}
</style>
