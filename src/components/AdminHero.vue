<template>
  <section class="admin-hero">
    <div class="admin-hero-content">
      <div class="admin-hero-left">
        <span class="brand">Pet World</span>
        <h1>Thiên đường mua sắm dành cho thú cưng!</h1>
        <p class="slogan">Dịch vụ tận tâm – Trải nghiệm mua sắm độc đáo!</p>
      </div>
      <div class="admin-hero-img">
        <div class="hero-bg"></div>
            <img src="https://images.unsplash.com/photo-1567270671170-fdc10a5bf831?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Dog and Cat" />
            <div class="paw-prints"></div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.admin-hero {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 0 40px;
  margin-top: 32px;
  min-height: 420px;
  position: relative;
  z-index: 1;
}
.admin-hero-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
  padding: 32px 0 0 0;
  gap: 32px;
}
.admin-hero-left {
  z-index: 2;
  flex: 1;
}
.brand {
  color: #ff9800;
  font-size: 1.3rem;
  font-weight: 700;
  letter-spacing: 1px;
}
.admin-hero-content h1 {
  font-size: 2.2rem;
  color: #222;
  margin: 12px 0 18px 0;
  font-weight: 800;
  line-height: 1.2;
}
.slogan {
  color: #555;
  font-size: 1.1rem;
  margin-bottom: 0;
}
.admin-hero-img {
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
  bottom: 0;
  width: 420px;
  height: 420px;
  background: radial-gradient(circle at 60% 40%, #ff9000 70%, #fff0 100%);
  border-radius: 60% 40% 60% 40% / 50% 60% 40% 50%;
  z-index: 2;
  opacity: 0.95;
}
.admin-hero-img img {
  position: relative;
  width: 340px;
  height: 340px;
  object-fit: cover;
  border-radius: 40% 60% 50% 50% / 60% 40% 60% 40%;
  z-index: 2;
  box-shadow: 0 8px 32px 0 rgba(0,0,0,0.10);
}

.paw-prints {
  position: absolute;
  right: 30px;
  bottom: 10px;
  width: 60px;
  height: 30px;
  z-index: 3;
  pointer-events: none;
  background: url('data:image/svg+xml;utf8,<svg width="60" height="30" viewBox="0 0 60 30" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="10" cy="15" rx="8" ry="12" fill="%23fff6" /><ellipse cx="30" cy="10" rx="6" ry="8" fill="%23fff6" /><ellipse cx="50" cy="15" rx="8" ry="12" fill="%23fff6" /></svg>');
  opacity: 0.3;
  background-repeat: no-repeat;
  background-size: contain;
}
@media (max-width: 900px) {
  .admin-hero-content {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }
  .admin-hero-img {
    width: 100%;
    max-width: 320px;
    height: auto;
    min-height: 160px;
  }
  .hero-bg {
    width: 220px;
    height: 140px;
  }
  .admin-hero-img img {
    width: 180px;
    height: 120px;
  }
}
</style>
