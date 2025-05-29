# pet-shop

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
2. Tạo và chuyển sang nhánh mới (thay `trinh` bằng tên bạn muốn):

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

## Project setup

```bash
npm install
```

### Compiles and hot-reloads for development

```bash
npm run serve
```

### Compiles and minifies for production

```bash
npm run build
```

### Lints and fixes files

```bash
npm run lint
```

### Customize configuration

See [Configuration Reference](https://cli.vuejs.org/config/).
