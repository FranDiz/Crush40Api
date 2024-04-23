<template>
    <header>
        <Header/>
    </header>
    <main>
        <aside>
            <Dashboard/>
        </aside>
        <section>
            <CategoryExplorer/>
        </section>
    </main>
</template>

<script>
import Header from '../components/Header.vue';
import Dashboard from '../components/Dashboard.vue';
import CategoryExplorer from '../components/CategoryExplorer.vue';
export default {
    components: { Header, Dashboard, CategoryExplorer }
    }
</script>

<style scoped>


</style>

