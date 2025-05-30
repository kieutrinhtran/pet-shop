<template>
  <div class="auth-container">
    <img src="/images/logo.png" alt="Logo" class="auth-logo" />
    <h2>ĐĂNG KÝ</h2>
    <form @submit.prevent="register">
      <input v-model="username" placeholder="Tên đăng nhập" required />
      <input v-model="password" type="password" placeholder="Mật khẩu" required />
      <input v-model="confirm" type="password" placeholder="Xác thực mật khẩu" required />
      <button type="submit">Đăng ký</button>
    </form>
    <div class="auth-links">
      Đã có tài khoản?
      <router-link to="/login" class="highlight">Đăng nhập ngay</router-link>
    </div>
  </div>
</template>
<script>
export default {
  name: 'RegisterPage',
  data() {
    return { username: '', password: '', confirm: '' }
  },
  methods: {
    register() {
      if (this.password !== this.confirm) {
        alert('Mật khẩu xác thực không khớp!')
        return
      }
      // Giả lập đăng ký thành công
      this.$router.push('/register-success')
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