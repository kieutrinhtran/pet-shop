<template>
  <div class="products">
    <h2>Sản phẩm</h2>
    <div class="products-grid">
      <div v-for="product in products" :key="product.id" class="product-card">
        <router-link :to="`/products/${product.id}`">
          <img :src="product.image" :alt="product.name">
          <h3>{{ product.name }}</h3>
        </router-link>
        <p class="category">{{ product.category }}</p>
        <p class="price">{{ product.price.toLocaleString() }}đ</p>
        <button @click="addToCart(product)" class="add-to-cart">Thêm vào giỏ</button>
      </div>
    </div>
  </div>
</template>

<script>
import { cartStore } from '../store/cart'
import { PRODUCTS } from '../data/products'

export default {
  name: 'ProductsList',
  data() {
    return {
      products: PRODUCTS
    }
  },
  methods: {
    addToCart(product) {
      cartStore.addItem(product)
    }
  }
}
</script>

<style scoped>
.products {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.product-card {
  background: white;
  border-radius: 8px;
  padding: 15px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  text-align: center;
}

.product-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 4px;
}

.product-card h3 {
  margin: 10px 0 0 0;
}

.category {
  color: #888;
  font-size: 0.95em;
  margin: 4px 0;
}

.price {
  color: #f90;
  font-weight: bold;
  font-size: 1.2em;
  margin: 10px 0;
}

.add-to-cart {
  width: 100%;
  padding: 10px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.add-to-cart:hover {
  background-color: #45a049;
}
</style> 