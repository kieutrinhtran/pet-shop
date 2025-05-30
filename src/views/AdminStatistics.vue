<template>
  <div class="admin-statistics">
    <section class="hero">
      <h1>Thống kê tình hình kinh doanh</h1>
    </section>
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-title">Tổng số khách hàng</div>
        <div class="stat-value">5,612</div>
        <div class="stat-change positive">▲ 2% vs Năm ngoái</div>
      </div>
      <div class="stat-card">
        <div class="stat-title">Tổng đơn hàng</div>
        <div class="stat-value">5,161</div>
        <div class="stat-change positive">▲ 21% vs tháng trước</div>
      </div>
      <div class="stat-card">
        <div class="stat-title">Tổng doanh thu</div>
        <div class="stat-value">391,152</div>
        <div class="stat-change positive">▲ 51% vs tháng trước</div>
      </div>
    </div>
    <div class="charts-grid">
      <div class="chart-box">
        <h3>Thống kê doanh thu theo tháng</h3>
        <canvas id="revenueChart"></canvas>
      </div>
      <div class="chart-box">
        <h3>Thống kê danh mục sản phẩm bán chạy</h3>
        <canvas id="categoryChart"></canvas>
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
  padding: 2rem 0 1rem 0;
  text-align: center;
}
.hero h1 {
  font-size: 2rem;
  color: #222;
  margin: 0;
}
.stats-grid {
  display: flex;
  gap: 2rem;
  justify-content: center;
  margin: 2rem 0;
}
.stat-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  padding: 2rem 2.5rem;
  min-width: 220px;
  text-align: center;
}
.stat-title {
  color: #888;
  font-size: 1rem;
  margin-bottom: 0.5rem;
}
.stat-value {
  font-size: 2.2rem;
  font-weight: bold;
  color: #ff9800;
}
.stat-change {
  margin-top: 0.5rem;
  font-size: 1rem;
}
.stat-change.positive {
  color: #43a047;
}
.charts-grid {
  display: flex;
  gap: 2rem;
  justify-content: center;
  flex-wrap: wrap;
}
.chart-box {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  padding: 2rem;
  min-width: 350px;
  max-width: 500px;
  flex: 1 1 350px;
}
.chart-box h3 {
  margin-bottom: 1rem;
  font-size: 1.1rem;
  color: #222;
  font-weight: 600;
}
canvas {
  width: 100% !important;
  height: 320px !important;
  max-width: 100%;
}
</style> 