<template>
    <main>
        <aside class="sidebar">
            <Dashboard/>
        </aside>
        <section class="content-area">
            <PlaylistsNav/>
        </section>
    </main>
</template>

<script>
import Dashboard from '../components/Dashboard.vue';
import PlaylistForm from '../components/PlaylistForm.vue';
import PlaylistsNav from '../components/PlaylistsNav.vue';
export default {
    components: { Dashboard, PlaylistForm, PlaylistsNav }
    }
</script>

<style scoped>


</style>

