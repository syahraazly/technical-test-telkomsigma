<template>
  <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Employment Data</h1>

  <div class="flex flex-col lg:flex-row justify-between space-y-6 lg:space-y-0 lg:space-x-6">
    <PieChartComponent />
    <ColumnChartComponent />
  </div>
  <ManageComponent />
</template>

<script>
import PieChartComponent from './components/PieChartComponent.vue';
import ColumnChartComponent from './components/ColumnChartComponent.vue';
import ManageComponent from './components/ManageComponent.vue';

export default {
  name: 'App',
  components: {
    PieChartComponent,
    ColumnChartComponent,
    ManageComponent,
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
