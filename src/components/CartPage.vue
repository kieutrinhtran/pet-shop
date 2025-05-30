<template>
  <div class="cart-page">
    <div class="breadcrumb">
      <router-link to="/" class="text-gray-600 hover:text-orange-500">Trang chủ</router-link> &gt; <span class="text-gray-800">Giỏ hàng</span>
    </div>
    <h1 class="text-2xl font-bold mb-6">Giỏ hàng</h1>
    <div class="checkout-steps">
      <div class="step active">
        <div class="step-number">1</div>
        <div class="step-text">Vận chuyển</div>
      </div>
      <div class="step-line"></div>
      <div class="step">
        <div class="step-number">2</div>
        <div class="step-text">Kiểm tra & Thanh toán</div>
      </div>
      <div class="step-line"></div>
      <div class="step">
        <div class="step-number">3</div>
        <div class="step-text">Thành công</div>
      </div>
    </div>

    <div v-if="cartItems.length === 0" class="empty-cart">
      <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
      <p class="text-gray-500 text-lg mb-4">Giỏ hàng của bạn đang trống.</p>
      <router-link to="/products" class="inline-block bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors">
        Tiếp tục mua sắm
      </router-link>
    </div>

    <div v-else class="cart-content">
      <div class="cart-items">
        <div v-for="item in cartItems" :key="item.id" class="cart-item">
          <div class="item-info">
            <img :src="item.image" :alt="item.name" class="item-image" />
            <div class="item-details">
              <h3 class="item-name">{{ item.name }}</h3>
              <p class="item-category">{{ item.category }}</p>
            </div>
          </div>
          <div class="item-price">{{ item.price.toLocaleString() }}đ</div>
          <div class="item-quantity">
            <button @click="decrease(item)" class="quantity-btn" :disabled="item.quantity <= 1">-</button>
            <span class="quantity-number">{{ item.quantity }}</span>
            <button @click="increase(item)" class="quantity-btn">+</button>
          </div>
          <div class="item-total">{{ (item.price * item.quantity).toLocaleString() }}đ</div>
          <button @click="remove(item)" class="remove-btn" title="Xóa sản phẩm">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>

      <div class="cart-summary">
        <h2 class="text-xl font-bold mb-4">Tổng đơn hàng</h2>
        <div class="summary-row">
          <span>Tạm tính:</span>
          <span class="font-semibold">{{ subtotal.toLocaleString() }}đ</span>
        </div>
        <div class="summary-row">
          <span>Vận chuyển:</span>
          <span class="font-semibold">{{ shipping.toLocaleString() }}đ</span>
        </div>
        <div class="summary-row total">
          <span>Tổng cộng:</span>
          <span class="font-bold text-xl text-orange-500">{{ total.toLocaleString() }}đ</span>
        </div>
        <button class="checkout-btn" @click="goShipping">
          Tiến hành thanh toán
          <i class="fas fa-arrow-right ml-2"></i>
        </button>
        <router-link to="/products" class="continue-shopping">
          <i class="fas fa-arrow-left mr-2"></i>
          Tiếp tục mua sắm
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { useCartStore } from '../store/cart'

export default {
  name: 'CartPage',
  data() {
    return { 
      shipping: 30000,
      isRemoving: false
    }
  },
  computed: {
    cart() { return useCartStore() },
    cartItems() { return this.cart.items },
    subtotal() { return this.cart.cartTotal },
    total() { return this.subtotal + this.shipping }
  },
  methods: {
    increase(item) { 
      this.cart.updateQuantity(item.id, item.quantity + 1)
    },
    decrease(item) { 
      if (item.quantity > 1) {
        this.cart.updateQuantity(item.id, item.quantity - 1)
      }
    },
    remove(item) {
      if (this.isRemoving) return
      this.isRemoving = true
      const element = event.target.closest('.cart-item')
      if (element) {
        element.classList.add('removing')
      }
      setTimeout(() => {
        this.cart.removeItem(item.id)
        this.isRemoving = false
      }, 300)
    },
    goShipping() { 
      this.$router.push('/shipping')
    }
  }
}
</script>

<style scoped>
.cart-page {
  background: #fff;
  border-radius: 16px;
  padding: 32px;
  max-width: 1200px;
  margin: 32px auto;
}

.breadcrumb {
  margin-bottom: 16px;
}

.checkout-steps {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 32px 0;
}

.step {
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #aaa;
}

.step.active {
  color: #f90;
}

.step-number {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #eee;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 8px;
  font-weight: bold;
}

.step.active .step-number {
  background: #f90;
  color: white;
}

.step-line {
  width: 100px;
  height: 2px;
  background: #eee;
  margin: 0 16px;
}

.empty-cart {
  text-align: center;
  padding: 60px 0;
}

.cart-content {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 32px;
}

.cart-items {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
}

.cart-item {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr auto;
  align-items: center;
  padding: 16px;
  border-bottom: 1px solid #eee;
  transition: all 0.3s ease;
}

.cart-item.removing {
  transform: translateX(100%);
  opacity: 0;
}

.item-info {
  display: flex;
  align-items: center;
  gap: 16px;
}

.item-image {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
}

.item-details {
  flex: 1;
}

.item-name {
  font-weight: 600;
  margin-bottom: 4px;
}

.item-category {
  color: #666;
  font-size: 0.9em;
}

.item-quantity {
  display: flex;
  align-items: center;
  gap: 8px;
}

.quantity-btn {
  width: 32px;
  height: 32px;
  border: 1px solid #ddd;
  border-radius: 4px;
  background: white;
  cursor: pointer;
  transition: all 0.2s;
}

.quantity-btn:hover:not(:disabled) {
  background: #f90;
  color: white;
  border-color: #f90;
}

.quantity-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.quantity-number {
  min-width: 40px;
  text-align: center;
}

.remove-btn {
  color: #ff4444;
  background: none;
  border: none;
  cursor: pointer;
  padding: 8px;
  transition: all 0.2s;
}

.remove-btn:hover {
  color: #ff0000;
  transform: scale(1.1);
}

.cart-summary {
  background: #fff7f0;
  border-radius: 12px;
  padding: 24px;
  height: fit-content;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 12px;
  color: #666;
}

.summary-row.total {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid #ddd;
}

.checkout-btn {
  width: 100%;
  background: #f90;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 12px;
  font-size: 1.1em;
  cursor: pointer;
  margin-top: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.checkout-btn:hover {
  background: #f80;
  transform: translateY(-2px);
}

.continue-shopping {
  display: block;
  text-align: center;
  margin-top: 12px;
  color: #666;
  text-decoration: none;
  transition: all 0.2s;
}

.continue-shopping:hover {
  color: #f90;
}

@media (max-width: 768px) {
  .cart-content {
    grid-template-columns: 1fr;
  }
  
  .cart-item {
    grid-template-columns: 1fr;
    gap: 12px;
    text-align: center;
  }
  
  .item-info {
    flex-direction: column;
  }
  
  .item-quantity {
    justify-content: center;
  }
}
</style> 