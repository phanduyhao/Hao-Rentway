# Tài liệu API

Tài liệu này cung cấp thông tin chi tiết về các điểm cuối (endpoints) API cho ứng dụng Hao-Rentway.

## URL cơ sở

`http://your-app-url/api`

---

## Xác thực

Tất cả các endpoint yêu cầu xác thực đều cần một header `Authorization` với một Bearer Token.

`Authorization: Bearer <YOUR_AUTH_TOKEN>`

### 1. Đăng ký

- **Endpoint:** `/auth/register`
- **Phương thức:** `POST`
- **Mô tả:** Tạo một tài khoản người dùng mới.
- **Ví dụ cURL:**
  ```bash
  curl -X POST http://your-app-url/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
      "name": "John Doe",
      "email": "john.doe@example.com",
      "password": "password123",
      "password_confirmation": "password123"
  }'
  ```
- **Phản hồi thành công (201):**
  ```json
  {
      "status": "success",
      "message": "User registered successfully",
      "data": {
          "token": "...",
          "user": { ... }
      }
  }
  ```

### 2. Đăng nhập

- **Endpoint:** `/auth/login`
- **Phương thức:** `POST`
- **Mô tả:** Xác thực người dùng và trả về một token API.
- **Ví dụ cURL:**
  ```bash
  curl -X POST http://your-app-url/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
      "email": "john.doe@example.com",
      "password": "password123"
  }'
  ```
- **Phản hồi thành công (200):**
  ```json
  {
      "status": "success",
      "data": {
          "token": "...",
          "user": { ... }
      }
  }
  ```

### 3. Đăng xuất

- **Endpoint:** `/auth/logout`
- **Phương thức:** `POST`
- **Yêu cầu xác thực:** Bắt buộc
- **Mô tả:** Vô hiệu hóa token hiện tại của người dùng.
- **Ví dụ cURL:**
  ```bash
  curl -X POST http://your-app-url/api/auth/logout \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN"
  ```
- **Phản hồi thành công (200):**
  ```json
  {
      "status": "success",
      "message": "Logged out successfully"
  }
  ```

### 4. Lấy thông tin người dùng

- **Endpoint:** `/auth/me`
- **Phương thức:** `GET`
- **Yêu cầu xác thực:** Bắt buộc
- **Mô tả:** Lấy thông tin hồ sơ của người dùng đang được xác thực.
- **Ví dụ cURL:**
  ```bash
  curl -X GET http://your-app-url/api/auth/me \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN"
  ```
- **Phản hồi thành công (200):**
  ```json
  {
      "id": 1,
      "name": "John Doe",
      "email": "john.doe@example.com",
      ...
  }
  ```

---

## Bài đăng (Baidang)

### 1. Tạo bài đăng đầy đủ

- **Endpoint:** `/baidangdaydu`
- **Phương thức:** `POST`
- **Yêu cầu xác thực:** Bắt buộc
- **Mô tả:** Tạo một bài đăng mới và chi tiết.
- **Ví dụ cURL:**
  ```bash
  curl -X POST http://your-app-url/api/baidangdaydu \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
      "tieude": "Căn Hộ Dịch Vụ Cao Cấp Cho Thuê",
      "title_en": "Luxury Serviced Apartment for Rent",
      "loainhadat_id": 1,
      "address_id": 1,
      "gia": 25000000,
      "dientich": 85,
      "mota": "Mô tả chi tiết về căn hộ dịch vụ cao cấp...",
      "description_en": "Detailed description of the luxury serviced apartment...",
      "hinhanh": [
          "/temp/images/baidang/cho-thue-nha-1.jpg"
      ],
      "videos": [
          "/temp/videos/upload-1752555393-6875df816355b.mp4"
      ],
      "sophongngu": 2,
      "sophongtam": 2,
      "huongnha": "Đông Nam",
      "huongbancong": "Đông Nam",
      "age": 2,
      "mohinh": "thue",
      "unit": "thang",
      "isVip": true,
      "thietbi": [1, 2, 3],
      "name_contact": "Mr. Hai",
      "phone_contact": "0828983338",
      "email_contact": "contact@example.com",
      "link_zalo": "https://zalo.me/...",
      "facebook": "https://facebook.com/...",
      "telegram": "https://t.me/...",
      "tongsophong": 5,
      "tongsotang": 10,
      "hoahong": 1,
      "thangdatcoc": 1,
      "thangtratruoc": 3,
      "hopdong": "1 năm"
  }'
  ```
- **Phản hồi thành công (201):**
  ```json
  {
      "status": "success",
      "message": "Post created successfully",
      "data": { ... } // Đối tượng bài đăng đã được tạo
  }
  ```

### 2. Lấy tất cả bài đăng

- **Endpoint:** `/baidang`
- **Phương thức:** `GET`
- **Mô tả:** Lấy danh sách tất cả các bài đăng.
- **Phản hồi thành công (200):**
  ```json
  {
      "status": "success",
      "data": [ ... ] // Mảng các đối tượng bài đăng
  }
  ```

### 3. Lấy một bài đăng

- **Endpoint:** `/baidang/{id}`
- **Phương thức:** `GET`
- **Mô tả:** Lấy một bài đăng cụ thể bằng ID của nó.
- **Phản hồi thành công (200):**
  ```json
  {
      "status": "success",
      "data": { ... } // Đối tượng bài đăng
  }
  ```

---

## Tải lên tập tin

### 1. Tải lên hình ảnh

- **Endpoint:** `/upload/images`
- **Phương thức:** `POST`
- **Mô tả:** Tải lên một hoặc nhiều hình ảnh và trả về đường dẫn trên máy chủ. Đây là một yêu cầu `multipart/form-data`.
- **Ví dụ cURL:**
  ```bash
  curl -X POST http://your-app-url/api/upload/images \
  -H "Content-Type: multipart/form-data" \
  -F "images[]=@/path/to/your/image1.jpg" \
  -F "images[]=@/path/to/your/image2.png" \
  -F "type=baidang"
  ```
- **Phản hồi thành công (201):**
  ```json
  {
      "status": "success",
      "message": "Images uploaded successfully",
      "data": {
          "images": [
              "/temp/images/baidang/upload-....jpg"
          ]
      }
  }
  ```

### 2. Tải lên video

- **Endpoint:** `/upload/videos`
- **Phương thức:** `POST`
- **Mô tả:** Tải lên một hoặc nhiều video và trả về đường dẫn trên máy chủ. Đây là một yêu cầu `multipart/form-data`.
- **Ví dụ cURL:**
  ```bash
  curl -X POST http://your-app-url/api/upload/videos \
  -H "Content-Type: multipart/form-data" \
  -F "videos[]=@/path/to/your/video1.mp4"
  ```
- **Phản hồi thành công (201):**
  ```json
  {
      "status": "success",
      "message": "Videos uploaded successfully",
      "data": {
          "videos": [
              "/temp/videos/upload-....mp4"
          ]
      }
  }
  ```

---

## Tin đăng nhanh

- **Endpoint:** `/quickpost`
- **Phương thức:** `POST`
- **Mô tả:** Tạo một "tin đăng nhanh" đơn giản.
- **Ví dụ cURL:**
  ```bash
  curl -X POST http://your-app-url/api/quickpost \
  -H "Content-Type: application/json" \
  -d '{
      "name": "Jane Doe",
      "title": "Quick post title",
      "phone": "0123456789",
      "description": "A short description.",
      "image_urls": ["/temp/images/baidang/image.jpg"]
  }'
  ```
- **Phản hồi thành công (201):**
  ```json
  {
    "status": "success",
    "message": "Quick post created successfully",
    "data": { ... }
  }
  ```

---

## Dữ liệu vị trí & Bất động sản

### 1. Lấy danh sách tỉnh/thành

- **Endpoint:** `/locations/provinces`
- **Phương thức:** `GET`

### 2. Lấy danh sách quận/huyện

- **Endpoint:** `/locations/districts/{provinceId}`
- **Phương thức:** `GET`

### 3. Lấy danh sách phường/xã

- **Endpoint:** `/locations/wards/{districtId}`
- **Phương thức:** `GET`

### 4. Lấy loại nhà đất

- **Endpoint:** `/loainhadat`
- **Phương thức:** `GET`

### 5. Lấy danh sách tiện ích

- **Endpoint:** `/thietbi`
- **Phương thức:** `GET` 