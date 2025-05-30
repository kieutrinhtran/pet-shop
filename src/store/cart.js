import { reactive } from 'vue'

const state = reactive({
  items: []
})

export const cartStore = {
  state,
  
  addItem(product) {
    const existingItem = state.items.find(item => item.id === product.id)
    if (existingItem) {
      existingItem.quantity++
    } else {
      state.items.push({
        ...product,
        quantity: 1
      })
    }
  },

  removeItem(productId) {
    const index = state.items.findIndex(item => item.id === productId)
    if (index > -1) {
      state.items.splice(index, 1)
    }
  },

  updateQuantity(productId, quantity) {
    const item = state.items.find(item => item.id === productId)
    if (item) {
      item.quantity = quantity
    }
  },

  getItemCount() {
    return state.items.reduce((total, item) => total + item.quantity, 0)
  },

  getTotal() {
    return state.items.reduce((total, item) => total + (item.price * item.quantity), 0)
  }
} 