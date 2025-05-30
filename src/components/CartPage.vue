<template>
  <div class="cart-page">
    <div class="breadcrumb">
      <router-link to="/">Trang chủ</router-link> &gt; <span>Giỏ hàng</span>
    </div>
    <h1>Giỏ hàng</h1>
    <div class="checkout-steps">
      <span class="step active">Vận chuyển</span>
      <span class="step">Kiểm tra & Thanh toán</span>
      <span class="step">Thành công</span>
    </div>
    <div v-if="cartItems.length === 0" class="empty-cart">Giỏ hàng của bạn đang trống.</div>
    <div v-else class="cart-content">
      <table class="cart-table">
        <thead>
          <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in cartItems" :key="item.id">
            <td>
              <img :src="item.image" :alt="item.name" class="cart-img" />
              {{ item.name }}
            </td>
            <td>{{ item.price.toLocaleString() }}đ</td>
            <td>
              <button @click="decrease(item)">-</button>
              {{ item.quantity }}
              <button @click="increase(item)">+</button>
            </td>
            <td>{{ (item.price * item.quantity).toLocaleString() }}đ</td>
            <td><button @click="remove(item)" class="remove-btn">🗑️</button></td>
          </tr>
        </tbody>
      </table>
      <div class="cart-summary">
        <div>Tạm tính: <b>{{ subtotal.toLocaleString() }}đ</b></div>
        <div>Vận chuyển: <b>{{ shipping.toLocaleString() }}đ</b></div>
        <div>Tổng: <b>{{ total.toLocaleString() }}đ</b></div>
        <button class="next-btn" @click="goShipping">Thanh toán</button>
      </div>
    </div>
  </div>
</template>
<script>
import { cartStore } from '../store/cart'
export default {
  name: 'CartPage',
  data() {
    return { shipping: 30000 }
  },
  computed: {
    cartItems() { return cartStore.state.items },
    subtotal() { return cartStore.getTotal() },
    total() { return this.subtotal + this.shipping }
  },
  methods: {
    increase(item) { cartStore.updateQuantity(item.id, item.quantity + 1) },
    decrease(item) { if (item.quantity > 1) cartStore.updateQuantity(item.id, item.quantity - 1) },
    remove(item) { cartStore.removeItem(item.id) },
    goShipping() { this.$router.push('/shipping') }
  }
}
</script>
<style scoped>
.cart-page { background: #fff; border-radius: 16px; padding: 32px; max-width: 1200px; margin: 32px auto; }
.breadcrumb { color: #888; margin-bottom: 16px; }
.checkout-steps { display: flex; gap: 32px; margin: 24px 0; }
.step { color: #aaa; font-weight: bold; }
.step.active { color: #f90; }
.cart-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
.cart-table th, .cart-table td { padding: 12px; border-bottom: 1px solid #eee; text-align: center; }
.cart-img { width: 60px; height: 60px; object-fit: contain; border-radius: 8px; margin-right: 8px; }
.remove-btn { background: none; border: none; color: #ff4444; font-size: 1.2em; cursor: pointer; }
.cart-summary { background: #fff7f0; border-radius: 12px; padding: 24px; max-width: 320px; margin-left: auto; }
.next-btn { width: 100%; margin-top: 16px; background: #f90; color: #fff; border: none; border-radius: 8px; padding: 12px; font-size: 1.1em; cursor: pointer; }
.empty-cart { text-align: center; color: #aaa; padding: 40px; }
</style> 