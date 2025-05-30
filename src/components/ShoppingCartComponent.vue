<template>
  <div class="shopping-cart">
    <h2>Shopping Cart</h2>
    <div v-if="cartItems.length === 0" class="empty-cart">
      <p>Your cart is empty</p>
      <router-link to="/products" class="continue-shopping">Continue Shopping</router-link>
    </div>
    <div v-else class="cart-content">
      <div class="cart-items">
        <div v-for="item in cartItems" :key="item.id" class="cart-item">
          <img :src="item.image" :alt="item.name" class="item-image">
          <div class="item-details">
            <h3>{{ item.name }}</h3>
            <p class="price">${{ item.price }}</p>
            <div class="quantity-controls">
              <button @click="decreaseQuantity(item)" :disabled="item.quantity <= 1">-</button>
              <span>{{ item.quantity }}</span>
              <button @click="increaseQuantity(item)">+</button>
            </div>
          </div>
          <button @click="removeItem(item)" class="remove-btn">Remove</button>
        </div>
      </div>
      <div class="cart-summary">
        <h3>Order Summary</h3>
        <div class="summary-item">
          <span>Subtotal:</span>
          <span>${{ subtotal }}</span>
        </div>
        <div class="summary-item">
          <span>Shipping:</span>
          <span>${{ shipping }}</span>
        </div>
        <div class="summary-item total">
          <span>Total:</span>
          <span>${{ total }}</span>
        </div>
        <button @click="checkout" class="checkout-btn">Proceed to Checkout</button>
      </div>
    </div>
  </div>
</template>

<script>
import { cartStore } from '../store/cart'

export default {
  name: 'ShoppingCartComponent',
  data() {
    return {
      shipping: 5.99
    }
  },
  computed: {
    cartItems() {
      return cartStore.state.items
    },
    subtotal() {
      return cartStore.getTotal().toFixed(2)
    },
    total() {
      return (parseFloat(this.subtotal) + this.shipping).toFixed(2)
    }
  },
  methods: {
    increaseQuantity(item) {
      cartStore.updateQuantity(item.id, item.quantity + 1)
    },
    decreaseQuantity(item) {
      if (item.quantity > 1) {
        cartStore.updateQuantity(item.id, item.quantity - 1)
      }
    },
    removeItem(item) {
      cartStore.removeItem(item.id)
    },
    checkout() {
      // Implement checkout logic here
      alert('Proceeding to checkout...')
    }
  }
}
</script>

<style scoped>
.shopping-cart {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.empty-cart {
  text-align: center;
  padding: 40px;
}

.continue-shopping {
  display: inline-block;
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  text-decoration: none;
  border-radius: 4px;
}

.cart-content {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 20px;
}

.cart-items {
  background: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.cart-item {
  display: flex;
  align-items: center;
  padding: 15px 0;
  border-bottom: 1px solid #eee;
}

.item-image {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 4px;
  margin-right: 20px;
}

.item-details {
  flex-grow: 1;
}

.quantity-controls {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-top: 10px;
}

.quantity-controls button {
  width: 30px;
  height: 30px;
  border: 1px solid #ddd;
  background: white;
  border-radius: 4px;
  cursor: pointer;
}

.quantity-controls button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.remove-btn {
  padding: 8px 15px;
  background-color: #ff4444;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.cart-summary {
  background: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  height: fit-content;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  margin: 10px 0;
  padding: 10px 0;
  border-bottom: 1px solid #eee;
}

.total {
  font-weight: bold;
  font-size: 1.2em;
}

.checkout-btn {
  width: 100%;
  padding: 15px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 20px;
  font-size: 1.1em;
}

.checkout-btn:hover {
  background-color: #45a049;
}

@media (max-width: 768px) {
  .cart-content {
    grid-template-columns: 1fr;
  }
}
</style> 