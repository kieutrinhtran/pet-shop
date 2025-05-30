import { createRouter, createWebHistory } from 'vue-router'
import ProductsList from '../views/ProductsList.vue'
import ProductDetail from '../views/ProductDetail.vue'
import CartPage from '../views/CartPage.vue'
import ShippingPage from '../views/ShippingPage.vue'
import CheckoutPage from '../views/CheckoutPage.vue'
import OrderSuccess from '../views/OrderSuccess.vue'
import AboutPage from '../views/AboutPage.vue'
import LoginPage from '../views/LoginPage.vue'
import RegisterPage from '../views/RegisterPage.vue'
import LoginSuccess from '../views/LoginSuccess.vue'
import RegisterSuccess from '../views/RegisterSuccess.vue'
import HomePage from '../views/HomePage.vue'
import AdminOrderManagement from '../views/AdminOrderManagement.vue'

const routes = [
  {
    path: '/',
    name: 'HomePage',
    component: HomePage
  },
  {
    path: '/products',
    name: 'ProductsList',
    component: ProductsList
  },
  {
    path: '/products/:id',
    name: 'ProductDetail',
    component: ProductDetail,
    props: true
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
    path: '/admin/orders',
    name: 'AdminOrderManagement',
    component: AdminOrderManagement
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('../views/NotFound.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router 