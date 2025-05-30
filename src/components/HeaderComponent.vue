<template>
  <header class="header-hero">
    <!-- Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <span class="icon"><i class="fas fa-phone"></i></span>
        <span>+84 123 456 789</span>
        <span class="icon"><i class="fas fa-envelope"></i></span>
        <span>wearepet@petshop.com</span>
      </div>
      <div class="topbar-center">
        <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
        <span>123 Lý Thường Kiệt, Phường 3, Quận 10, Thành phố Hồ Chí Minh</span>
      </div>
      <div class="topbar-right">
        <span class="icon"><i class="fas fa-user"></i></span>
        <span>Nguyễn Văn A</span>
      </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
      <div class="navbar-logo">
        <span class="paw-icon"><i class="fas fa-paw"></i></span>
        <span class="logo-text">Pet World</span>
      </div>
      <ul class="navbar-menu">
        <li :class="{ active: isHome }">
          <router-link to="/">Pet World</router-link>
        </li>
        <li :class="{ active: isHome }">
          <router-link to="/">Trang chủ</router-link>
        </li>
        <li :class="{ active: isProducts }">
          <router-link to="/products">Sản phẩm</router-link>
        </li>
        <li :class="{ active: isAbout }">
          <router-link to="/about">Về chúng tôi</router-link>
        </li>
      </ul>
      <div class="navbar-search-icons">
        <div class="search-box">
          <input type="text" placeholder="Tìm kiếm sản phẩm" />
          <span class="search-icon"><i class="fas fa-search"></i></span>
        </div>
        <span class="icon-heart">
          <i class="far fa-heart"></i>
          <span class="badge">0</span>
        </span>
        <span class="icon-cart">
          <i class="fas fa-shopping-cart"></i>
          <span class="badge">1</span>
        </span>
      </div>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'HeaderComponent',
  computed: {
    isHome() {
      return this.$route.path === '/';
    },
    isProducts() {
      return this.$route.path.startsWith('/products');
    },
    isAbout() {
      return this.$route.path === '/about';
    }
  }
}
</script>

<style scoped>
.header-hero {
  background: #fafbfc;
  font-family: 'Inter', Arial, sans-serif;
}

/* Topbar */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 15px;
  padding: 12px 40px 0 40px;
  color: #222;
}
.topbar-left, .topbar-center, .topbar-right {
  display: flex;
  align-items: center;
  gap: 8px;
}
.topbar-center {
  flex: 1;
  justify-content: center;
  text-align: center;
}
.topbar-right {
  min-width: 160px;
  justify-content: flex-end;
}

/* Navbar */
.navbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #fff;
  margin: 18px 40px 0 40px;
  border-radius: 32px;
  box-shadow: 0 4px 24px 0 rgba(0,0,0,0.04);
  padding: 0 32px;
  height: 64px;
  position: relative;
  z-index: 2;
}
.navbar-logo {
  display: flex;
  align-items: center;
  font-weight: 700;
  font-size: 20px;
}
.paw-icon {
  font-size: 22px;
  margin-right: 8px;
}
.navbar-menu {
  display: flex;
  list-style: none;
  margin: 0;
  padding: 0;
}
.navbar-menu li {
  margin: 0 18px;
  font-weight: 600;
  font-size: 18px;
}
.navbar-menu li.active a,
.navbar-menu li a:hover {
  color: #ff9000;
  border-bottom: 3px solid #ff9000;
  padding-bottom: 2px;
  transition: 0.2s;
}
.navbar-menu li a {
  color: #222;
  text-decoration: none;
  padding-bottom: 2px;
}
.navbar-search-icons {
  display: flex;
  align-items: center;
}
.search-box {
  position: relative;
  margin-right: 18px;
}
.search-box input {
  border: none;
  background: #f5f5f5;
  border-radius: 18px;
  padding: 8px 36px 8px 16px;
  font-size: 15px;
  outline: none;
  width: 180px;
}
.search-icon {
  position: absolute;
  right: 10px;
  top: 7px;
  font-size: 18px;
  color: #888;
}
.icon-heart, .icon-cart {
  position: relative;
  font-size: 22px;
  margin-right: 16px;
  cursor: pointer;
}
.icon-cart { margin-right: 0; }
.badge {
  position: absolute;
  top: -7px;
  right: -10px;
  background: #ff9000;
  color: #fff;
  border-radius: 50%;
  font-size: 12px;
  padding: 2px 6px;
  font-weight: 700;
}
@media (max-width: 900px) {
  .navbar, .topbar {
    margin: 0 10px;
    padding: 0 10px;
  }
  .navbar-menu li {
    font-size: 15px;
    margin: 0 8px;
  }
  .navbar-logo {
    font-size: 16px;
  }
}
</style>
