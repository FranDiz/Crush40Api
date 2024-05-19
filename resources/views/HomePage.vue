<template>
    <main>
        <aside class="sidebar">
            <Dashboard/>
        </aside>
        <section class="content-area">
          <Home/>
        </section>
    </main>
</template>

<script>
import Header from '../components/Header.vue';
import Home from '../components/Home.vue';
import Dashboard from '../components/Dashboard.vue';
import '../css/app.css';

export default {
  components: {Header, Home, Dashboard},  
};
</script>