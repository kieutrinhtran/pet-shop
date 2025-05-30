<template>
  <div class="shipping-page">
    <div class="breadcrumb">
      <router-link to="/">Trang chủ</router-link> &gt; <span>Giỏ hàng</span> &gt; <span>Vận chuyển</span>
    </div>
    <h1>Vận chuyển</h1>
    <div class="checkout-steps">
      <span class="step active">Vận chuyển</span>
      <span class="step">Kiểm tra & Thanh toán</span>
      <span class="step">Thành công</span>
    </div>
    <div class="address-section">
      <h3>Địa chỉ nhận hàng</h3>
      <div class="address-info">
        <div><b>Nguyễn Văn A</b> | (+84) 347 895 555</div>
        <div>123 Nguyễn Thị Minh Khai, Phường 6, Quận 3, TP. HCM</div>
        <button class="edit-btn">Thay đổi</button>
      </div>
    </div>
    <button class="next-btn" @click="goCheckout">Tiếp tục</button>
  </div>
</template>
<script>
export default {
  name: 'ShippingPage',
  methods: {
    goCheckout() { this.$router.push('/checkout') }
  }
}
</script>
<style scoped>
.shipping-page { background: #fff; border-radius: 16px; padding: 32px; max-width: 900px; margin: 32px auto; }
.breadcrumb { color: #888; margin-bottom: 16px; }
.checkout-steps { display: flex; gap: 32px; margin: 24px 0; }
.step { color: #aaa; font-weight: bold; }
.step.active { color: #f90; }
.address-section { background: #fff7f0; border-radius: 12px; padding: 24px; margin-bottom: 32px; }
.address-info { display: flex; align-items: center; gap: 24px; }
.edit-btn { background: #fff; border: 1px solid #f90; color: #f90; border-radius: 6px; padding: 6px 16px; cursor: pointer; }
.next-btn { width: 100%; background: #f90; color: #fff; border: none; border-radius: 8px; padding: 12px; font-size: 1.1em; cursor: pointer; }
</style> 