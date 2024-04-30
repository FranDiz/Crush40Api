<template>
    <main>
        <aside class="sidebar">
            <Dashboard/>
        </aside>
        <section class="content-area">
            <Profile/>
        </section>
    </main>
</template>

<script>
import Dashboard from '../components/Dashboard.vue';
import Profile from '../components/Profile.vue';
export default {
    components: { Dashboard, Profile }
    }
</script>

<style scoped>


</style>

