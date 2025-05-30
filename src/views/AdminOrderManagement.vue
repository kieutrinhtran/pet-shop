<template>
  <div class="admin-order-management">
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
      <BasePagination
        :current-page="currentPage"
        :total-pages="totalPages"
        @prev="currentPage > 1 && (currentPage--, applyFilters())"
        @next="currentPage < totalPages && (currentPage++, applyFilters())"
      />
    </div>

    <!-- Order Confirmation Modal -->
    <div v-if="showEditModal" class="modal-overlay">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Xác nhận đơn hàng #{{ editingOrder.id }}</h2>
          <button class="close-btn" @click="showEditModal = false">&times;</button>
        </div>
        <div class="modal-body">
          <div class="order-info">
            <div class="info-group">
              <label>Khách hàng:</label>
              <span>{{ editingOrder.customer_name }}</span>
            </div>
            <div class="info-group">
              <label>Email:</label>
              <span>{{ editingOrder.customer_email }}</span>
            </div>
            <div class="info-group">
              <label>Ngày đặt:</label>
              <span>{{ formatDate(editingOrder.created_at) }}</span>
            </div>
            <div class="info-group">
              <label>Tổng giá trị:</label>
              <span>{{ formatPrice(editingOrder.total_amount) }}</span>
            </div>
            <div class="info-group">
              <label>Phương thức thanh toán:</label>
              <span>{{ getPaymentMethodText(editingOrder.payment_method) }}</span>
            </div>
          </div>

          <div class="status-update">
            <div class="form-group">
              <label>Trạng thái đơn hàng:</label>
              <select v-model="editingOrder.status">
                <option value="pending">Chờ xác nhận</option>
                <option value="processing">Đang xử lý</option>
                <option value="shipped">Đang giao hàng</option>
                <option value="delivered">Đã nhận hàng</option>
                <option value="cancelled">Đã hủy</option>
              </select>
            </div>
            <div class="form-group">
              <label>Trạng thái thanh toán:</label>
              <select v-model="editingOrder.payment_status">
                <option value="pending">Chờ thanh toán</option>
                <option value="paid">Đã thanh toán</option>
                <option value="failed">Thanh toán thất bại</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="cancel-btn" @click="showEditModal = false">Hủy</button>
          <button class="save-btn" @click="saveOrderChanges">Lưu thay đổi</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from "axios";
import BasePagination from '@/components/BasePagination.vue'

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
    // Tìm đơn hàng trong mảng orders
    const order = orders.value.find(o => o.id === orderId);
    if (order) {
      editingOrder.value = { ...order };
      showEditModal.value = true;
    }
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

// Thêm hàm saveOrderChanges
const saveOrderChanges = async () => {
  try {
    // Tìm và cập nhật đơn hàng trong mảng orders
    const index = orders.value.findIndex(order => order.id === editingOrder.value.id);
    if (index !== -1) {
      orders.value[index] = { ...editingOrder.value };
      applyFilters();
      showEditModal.value = false;
    }
  } catch (err) {
    error.value = 'Không thể cập nhật đơn hàng';
    console.error(err);
  }
};

// Load initial data
onMounted(async () => {
  try {
    loading.value = true;
    
    //chờ file api rồi sửa
    // const response = await axios.get(`${apiBaseUrl}/orders`);
    // orders.value = response.data;

    // Mock data thay vì gọi API
    orders.value = [
      {
        id: 'ORD001',
        created_at: '2024-03-15T10:30:00',
        status: 'pending',
        total_amount: 1250000,
        payment_method: 'cod',
        payment_status: 'pending',
        customer_name: 'Nguyễn Văn A',
        customer_email: 'nguyenvana@gmail.com'
      },
      {
        id: 'ORD002',
        created_at: '2024-03-14T15:45:00',
        status: 'processing',
        total_amount: 2500000,
        payment_method: 'bank_transfer',
        payment_status: 'paid',
        customer_name: 'Trần Thị B',
        customer_email: 'tranthib@gmail.com'
      },
      {
        id: 'ORD003',
        created_at: '2024-03-13T09:20:00',
        status: 'shipped',
        total_amount: 1800000,
        payment_method: 'credit_card',
        payment_status: 'paid',
        customer_name: 'Lê Văn C',
        customer_email: 'levanc@gmail.com'
      },
      {
        id: 'ORD004',
        created_at: '2024-03-12T14:15:00',
        status: 'delivered',
        total_amount: 3200000,
        payment_method: 'cod',
        payment_status: 'paid',
        customer_name: 'Phạm Thị D',
        customer_email: 'phamthid@gmail.com'
      },
      {
        id: 'ORD005',
        created_at: '2024-03-11T11:30:00',
        status: 'cancelled',
        total_amount: 950000,
        payment_method: 'bank_transfer',
        payment_status: 'failed',
        customer_name: 'Hoàng Văn E',
        customer_email: 'hoangvane@gmail.com'
      },
      {
        id: 'ORD006',
        created_at: '2024-03-10T16:45:00',
        status: 'pending',
        total_amount: 1500000,
        payment_method: 'credit_card',
        payment_status: 'pending',
        customer_name: 'Đỗ Thị F',
        customer_email: 'dothif@gmail.com'
      },
      {
        id: 'ORD007',
        created_at: '2024-03-09T13:20:00',
        status: 'processing',
        total_amount: 2800000,
        payment_method: 'cod',
        payment_status: 'paid',
        customer_name: 'Vũ Văn G',
        customer_email: 'vuvang@gmail.com'
      },
      {
        id: 'ORD008',
        created_at: '2024-03-08T10:15:00',
        status: 'shipped',
        total_amount: 2100000,
        payment_method: 'bank_transfer',
        payment_status: 'paid',
        customer_name: 'Đặng Thị H',
        customer_email: 'dangthih@gmail.com'
      },
      {
        id: 'ORD009',
        created_at: '2024-03-07T15:30:00',
        status: 'delivered',
        total_amount: 1750000,
        payment_method: 'credit_card',
        payment_status: 'paid',
        customer_name: 'Bùi Văn I',
        customer_email: 'buivani@gmail.com'
      },
      {
        id: 'ORD010',
        created_at: '2024-03-06T09:45:00',
        status: 'cancelled',
        total_amount: 1200000,
        payment_method: 'cod',
        payment_status: 'failed',
        customer_name: 'Ngô Thị K',
        customer_email: 'ngothik@gmail.com'
      }
    ];
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

/* Modal styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  border-radius: 8px;
  width: 90%;
  max-width: 600px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  padding: 1rem;
  border-bottom: 1px solid #eee;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h2 {
  margin: 0;
  font-size: 1.25rem;
  color: #333;
}

.close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #666;
}

.modal-body {
  padding: 1rem;
}

.order-info {
  margin-bottom: 1.5rem;
}

.info-group {
  display: flex;
  margin-bottom: 0.75rem;
}

.info-group label {
  width: 150px;
  font-weight: 600;
  color: #666;
}

.status-update {
  background: #f8f9fa;
  padding: 1rem;
  border-radius: 4px;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #666;
}

.form-group select {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  background: white;
}

.modal-footer {
  padding: 1rem;
  border-top: 1px solid #eee;
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}

.cancel-btn, .save-btn {
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 600;
}

.cancel-btn {
  background: #f8f9fa;
  border: 1px solid #ddd;
  color: #666;
}

.save-btn {
  background: #4a90e2;
  border: none;
  color: white;
}

.cancel-btn:hover {
  background: #e9ecef;
}

.save-btn:hover {
  background: #357abd;
}

.action-btn.edit {
  color: #4a90e2;
}

.action-btn.delete {
  color: #dc3545;
}
</style>
