<template>
  <div class="products">
    <div class="filters mb-6">
      <div class="search-bar mb-4">
        <input 
          type="text" 
          v-model="searchQuery" 
          placeholder="Tìm kiếm sản phẩm..."
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500"
        >
      </div>
      <div class="category-filter">
        <select 
          v-model="selectedCategory" 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500"
        >
          <option value="">Tất cả danh mục</option>
          <option v-for="category in categories" :key="category" :value="category">
            {{ category }}
          </option>
        </select>
      </div>
    </div>

    <div v-if="filteredProducts.length === 0" class="text-center py-8">
      <p class="text-gray-500">Không tìm thấy sản phẩm nào</p>
    </div>

    <div v-else class="products-grid">
      <div v-for="product in filteredProducts" :key="product.id" class="product-card">
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
import { useCartStore } from '../store/cart'
import { PRODUCTS } from '../data/products'

export default {
  name: 'ProductsList',
  data() {
    return {
      products: PRODUCTS,
      searchQuery: '',
      selectedCategory: ''
    }
  },
  computed: {
    categories() {
      return [...new Set(this.products.map(product => product.category))]
    },
    filteredProducts() {
      let filtered = this.products

      // Filter by search query
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase()
        filtered = filtered.filter(product => 
          product.name.toLowerCase().includes(query) ||
          product.category.toLowerCase().includes(query)
        )
      }

      // Filter by category
      if (this.selectedCategory) {
        filtered = filtered.filter(product => 
          product.category === this.selectedCategory
        )
      }

      return filtered
    }
  },
  methods: {
    addToCart(product) {
      const cart = useCartStore()
      cart.addItem(product)
    }
  },
  created() {
    // Get search query from URL if exists
    const searchQuery = this.$route.query.search
    if (searchQuery) {
      this.searchQuery = searchQuery
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

/* Tablet (768px) */
@media (max-width: 768px) {
  .products-container {
    padding: 20px;
  }

  .filters {
    position: fixed;
    top: 0;
    left: -100%;
    width: 80%;
    height: 100vh;
    background: white;
    z-index: 1000;
    padding: 20px;
    transition: left 0.3s ease;
  }

  .filters.active {
    left: 0;
  }

  .filter-toggle {
    display: block;
    margin-bottom: 20px;
  }

  .products-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }

  .product-card {
    padding: 15px;
  }

  .product-card img {
    height: 200px;
  }

  .sort-options {
    flex-wrap: wrap;
    gap: 10px;
  }

  .sort-options select {
    width: 100%;
  }
}

/* Mobile (480px) */
@media (max-width: 480px) {
  .products-container {
    padding: 15px;
  }

  .filters {
    width: 100%;
  }

  .products-grid {
    grid-template-columns: 1fr;
  }

  .product-card {
    padding: 12px;
  }

  .product-card img {
    height: 180px;
  }

  .product-card h3 {
    font-size: 16px;
  }

  .product-card .price {
    font-size: 15px;
  }

  .sort-options {
    flex-direction: column;
  }

  .sort-options select,
  .sort-options button {
    width: 100%;
  }
}

/* Add smooth transitions */
.filters,
.product-card,
.sort-options select,
.sort-options button {
  transition: all 0.3s ease;
}

/* Improve touch targets for mobile */
@media (hover: none) {
  .filter-toggle,
  .product-card button,
  .sort-options select,
  .sort-options button {
    min-height: 44px;
    min-width: 44px;
  }
}
</style> 