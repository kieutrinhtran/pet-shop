<template>
  <div id="app">
    <AdminOrderManagement />
  </div>
</template>

<script>
import AdminOrderManagement from "./components/AdminOrderManagement.vue";

export default {
  name: "App",
  components: {
    AdminOrderManagement,
  },
};
</script>

<style>
#app {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  width: 100%;
  min-height: 100vh;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
</style>
