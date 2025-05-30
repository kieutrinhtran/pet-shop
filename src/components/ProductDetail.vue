<template>
  <div class="product-detail" v-if="product">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
      <router-link to="/">Trang chủ</router-link> &gt; <span>Sản phẩm</span>
    </div>

    <!-- Product Main Info -->
    <div class="product-main">
      <img :src="product.image" :alt="product.name" class="product-img" />
      <div class="product-info">
        <h1>{{ product.name }}</h1>
        <div class="price-row">
          <span class="price">{{ product.price.toLocaleString() }}đ</span>
          <span class="old-price" v-if="product.oldPrice">{{ product.oldPrice.toLocaleString() }}đ</span>
          <span class="discount" v-if="product.discount">Tiết kiệm {{ product.discount }}%</span>
        </div>
        <div class="variant-row" v-if="product.variants && product.variants.length">
          <span>Phân loại:</span>
          <button
            v-for="variant in product.variants"
            :key="variant"
            :class="{ active: selectedVariant === variant }"
            @click="selectedVariant = variant"
          >{{ variant }}</button>
        </div>
        <div class="quantity-row">
          <span>Số lượng:</span>
          <button @click="decreaseQty">-</button>
          <span>{{ quantity }}</span>
          <button @click="increaseQty">+</button>
        </div>
        <div class="action-row">
          <button class="add-cart" @click="addToCart">Thêm vào giỏ hàng</button>
          <button class="buy-now" @click="buyNow">Mua ngay</button>
        </div>
        <div class="shipping-note">
          <span>Miễn phí shipping: Cho đơn trên 500,000đ</span>
        </div>
      </div>
    </div>

    <!-- Product Description -->
    <div class="product-desc">
      <h2>Mô tả</h2>
      <div v-html="product.description"></div>
      <div class="desc-images">
        <img v-for="img in product.descImages" :key="img" :src="img" />
      </div>
    </div>

    <!-- Relevant Products -->
    <div class="relevant-products" v-if="relevantProducts.length">
      <h2>Sản phẩm liên quan</h2>
      <div class="relevant-list">
        <div v-for="item in relevantProducts" :key="item.id" class="relevant-item">
          <router-link :to="`/products/${item.id}`">
            <img :src="item.image" :alt="item.name" />
            <div>{{ item.name }}</div>
          </router-link>
          <div class="price">{{ item.price.toLocaleString() }}đ</div>
          <button @click="addToCart(item)">Thêm vào giỏ</button>
        </div>
      </div>
    </div>
  </div>
  <div v-else class="not-found">Không tìm thấy sản phẩm.</div>
</template>

<script>
import { useCartStore } from '../store/cart'
import { PRODUCTS } from '../data/products'
export default {
  name: 'ProductDetail',
  data() {
    return {
      product: null,
      selectedVariant: '',
      quantity: 1,
      relevantProducts: []
    }
  },
  created() {
    const id = Number(this.$route.params.id)
    const found = PRODUCTS.find(p => p.id === id)
    if (found) {
      this.product = found
      this.selectedVariant = found.variants ? found.variants[0] : ''
      this.relevantProducts = PRODUCTS.filter(p => p.id !== id).slice(0, 4)
    }
  },
  watch: {
    '$route.params.id'(newId) {
      const id = Number(newId)
      const found = PRODUCTS.find(p => p.id === id)
      if (found) {
        this.product = found
        this.selectedVariant = found.variants ? found.variants[0] : ''
        this.relevantProducts = PRODUCTS.filter(p => p.id !== id).slice(0, 4)
      }
    }
  },
  methods: {
    increaseQty() { this.quantity++ },
    decreaseQty() { if (this.quantity > 1) this.quantity-- },
    addToCart(product = null) {
      const cart = useCartStore()
      const item = product || {
        ...this.product,
        variant: this.selectedVariant,
        quantity: this.quantity
      }
      cart.addItem(item)
      alert('Đã thêm vào giỏ hàng!')
    },
    buyNow() {
      this.addToCart()
      this.$router.push('/cart')
    }
  }
}
</script>

<style scoped>
.product-detail { background: #fff; border-radius: 16px; padding: 32px; max-width: 1200px; margin: 32px auto; }
.breadcrumb { color: #888; margin-bottom: 16px; }
.product-main { display: flex; gap: 32px; }
.product-img { width: 320px; height: 320px; object-fit: contain; border-radius: 12px; background: #fafafa; }
.product-info { flex: 1; }
.price-row { font-size: 1.5em; color: #f90; margin-bottom: 8px; }
.old-price { text-decoration: line-through; color: #aaa; margin-left: 12px; font-size: 1em; }
.discount { background: #ff4444; color: #fff; border-radius: 4px; padding: 2px 8px; margin-left: 12px; font-size: 0.9em; }
.variant-row { margin: 16px 0; }
.variant-row button { margin-right: 8px; padding: 6px 16px; border: 1px solid #f90; background: #fff; color: #f90; border-radius: 6px; cursor: pointer; }
.variant-row button.active { background: #f90; color: #fff; }
.quantity-row { margin: 16px 0; display: flex; align-items: center; gap: 8px; }
.quantity-row button { width: 32px; height: 32px; border: 1px solid #ccc; background: #fff; border-radius: 4px; font-size: 1.2em; cursor: pointer; }
.action-row { margin: 16px 0; display: flex; gap: 16px; }
.add-cart, .buy-now { padding: 10px 24px; border-radius: 6px; border: 1px solid #f90; background: #fff; color: #f90; font-weight: bold; cursor: pointer; }
.buy-now { background: #f90; color: #fff; }
.shipping-note { color: #f90; margin-top: 8px; }
.product-desc { margin: 32px 0; }
.product-desc h2 { color: #f90; margin-bottom: 12px; }
.desc-images { display: flex; gap: 16px; margin-top: 16px; }
.desc-images img { width: 160px; height: 160px; object-fit: contain; border-radius: 8px; background: #fafafa; }
.relevant-products { margin: 32px 0; }
.relevant-list { display: flex; gap: 24px; }
.relevant-item { background: #fafafa; border-radius: 12px; padding: 16px; text-align: center; width: 180px; }
.relevant-item img { width: 120px; height: 120px; object-fit: contain; border-radius: 8px; }
.relevant-item .price { color: #f90; font-weight: bold; margin: 8px 0; }
.show-more { margin-top: 16px; padding: 8px 24px; border: 1px solid #f90; background: #fff; color: #f90; border-radius: 6px; cursor: pointer; }
.not-found { text-align: center; color: #ff4444; padding: 40px; }
</style> 