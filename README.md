# Pet Shop - Ứng dụng Thương mại điện tử Vue.js

Ứng dụng thương mại điện tử hiện đại cho sản phẩm thú cưng được xây dựng bằng Vue.js.

## Cấu trúc Dự án

```
pet-world/
├── src/
│   ├── assets/                  # Chứa tài nguyên tĩnh như ảnh, font, icon...
│   ├── components/              # Các component tái sử dụng nhiều nơi trong app
│   │   ├── AdminHeader.vue          # Header cho giao diện admin
│   │   ├── CustomerHeader.vue       # Header cho giao diện khách hàng
│   │   ├── FooterComponent.vue      # Chân trang dùng toàn site
│   │   ├── BasePagination.vue       # Component phân trang dùng lại cho nhiều trang
│   │   └── ShoppingCartComponent.vue# Hiển thị giỏ hàng nhỏ (mini cart)
│   ├── layouts/                # Các layout tổng thể cho từng loại trang
│   │   ├── AdminLayout.vue         # Layout cho các trang admin (có header, footer riêng)
│   │   └── CustomerLayout.vue      # Layout cho các trang khách hàng (header, footer riêng)
│   ├── views/                   # Các trang chính (page) của ứng dụng
│   │   ├── AboutPage.vue            # Trang giới thiệu về shop
│   │   ├── AdminOrderManagement.vue # Trang quản lý đơn hàng (admin)
│   │   ├── AdminStatistics.vue      # Trang thống kê, dashboard (admin)
│   │   ├── CartPage.vue             # Trang giỏ hàng
│   │   ├── CheckoutPage.vue         # Trang thanh toán
│   │   ├── HomePage.vue             # Trang chủ
│   │   ├── LoginPage.vue            # Trang đăng nhập khách hàng
│   │   ├── LoginSuccess.vue         # Trang thông báo đăng nhập thành công
│   │   ├── OrderSuccess.vue         # Trang thông báo đặt hàng thành công
│   │   ├── ProductDetail.vue        # Trang chi tiết sản phẩm
│   │   ├── ProductsList.vue         # Trang danh sách sản phẩm
│   │   ├── RegisterPage.vue         # Trang đăng ký tài khoản khách hàng
│   │   ├── RegisterSuccess.vue      # Trang thông báo đăng ký thành công
│   │   ├── ShippingPage.vue         # Trang nhập thông tin vận chuyển
│   │   ├── NotFound.vue             # Trang 404 khi không tìm thấy đường dẫn
│   │   └── AdminLogin.vue           # Trang đăng nhập dành cho admin
│   ├── data/                    # Chứa dữ liệu mẫu, hằng số (nếu có)
│   ├── router/                  # Cấu hình router (điều hướng các trang)
│   │   └── index.js                 # Định nghĩa các route, layout, children route
│   ├── services/                # Chứa các hàm gọi API, xử lý dữ liệu (nếu có)
│   ├── store/                   # Quản lý state toàn cục (Pinia/Vuex)
│   │   └── index.js
│   ├── App.vue                  # Component gốc, nơi mount toàn bộ ứng dụng
│   └── main.js                  # File khởi tạo Vue app, khai báo router, store, global style
├── public/                      # File tĩnh công khai (index.html, favicon, ảnh dùng trực tiếp)
├── backend/                     # Máy chủ API (nếu có, thường cho backend NodeJS, Laravel...)
├── package.json                 # Danh sách dependency, script, metadata của dự án
├── vue.config.js                # Cấu hình bổ sung cho Vue CLI (proxy, build, ...)
└── README.md                    # Tài liệu hướng dẫn dự án (file này)
```

## Tính năng

- 🛍️ Duyệt và tìm kiếm sản phẩm
- 🛒 Chức năng giỏ hàng
- 👤 Xác thực người dùng (đăng nhập/đăng ký)
- 📦 Quản lý đơn hàng
- 💳 Quy trình thanh toán
- 📱 Thiết kế responsive
- 🔒 Tích hợp thanh toán an toàn
- 📊 Bảng điều khiển quản trị đơn hàng

## Yêu cầu hệ thống

- Node.js (phiên bản 14 trở lên)
- npm (phiên bản 6 trở lên)

## Hướng dẫn khởi tạo dự án Vue và kết nối GitHub

### 🚀 Tạo project Vue mới (vì đã tạo rồi nên không cần làm lại bước này)

1. Mở terminal và chuyển đến thư mục bạn muốn lưu project:

   ```bash
   cd "C:\Users\Trinh\Documents\0. VueJS"
   ```
2. Tạo project Vue:

   ```bash
   vue create pet-shop
   ```

   → Chọn Vue 3 (default), nhấn `Enter` liên tục để tạo project.

---

## 🔗 Kết nối với GitHub

### Clone repo (nếu đã tạo sẵn trên GitHub)

```bash
git clone https://github.com/kieutrinhtran/pet-shop
cd pet-shop
git add .
git commit -m "initial commit"
```

### Làm việc trong VS Code

1. Mở thư mục `pet-shop` trong VS Code.
2. Khởi tạo Git (nếu chưa có):

   ```bash
   git init
   ```
3. Thêm remote origin (chỉ cần làm 1 lần):

   ```bash
   git remote add origin https://github.com/kieutrinhtran/pet-shop.git
   ```

---

## 🌿 Quản lý nhánh và đẩy code lên GitHub

1. Xem các nhánh hiện có:

   ```bash
   git branch
   ```
2. Tạo và chuyển sang nhánh mới (thay `trinh` bằng tên của bạn, sau này chỉ push code lên branch của mình):

   ```bash
   git checkout -b trinh
   ```
3. Kiểm tra nhánh hiện tại:

   ```bash
   git branch
   ```
4. Thêm thay đổi và commit:

   ```bash
   git add .
   git commit -m "Add code to trinh branch"
   ```
5. Push nhánh mới lên GitHub:

   ```bash
   git push -u origin trinh
   ```

---

## Cài đặt và chạy dự án

### Cài đặt dependencies
```bash
npm install
```