<template>
  <div class="admin-order-management">
    <Header />
    
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

    <Footer />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import Header from '@/components/shared/Header.vue';
import Footer from '@/components/shared/Footer.vue';
import axios from "axios";

const activeTab = ref("orders");
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
const saving = ref(false);

// API configuration
const apiBaseUrl = process.env.VUE_APP_API_URL || "http://localhost/api";

// Loading states
const loadingStates = ref({
  fetchingOrders: false,
  deletingOrder: false,
  savingOrder: false,
});

const totalOrders = computed(() => orders.value.length);
const totalPages = computed(() => Math.ceil(filteredOrders.value.length / itemsPerPage.value));
const paginatedOrders = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredOrders.value.slice(start, end);
});

const visiblePages = computed(() => {
  const pages = [];
  const total = totalPages.value;
  const current = currentPage.value;

  // Show first page
  if (current > 3) pages.push(1);
  if (current > 4) pages.push("...");

  // Show pages around current
  for (
    let i = Math.max(1, current - 2);
    i <= Math.min(total, current + 2);
    i++
  ) {
    pages.push(i);
  }

  // Show last page
  if (current < total - 3) pages.push("...");
  if (current < total - 2) pages.push(total);

  return pages;
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

const sortBy = (field) => {
  if (sortField.value === field) {
    sortDirection.value = sortDirection.value === "asc" ? "desc" : "asc";
  } else {
    sortField.value = field;
    sortDirection.value = "asc";
  }
  applyFilters();
};

const handleSearch = () => {
  applyFilters();
};

const navigateTo = (tab) => {
  activeTab.value = tab;
  // Emit event or use router to navigate
  // Assuming $emit is used in the parent component
};

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};

const editOrder = (order) => {
  editingOrder.value = { ...order };
  showEditModal.value = true;
};

const closeEditModal = () => {
  showEditModal.value = false;
  editingOrder.value = {};
};

const viewOrderDetails = (orderId) => {
  // Navigate to order details page
  // Assuming $router is used in the parent component
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString("vi-VN", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
  });
};

const formatCurrency = (amount) => {
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(amount);
};

const getPaymentMethodText = (method) => {
  const methods = {
    cod: "Thanh toán khi nhận hàng",
    bank_transfer: "Chuyển khoản ngân hàng",
    credit_card: "Thẻ tín dụng",
    e_wallet: "Ví điện tử",
  };
  return methods[method] || method;
};

const getPaymentStatusText = (status) => {
  const statuses = {
    unpaid: "Chưa thanh toán",
    paid: "Đã thanh toán",
    refunded: "Đã hoàn tiền",
  };
  return statuses[status] || status;
};

const getStatusText = (status) => {
  const statuses = {
    pending: "Chờ xử lý",
    processing: "Đang xử lý",
    shipped: "Đã giao hàng",
    delivered: "Đã nhận hàng",
    cancelled: "Đã hủy",
  };
  return statuses[status] || status;
};

const handleError = (error) => {
  if (error.response) {
    error.value = error.response.data.message || "Có lỗi xảy ra";
  } else {
    error.value = "Không thể kết nối đến server";
  }
};

const validateOrder = () => {
  const errors = [];
  if (!editingOrder.value.status) {
    errors.push("Trạng thái đơn hàng không được để trống");
  }
  if (!editingOrder.value.payment_status) {
    errors.push("Trạng thái thanh toán không được để trống");
  }
  return errors;
};

const exportToCsv = () => {
  try {
    const headers = [
      "ID",
      "Ngày đặt",
      "Khách hàng",
      "Tổng tiền",
      "Trạng thái",
    ];
    const data = orders.value.map((order) => [
      order.id,
      formatDate(order.created_at),
      order.customer_name,
      order.total_amount,
      getStatusText(order.status),
    ]);

    const csvContent = [
      headers.join(","),
      ...data.map((row) => row.join(",")),
    ].join("\n");

    const blob = new Blob([csvContent], {
      type: "text/csv;charset=utf-8;",
    });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);

    link.setAttribute("href", url);
    link.setAttribute("download", `orders-${new Date().toISOString()}.csv`);
    link.style.visibility = "hidden";

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url); // Clean up the URL object
  } catch (error) {
    console.error("Error exporting CSV:", error);
    // Assuming $toast is used in the parent component
    // $toast.error("Không thể xuất file CSV. Vui lòng thử lại.");
  }
};

onMounted(() => {
  fetchOrders();
});

const fetchOrders = async () => {
  loading.value = true;
  error.value = null;

  try {
    const response = await axios.get(`${apiBaseUrl}/orders`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
        "Content-Type": "application/json",
      },
    });

    orders.value = response.data.data || response.data;
    applyFilters();
  } catch (error) {
    console.error("Error fetching orders:", error);
    error.value = "Không thể tải danh sách đơn hàng. Vui lòng thử lại.";
  } finally {
    loading.value = false;
  }
};

const saveOrder = async () => {
  saving.value = true;

  try {
    const response = await axios.put(
      `${apiBaseUrl}/orders/${editingOrder.value.id}`,
      {
        status: editingOrder.value.status,
        payment_status: editingOrder.value.payment_status,
        notes: editingOrder.value.notes,
      },
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
          "Content-Type": "application/json",
        },
      }
    );

    // Update local data
    const index = orders.value.findIndex(
      (order) => order.id === editingOrder.value.id
    );
    if (index !== -1) {
      orders.value[index] = { ...orders.value[index], ...response.data.data };
    }

    applyFilters();
    closeEditModal();
    // Assuming $toast is used in the parent component
    // $toast.success("Cập nhật đơn hàng thành công!");
  } catch (error) {
    console.error("Error saving order:", error);
    // Assuming $toast is used in the parent component
    // $toast.error("Không thể cập nhật đơn hàng. Vui lòng thử lại.");
  } finally {
    saving.value = false;
  }
};

const deleteOrder = async (orderId) => {
  if (!confirm("Bạn có chắc chắn muốn xóa đơn hàng này?")) return;

  try {
    await axios.delete(`${apiBaseUrl}/orders/${orderId}`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });

    orders.value = orders.value.filter((order) => order.id !== orderId);
    applyFilters();
    // Assuming $toast is used in the parent component
    // $toast.success("Xóa đơn hàng thành công!");
  } catch (error) {
    console.error("Error deleting order:", error);
    // Assuming $toast is used in the parent component
    // $toast.error("Không thể xóa đơn hàng. Vui lòng thử lại.");
  }
};

const confirmDelete = async (orderId) => {
  if (await confirm("Bạn có chắc muốn xóa đơn hàng này?")) {
    deleteOrder(orderId);
  }
};
</script>

<style scoped>
.admin-order-management {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.main-content {
  flex: 1;
  padding: 32px;
  max-width: 1600px;
  margin: 0 auto;
  width: 100%;
}

.hero-section {
  text-align: center;
  padding: 48px 0;
  background: #fafbfc;
}

.hero-section h1 {
  font-size: 36px;
  color: #222;
  margin-bottom: 16px;
}

.hero-section p {
  font-size: 20px;
  color: #666;
}

.filters {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.search-box {
  flex: 1;
  position: relative;
}

.search-box input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.filter-options {
  display: flex;
  gap: 15px;
}

.filter-options select {
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
  background: white;
}

.orders-table {
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.orders-table table {
  width: 100%;
  border-collapse: collapse;
}

.orders-table th {
  background: #f8f9fa;
  padding: 15px 10px;
  text-align: left;
  font-weight: 600;
  color: #666;
  border-bottom: 2px solid #e9ecef;
  font-size: 12px;
  text-transform: uppercase;
}

.orders-table th.sortable {
  cursor: pointer;
  user-select: none;
  position: relative;
}

.orders-table th.sortable:hover {
  background: #e9ecef;
}

.orders-table td {
  padding: 15px 10px;
  border-bottom: 1px solid #e9ecef;
  font-size: 14px;
}

.orders-table tbody tr {
  cursor: pointer;
  transition: background-color 0.2s;
}

.orders-table tbody tr:hover {
  background: #f8f9fa;
}

.status-badge {
  display: inline-block;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 500;
}

.status-badge.pending {
  background: #fff3cd;
  color: #856404;
}

.status-badge.processing {
  background: #cce5ff;
  color: #004085;
}

.status-badge.shipped {
  background: #d4edda;
  color: #155724;
}

.status-badge.delivered {
  background: #d4edda;
  color: #155724;
}

.status-badge.cancelled {
  background: #f8d7da;
  color: #721c24;
}

.actions {
  text-align: right;
}

.actions .action-btn {
  width: 32px;
  height: 32px;
  border: 2px solid #ff6b35;
  background: white;
  border-radius: 4px;
  cursor: pointer;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  font-size: 16px;
  color: #ff6b35;
  transition: all 0.2s;
}

.actions .action-btn:hover {
  background: #ff6b35;
  color: white;
}

.actions .action-btn.edit {
  border-color: #007bff;
  color: #007bff;
}

.actions .action-btn.edit:hover {
  background: #007bff;
  color: white;
}

.actions .action-btn.delete {
  border-color: #dc3545;
  color: #dc3545;
}

.actions .action-btn.delete:hover {
  background: #dc3545;
  color: white;
}

.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.page-btn {
  background: #f8f9fa;
  border: 1px solid #ddd;
  padding: 8px 12px;
  margin: 0 5px;
  cursor: pointer;
  font-size: 14px;
  border-radius: 4px;
}

.page-btn.active {
  background: #ff6b35;
  color: white;
  border-color: #ff6b35;
}

.page-btn:disabled {
  background: #e9ecef;
  color: #666;
  cursor: not-allowed;
}

.page-info {
  margin: 0 15px;
  font-size: 14px;
  color: #666;
}
</style>
