<template>
  <main>
    <aside>
      <Dashboard/>
    </aside>
      <section>
          <SearchComponent/>
      </section>
  </main>
</template>

<script>
import Header from '../components/Header.vue';
import Dashboard from '../components/Dashboard.vue';
import SearchComponent from '../components/SearchComponent.vue';

export default {
  components: { Header, SearchComponent, Dashboard,  }
}
</script>

<style>

</style>

<style scoped>


</style>

