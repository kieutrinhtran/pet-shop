<template>
  <div class="checkout-page">
    <div class="breadcrumb">
      <router-link to="/" class="text-gray-600 hover:text-orange-500">Trang chủ</router-link> &gt; 
      <router-link to="/cart" class="text-gray-600 hover:text-orange-500">Giỏ hàng</router-link> &gt; 
      <router-link to="/shipping" class="text-gray-600 hover:text-orange-500">Vận chuyển</router-link> &gt; 
      <span class="text-gray-800">Thanh toán</span>
    </div>
    <h1 class="text-2xl font-bold mb-6">Thanh toán</h1>
    <div class="checkout-steps">
      <div class="step">
        <div class="step-number">1</div>
        <div class="step-text">Vận chuyển</div>
      </div>
      <div class="step-line"></div>
      <div class="step active">
        <div class="step-number">2</div>
        <div class="step-text">Kiểm tra & Thanh toán</div>
      </div>
      <div class="step-line"></div>
      <div class="step">
        <div class="step-number">3</div>
        <div class="step-text">Thành công</div>
      </div>
    </div>

    <div class="checkout-content">
      <div class="payment-section">
        <div class="section-card">
          <h3 class="text-xl font-semibold mb-4">Phương thức thanh toán</h3>
          <div class="payment-methods">
            <label class="payment-method">
              <input 
                type="radio" 
                v-model="paymentMethod" 
                value="cod"
                class="method-radio"
              >
              <div class="method-info">
                <div class="method-icon">
                  <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="method-details">
                  <div class="method-name">Thanh toán khi nhận hàng</div>
                  <div class="method-description">Thanh toán bằng tiền mặt khi nhận hàng</div>
                </div>
              </div>
            </label>

            <label class="payment-method">
              <input 
                type="radio" 
                v-model="paymentMethod" 
                value="card"
                class="method-radio"
              >
              <div class="method-info">
                <div class="method-icon">
                  <i class="fas fa-credit-card"></i>
                </div>
                <div class="method-details">
                  <div class="method-name">Thẻ ngân hàng</div>
                  <div class="method-description">Thanh toán qua thẻ ATM/Visa/Mastercard</div>
                </div>
              </div>
            </label>

            <label class="payment-method">
              <input 
                type="radio" 
                v-model="paymentMethod" 
                value="ewallet"
                class="method-radio"
              >
              <div class="method-info">
                <div class="method-icon">
                  <i class="fas fa-wallet"></i>
                </div>
                <div class="method-details">
                  <div class="method-name">Ví điện tử</div>
                  <div class="method-description">Thanh toán qua MoMo, ZaloPay, VNPay</div>
                </div>
              </div>
            </label>
          </div>
        </div>

        <div class="section-card">
          <h3 class="text-xl font-semibold mb-4">Mã giảm giá</h3>
          <div class="discount-section">
            <div class="discount-input">
              <input 
                type="text" 
                v-model="discountCode" 
                placeholder="Nhập mã giảm giá"
                class="form-input"
                :class="{ 'error': discountError }"
              />
              <div v-if="discountError" class="error-message">{{ discountError }}</div>
            </div>
            <button 
              @click="applyDiscount" 
              class="apply-btn"
              :disabled="!discountCode"
            >
              Áp dụng
            </button>
          </div>
          <div v-if="discount" class="discount-applied">
            <div class="discount-info">
              <span class="discount-code">{{ discountCode }}</span>
              <span class="discount-amount">-{{ discount.toLocaleString() }}đ</span>
            </div>
            <button @click="removeDiscount" class="remove-discount">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>

        <button 
          class="checkout-btn" 
          @click="goSuccess"
          :disabled="!isValid"
        >
          Hoàn tất thanh toán
          <i class="fas fa-arrow-right ml-2"></i>
        </button>
      </div>

      <div class="order-summary">
        <h3 class="text-xl font-semibold mb-4">Đơn hàng của bạn</h3>
        <div class="cart-items">
          <div v-for="item in cartItems" :key="item.id" class="cart-item">
            <img :src="item.image" :alt="item.name" class="item-image" />
            <div class="item-details">
              <div class="item-name">{{ item.name }}</div>
              <div class="item-quantity">Số lượng: {{ item.quantity }}</div>
            </div>
            <div class="item-price">{{ (item.price * item.quantity).toLocaleString() }}đ</div>
          </div>
        </div>

        <div class="summary-total">
          <div class="summary-row">
            <span>Tạm tính:</span>
            <span class="font-semibold">{{ subtotal.toLocaleString() }}đ</span>
          </div>
          <div class="summary-row">
            <span>Vận chuyển:</span>
            <span class="font-semibold">{{ shipping.toLocaleString() }}đ</span>
          </div>
          <div v-if="discount" class="summary-row discount">
            <span>Giảm giá:</span>
            <span class="font-semibold text-green-600">-{{ discount.toLocaleString() }}đ</span>
          </div>
          <div class="summary-row total">
            <span>Tổng cộng:</span>
            <span class="font-bold text-xl text-orange-500">{{ total.toLocaleString() }}đ</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useCartStore } from '../store/cart'

export default {
  name: 'CheckoutPage',
  data() {
    return {
      shipping: 30000,
      discount: 0,
      discountCode: '',
      discountError: '',
      paymentMethod: 'cod'
    }
  },
  computed: {
    cart() { return useCartStore() },
    cartItems() { return this.cart.items },
    subtotal() { return this.cart.cartTotal },
    total() { return this.subtotal + this.shipping - this.discount },
    isValid() {
      return this.cartItems.length > 0 && this.paymentMethod
    }
  },
  methods: {
    applyDiscount() {
      this.discountError = ''
      if (!this.discountCode) {
        this.discountError = 'Vui lòng nhập mã giảm giá'
        return
      }
      switch (this.discountCode.toUpperCase()) {
        case 'GIAM50':
          this.discount = 50000
          break
        case 'GIAM100':
          this.discount = 100000
          break
        case 'GIAM200':
          this.discount = 200000
          break
        default:
          this.discountError = 'Mã giảm giá không hợp lệ'
          this.discount = 0
      }
    },
    removeDiscount() {
      this.discount = 0
      this.discountCode = ''
      this.discountError = ''
    },
    goSuccess() {
      if (this.isValid) {
        this.cart.clearCart()
        this.$router.push('/order-success')
      }
    }
  }
}
</script>

<style scoped>
.checkout-page {
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
  font-size: 1rem;
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

.checkout-content {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 32px;
}

.section-card {
  background: #fff7f0;
  border-radius: 12px;
  padding: 24px;
  margin-bottom: 24px;
}

.payment-methods {
  display: grid;
  gap: 12px;
}

.payment-method {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 16px;
  background: white;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
}

.payment-method:hover {
  background: #fff7f0;
}

.method-radio {
  width: 20px;
  height: 20px;
  accent-color: #f90;
}

.method-info {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 16px;
}

.method-icon {
  width: 40px;
  height: 40px;
  background: #fff7f0;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #f90;
  font-size: 1.2em;
}

.method-details {
  flex: 1;
}

.method-name {
  font-weight: 500;
  margin-bottom: 4px;
  font-size: 1.06rem;
}

.method-description {
  color: #666;
  font-size: 0.9em;
}

.discount-section {
  display: flex;
  gap: 12px;
}

.discount-input {
  flex: 1;
  position: relative;
}

.form-input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 1em;
}

.form-input:focus {
  outline: none;
  border-color: #f90;
}

.form-input.error {
  border-color: #ff4444;
}

.error-message {
  position: absolute;
  bottom: -20px;
  left: 0;
  color: #ff4444;
  font-size: 0.9em;
}

.apply-btn {
  padding: 12px 24px;
  background: #f90;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
}

.apply-btn:hover:not(:disabled) {
  background: #f80;
}

.apply-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.discount-applied {
  margin-top: 24px;
  padding: 12px;
  background: white;
  border-radius: 8px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.discount-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.discount-code {
  background: #fff7f0;
  color: #f90;
  padding: 4px 8px;
  border-radius: 4px;
  font-weight: 500;
  font-size: 1rem;
}

.discount-amount {
  color: #22c55e;
  font-weight: 600;
  font-size: 1rem;
}

.remove-discount {
  color: #666;
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  transition: all 0.2s;
}

.remove-discount:hover {
  color: #ff4444;
}

.checkout-btn {
  width: 100%;
  background: #f90;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 16px;
  font-size: 1.125rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.checkout-btn:hover:not(:disabled) {
  background: #f80;
  transform: translateY(-2px);
}

.checkout-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.order-summary {
  background: #fff7f0;
  border-radius: 12px;
  padding: 24px;
  height: fit-content;
}

.cart-items {
  margin-bottom: 24px;
}

.cart-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 0;
  border-bottom: 1px solid #eee;
}

.item-image {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 8px;
}

.item-details {
  flex: 1;
}

.item-name {
  font-weight: 500;
  margin-bottom: 4px;
}

.item-quantity {
  color: #666;
  font-size: 0.9em;
}

.item-price {
  font-weight: 600;
  color: #f90;
}

.summary-total {
  margin-top: 16px;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 12px;
  color: #666;
}

.summary-row.discount {
  color: #22c55e;
}

.summary-row.total {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid #ddd;
}

.checkout-page h1 {
  font-size: clamp(1.25rem, 4vw, 2rem);
}

.section-card h3, .order-summary h3 {
  font-size: 1.25rem;
}

/* Tablet (768px) */
@media (max-width: 768px) {
  .checkout-page {
    padding: 20px;
  }

  .checkout-container {
    flex-direction: column;
    gap: 30px;
  }

  .checkout-form {
    width: 100%;
  }

  .form-row {
    flex-direction: column;
    gap: 15px;
  }

  .form-group {
    width: 100%;
  }

  .order-summary {
    width: 100%;
    position: sticky;
    bottom: 0;
    background: white;
    z-index: 10;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
  }

  .payment-methods {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Mobile (480px) */
@media (max-width: 480px) {
  .checkout-page {
    padding: 15px;
  }

  .checkout-page h1 {
    font-size: 1.5rem;
  }

  .checkout-container {
    gap: 20px;
  }

  .form-group label {
    font-size: 0.88rem;
  }

  .form-group input,
  .form-group select {
    font-size: 0.88rem;
    padding: 8px 12px;
  }

  .payment-methods {
    grid-template-columns: 1fr;
  }

  .payment-method {
    padding: 12px;
  }

  .payment-method label {
    font-size: 0.88rem;
  }

  .order-summary {
    padding: 15px;
  }

  .summary-item {
    font-size: 0.88rem;
  }

  .place-order-btn {
    padding: 12px;
    font-size: 1rem;
  }
}

/* Add smooth transitions */
.checkout-container,
.form-group input,
.form-group select,
.payment-method,
.place-order-btn {
  transition: all 0.3s ease;
}

/* Improve touch targets for mobile */
@media (hover: none) {
  .form-group input,
  .form-group select,
  .payment-method,
  .place-order-btn {
    min-height: 44px;
    min-width: 44px;
  }
}
</style> 