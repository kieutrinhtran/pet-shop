<template>
  <div class="checkout-page">
    <div class="breadcrumb">
      <router-link to="/">Trang chủ</router-link> &gt; <span>Thanh toán</span>
    </div>
    <h1>Thanh toán</h1>
    <div class="checkout-steps">
      <span class="step">Vận chuyển</span>
      <span class="step active">Kiểm tra & Thanh toán</span>
      <span class="step">Thành công</span>
    </div>
    <div class="payment-section">
      <h3>Phương thức thanh toán</h3>
      <div class="payment-methods">
        <label><input type="radio" name="pay" checked> Thanh toán khi nhận hàng</label>
        <label><input type="radio" name="pay"> Thẻ ngân hàng</label>
        <label><input type="radio" name="pay"> Ví điện tử</label>
      </div>
      <div class="discount-section">
        <input type="text" placeholder="Áp dụng mã giảm giá" v-model="discountCode" />
        <button @click="applyDiscount">Áp dụng</button>
      </div>
      <button class="next-btn" @click="goSuccess">Hoàn tất thanh toán</button>
    </div>
    <div class="order-summary">
      <h3>Giỏ hàng</h3>
      <div v-for="item in cartItems" :key="item.id" class="summary-item">
        <img :src="item.image" :alt="item.name" />
        <div>
          <div>{{ item.name }}</div>
          <div>Số lượng: {{ item.quantity }}</div>
        </div>
        <div>{{ item.price.toLocaleString() }}đ</div>
      </div>
      <div class="summary-total">
        <div>Tổng tiền: <b>{{ subtotal.toLocaleString() }}đ</b></div>
        <div>Vận chuyển: <b>{{ shipping.toLocaleString() }}đ</b></div>
        <div v-if="discount">Giảm giá: <b>-{{ discount.toLocaleString() }}đ</b></div>
        <div>Tổng đơn đặt hàng: <b>{{ total.toLocaleString() }}đ</b></div>
      </div>
    </div>
  </div>
</template>
<script>
import { cartStore } from '../store/cart'
export default {
  name: 'CheckoutPage',
  data() {
    return {
      shipping: 30000,
      discount: 0,
      discountCode: ''
    }
  },
  computed: {
    cartItems() { return cartStore.state.items },
    subtotal() { return cartStore.getTotal() },
    total() { return this.subtotal + this.shipping - this.discount }
  },
  methods: {
    applyDiscount() {
      if (this.discountCode === 'GIAM50') this.discount = 50000
      else this.discount = 0
    },
    goSuccess() { this.$router.push('/order-success') }
  }
}
</script>
<style scoped>
.checkout-page { background: #fff; border-radius: 16px; padding: 32px; max-width: 1200px; margin: 32px auto; display: flex; gap: 32px; }
.breadcrumb { color: #888; margin-bottom: 16px; }
.checkout-steps { display: flex; gap: 32px; margin: 24px 0; }
.step { color: #aaa; font-weight: bold; }
.step.active { color: #f90; }
.payment-section { flex: 1; }
.payment-methods { display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; }
.discount-section { display: flex; gap: 8px; margin-bottom: 16px; }
.discount-section input { flex: 1; padding: 8px; border: 1px solid #eee; border-radius: 6px; }
.discount-section button { background: #f90; color: #fff; border: none; border-radius: 6px; padding: 8px 16px; cursor: pointer; }
.next-btn { width: 100%; background: #f90; color: #fff; border: none; border-radius: 8px; padding: 12px; font-size: 1.1em; cursor: pointer; }
.order-summary { background: #fff7f0; border-radius: 12px; padding: 24px; min-width: 320px; }
.summary-item { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
.summary-item img { width: 48px; height: 48px; object-fit: contain; border-radius: 8px; }
.summary-total { margin-top: 16px; }
</style> 