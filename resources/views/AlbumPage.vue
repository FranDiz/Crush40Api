<template>
    <main>
        <aside class="sidebar">
            <Dashboard/>
        </aside>
        <section class="content-area">
          <AlbumSongs :albumId="albumId" />
        </section>
    </main>
</template>

<script>
import Header from '../components/Header.vue';
import AlbumSongs from '../components/AlbumSongs.vue';
import Dashboard from '../components/Dashboard.vue';

export default {
  components: {Header, AlbumSongs, Dashboard},
  data() {
    return {
      albumId: this.$route.params.id
    };
  }
  
};
</script>

<style scoped>


</style>