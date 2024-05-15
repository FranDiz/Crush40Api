<template>
    <main>
        <aside class="sidebar">
            <Dashboard/>
        </aside>
        <section class="content-area">
            <Playlist :playlistId="playlistId" />
        </section>
    </main>
</template>

<script>
import Dashboard from '../components/Dashboard.vue';
import PlaylistForm from '../components/PlaylistForm.vue';
import PlaylistsNav from '../components/PlaylistsNav.vue';
import Playlist from '../components/Playlist.vue';
export default {
    components: { Dashboard, PlaylistForm, PlaylistsNav, Playlist },
    data()  {
        return {
            playlistId: this.$route.params.id
        }
    }
};
</script>

<style scoped>


</style>

