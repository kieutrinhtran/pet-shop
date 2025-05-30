import { createRouter, createWebHistory } from 'vue-router'
import ProductsList from '../components/ProductsList.vue'
import ProductDetail from '../components/ProductDetail.vue'
import CartPage from '../components/CartPage.vue'
import ShippingPage from '../components/ShippingPage.vue'
import CheckoutPage from '../components/CheckoutPage.vue'
import OrderSuccess from '../components/OrderSuccess.vue'
import AboutPage from '../components/AboutPage.vue'
import LoginPage from '../components/LoginPage.vue'
import RegisterPage from '../components/RegisterPage.vue'
import LoginSuccess from '../components/LoginSuccess.vue'
import RegisterSuccess from '../components/RegisterSuccess.vue'
import HomePage from '../components/HomePage.vue'
import AdminOrderManagement from '../components/AdminOrderManagement.vue'

const routes = [
  {
    path: '/products',
    name: 'ProductsList',
    component: ProductsList
  },
  {
    path: '/products/:id',
    name: 'ProductDetail',
    component: ProductDetail
  },
  {
    path: '/cart',
    name: 'CartPage',
    component: CartPage
  },
  {
    path: '/shipping',
    name: 'ShippingPage',
    component: ShippingPage
  },
  {
    path: '/checkout',
    name: 'CheckoutPage',
    component: CheckoutPage
  },
  {
    path: '/order-success',
    name: 'OrderSuccess',
    component: OrderSuccess
  },
  {
    path: '/about',
    name: 'AboutPage',
    component: AboutPage
  },
  {
    path: '/login',
    name: 'LoginPage',
    component: LoginPage
  },
  {
    path: '/register',
    name: 'RegisterPage',
    component: RegisterPage
  },
  {
    path: '/login-success',
    name: 'LoginSuccess',
    component: LoginSuccess
  },
  {
    path: '/register-success',
    name: 'RegisterSuccess',
    component: RegisterSuccess
  },
  {
    path: '/',
    name: 'HomePage',
    component: HomePage
  },
  {
    path: '/admin/orders',
    name: 'AdminOrderManagement',
    component: AdminOrderManagement
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router 