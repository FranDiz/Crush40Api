<template>
    <main>
        <aside class="sidebar">
            <Dashboard/>
        </aside>
        <section class="content-area">
            <CategoryExplorer/>
        </section>
    </main>
</template>

<script>
import Dashboard from '../components/Dashboard.vue';
import CategoryExplorer from '../components/CategoryExplorer.vue';
export default {
    components: { Dashboard, CategoryExplorer }
    }
</script>

<style scoped>


</style>

