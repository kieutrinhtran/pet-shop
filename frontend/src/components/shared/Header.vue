<template>
  <header class="header-wrapper">
    <!-- Top bar -->
    <div class="header-top">
      <div class="header-contact">
        <span class="icon"><i class="fas fa-phone"></i></span>
        <span class="contact-text">+84 123 456 789</span>
        <span class="icon email"><i class="fas fa-envelope"></i></span>
        <span class="contact-text">wearepet@petshop.com</span>
      </div>
      <div class="header-admin">
        <span class="icon user"><i class="fas fa-user"></i></span>
        <span class="admin-text">Quản lý cửa hàng</span>
      </div>
    </div>
    <!-- Menu bar -->
    <nav class="header-menu">
      <ul>
        <li class="logo">
          <span class="paw-icon"><i class="fas fa-paw"></i></span>
          <span class="logo-text">Pet World</span>
        </li>
        <li>Khách hàng</li>
        <li>Đơn hàng</li>
        <li>Sản phẩm</li>
        <li class="active">Mã khuyến mãi</li>
        <li>Thống kê</li>
      </ul>
    </nav>
  </header>
</template>

<script setup>
// Không cần logic JS cho header này
</script>

<style scoped>
.header-wrapper {
  width: 100%;
  background: #fafbfc;
  padding-bottom: 24px;
}
.header-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 32px 0 0 0;
  font-size: 18px;
  color: #222;
}
.header-contact {
  display: flex;
  align-items: center;
  gap: 16px;
}
.header-contact .icon {
  color: #ff9000;
  margin-right: 4px;
}
.header-contact .email {
  margin-left: 16px;
}
.header-admin {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #ff9000;
  font-weight: 700;
  font-size: 24px;
  border-bottom: 4px solid #ff9000;
  padding-bottom: 2px;
}
.header-admin .icon {
  font-size: 28px;
}
.header-menu {
  display: flex;
  justify-content: center;
  margin-top: 32px;
}
.header-menu ul {
  display: flex;
  align-items: center;
  background: #fff;
  border-radius: 48px;
  box-shadow: 0 4px 16px 0 rgba(0,0,0,0.06);
  padding: 0 32px;
  min-height: 80px;
  gap: 48px;
  list-style: none;
}
.header-menu li {
  font-size: 26px;
  font-weight: 700;
  color: #222;
  cursor: pointer;
  transition: color 0.2s, border-bottom 0.2s;
  padding: 0 8px;
  line-height: 80px;
}
.header-menu .logo {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 26px;
  color: #222;
  font-weight: 700;
  margin-right: 32px;
}
.header-menu .paw-icon {
  color: #222;
  font-size: 32px;
}
.header-menu .active {
  color: #ff9000;
  border-bottom: 4px solid #ff9000;
  padding-bottom: 4px;
}
@media (max-width: 900px) {
  .header-menu ul {
    gap: 16px;
    padding: 0 8px;
  }
  .header-menu li {
    font-size: 18px;
    line-height: 56px;
  }
  .header-menu .logo {
    font-size: 18px;
    margin-right: 8px;
  }
}
</style>
