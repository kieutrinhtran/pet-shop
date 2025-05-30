<template>
  <div class="about-wrapper">
    <!-- HERO -->
    <section class="about-hero">
      <div class="about-hero-content">
        <span class="brand">Pet World</span>
        <h1>
          Nếu các Boss có thể giao tiếp,<br />
          <span class="highlight">Câu chuyện của họ sẽ là về Chúng tôi!</span>
        </h1>
        <p class="slogan">
          <span>Chất lượng vượt trội</span> – <span>Dịch vụ tận tâm</span> – <span>Trải nghiệm mua sắm độc đáo!</span>
        </p>
        <div class="cta-buttons">
          <router-link to="/products" class="cta-btn primary">Mua ngay</router-link>
          <router-link to="/contact" class="cta-btn secondary">Liên hệ</router-link>
        </div>
      </div>
      <div class="about-hero-img">
        <div class="hero-bg"></div>
        <img src="https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=crop&w=600&q=80" alt="Dog and Cat" />
        <span class="bird-icon">🕊️</span>
        <div class="paw-prints"></div>
      </div>
    </section>

    <!-- VỀ CHÚNG TÔI -->
    <section class="about-section">
      <h2 class="section-title">VỀ CHÚNG TÔI</h2>
      <div class="about-desc">
        <b>Pet World</b> – Vì một thế giới hoàn hảo cho thú cưng<br /><br />
        <b>Pet World</b> không chỉ là một nền tảng mua sắm, mà còn là người bạn đồng hành tin cậy trên hành trình chăm sóc thú cưng của bạn. Được thành lập với niềm đam mê dành cho động vật, chúng tôi mang đến một hệ sinh thái thú cưng điển hình, giúp bạn dễ dàng tìm thấy mọi thứ mà thú cưng cần – từ thực phẩm dinh dưỡng, phụ kiện thời trang, đồ chơi cho đến dịch vụ chăm sóc sức khỏe, spa, huấn luyện.<br /><br />
        Với sự hợp tác từ những thương hiệu hàng đầu và các chuyên gia thú y, <b>Pet World cam kết</b> mang đến sản phẩm chất lượng cao, an toàn và phù hợp nhất cho từng bé cưng. Chúng tôi tin rằng mỗi thú cưng đều xứng đáng được yêu thương, chăm sóc tốt nhất, và mỗi người nuôi đều xứng đáng có trải nghiệm mua sắm tiện lợi, nhanh chóng và đáng tin cậy.
      </div>
      <div class="about-stats">
        <div class="stat-item">
          <i class="fas fa-users stat-icon"></i>
          <span class="stat-number">10.000+</span>
          <span class="stat-label">Khách hàng mỗi năm</span>
        </div>
        <div class="stat-item">
          <i class="fas fa-store stat-icon"></i>
          <span class="stat-number">10</span>
          <span class="stat-label">CN/nhánh</span>
        </div>
        <div class="stat-item">
          <i class="fas fa-box-open stat-icon"></i>
          <span class="stat-number">200+</span>
          <span class="stat-label">Sản phẩm</span>
        </div>
        <div class="stat-item">
          <i class="fas fa-award stat-icon"></i>
          <span class="stat-number">5+</span>
          <span class="stat-label">Năm kinh nghiệm</span>
        </div>
      </div>
    </section>

    <!-- TESTIMONIAL -->
    <section class="testimonial-section">
      <div class="testimonial-content">
        <span class="testimonial-label">Chứng Thực</span>
        <h3>Khách hàng nói gì về chúng tôi?</h3>
        <div class="testimonial-slider">
          <div class="testimonial-quote active">
            <div class="quote-icon">❝</div>
            <p>
              <b>Pet World thực sự là thiên đường cho thú cưng!</b> Tôi đã tìm thấy mọi thứ mình cần cho bé cún của mình, từ thức ăn, phụ kiện đến dịch vụ spa. Đội ngũ nhân viên rất nhiệt tình tư vấn và cũng chuyên nghiệp!
            </p>
            <div class="testimonial-author">
              <img src="https://media.vneconomy.vn/w800/images/upload/2023/11/17/ong-pham-nhat-vuong.jpg" alt="Phạm Nhật Vượng" />
              <div>
                <b>Phạm Nhật Vượng</b>
                <span>Khách hàng</span>
              </div>
            </div>
          </div>
          <div class="testimonial-quote">
            <div class="quote-icon">❝</div>
            <p>
              <b>Dịch vụ tuyệt vời!</b> Tôi rất ấn tượng với sự chuyên nghiệp và tận tâm của đội ngũ Pet World. Các sản phẩm đều chất lượng và giá cả hợp lý.
            </p>
            <div class="testimonial-author">
              <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" alt="Nguyễn Thị A" />
              <div>
                <b>Nguyễn Thị A</b>
                <span>Khách hàng thân thiết</span>
              </div>
            </div>
          </div>
          <div class="testimonial-quote">
            <div class="quote-icon">❝</div>
            <p>
              <b>Mèo nhà tôi rất thích!</b> Thức ăn và đồ chơi từ Pet World luôn là lựa chọn hàng đầu của tôi. Giao hàng nhanh chóng và đóng gói cẩn thận.
            </p>
            <div class="testimonial-author">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" alt="Trần Văn B" />
              <div>
                <b>Trần Văn B</b>
                <span>Khách hàng</span>
              </div>
            </div>
          </div>
        </div>
        <div class="testimonial-dots">
          <span class="dot active"></span>
          <span class="dot"></span>
          <span class="dot"></span>
        </div>
      </div>
    </section>

    <!-- ĐỐI TÁC CHIẾN LƯỢC -->
    <section class="partner-section">
      <h2 class="section-title">Các đối tác chiến lược</h2>
      <div class="partner-logos">
        <div class="partner-logo">
          <img src="https://www.royalcanin.com/static/images/logo.svg" alt="Royal Canin" />
        </div>
        <div class="partner-logo">
          <img src="https://nutricience.vn/wp-content/uploads/2022/09/logo-nutrience.png" alt="Nutrience" />
        </div>
        <div class="partner-logo">
          <img src="https://www.hiraw.com.vn/wp-content/uploads/2022/09/logo-hiraw.png" alt="Hi Raw" />
        </div>
        <div class="partner-logo">
          <img src="https://www.inabafoods.com.vn/wp-content/uploads/2022/09/logo-inaba.png" alt="Inaba" />
        </div>
        <div class="partner-logo">
          <img src="https://www.mongeviet.vn/wp-content/uploads/2022/09/logo-monge.png" alt="Monge" />
        </div>
        <div class="partner-logo">
          <img src="https://www.kitcat.com.vn/wp-content/uploads/2022/09/logo-kitcat.png" alt="Kit Cat" />
        </div>
      </div>
    </section>

    <!-- HỆ THỐNG CỬA HÀNG -->
    <section class="store-section">
      <h2 class="section-title">Hệ thống cửa hàng</h2>
      <div class="store-list">
        <div class="store-item">
          <div class="store-img">
            <img src="https://petshopsaigon.vn/wp-content/uploads/2021/07/cua-hang-petshopsaigon-ly-thuong-kiet.jpg" alt="Pet World - Lý Thường Kiệt" />
            <div class="store-overlay">
              <a href="https://maps.google.com" target="_blank" class="store-map-btn">
                <i class="fas fa-map-marker-alt"></i>
                Xem bản đồ
              </a>
            </div>
          </div>
          <div class="store-info">
            <h3>Pet World - Lý Thường Kiệt</h3>
            <p><i class="fas fa-map-marker-alt"></i> 186 Trường Sa, Phường 1, Q. Bình Thạnh, Tp Hồ Chí Minh</p>
            <p><i class="fas fa-clock"></i> 8:00 - 22:00</p>
            <p><i class="fas fa-phone"></i> (028) 1234 5678</p>
          </div>
        </div>
        <div class="store-item">
          <div class="store-img">
            <img src="https://petshopsaigon.vn/wp-content/uploads/2021/07/cua-hang-petshopsaigon-nguyen-tri-phuong.jpg" alt="Pet World - Nguyễn Tri Phương" />
            <div class="store-overlay">
              <a href="https://maps.google.com" target="_blank" class="store-map-btn">
                <i class="fas fa-map-marker-alt"></i>
                Xem bản đồ
              </a>
            </div>
          </div>
          <div class="store-info">
            <h3>Pet World - Nguyễn Tri Phương</h3>
            <p><i class="fas fa-map-marker-alt"></i> 412/3 Nơ Trang Long, P.13, Q. Bình Thạnh, Tp Hồ Chí Minh</p>
            <p><i class="fas fa-clock"></i> 8:00 - 22:00</p>
            <p><i class="fas fa-phone"></i> (028) 1234 5679</p>
          </div>
        </div>
        <div class="store-item">
          <div class="store-img">
            <img src="https://petshopsaigon.vn/wp-content/uploads/2021/07/cua-hang-petshopsaigon-nguyen-van-linh.jpg" alt="Pet World - Nguyễn Văn Linh" />
            <div class="store-overlay">
              <a href="https://maps.google.com" target="_blank" class="store-map-btn">
                <i class="fas fa-map-marker-alt"></i>
                Xem bản đồ
              </a>
            </div>
          </div>
          <div class="store-info">
            <h3>Pet World - Nguyễn Văn Linh</h3>
            <p><i class="fas fa-map-marker-alt"></i> 918 Tạ Quang Bửu, P. An Khánh, Tp Thủ Đức (Quận 2 cũ)</p>
            <p><i class="fas fa-clock"></i> 8:00 - 22:00</p>
            <p><i class="fas fa-phone"></i> (028) 1234 5680</p>
          </div>
        </div>
      </div>
    </section>

    <!-- LIÊN HỆ -->
    <section class="contact-section">
      <div class="contact-form">
        <h2>Liên hệ chúng tôi</h2>
        <form @submit.prevent="handleSubmit">
          <div class="form-row">
            <div class="form-group">
              <input type="text" v-model="form.lastName" placeholder="Họ" required />
              <span class="error" v-if="errors.lastName">{{ errors.lastName }}</span>
            </div>
            <div class="form-group">
              <input type="text" v-model="form.firstName" placeholder="Tên của bạn" required />
              <span class="error" v-if="errors.firstName">{{ errors.firstName }}</span>
            </div>
          </div>
          <div class="form-group">
            <input type="email" v-model="form.email" placeholder="Địa chỉ e-mail" required />
            <span class="error" v-if="errors.email">{{ errors.email }}</span>
          </div>
          <div class="form-group">
            <textarea v-model="form.message" placeholder="Nội dung" required></textarea>
            <span class="error" v-if="errors.message">{{ errors.message }}</span>
          </div>
          <button type="submit" :disabled="isSubmitting">
            <i class="fas fa-paper-plane"></i>
            {{ isSubmitting ? 'Đang gửi...' : 'Gửi' }}
          </button>
        </form>
      </div>
      <div class="contact-info">
        <h3>Liên hệ chúng tôi</h3>
        <ul>
          <li>
            <i class="fas fa-map-marker-alt"></i>
            <div>
              <b>Địa chỉ:</b>
              <span>123 Lý Thường Kiệt, Phường 3, Quận 10, Thành phố Hồ Chí Minh</span>
            </div>
          </li>
          <li>
            <i class="fas fa-envelope"></i>
            <div>
              <b>Email:</b>
              <span>petworld@gmail.com</span>
            </div>
          </li>
          <li>
            <i class="fas fa-phone"></i>
            <div>
              <b>Điện thoại:</b>
              <span>+84 123 456 789</span>
            </div>
          </li>
          <li>
            <i class="fas fa-clock"></i>
            <div>
              <b>Giờ mở cửa:</b>
              <span>Mon - Fri: 10AM - 10PM</span>
            </div>
          </li>
        </ul>
        <div class="social-links">
          <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
          <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
          <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'AboutPage',
  data() {
    return {
      form: {
        firstName: '',
        lastName: '',
        email: '',
        message: ''
      },
      errors: {},
      isSubmitting: false,
      currentTestimonial: 0
    }
  },
  methods: {
    handleSubmit() {
      this.errors = {}
      this.isSubmitting = true

      // Validate form
      if (!this.form.firstName) {
        this.errors.firstName = 'Vui lòng nhập tên'
      }
      if (!this.form.lastName) {
        this.errors.lastName = 'Vui lòng nhập họ'
      }
      if (!this.form.email) {
        this.errors.email = 'Vui lòng nhập email'
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) {
        this.errors.email = 'Email không hợp lệ'
      }
      if (!this.form.message) {
        this.errors.message = 'Vui lòng nhập nội dung'
      }

      if (Object.keys(this.errors).length === 0) {
        // Simulate API call
        setTimeout(() => {
          this.isSubmitting = false
          this.form = {
            firstName: '',
            lastName: '',
            email: '',
            message: ''
          }
          alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.')
        }, 1500)
      } else {
        this.isSubmitting = false
      }
    }
  },
  mounted() {
    // Auto slide testimonials
    setInterval(() => {
      const dots = document.querySelectorAll('.testimonial-dots .dot')
      const quotes = document.querySelectorAll('.testimonial-quote')
      
      dots[this.currentTestimonial].classList.remove('active')
      quotes[this.currentTestimonial].classList.remove('active')
      
      this.currentTestimonial = (this.currentTestimonial + 1) % dots.length
      
      dots[this.currentTestimonial].classList.add('active')
      quotes[this.currentTestimonial].classList.add('active')
    }, 5000)
  }
}
</script>

<style scoped>
.about-wrapper {
  background: #fafbfc;
  font-family: 'Inter', Arial, sans-serif;
}

/* HERO */
.about-hero {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 0 40px;
  margin-top: 32px;
  min-height: 420px;
  position: relative;
  z-index: 1;
}

.about-hero-content {
  flex: 1;
  z-index: 2;
}

.brand {
  color: #ff9000;
  font-size: 22px;
  font-weight: 700;
}

.about-hero-content h1 {
  font-size: 38px;
  font-weight: 800;
  margin: 12px 0 18px 0;
  line-height: 1.2;
}

.about-hero-content .highlight {
  color: #222;
}

.slogan {
  color: #555;
  font-size: 17px;
  margin-bottom: 32px;
}

.cta-buttons {
  display: flex;
  gap: 16px;
}

.cta-btn {
  padding: 14px 38px;
  font-size: 18px;
  font-weight: 600;
  border-radius: 12px;
  text-decoration: none;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.cta-btn.primary {
  background: #111;
  color: #fff;
}

.cta-btn.primary:hover {
  background: #ff9000;
  transform: translateY(-2px);
}

.cta-btn.secondary {
  background: #fff;
  color: #111;
  border: 2px solid #111;
}

.cta-btn.secondary:hover {
  background: #111;
  color: #fff;
  transform: translateY(-2px);
}

.about-hero-img {
  flex: 1;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  min-width: 350px;
  min-height: 350px;
}

.hero-bg {
  position: absolute;
  right: 0;
  width: 420px;
  height: 420px;
  background: radial-gradient(circle at 60% 40%, #ff9000 70%, #fff0 100%);
  border-radius: 60% 40% 60% 40% / 50% 60% 40% 50%;
  z-index: 1;
  opacity: 0.95;
}

.about-hero-img img {
  position: relative;
  width: 340px;
  height: 340px;
  object-fit: cover;
  border-radius: 40% 60% 50% 50% / 60% 40% 60% 40%;
  z-index: 2;
  box-shadow: 0 8px 32px 0 rgba(0,0,0,0.10);
}

.bird-icon {
  position: absolute;
  left: 30px;
  top: 30px;
  font-size: 60px;
  color: #ccc;
  opacity: 0.5;
  z-index: 3;
  pointer-events: none;
}

.paw-prints {
  position: absolute;
  right: 80px;
  top: 80px;
  width: 180px;
  height: 180px;
  z-index: 3;
  pointer-events: none;
  background: url('data:image/svg+xml;utf8,<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="20" cy="20" rx="8" ry="12" fill="%23fff6" /><ellipse cx="60" cy="20" rx="8" ry="12" fill="%23fff6" /><ellipse cx="30" cy="50" rx="10" ry="14" fill="%23fff6" /><ellipse cx="50" cy="50" rx="10" ry="14" fill="%23fff6" /></svg>');
  opacity: 0.3;
  background-repeat: no-repeat;
  background-size: contain;
}

/* ABOUT SECTION */
.about-section {
  background: #fff;
  border-radius: 16px;
  margin: 40px 40px 0 40px;
  padding: 40px 32px 32px 32px;
  box-shadow: 0 4px 24px 0 rgba(0,0,0,0.04);
}

.section-title {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 24px;
  text-align: center;
}

.about-desc {
  color: #555;
  line-height: 1.8;
  margin-bottom: 40px;
  text-align: center;
}

.about-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 32px;
  margin-top: 40px;
}

.stat-item {
  text-align: center;
  padding: 24px;
  background: #fff7f0;
  border-radius: 12px;
  transition: transform 0.2s;
}

.stat-item:hover {
  transform: translateY(-4px);
}

.stat-icon {
  font-size: 32px;
  color: #ff9000;
  margin-bottom: 16px;
}

.stat-number {
  display: block;
  color: #ff9000;
  font-size: 32px;
  font-weight: 800;
  display: block;
}
.stat-label {
  color: #555;
  font-size: 16px;
}

/* TESTIMONIAL */
.testimonial-section {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 40px 40px 0 40px;
  background: #fff;
  border-radius: 16px;
  padding: 32px;
  box-shadow: 0 4px 24px 0 rgba(0,0,0,0.04);
}
.testimonial-content {
  flex: 2;
}
.testimonial-label {
  color: #ff9000;
  font-weight: 700;
  font-size: 18px;
}
.testimonial-quote {
  margin-top: 18px;
  font-size: 18px;
  color: #222;
  background: #fff7e6;
  border-radius: 12px;
  padding: 18px 24px;
  margin-bottom: 12px;
}
.testimonial-author {
  margin-top: 12px;
  color: #555;
  font-size: 16px;
}
.testimonial-img {
  flex: 1;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}
.testimonial-img-bg {
  position: absolute;
  width: 180px;
  height: 180px;
  background: #ff9000;
  border-radius: 50%;
  opacity: 0.2;
  z-index: 1;
}
.testimonial-img img {
  position: relative;
  width: 140px;
  height: 140px;
  object-fit: cover;
  border-radius: 50%;
  z-index: 2;
  border: 6px solid #fff;
  box-shadow: 0 4px 16px 0 rgba(0,0,0,0.10);
}

/* PARTNER */
.partner-section {
  background: #fff;
  border-radius: 16px;
  margin: 40px 40px 0 40px;
  padding: 32px;
  box-shadow: 0 4px 24px 0 rgba(0,0,0,0.04);
  text-align: center;
}
.partner-logos {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 32px;
  margin-top: 24px;
}
.partner-logos img {
  height: 48px;
  object-fit: contain;
  background: #fff;
  padding: 8px 16px;
  border-radius: 8px;
  box-shadow: 0 2px 8px #eee;
}

/* STORE */
.store-section {
  background: #fff;
  border-radius: 16px;
  margin: 40px 40px 0 40px;
  padding: 32px;
  box-shadow: 0 4px 24px 0 rgba(0,0,0,0.04);
}
.store-list {
  display: flex;
  gap: 32px;
  justify-content: center;
  margin-top: 24px;
}
.store-item {
  text-align: center;
  background: #fff7e6;
  border-radius: 12px;
  padding: 18px 12px;
  width: 260px;
  box-shadow: 0 2px 8px #eee;
}
.store-item img {
  width: 220px;
  height: 120px;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 8px;
}
.store-item span {
  font-weight: 700;
  color: #ff9000;
  font-size: 18px;
}
.store-item p {
  color: #555;
  font-size: 15px;
  margin-top: 4px;
}

/* CONTACT */
.contact-section {
  display: flex;
  gap: 48px;
  justify-content: center;
  margin: 40px 40px 0 40px;
  background: #fff;
  border-radius: 16px;
  padding: 32px;
  box-shadow: 0 4px 24px 0 rgba(0,0,0,0.04);
}
.contact-form {
  flex: 1;
}
.contact-form h2 {
  color: #ff9000;
  margin-bottom: 18px;
}
.contact-form form {
  display: flex;
  flex-direction: column;
  gap: 14px;
}
.form-row {
  display: flex;
  gap: 12px;
}
.contact-form input,
.contact-form textarea {
  padding: 10px 14px;
  border-radius: 8px;
  border: 1px solid #eee;
  font-size: 16px;
  background: #fafbfc;
}
.contact-form textarea {
  min-height: 60px;
  resize: vertical;
}
.contact-form button {
  background: #ff9000;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 12px 0;
  font-size: 18px;
  font-weight: 700;
  cursor: pointer;
  margin-top: 8px;
}
.contact-info {
  flex: 1;
  padding-left: 32px;
}
.contact-info h3 {
  color: #ff9000;
  margin-bottom: 12px;
}
.contact-info ul {
  list-style: none;
  padding: 0;
  color: #222;
  font-size: 16px;
}
.contact-info li {
  margin-bottom: 10px;
}

@media (max-width: 900px) {
  .about-hero, .testimonial-section, .contact-section, .about-section, .partner-section, .store-section {
    flex-direction: column;
    margin: 0 10px;
    padding: 18px;
  }
  .about-hero-img, .testimonial-img, .contact-info {
    margin-top: 24px;
    padding-left: 0;
  }
  .about-stats, .store-list, .partner-logos {
    flex-direction: column;
    gap: 18px;
  }
}
</style>

export default {
  name: 'AboutPage',
} 