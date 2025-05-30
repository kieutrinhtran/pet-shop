<template>
  <div class="min-h-screen flex flex-col">
    <HeaderComponent />
    <main class="flex-grow">
      <router-view></router-view>
    </main>
    <FooterComponent />
  </div>
</template>

<script>
import { useCartStore } from './store/cart'
import HeaderComponent from './components/HeaderComponent.vue'
import FooterComponent from './components/FooterComponent.vue'

export default {
  name: 'App',
  components: {
    HeaderComponent,
    FooterComponent
  },
  setup() {
    const cart = useCartStore()
    return {
      cart
    }
  },
  computed: {
    cartItemCount() {
      return this.cart.itemCount
    }
  }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html {
  font-size: clamp(14px, 2vw, 18px);
}

body {
  font-family: 'Inter', Arial, sans-serif;
  font-size: 1rem;
}
</style> 