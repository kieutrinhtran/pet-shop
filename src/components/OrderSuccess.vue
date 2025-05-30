<template>
  <div class="order-success">
    <div class="breadcrumb">
      <router-link to="/">Trang chủ</router-link> &gt; <span>Thành công</span>
    </div>
    <h1>Đặt hàng thành công!</h1>
    <div class="success-icon">🎉</div>
    <div class="success-msg">Cảm ơn bạn đã đặt hàng tại Pet Shop!</div>
    <div class="order-actions">
      <router-link to="/" class="home-btn">Về trang chủ</router-link>
      <router-link to="/" class="order-btn">Xem đơn hàng</router-link>
    </div>
  </div>
</template>
<script>
export default { name: 'OrderSuccess' }
</script>
<style scoped>
.order-success { background: #fff; border-radius: 16px; padding: 32px; max-width: 600px; margin: 64px auto; text-align: center; }
.breadcrumb { color: #888; margin-bottom: 16px; }
.success-icon { font-size: 3em; margin: 24px 0; }
.success-msg { color: #f90; font-size: 1.2em; margin-bottom: 24px; }
.order-actions { display: flex; gap: 24px; justify-content: center; }
.home-btn, .order-btn { background: #f90; color: #fff; border: none; border-radius: 8px; padding: 12px 32px; font-size: 1.1em; text-decoration: none; }
.order-btn { background: #333; }
</style> 