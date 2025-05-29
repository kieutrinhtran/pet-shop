<template>
  <div class="admin-order-management">
    <!-- Header -->
    <header class="header">
      <div class="header-top">
        <div class="contact-info">
          <span>📞 +84 123 456 789</span>
          <span>✉️ wearpet@petshop.com</span>
        </div>
        <div class="store-management">🏪 Quản lý cửa hàng</div>
      </div>

      <nav class="nav">
        <div class="nav-content">
          <div class="logo">Pet World</div>
          <ul class="nav-menu">
            <li
              @click="navigateTo('customers')"
              :class="{ active: activeTab === 'customers' }"
            >
              Khách hàng
            </li>
            <li
              @click="navigateTo('orders')"
              :class="{ active: activeTab === 'orders' }"
            >
              Đơn hàng
            </li>
            <li
              @click="navigateTo('products')"
              :class="{ active: activeTab === 'products' }"
            >
              Sản phẩm
            </li>
            <li
              @click="navigateTo('promotions')"
              :class="{ active: activeTab === 'promotions' }"
            >
              Mô khuyển mai
            </li>
            <li
              @click="navigateTo('statistics')"
              :class="{ active: activeTab === 'statistics' }"
            >
              Thống kê
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <div class="hero-text">
          <div class="hero-subtitle">Pet World</div>
          <h1>Thiên đường mua sắm<br />dành cho thú cưng!</h1>
          <div class="search-container">
            <input
              type="text"
              v-model="searchQuery"
              @input="handleSearch"
              :placeholder="`Hiện thị ${filteredOrders.length} từ ${totalOrders} kết quả tìm kiếm`"
            />
            <button @click="handleSearch">Tìm kiếm</button>
          </div>
        </div>
        <div class="hero-image">
          <div class="hero-circle">
            <div class="pet-image"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
      <div class="orders-header">
        <h2>Danh sách đơn hàng</h2>
        <div class="order-controls">
          <select
            v-model="statusFilter"
            @change="applyFilters"
            class="filter-select"
          >
            <option value="">Tất cả trạng thái</option>
            <option value="pending">Chờ xử lý</option>
            <option value="processing">Đang xử lý</option>
            <option value="shipped">Đã giao hàng</option>
            <option value="delivered">Đã nhận hàng</option>
            <option value="cancelled">Đã hủy</option>
          </select>
          <select
            v-model="paymentStatusFilter"
            @change="applyFilters"
            class="filter-select"
          >
            <option value="">Tất cả thanh toán</option>
            <option value="paid">Đã thanh toán</option>
            <option value="unpaid">Chưa thanh toán</option>
            <option value="refunded">Đã hoàn tiền</option>
          </select>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="loading-container">
        <div class="loading-spinner"></div>
        <p>Đang tải dữ liệu...</p>
      </div>

      <!-- Error State -->
      <div v-if="error" class="error-container">
        <p>{{ error }}</p>
        <button @click="fetchOrders" class="retry-btn">Thử lại</button>
      </div>

      <!-- Orders Table -->
      <div v-if="!loading && !error" class="table-container">
        <table class="data-table">
          <thead>
            <tr>
              <th @click="sortBy('id')" class="sortable">
                ID đơn hàng
                <span
                  v-if="sortField === 'id'"
                  :class="['sort-arrow', sortDirection]"
                >
                  {{ sortDirection === "asc" ? "↑" : "↓" }}
                </span>
              </th>
              <th @click="sortBy('created_at')" class="sortable">
                Ngày đặt
                <span
                  v-if="sortField === 'created_at'"
                  :class="['sort-arrow', sortDirection]"
                >
                  {{ sortDirection === "asc" ? "↑" : "↓" }}
                </span>
              </th>
              <th>Khách hàng</th>
              <th @click="sortBy('total_amount')" class="sortable">
                Tổng giá trị
                <span
                  v-if="sortField === 'total_amount'"
                  :class="['sort-arrow', sortDirection]"
                >
                  {{ sortDirection === "asc" ? "↑" : "↓" }}
                </span>
              </th>
              <th>Phương thức thanh toán</th>
              <th>Trạng thái thanh toán</th>
              <th>Trạng thái đơn hàng</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="order in paginatedOrders"
              :key="order.id"
              @click="viewOrderDetails(order.id)"
            >
              <td>
                <span class="order-id">#{{ order.id }}</span>
              </td>
              <td>{{ formatDate(order.created_at) }}</td>
              <td>{{ order.customer_name }}</td>
              <td>
                <span class="price">{{
                  formatCurrency(order.total_amount)
                }}</span>
              </td>
              <td>{{ getPaymentMethodText(order.payment_method) }}</td>
              <td>
                <span :class="['status', order.payment_status]">
                  {{ getPaymentStatusText(order.payment_status) }}
                </span>
              </td>
              <td>
                <span :class="['status', order.status]">
                  {{ getOrderStatusText(order.status) }}
                </span>
              </td>
              <td @click.stop>
                <div class="actions">
                  <button
                    class="action-btn edit"
                    v-tooltip="'Chỉnh sửa đơn hàng'"
                    @click="editOrder(order)"
                  >
                    ✏️
                  </button>
                  <button
                    @click="confirmDelete(order.id)"
                    class="action-btn delete"
                    title="Xóa"
                  >
                    🗑️
                  </button>
                  <button
                    @click="viewOrderDetails(order.id)"
                    class="action-btn view"
                    title="Xem chi tiết"
                  >
                    👁️
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Empty State -->
        <div v-if="filteredOrders.length === 0" class="empty-state">
          <p>Không tìm thấy đơn hàng nào</p>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="filteredOrders.length > itemsPerPage" class="pagination">
        <button
          @click="goToPage(currentPage - 1)"
          :disabled="currentPage === 1"
          class="pagination-btn"
        >
          ‹ Trước
        </button>

        <button
          v-for="page in visiblePages"
          :key="page"
          @click="goToPage(page)"
          :class="['pagination-btn', { active: page === currentPage }]"
        >
          {{ page }}
        </button>

        <button
          @click="goToPage(currentPage + 1)"
          :disabled="currentPage === totalPages"
          class="pagination-btn"
        >
          Sau ›
        </button>
      </div>
    </main>

    <!-- Edit Order Modal -->
    <div v-if="showEditModal" class="modal-overlay" @click="closeEditModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>Chỉnh sửa đơn hàng #{{ editingOrder.id }}</h3>
          <button @click="closeEditModal" class="close-btn">×</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Trạng thái đơn hàng:</label>
            <select v-model="editingOrder.status" class="form-control">
              <option value="pending">Chờ xử lý</option>
              <option value="processing">Đang xử lý</option>
              <option value="shipped">Đã giao hàng</option>
              <option value="delivered">Đã nhận hàng</option>
              <option value="cancelled">Đã hủy</option>
            </select>
          </div>
          <div class="form-group">
            <label>Trạng thái thanh toán:</label>
            <select v-model="editingOrder.payment_status" class="form-control">
              <option value="unpaid">Chưa thanh toán</option>
              <option value="paid">Đã thanh toán</option>
              <option value="refunded">Đã hoàn tiền</option>
            </select>
          </div>
          <div class="form-group">
            <label>Ghi chú:</label>
            <textarea
              v-model="editingOrder.notes"
              class="form-control"
              rows="3"
            ></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button @click="closeEditModal" class="btn btn-secondary">Hủy</button>
          <button @click="saveOrder" class="btn btn-primary" :disabled="saving">
            {{ saving ? "Đang lưu..." : "Lưu thay đổi" }}
          </button>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <div class="footer-content">
        <div class="footer-section">
          <h3>🐾 Pet Shop</h3>
          <p>
            Chúng tôi thông qua phục vụ thú cưng - một con vật đáng hàng cung
            bạn khi hành trình yêu thương chúng.
          </p>
        </div>
        <div class="footer-section">
          <h3>Store</h3>
          <p>123 Lý Thường Kiệt, Phường 5, Quận 10, Thành phố Hồ Chí Minh</p>
          <p>📞 +84 123 456 789</p>
          <p>✉️ wearpet@petshop.com</p>
        </div>
      </div>
      <div class="footer-bottom">© Copyright Pet Shop. 2024</div>
    </footer>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AdminOrderManagement",
  data() {
    return {
      activeTab: "orders",
      orders: [],
      filteredOrders: [],
      loading: false,
      error: null,
      searchQuery: "",
      statusFilter: "",
      paymentStatusFilter: "",
      sortField: "created_at",
      sortDirection: "desc",

      // Pagination
      currentPage: 1,
      itemsPerPage: 10,

      // Modal
      showEditModal: false,
      editingOrder: {},
      saving: false,

      // API configuration
      apiBaseUrl: process.env.VUE_APP_API_URL || "http://localhost/api",

      // Loading states
      loadingStates: {
        fetchingOrders: false,
        deletingOrder: false,
        savingOrder: false,
      },
    };
  },

  computed: {
    totalOrders() {
      return this.orders.length;
    },

    totalPages() {
      return Math.ceil(this.filteredOrders.length / this.itemsPerPage);
    },

    paginatedOrders() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredOrders.slice(start, end);
    },

    visiblePages() {
      const pages = [];
      const total = this.totalPages;
      const current = this.currentPage;

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
    },
  },

  watch: {
    searchQuery: {
      handler: "applyFilters",
      immediate: false,
    },
  },

  mounted() {
    this.fetchOrders();
  },

  methods: {
    // API calls
    async fetchOrders() {
      this.loading = true;
      this.error = null;

      try {
        const response = await axios.get(`${this.apiBaseUrl}/orders`, {
          headers: {
            Authorization: `Bearer ${this.$store.getters.authToken}`,
            "Content-Type": "application/json",
          },
        });

        this.orders = response.data.data || response.data;
        this.applyFilters();
      } catch (error) {
        console.error("Error fetching orders:", error);
        this.error = "Không thể tải danh sách đơn hàng. Vui lòng thử lại.";
      } finally {
        this.loading = false;
      }
    },

    async saveOrder() {
      this.saving = true;

      try {
        const response = await axios.put(
          `${this.apiBaseUrl}/orders/${this.editingOrder.id}`,
          {
            status: this.editingOrder.status,
            payment_status: this.editingOrder.payment_status,
            notes: this.editingOrder.notes,
          },
          {
            headers: {
              Authorization: `Bearer ${this.$store.getters.authToken}`,
              "Content-Type": "application/json",
            },
          }
        );

        // Update local data
        const index = this.orders.findIndex(
          (order) => order.id === this.editingOrder.id
        );
        if (index !== -1) {
          this.orders[index] = { ...this.orders[index], ...response.data.data };
        }

        this.applyFilters();
        this.closeEditModal();
        this.$toast.success("Cập nhật đơn hàng thành công!");
      } catch (error) {
        console.error("Error saving order:", error);
        this.$toast.error("Không thể cập nhật đơn hàng. Vui lòng thử lại.");
      } finally {
        this.saving = false;
      }
    },

    async deleteOrder(orderId) {
      if (!confirm("Bạn có chắc chắn muốn xóa đơn hàng này?")) return;

      try {
        await axios.delete(`${this.apiBaseUrl}/orders/${orderId}`, {
          headers: {
            Authorization: `Bearer ${this.$store.getters.authToken}`,
          },
        });

        this.orders = this.orders.filter((order) => order.id !== orderId);
        this.applyFilters();
        this.$toast.success("Xóa đơn hàng thành công!");
      } catch (error) {
        console.error("Error deleting order:", error);
        this.$toast.error("Không thể xóa đơn hàng. Vui lòng thử lại.");
      }
    },

    async confirmDelete(orderId) {
      if (await this.$confirm("Bạn có chắc muốn xóa đơn hàng này?")) {
        this.deleteOrder(orderId);
      }
    },

    // Filtering and sorting
    applyFilters() {
      let filtered = [...this.orders];

      // Search filter
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter(
          (order) =>
            order.id.toString().includes(query) ||
            order.customer_name.toLowerCase().includes(query) ||
            order.customer_email.toLowerCase().includes(query)
        );
      }

      // Status filters
      if (this.statusFilter) {
        filtered = filtered.filter(
          (order) => order.status === this.statusFilter
        );
      }

      if (this.paymentStatusFilter) {
        filtered = filtered.filter(
          (order) => order.payment_status === this.paymentStatusFilter
        );
      }

      // Sort
      filtered.sort((a, b) => {
        let aVal = a[this.sortField];
        let bVal = b[this.sortField];

        if (this.sortField === "total_amount") {
          aVal = parseFloat(aVal);
          bVal = parseFloat(bVal);
        }

        if (this.sortDirection === "asc") {
          return aVal > bVal ? 1 : -1;
        } else {
          return aVal < bVal ? 1 : -1;
        }
      });

      this.filteredOrders = filtered;
      this.currentPage = 1; // Reset to first page when filtering
    },

    sortBy(field) {
      if (this.sortField === field) {
        this.sortDirection = this.sortDirection === "asc" ? "desc" : "asc";
      } else {
        this.sortField = field;
        this.sortDirection = "asc";
      }
      this.applyFilters();
    },

    handleSearch() {
      this.applyFilters();
    },

    // Navigation
    navigateTo(tab) {
      this.activeTab = tab;
      // Emit event or use router to navigate
      this.$emit("navigate", tab);
    },

    // Pagination
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },

    // Modal handling
    editOrder(order) {
      this.editingOrder = { ...order };
      this.showEditModal = true;
    },

    closeEditModal() {
      this.showEditModal = false;
      this.editingOrder = {};
    },

    viewOrderDetails(orderId) {
      // Navigate to order details page
      this.$router.push(`/admin/orders/${orderId}`);
    },

    // Formatting helpers
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString("vi-VN", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
      });
    },

    formatCurrency(amount) {
      return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
      }).format(amount);
    },

    getPaymentMethodText(method) {
      const methods = {
        cod: "Thanh toán khi nhận hàng",
        bank_transfer: "Chuyển khoản ngân hàng",
        credit_card: "Thẻ tín dụng",
        e_wallet: "Ví điện tử",
      };
      return methods[method] || method;
    },

    getPaymentStatusText(status) {
      const statuses = {
        unpaid: "Chưa thanh toán",
        paid: "Đã thanh toán",
        refunded: "Đã hoàn tiền",
      };
      return statuses[status] || status;
    },

    getOrderStatusText(status) {
      const statuses = {
        pending: "Chờ xử lý",
        processing: "Đang xử lý",
        shipped: "Đã giao hàng",
        delivered: "Đã nhận hàng",
        cancelled: "Đã hủy",
      };
      return statuses[status] || status;
    },

    handleError(error) {
      if (error.response) {
        this.error = error.response.data.message || "Có lỗi xảy ra";
      } else {
        this.error = "Không thể kết nối đến server";
      }
    },

    validateOrder() {
      const errors = [];
      if (!this.editingOrder.status) {
        errors.push("Trạng thái đơn hàng không được để trống");
      }
      if (!this.editingOrder.payment_status) {
        errors.push("Trạng thái thanh toán không được để trống");
      }
      return errors;
    },

    exportToCsv() {
      try {
        const headers = [
          "ID",
          "Ngày đặt",
          "Khách hàng",
          "Tổng tiền",
          "Trạng thái",
        ];
        const data = this.orders.map((order) => [
          order.id,
          this.formatDate(order.created_at),
          order.customer_name,
          order.total_amount,
          this.getOrderStatusText(order.status),
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
        this.$toast.error("Không thể xuất file CSV. Vui lòng thử lại.");
      }
    },
  },
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.admin-order-management {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f8f9fa;
  color: #333;
  min-height: 100vh;
}

/* Header Styles */
.header {
  background: white;
  padding: 15px 0;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  z-index: 100;
}

.header-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.contact-info {
  display: flex;
  gap: 30px;
  font-size: 14px;
  color: #666;
}

.store-management {
  color: #ff6b35;
  font-weight: 600;
  cursor: pointer;
}

.nav {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  margin-top: 15px;
}

.nav-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 18px;
  font-weight: bold;
}

.logo::before {
  content: "🐾";
  font-size: 20px;
}

.nav-menu {
  display: flex;
  gap: 40px;
  list-style: none;
}

.nav-menu li {
  cursor: pointer;
  padding: 8px 0;
  border-bottom: 2px solid transparent;
  transition: all 0.3s;
}

.nav-menu li.active {
  color: #ff6b35;
  border-bottom-color: #ff6b35;
}

.nav-menu li:hover {
  color: #ff6b35;
}

/* Hero Section */
.hero {
  background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
  padding: 60px 0;
  position: relative;
  overflow: hidden;
}

.hero-content {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.hero-text {
  flex: 1;
  color: white;
}

.hero-subtitle {
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: 10px;
}

.hero-text h1 {
  font-size: 48px;
  font-weight: bold;
  line-height: 1.2;
  margin-bottom: 30px;
}

.search-container {
  background: white;
  border-radius: 8px;
  padding: 4px;
  display: flex;
  max-width: 400px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.search-container input {
  flex: 1;
  border: none;
  padding: 12px 16px;
  font-size: 14px;
  outline: none;
}

.search-container button {
  background: #ff6b35;
  color: white;
  border: none;
  padding: 12px 20px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
}

.hero-image {
  position: relative;
}

.hero-circle {
  width: 300px;
  height: 300px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  position: relative;
  overflow: hidden;
}

.pet-image {
  position: absolute;
  bottom: -20px;
  right: -20px;
  width: 200px;
  height: 200px;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle cx="100" cy="100" r="80" fill="%23333"/><circle cx="80" cy="80" r="8" fill="white"/><circle cx="120" cy="80" r="8" fill="white"/><path d="M90 110 Q100 120 110 110" stroke="white" fill="none" stroke-width="3"/></svg>')
    center/contain no-repeat;
  border-radius: 50%;
}

/* Main Content */
.main-content {
  max-width: 1200px;
  margin: 40px auto;
  padding: 0 20px;
}

.orders-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.orders-header h2 {
  font-size: 24px;
  color: #333;
}

.order-controls {
  display: flex;
  gap: 15px;
}

.filter-select {
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
  background: white;
}

/* Loading and Error States */
.loading-container,
.error-container {
  text-align: center;
  padding: 60px 20px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #ff6b35;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 20px;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.retry-btn {
  background: #ff6b35;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 15px;
}

/* Table Styles */
.table-container {
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.data-table {
  width: 100%;
  border-collapse: collapse;
}

.data-table th {
  background: #f8f9fa;
  padding: 15px 10px;
  text-align: left;
  font-weight: 600;
  color: #666;
  border-bottom: 2px solid #e9ecef;
  font-size: 12px;
  text-transform: uppercase;
}

.data-table th.sortable {
  cursor: pointer;
  user-select: none;
  position: relative;
}

.data-table th.sortable:hover {
  background: #e9ecef;
}

.sort-arrow {
  margin-left: 5px;
  font-size: 12px;
}

.data-table td {
  padding: 15px 10px;
  border-bottom: 1px solid #e9ecef;
  font-size: 14px;
}

.data-table tbody tr {
  cursor: pointer;
  transition: background-color 0.2s;
}

.data-table tbody tr:hover {
  background: #f8f9fa;
}

.order-id {
  color: #007bff;
  font-weight: 600;
}

.price {
  font-weight: 600;
  color: #28a745;
}

.status {
  display: inline-block;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 500;
}

.status.paid {
  background: #d4edda;
  color: #155724;
}

.status.unpaid {
  background: #fff3cd;
  color: #856404;
}

.status.refunded {
  background: #d1ecf1;
  color: #0c5460;
}

.status.pending {
  background: #fff3cd;
  color: #856404;
}

.status.processing {
  background: #cce5ff;
  color: #004085;
}

.status.shipped {
  background: #d4edda;
  color: #155724;
}

.status.delivered {
  background: #d4edda;
  color: #155724;
}

.status.cancelled {
  background: #f8d7da;
  color: #721c24;
}

.actions {
  display: flex;
  gap: 8px;
}

.action-btn {
  width: 32px;
  height: 32px;
  border: 2px solid #ff6b35;
  background: white;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 16px;
  color: #ff6b35;
  transition: all 0.2s;
}
.action-btn:hover {
  background: #ff6b35;
  color: white;
}
.action-btn.edit {
  border-color: #007bff;
  color: #007bff;
}
.action-btn.edit:hover {
  background: #007bff;
  color: white;
}
.action-btn.delete {
  border-color: #dc3545;
  color: #dc3545;
}
.action-btn.delete:hover {
  background: #dc3545;
  color: white;
}
.action-btn.view {
  border-color: #28a745;
  color: #28a745;
}
.action-btn.view:hover {
  background: #28a745;
  color: white;
}
.actions .action-btn {
  width: 32px;
  height: 32px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 16px;
}
.actions .action-btn:hover {
  background: #ff6b35;
  color: white;
}
/* Empty State */
.empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #666;
}
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}
.pagination-btn {
  background: #f8f9fa;
  border: 1px solid #ddd;
  padding: 8px 12px;
  margin: 0 5px;
  cursor: pointer;
  font-size: 14px;
  border-radius: 4px;
}
.pagination-btn.active {
  background: #ff6b35;
  color: white;
  border-color: #ff6b35;
}
.pagination-btn:disabled {
  background: #e9ecef;
  color: #666;
  cursor: not-allowed;
}
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal-content {
  background: white;
  border-radius: 8px;
  width: 500px;
  max-width: 90%;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
.modal-header h3 {
  font-size: 20px;
  color: #333;
}
.modal-header .close-btn {
  background: transparent;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #666;
}
.modal-body {
  margin-bottom: 20px;
}
.form-group {
  margin-bottom: 15px;
}
.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: 600;
  color: #333;
}
.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}
.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}
.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
}
.btn-secondary {
  background: #f8f9fa;
  color: #333;
}
.btn-secondary:hover {
  background: #e9ecef;
}
.btn-primary {
  background: #ff6b35;
  color: white;
}
.btn-primary:hover {
  background: #e65c2f;
}
.footer {
  background: #343a40;
  color: white;
  padding: 40px 0;
  margin-top: 40px;
}
.footer-content {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  padding: 0 20px;
}
.footer-section {
  flex: 1;
  margin-right: 20px;
}
.footer-section:last-child {
  margin-right: 0;
}
.footer-section h3 {
  font-size: 18px;
  margin-bottom: 15px;
  color: #ff6b35;
}
.footer-section p {
  font-size: 14px;
  color: #ccc;
  line-height: 1.5;
}
.footer-bottom {
  text-align: center;
  padding: 20px 0;
  background: #23272b;
  color: #ccc;
  font-size: 14px;
}
.footer-bottom a {
  color: #ff6b35;
  text-decoration: none;
}
.footer-bottom a:hover {
  text-decoration: underline;
}
</style>
<style>
@media (max-width: 768px) {
  .header-top {
    flex-direction: column;
    align-items: flex-start;
  }

  .nav-menu {
    flex-direction: column;
    gap: 10px;
  }

  .hero-content {
    flex-direction: column;
    align-items: center;
  }

  .hero-image {
    margin-top: 20px;
  }

  .data-table th,
  .data-table td {
    font-size: 12px;
    padding: 10px;
  }

  .search-container {
    width: 100%;
    max-width: none;
  }
}
@media (max-width: 576px) {
  .hero-text h1 {
    font-size: 32px;
    text-align: center;
  }

  .hero-subtitle {
    text-align: center;
  }

  .search-container {
    width: 100%;
    max-width: none;
    margin-top: 20px;
  }

  .orders-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .order-controls {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
}
@media (max-width: 480px) {
  .hero-content {
    flex-direction: column;
    align-items: center;
  }

  .hero-text {
    text-align: center;
  }

  .hero-image {
    width: 100%;
    max-width: 300px;
    margin-top: 20px;
  }

  .data-table th,
  .data-table td {
    font-size: 12px;
    padding: 8px;
  }

  .pagination-btn {
    padding: 6px 10px;
    font-size: 12px;
  }
}
@media (max-width: 360px) {
  .hero-text h1 {
    font-size: 28px;
  }

  .hero-subtitle {
    font-size: 16px;
  }

  .search-container input {
    font-size: 12px;
    padding: 8px;
  }

  .search-container button {
    padding: 8px 12px;
    font-size: 12px;
  }

  .data-table th,
  .data-table td {
    font-size: 10px;
    padding: 6px;
  }
}
@media (max-width: 320px) {
  .hero-text h1 {
    font-size: 24px;
  }

  .hero-subtitle {
    font-size: 14px;
  }

  .search-container input {
    font-size: 10px;
    padding: 6px;
  }

  .search-container button {
    padding: 6px 10px;
    font-size: 10px;
  }

  .data-table th,
  .data-table td {
    font-size: 10px;
    padding: 4px;
  }
}
</style>
