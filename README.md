# Pet Shop Project

## Cấu trúc thư mục
```
pet-shop/
├── frontend/                 # Ứng dụng Vue.js phía client
│   ├── public/              # Các file tĩnh
│   └── src/                 # Mã nguồn
│       ├── assets/          # Hình ảnh, font chữ, etc.
│       ├── components/      # Các component Vue
│       ├── views/           # Các trang Vue
│       ├── App.vue          # Component gốc
│       └── main.js          # Điểm khởi đầu ứng dụng
│
├── backend/                  # Ứng dụng phía server
│   ├── admin/               # Trang quản trị
│   └── config/              # Các file cấu hình
│
├── .editorconfig            # Cấu hình editor
├── .gitignore              # Quy tắc bỏ qua Git
├── babel.config.js         # Cấu hình Babel
├── jsconfig.json           # Cấu hình JavaScript
├── package.json            # Các dependency của dự án
├── vue.config.js           # Cấu hình Vue.js
└── README.md               # Tài liệu dự án
```

## Hướng dẫn khởi tạo dự án Vue và kết nối GitHub

### 🚀 Tạo project Vue mới

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