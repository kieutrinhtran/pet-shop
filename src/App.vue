<template>
  <div id="app">
    <HeaderComponent />
    <router-view></router-view>
    <FooterComponent />
  </div>
</template>

<script>
import { cartStore } from './store/cart'
import HeaderComponent from './components/HeaderComponent.vue'
import FooterComponent from './components/FooterComponent.vue'

export default {
  name: 'App',
  components: {
    HeaderComponent,
    FooterComponent
  },
  computed: {
    cartItemCount() {
      return cartStore.getItemCount()
    }
  }
}
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
}

#app {
  min-height: 100vh;
}

.navbar {
  background-color: #333;
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: white;
}

.logo {
  font-size: 1.5rem;
  font-weight: bold;
  color: white;
  text-decoration: none;
}

.nav-links {
  display: flex;
  gap: 2rem;
}

.nav-links a {
  color: white;
  text-decoration: none;
  font-size: 1.1rem;
}

.cart-link {
  position: relative;
}

.cart-count {
  position: absolute;
  top: -8px;
  right: -12px;
  background-color: #ff4444;
  color: white;
  border-radius: 50%;
  padding: 2px 6px;
  font-size: 0.8rem;
}

a.router-link-active {
  color: #4CAF50;
}
</style> 