import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [],
    total: 0
  }),
  
  getters: {
    cartItems: (state) => state.items,
    cartTotal: (state) => state.total,
    itemCount: (state) => state.items.length
  },
  
  actions: {
    addItem(product) {
      const existingItem = this.items.find(item => item.id === product.id)
      if (existingItem) {
        existingItem.quantity++
      } else {
        this.items.push({
          ...product,
          quantity: 1
        })
      }
      this.calculateTotal()
    },
    
    removeItem(productId) {
      const index = this.items.findIndex(item => item.id === productId)
      if (index > -1) {
        this.items.splice(index, 1)
        this.calculateTotal()
      }
    },
    
    updateQuantity(productId, quantity) {
      const item = this.items.find(item => item.id === productId)
      if (item) {
        item.quantity = quantity
        this.calculateTotal()
      }
    },
    
    calculateTotal() {
      this.total = this.items.reduce((total, item) => {
        return total + (item.price * item.quantity)
      }, 0)
    },
    
    clearCart() {
      this.items = []
      this.total = 0
    }
  }
}) 