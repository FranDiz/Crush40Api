<template>
    <main>
        <aside class="sidebar">
            <Dashboard/>
        </aside>
        <section class="content-area">
            <Contact/>
        </section>
    </main>
</template>

<script>
import Dashboard from '../components/Dashboard.vue';
import Contact from '../components/Contact.vue';
export default {
    components: { Dashboard, Contact }
    }
</script>

<style scoped>


</style>

