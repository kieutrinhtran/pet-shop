<template>
  <div class="admin-order-management">
    <HeaderComponent />
    
    <!-- Hero section -->
    <div class="hero-section">
      <h1>Quản lý đơn hàng</h1>
      <p>Quản lý và theo dõi tất cả đơn hàng của khách hàng</p>
    </div>

    <!-- Main content -->
    <div class="main-content">
      <!-- Filters -->
      <div class="filters">
        <div class="search-box">
          <input
            type="text"
            v-model="searchQuery"
            :placeholder="`Hiện thị ${filteredOrders.length} từ ${totalOrders} kết quả tìm kiếm`"
            @input="applyFilters"
          />
        </div>
        <div class="filter-options">
          <select v-model="statusFilter" @change="applyFilters">
            <option value="">Tất cả trạng thái đơn hàng</option>
            <option value="pending">Chờ xác nhận</option>
            <option value="processing">Đang xử lý</option>
            <option value="shipped">Đang giao hàng</option>
            <option value="delivered">Đã nhận hàng</option>
            <option value="cancelled">Đã hủy</option>
          </select>
          <select v-model="paymentStatusFilter" @change="applyFilters">
            <option value="">Tất cả trạng thái thanh toán</option>
            <option value="pending">Chờ thanh toán</option>
            <option value="paid">Đã thanh toán</option>
            <option value="failed">Thanh toán thất bại</option>
          </select>
        </div>
      </div>

      <!-- Orders table -->
      <div class="orders-table">
        <table>
          <thead>
            <tr>
              <th>ID đơn hàng</th>
              <th>Ngày đặt</th>
              <th>Trạng thái đơn hàng</th>
              <th>Tổng giá trị</th>
              <th>Phương thức thanh toán</th>
              <th>Trạng thái thanh toán</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in paginatedOrders" :key="order.id">
              <td>{{ order.id }}</td>
              <td>{{ formatDate(order.created_at) }}</td>
              <td>
                <span :class="['status-badge', order.status]">
                  {{ getStatusText(order.status) }}
                </span>
              </td>
              <td>{{ formatPrice(order.total_amount) }}</td>
              <td>{{ getPaymentMethodText(order.payment_method) }}</td>
              <td>
                <span :class="['status-badge', order.payment_status]">
                  {{ getPaymentStatusText(order.payment_status) }}
                </span>
              </td>
              <td class="actions">
                <button
                  @click="editOrder(order.id)"
                  class="action-btn edit"
                  title="Sửa đơn hàng"
                >
                  ✏️
                </button>
                <button
                  @click="deleteOrder(order.id)"
                  class="action-btn delete"
                  title="Xóa đơn hàng"
                >
                  🗑️
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="pagination">
        <button
          @click="currentPage--"
          :disabled="currentPage === 1"
          class="page-btn"
        >
          Trước
        </button>
        <span class="page-info">Trang {{ currentPage }} / {{ totalPages }}</span>
        <button
          @click="currentPage++"
          :disabled="currentPage === totalPages"
          class="page-btn"
        >
          Sau
        </button>
      </div>
    </div>

    <FooterComponent />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import HeaderComponent from '@/components/HeaderComponent.vue';
import FooterComponent from '@/components/FooterComponent.vue';
import axios from "axios";

const orders = ref([]);
const filteredOrders = ref([]);
const loading = ref(false);
const error = ref(null);
const searchQuery = ref("");
const statusFilter = ref("");
const paymentStatusFilter = ref("");
const sortField = ref("created_at");
const sortDirection = ref("desc");

// Pagination
const currentPage = ref(1);
const itemsPerPage = ref(10);

// Modal
const showEditModal = ref(false);
const editingOrder = ref({});

// API configuration
const apiBaseUrl = process.env.VUE_APP_API_URL || "http://localhost/api";

const totalOrders = computed(() => orders.value.length);
const totalPages = computed(() => Math.ceil(filteredOrders.value.length / itemsPerPage.value));
const paginatedOrders = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredOrders.value.slice(start, end);
});

const applyFilters = () => {
  let filtered = [...orders.value];

  // Search filter
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter(
      (order) =>
        order.id.toString().includes(query) ||
        order.customer_name.toLowerCase().includes(query) ||
        order.customer_email.toLowerCase().includes(query)
    );
  }

  // Status filters
  if (statusFilter.value) {
    filtered = filtered.filter(
      (order) => order.status === statusFilter.value
    );
  }

  if (paymentStatusFilter.value) {
    filtered = filtered.filter(
      (order) => order.payment_status === paymentStatusFilter.value
    );
  }

  // Sort
  filtered.sort((a, b) => {
    let aVal = a[sortField.value];
    let bVal = b[sortField.value];

    if (sortField.value === "total_amount") {
      aVal = parseFloat(aVal);
      bVal = parseFloat(bVal);
    }

    if (sortDirection.value === "asc") {
      return aVal > bVal ? 1 : -1;
    } else {
      return aVal < bVal ? 1 : -1;
    }
  });

  filteredOrders.value = filtered;
  currentPage.value = 1; // Reset to first page when filtering
};

// Format functions
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('vi-VN');
};

const formatPrice = (price) => {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(price);
};

const getStatusText = (status) => {
  const statusMap = {
    pending: 'Chờ xác nhận',
    processing: 'Đang xử lý',
    shipped: 'Đang giao hàng',
    delivered: 'Đã nhận hàng',
    cancelled: 'Đã hủy'
  };
  return statusMap[status] || status;
};

const getPaymentMethodText = (method) => {
  const methodMap = {
    cod: 'Thanh toán khi nhận hàng',
    bank_transfer: 'Chuyển khoản ngân hàng',
    credit_card: 'Thẻ tín dụng'
  };
  return methodMap[method] || method;
};

const getPaymentStatusText = (status) => {
  const statusMap = {
    pending: 'Chờ thanh toán',
    paid: 'Đã thanh toán',
    failed: 'Thanh toán thất bại'
  };
  return statusMap[status] || status;
};

// CRUD operations
const editOrder = async (orderId) => {
  try {
    const response = await axios.get(`${apiBaseUrl}/orders/${orderId}`);
    editingOrder.value = response.data;
    showEditModal.value = true;
  } catch (err) {
    error.value = 'Không thể tải thông tin đơn hàng';
    console.error(err);
  }
};

const deleteOrder = async (orderId) => {
  if (!confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) return;
  
  try {
    await axios.delete(`${apiBaseUrl}/orders/${orderId}`);
    orders.value = orders.value.filter(order => order.id !== orderId);
    applyFilters();
  } catch (err) {
    error.value = 'Không thể xóa đơn hàng';
    console.error(err);
  }
};

// Load initial data
onMounted(async () => {
  try {
    loading.value = true;
    const response = await axios.get(`${apiBaseUrl}/orders`);
    orders.value = response.data;
    applyFilters();
  } catch (err) {
    error.value = 'Không thể tải danh sách đơn hàng';
    console.error(err);
  } finally {
    loading.value = false;
  }
});
</script>

<style scoped>
.admin-order-management {
  min-height: 100vh;
  background-color: #f5f5f5;
}

.hero-section {
  background-color: #4a90e2;
  color: white;
  padding: 2rem;
  text-align: center;
}

.hero-section h1 {
  margin: 0;
  font-size: 2rem;
}

.hero-section p {
  margin: 0.5rem 0 0;
  opacity: 0.9;
}

.main-content {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 0 1rem;
}

.filters {
  background-color: white;
  padding: 1rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  margin-bottom: 1rem;
}

.search-box {
  margin-bottom: 1rem;
}

.search-box input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.filter-options {
  display: flex;
  gap: 1rem;
}

.filter-options select {
  flex: 1;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.orders-table {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #eee;
}

th {
  background-color: #f8f9fa;
  font-weight: 600;
}

.status-badge {
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.875rem;
}

.status-badge.pending {
  background-color: #fff3cd;
  color: #856404;
}

.status-badge.processing {
  background-color: #cce5ff;
  color: #004085;
}

.status-badge.shipped {
  background-color: #d4edda;
  color: #155724;
}

.status-badge.delivered {
  background-color: #d1e7dd;
  color: #0f5132;
}

.status-badge.cancelled {
  background-color: #f8d7da;
  color: #721c24;
}

.actions {
  display: flex;
  gap: 0.5rem;
}

.action-btn {
  padding: 0.25rem;
  border: none;
  background: none;
  cursor: pointer;
  font-size: 1.25rem;
}

.action-btn:hover {
  opacity: 0.7;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  margin-top: 1rem;
}

.page-btn {
  padding: 0.5rem 1rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  background-color: white;
  cursor: pointer;
}

.page-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.page-info {
  font-size: 0.875rem;
  color: #666;
}
</style>
