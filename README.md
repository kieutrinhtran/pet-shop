# Pet Shop - Ứng dụng Thương mại điện tử Vue.js

Ứng dụng thương mại điện tử hiện đại cho sản phẩm thú cưng được xây dựng bằng Vue.js.

## Cấu trúc Dự án

```
pet-shop/
├── src/                    # Thư mục chứa mã nguồn
│   ├── assets/            # Tài nguyên tĩnh (hình ảnh, font chữ, v.v.)
│   ├── components/        # Các component Vue
│   │   ├── AboutPage.vue              # Trang Giới thiệu
│   │   ├── AdminOrderManagement.vue   # Trang Quản lý đơn hàng (Admin)
│   │   ├── CartPage.vue               # Trang Giỏ hàng
│   │   ├── CheckoutPage.vue           # Trang Thanh toán
│   │   ├── FooterComponent.vue        # Component Footer
│   │   ├── HeaderComponent.vue        # Component Header
│   │   ├── HomePage.vue               # Trang Chủ
│   │   ├── LoginPage.vue              # Trang Đăng nhập
│   │   ├── LoginSuccess.vue           # Trang Đăng nhập thành công
│   │   ├── OrderSuccess.vue           # Trang Đặt hàng thành công
│   │   ├── ProductDetail.vue          # Trang Chi tiết sản phẩm
│   │   ├── ProductsList.vue           # Trang Danh sách sản phẩm
│   │   ├── RegisterPage.vue           # Trang Đăng ký
│   │   ├── RegisterSuccess.vue        # Trang Đăng ký thành công
│   │   ├── ShippingPage.vue           # Trang Vận chuyển
│   │   └── ShoppingCartComponent.vue  # Component Giỏ hàng
│   ├── data/             # Dữ liệu mẫu và hằng số
│   ├── router/           # Cấu hình Vue Router
│   ├── store/            # Quản lý trạng thái
│   ├── App.vue           # Component gốc
│   └── main.js           # Điểm khởi đầu ứng dụng
├── public/               # Các file tĩnh công khai
├── backend/             # Máy chủ API
├── package.json         # Các dependency của dự án
├── vue.config.js        # Cấu hình Vue CLI
└── README.md           # Tài liệu dự án
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

### Chạy môi trường phát triển
```bash
npm run serve
```

### Build cho production

```bash
npm run build
```
### Kiểm tra và sửa lỗi code
```bash
npm run lint
```
