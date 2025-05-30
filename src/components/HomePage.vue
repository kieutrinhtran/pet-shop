<template>
  <div class="homepage">
    <!-- HeaderBar -->
    <header class="header-bar">
      <div class="header-top">
        <span><i class="fas fa-phone"></i> +84 123 456 789</span>
        <span><i class="fas fa-envelope"></i> wearpet@petshop.com</span>
        <span><i class="fas fa-map-marker-alt"></i> 123 Lý Thường Kiệt, Quận 10, TP.HCM</span>
        <span class="header-user"><i class="fas fa-user-circle"></i> Nguyễn Văn A</span>
      </div>
      <nav class="header-nav">
        <img src="/images/logo.png" alt="Pet Shop Logo" class="logo" />
        <router-link to="/">Pet World</router-link>
        <router-link to="/">Trang chủ</router-link>
        <router-link to="/products">Sản phẩm</router-link>
        <router-link to="/about">Về chúng tôi</router-link>
        <div class="search-bar">
          <input type="text" placeholder="Tìm kiếm sản phẩm" />
          <button><i class="fas fa-search"></i></button>
        </div>
        <router-link to="/cart" class="cart-link">
          <i class="fas fa-shopping-cart"></i>
        </router-link>
        <span class="header-user-mobile"><i class="fas fa-user-circle"></i></span>
      </nav>
    </header>

    <!-- BannerSection -->
    <section class="banner-section">
      <div class="banner-content">
        <h1>Thiên đường mua sắm dành cho thú cưng!</h1>
        <p>Dịch vụ tận tâm – Trải nghiệm mua sắm độc đáo!</p>
        <button class="cta-btn">Mua ngay</button>
      </div>
      <img src="/images/banner-pets.jpg" alt="Banner Pets" class="banner-img" />
      <div class="banner-decor"></div>
    </section>

    <!-- QuickCategorySection -->
    <section class="quick-category-section">
      <div class="quick-category">
        <img src="/images/dog-category.jpg" alt="Dog" />
        <span>Mua sắm cho cún</span>
      </div>
      <div class="quick-category">
        <img src="/images/cat-category.jpg" alt="Cat" />
        <span>Mua sắm cho mèo</span>
      </div>
    </section>

    <!-- ProductCategorySection -->
    <section class="product-category-section">
      <h2>Danh mục sản phẩm</h2>
      <div class="product-category-list">
        <div class="product-category-item">
          <img src="/images/fashion.jpg" alt="Quần áo/Thời trang" />
          <span>Quần áo/Thời trang</span>
        </div>
        <div class="product-category-item">
          <img src="/images/food.jpg" alt="Thức ăn" />
          <span>Thức ăn</span>
        </div>
        <div class="product-category-item">
          <img src="/images/care.jpg" alt="Phụ kiện chăm sóc" />
          <span>Phụ kiện chăm sóc</span>
        </div>
        <div class="product-category-item">
          <img src="/images/clean.jpg" alt="Vật dụng vệ sinh" />
          <span>Vật dụng vệ sinh</span>
        </div>
      </div>
    </section>

    <!-- BestSellerSection -->
    <section class="bestseller-section">
      <h2>Các sản phẩm bán chạy</h2>
      <div class="bestseller-list">
        <div class="bestseller-item">
          <img src="/images/royal-canin-chihuahua.jpg" alt="Royal Canin Chihuahua" />
          <span>Chihuahua Puppy</span>
          <span>300.000đ</span>
        </div>
        <div class="bestseller-item">
          <img src="/images/royal-canin-hairskin.jpg" alt="Royal Canin Hair & Skin" />
          <span>Royal Canin Hair & Skin</span>
          <span>300.000đ</span>
        </div>
        <div class="bestseller-item">
          <img src="/images/pedigree-adult.jpg" alt="Pedigree Adult" />
          <span>Pedigree - Vị bò và rau củ</span>
          <span>300.000đ</span>
        </div>
      </div>
    </section>

    <!-- BrandSection -->
    <section class="brand-section">
      <h2>1000+ Thương Hiệu Boss Thích</h2>
      <div class="brand-list">
        <img src="/images/brand-royalcanin.png" alt="Royal Canin" />
        <img src="/images/brand-hi-raw.png" alt="Hi Raw" />
        <img src="/images/brand-equilibrio.png" alt="Equilibrio" />
        <!-- ... thêm các logo khác ... -->
      </div>
    </section>

    <!-- StoreSection -->
    <section class="store-section">
      <h2>Mua Trực Tiếp Tại Cửa Hàng</h2>
      <div class="store-list">
        <div class="store-item">
          <img src="/images/store-1.jpg" alt="Store 1" />
          <span>Pet World - Lý Thường Kiệt</span>
        </div>
        <div class="store-item">
          <img src="/images/store-2.jpg" alt="Store 2" />
          <span>Pet World - Nguyễn Tri Phương</span>
        </div>
        <div class="store-item">
          <img src="/images/store-3.jpg" alt="Store 3" />
          <span>Pet World - Nguyễn Văn Linh</span>
        </div>
      </div>
    </section>

    <!-- FooterBar -->
    <footer class="footer-bar">
      <div class="footer-content">
        <div class="footer-logo">
          <img src="/images/logo.png" alt="Pet Shop Logo" />
          <p>Chúng tôi không chỉ phục vụ thú cưng mà còn đồng hành cùng bạn trên hành trình yêu thương chúng.</p>
        </div>
        <div class="footer-info">
          <h4>Store</h4>
          <p>123 Lý Thường Kiệt, Phường 3, Quận 10, Thành phố Hồ Chí Minh</p>
          <p>+84 123 456 789</p>
          <p>wearpet@petshop.com</p>
        </div>
      </div>
      <div class="footer-copyright">
        &copy; Copyright Pet Shop 2023
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'HomePage'
}
</script>

<style scoped>
/* Thêm CSS layout cơ bản, bạn có thể tuỳ chỉnh thêm */
.homepage { background: #fafafa; }
.header-bar { background: #fff; border-bottom: 1px solid #eee; }
.header-top { display: flex; justify-content: space-between; padding: 8px 32px; font-size: 0.95em; color: #333; }
.header-user { color: #f90; }
.header-nav { display: flex; align-items: center; gap: 24px; padding: 12px 32px; }
.logo { height: 48px; margin-right: 16px; }
.search-bar { display: flex; align-items: center; }
.search-bar input { padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px 0 0 4px; }
.search-bar button { padding: 6px 10px; border: none; background: #f90; color: #fff; border-radius: 0 4px 4px 0; }
.cart-link { position: relative; }
.header-user-mobile { display: none; }

.banner-section { display: flex; align-items: center; justify-content: space-between; padding: 40px 32px; background: #fff; margin-bottom: 24px; border-radius: 16px; }
.banner-content { max-width: 50%; }
.banner-content h1 { font-size: 2.2em; color: #222; margin-bottom: 12px; }
.banner-content p { color: #666; margin-bottom: 18px; }
.cta-btn { background: #f90; color: #fff; border: none; padding: 12px 32px; border-radius: 8px; font-size: 1.1em; cursor: pointer; }
.banner-img { max-width: 40%; border-radius: 16px; }
.banner-decor { position: absolute; width: 200px; height: 200px; background: #ffb36633; border-radius: 50%; top: 60px; right: 60px; z-index: 0; }

.quick-category-section { display: flex; gap: 24px; justify-content: center; margin: 32px 0; }
.quick-category { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #eee; padding: 16px 32px; text-align: center; cursor: pointer; }
.quick-category img { width: 120px; height: 80px; object-fit: cover; border-radius: 8px; }

.product-category-section { background: #fff; border-radius: 16px; padding: 32px; margin-bottom: 24px; }
.product-category-list { display: flex; gap: 32px; justify-content: center; }
.product-category-item { text-align: center; }
.product-category-item img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-bottom: 8px; }

.bestseller-section { background: #fff; border-radius: 16px; padding: 32px; margin-bottom: 24px; }
.bestseller-list { display: flex; gap: 32px; justify-content: center; }
.bestseller-item { text-align: center; }
.bestseller-item img { width: 120px; height: 160px; object-fit: cover; border-radius: 8px; margin-bottom: 8px; }

.brand-section { background: #fff; border-radius: 16px; padding: 32px; margin-bottom: 24px; }
.brand-list { display: flex; gap: 24px; flex-wrap: wrap; justify-content: center; }
.brand-list img { width: 100px; height: 40px; object-fit: contain; margin-bottom: 8px; }

.store-section { background: #fff; border-radius: 16px; padding: 32px; margin-bottom: 24px; }
.store-list { display: flex; gap: 32px; justify-content: center; }
.store-item { text-align: center; }
.store-item img { width: 180px; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 8px; }

.footer-bar { background: #fff; border-top: 1px solid #eee; padding: 32px 0 0 0; }
.footer-content { display: flex; justify-content: space-between; padding: 0 32px 24px 32px; }
.footer-logo img { height: 48px; margin-bottom: 8px; }
.footer-info { max-width: 300px; }
.footer-copyright { text-align: center; color: #aaa; padding: 12px 0; font-size: 0.95em; }

@media (max-width: 900px) {
  .banner-section { flex-direction: column; align-items: flex-start; }
  .banner-img { max-width: 100%; margin-top: 24px; }
  .banner-content { max-width: 100%; }
  .footer-content { flex-direction: column; gap: 24px; }
  .product-category-list, .bestseller-list, .store-list { flex-direction: column; gap: 16px; }
}
</style> 