<template>
  <div class="auth-container">
    <img src="/images/logo.png" alt="Logo" class="auth-logo" />
    <h2>ĐĂNG NHẬP</h2>
    <form @submit.prevent="login">
      <input v-model="username" placeholder="Tên đăng nhập" required />
      <input v-model="password" type="password" placeholder="Mật khẩu" required />
      <button type="submit">Đăng nhập</button>
    </form>
    <div class="auth-links">
      <router-link to="#">Quên mật khẩu?</router-link>
      <div>
        Chưa có tài khoản?
        <router-link to="/register" class="highlight">Đăng ký ngay</router-link>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'LoginPage',
  data() {
    return { username: '', password: '' }
  },
  methods: {
    login() {
      // Giả lập đăng nhập thành công
      this.$router.push('/login-success')
    }
  }
}
</script>
<style scoped>
.auth-container { background: #f5f7fa; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; }
.auth-logo { width: 220px; margin-bottom: 24px; }
h2 { margin-bottom: 24px; }
form { display: flex; flex-direction: column; gap: 16px; width: 350px; }
input { padding: 12px; border-radius: 6px; border: 1px solid #ccc; background: #ffe5c2; }
button { background: #f90; color: #fff; border: none; border-radius: 6px; padding: 12px; font-size: 1.1em; cursor: pointer; }
.auth-links { margin-top: 24px; text-align: center; }
.auth-links .highlight { color: #f90; font-weight: bold; margin-left: 4px; }
</style> 