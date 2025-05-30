<template>
  <div class="admin-statistics">
    <div class="stats-section">
      <h2>Thống kê tình hình kinh doanh</h2>
      <div class="stats-cards">
        <div class="stat-card">
          <div class="stat-icon customers"><i class="fas fa-users"></i></div>
          <div class="stat-info">
            <div class="stat-title">Tổng số khách hàng</div>
            <div class="stat-value">5,612</div>
            <div class="stat-change positive">▲ 2% vs Năm ngoái</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon orders"><i class="fas fa-shopping-basket"></i></div>
          <div class="stat-info">
            <div class="stat-title">Tổng đơn hàng</div>
            <div class="stat-value">5,161</div>
            <div class="stat-change positive">▲ 21% vs tháng trước</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon revenue"><i class="fas fa-coins"></i></div>
          <div class="stat-info">
            <div class="stat-title">Tổng doanh thu</div>
            <div class="stat-value">391,152</div>
            <div class="stat-change positive">▲ 51% vs tháng trước</div>
          </div>
        </div>
      </div>
      <div class="charts-row">
        <div class="chart-card">
          <h3>Thống kê doanh thu theo tháng</h3>
          <canvas id="revenueChart"></canvas>
        </div>
        <div class="chart-card">
          <h3>Thống kê danh mục sản phẩm bán chạy</h3>
          <canvas id="categoryChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import Chart from 'chart.js/auto'

onMounted(() => {
  // Biểu đồ doanh thu theo tháng
  const ctx1 = document.getElementById('revenueChart').getContext('2d')
  new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
      datasets: [{
        label: 'Doanh thu (VND)',
        data: [50000, 60000, 80000, 130000, 90000, 85000, 95000, 90000, 87000],
        backgroundColor: '#ff9800',
        borderRadius: 8
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: { callbacks: { label: ctx => `${ctx.parsed.y.toLocaleString()} VND` } }
      },
      scales: {
        y: { beginAtZero: true, ticks: { callback: v => v.toLocaleString() } }
      }
    }
  })

  // Biểu đồ tròn danh mục bán chạy
  const ctx2 = document.getElementById('categoryChart').getContext('2d')
  new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: ['Thức ăn', 'Đồ chơi', 'Phụ kiện chăm sóc', 'Chuồng/vật dụng', 'Quần áo/Thời trang'],
      datasets: [{
        data: [33, 33, 21, 11, 2],
        backgroundColor: ['#ff9800', '#ffd54f', '#4fc3f7', '#81c784', '#f06292']
      }]
    },
    options: {
      plugins: {
        legend: { position: 'right' }
      }
    }
  })
})
</script>

<style scoped>
.admin-statistics {
  min-height: 100vh;
  background: #fafbfc;
  padding-bottom: 40px;
}
.hero {
  background: linear-gradient(90deg, #fff 60%, #ff9800 100%);
  padding: 0 0 32px 0;
}
.hero-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
  padding: 32px 0 0 0;
  gap: 32px;
}
.brand {
  color: #ff9800;
  font-weight: 700;
  font-size: 1.2rem;
  letter-spacing: 1px;
}
.hero-content h1 {
  font-size: 2.2rem;
  color: #222;
  margin: 8px 0 0 0;
  font-weight: 800;
}
.slogan {
  color: #666;
  margin-top: 8px;
  font-size: 1.1rem;
}
.hero-img img {
  width: 260px;
  height: 180px;
  object-fit: cover;
  border-radius: 2rem 0 2rem 0;
  box-shadow: 0 4px 24px rgba(0,0,0,0.08);
}
.stats-section {
  max-width: 1200px;
  margin: 0 auto;
  padding: 32px 16px 0 16px;
}
.stats-section h2 {
  font-size: 1.4rem;
  font-weight: 700;
  margin-bottom: 24px;
  color: #222;
  text-align: left;
}
.stats-cards {
  display: flex;
  gap: 32px;
  margin-bottom: 32px;
  flex-wrap: wrap;
}
.stat-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 2px 16px rgba(0,0,0,0.06);
  display: flex;
  align-items: center;
  gap: 18px;
  padding: 24px 32px;
  min-width: 280px;
  flex: 1 1 280px;
}
.stat-icon {
  font-size: 2.2rem;
  width: 56px;
  height: 56px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff3e0;
  color: #ff9800;
  box-shadow: 0 2px 8px rgba(255,152,0,0.08);
}
.stat-icon.orders {
  background: #e3f2fd;
  color: #2196f3;
}
.stat-icon.revenue {
  background: #e8f5e9;
  color: #43a047;
}
.stat-info {
  flex: 1;
}
.stat-title {
  color: #888;
  font-size: 1rem;
  margin-bottom: 0.5rem;
}
.stat-value {
  font-size: 2.1rem;
  font-weight: bold;
  color: #222;
}
.stat-change {
  margin-top: 0.5rem;
  font-size: 1rem;
}
.stat-change.positive {
  color: #43a047;
}
.charts-row {
  display: flex;
  gap: 32px;
  flex-wrap: wrap;
  margin-top: 8px;
}
.chart-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 2px 16px rgba(0,0,0,0.06);
  padding: 24px 32px;
  min-width: 350px;
  max-width: 520px;
  flex: 1 1 350px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.chart-card h3 {
  margin-bottom: 1rem;
  font-size: 1.1rem;
  color: #222;
  font-weight: 600;
  text-align: center;
}
canvas {
  width: 100% !important;
  height: 320px !important;
  max-width: 100%;
}
@media (max-width: 900px) {
  .hero-content {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }
  .hero-img img {
    width: 100%;
    max-width: 320px;
    height: auto;
  }
  .charts-row {
    flex-direction: column;
    gap: 24px;
  }
  .stats-cards {
    flex-direction: column;
    gap: 18px;
  }
}
</style> 