<template>
  <div class="shipping-page">
    <div class="breadcrumb">
      <router-link to="/" class="text-gray-600 hover:text-orange-500">Trang chủ</router-link> &gt; 
      <router-link to="/cart" class="text-gray-600 hover:text-orange-500">Giỏ hàng</router-link> &gt; 
      <span class="text-gray-800">Vận chuyển</span>
    </div>
    <h1 class="text-2xl font-bold mb-6">Vận chuyển</h1>
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

    <div class="shipping-content">
      <div class="address-section">
        <div class="section-header">
          <h3 class="text-xl font-semibold">Địa chỉ nhận hàng</h3>
          <button v-if="!isEditing" @click="startEditing" class="edit-btn">
            <i class="fas fa-edit mr-2"></i>
            Thay đổi
          </button>
        </div>

        <div v-if="!isEditing" class="address-info">
          <div class="user-info">
            <div class="name-phone">
              <span class="font-semibold">{{ shippingInfo.name }}</span>
              <span class="text-gray-500">|</span>
              <span class="text-gray-600">{{ shippingInfo.phone }}</span>
            </div>
            <div class="address text-gray-600">
              {{ shippingInfo.address }}
            </div>
          </div>
        </div>

        <form v-else @submit.prevent="saveAddress" class="address-form">
          <div class="form-group">
            <label for="name">Họ và tên</label>
            <input 
              type="text" 
              id="name" 
              v-model="shippingInfo.name" 
              required
              class="form-input"
            >
          </div>

          <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input 
              type="tel" 
              id="phone" 
              v-model="shippingInfo.phone" 
              required
              pattern="[0-9]{10}"
              class="form-input"
            >
          </div>

          <div class="form-group">
            <label for="address">Địa chỉ</label>
            <textarea 
              id="address" 
              v-model="shippingInfo.address" 
              required
              rows="3"
              class="form-input"
            ></textarea>
          </div>

          <div class="form-actions">
            <button type="button" @click="cancelEditing" class="cancel-btn">
              Hủy
            </button>
            <button type="submit" class="save-btn">
              Lưu thay đổi
            </button>
          </div>
        </form>
      </div>

      <div class="shipping-method">
        <h3 class="text-xl font-semibold mb-4">Phương thức vận chuyển</h3>
        <div class="method-options">
          <label class="method-option">
            <input 
              type="radio" 
              v-model="shippingMethod" 
              value="standard"
              class="method-radio"
            >
            <div class="method-info">
              <div class="method-name">Giao hàng tiêu chuẩn</div>
              <div class="method-price">30.000đ</div>
            </div>
          </label>

          <label class="method-option">
            <input 
              type="radio" 
              v-model="shippingMethod" 
              value="express"
              class="method-radio"
            >
            <div class="method-info">
              <div class="method-name">Giao hàng nhanh</div>
              <div class="method-price">50.000đ</div>
            </div>
          </label>
        </div>
      </div>

      <div class="order-summary">
        <h3 class="text-xl font-semibold mb-4">Tổng đơn hàng</h3>
        <div class="summary-row">
          <span>Tạm tính:</span>
          <span class="font-semibold">{{ subtotal.toLocaleString() }}đ</span>
        </div>
        <div class="summary-row">
          <span>Vận chuyển:</span>
          <span class="font-semibold">{{ shippingCost.toLocaleString() }}đ</span>
        </div>
        <div class="summary-row total">
          <span>Tổng cộng:</span>
          <span class="font-bold text-xl text-orange-500">{{ total.toLocaleString() }}đ</span>
        </div>
      </div>

      <button class="next-btn" @click="goCheckout" :disabled="!isValid">
        Tiến hành thanh toán
        <i class="fas fa-arrow-right ml-2"></i>
      </button>
    </div>
  </div>
</template>

<script>
import { useCartStore } from '../store/cart'

export default {
  name: 'ShippingPage',
  data() {
    return {
      isEditing: false,
      shippingMethod: 'standard',
      shippingInfo: {
        name: 'Nguyễn Văn A',
        phone: '0347895555',
        address: '123 Nguyễn Thị Minh Khai, Phường 6, Quận 3, TP. HCM'
      }
    }
  },
  computed: {
    cart() { return useCartStore() },
    subtotal() {
      return this.cart.cartTotal
    },
    shippingCost() {
      return this.shippingMethod === 'standard' ? 30000 : 50000
    },
    total() {
      return this.subtotal + this.shippingCost
    },
    isValid() {
      return this.shippingInfo.name && 
             this.shippingInfo.phone && 
             this.shippingInfo.address &&
             this.shippingMethod
    }
  },
  methods: {
    startEditing() {
      this.isEditing = true
    },
    cancelEditing() {
      this.isEditing = false
    },
    saveAddress() {
      this.isEditing = false
    },
    goCheckout() {
      if (this.isValid) {
        this.$router.push('/checkout')
      }
    }
  }
}
</script>

<style scoped>
.shipping-page {
  background: #fff;
  border-radius: 16px;
  padding: 32px;
  max-width: 900px;
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

.shipping-content {
  display: grid;
  gap: 24px;
}

.address-section {
  background: #fff7f0;
  border-radius: 12px;
  padding: 24px;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

.edit-btn {
  background: #fff;
  border: 1px solid #f90;
  color: #f90;
  border-radius: 6px;
  padding: 8px 16px;
  cursor: pointer;
  transition: all 0.2s;
}

.edit-btn:hover {
  background: #f90;
  color: white;
}

.address-info {
  background: white;
  border-radius: 8px;
  padding: 16px;
}

.user-info {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.name-phone {
  display: flex;
  gap: 8px;
  align-items: center;
}

.address-form {
  display: grid;
  gap: 16px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-weight: 500;
  color: #666;
}

.form-input {
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 1em;
}

.form-input:focus {
  outline: none;
  border-color: #f90;
}

.form-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  margin-top: 8px;
}

.cancel-btn {
  padding: 8px 16px;
  border: 1px solid #ddd;
  border-radius: 6px;
  background: white;
  color: #666;
  cursor: pointer;
  transition: all 0.2s;
}

.cancel-btn:hover {
  background: #f5f5f5;
}

.save-btn {
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  background: #f90;
  color: white;
  cursor: pointer;
  transition: all 0.2s;
}

.save-btn:hover {
  background: #f80;
}

.shipping-method {
  background: #fff7f0;
  border-radius: 12px;
  padding: 24px;
}

.method-options {
  display: grid;
  gap: 12px;
}

.method-option {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px;
  background: white;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
}

.method-option:hover {
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
  justify-content: space-between;
  align-items: center;
}

.method-name {
  font-weight: 500;
}

.method-price {
  color: #f90;
  font-weight: 600;
}

.order-summary {
  background: #fff7f0;
  border-radius: 12px;
  padding: 24px;
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

.next-btn {
  width: 100%;
  background: #f90;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 12px;
  font-size: 1.1em;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.next-btn:hover:not(:disabled) {
  background: #f80;
  transform: translateY(-2px);
}

.next-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

@media (max-width: 768px) {
  .shipping-page {
    padding: 16px;
    margin: 16px;
  }

  .checkout-steps {
    flex-direction: column;
    gap: 16px;
  }

  .step-line {
    width: 2px;
    height: 40px;
  }

  .method-info {
    flex-direction: column;
    align-items: flex-start;
    gap: 4px;
  }
}
</style> 