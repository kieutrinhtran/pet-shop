<template>
  <div class="customer-layout">
    <CustomerHeader />
    <main>
      <router-view />
    </main>
    <FooterComponent />
  </div>
</template>

<script setup>
import CustomerHeader from '@/components/CustomerHeader.vue'
import FooterComponent from '@/components/FooterComponent.vue'
</script>

<style scoped>
.customer-layout {
  min-height: 100vh;
  background: #ffffff;
  display: flex;
  flex-direction: column;
}
main {
  flex: 1;
}
</style> 