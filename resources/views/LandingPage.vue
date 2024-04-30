<template>
  <main>
    <aside class="sidebar">
      <Dashboard/>
    </aside>
      <section class="content-area">
          <SearchComponent/>
      </section>
  </main>
</template>

<script>
import Header from '../components/Header.vue';
import Dashboard from '../components/Dashboard.vue';
import SearchComponent from '../components/SearchComponent.vue';
import '../css/app.css';
export default {
  components: { Header, SearchComponent, Dashboard,  }
}
</script>

<style>

</style>

<style scoped>


</style>

