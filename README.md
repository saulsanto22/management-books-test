# 📚 Library Management API (Laravel 12)

Backend API untuk sistem manajemen perpustakaan sederhana.  
Dibuat menggunakan **Laravel 12**, **Sanctum**, **MySQL**, dan sudah dilengkapi dengan **Swagger Docs** + **Unit Test**.

---

## ⚡ Features
- 🔐 **Authentication**
  - Register, Login, Logout (JWT-like via Sanctum)
- 📖 **Books**
  - CRUD buku + pagination & filtering (search, author, year)
- 📖 **Loans**
  - Pinjam buku (stok berkurang)
  - Tidak bisa pinjam jika stok 0
  - List pinjaman user
- **Bonus**
  - Swagger API docs
  - Response helper (standard JSON)
  - Clean Architecture (Service, Request, Resource, Controller)
  - Unit Test (PHPUnit)

---

## 🏗 Installation

### 1. Clone Repository
```bash
git clone <your-repo-url>
cd management-books
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Copy Environment
```bash
cp .env.example .env
```

### 4. Generate Key
```bash
php artisan key:generate
```

### 5. Configure Database
Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_db
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Migrate & Seed
```bash
php artisan migrate --seed
```

---

🔑 Otentikasi & Role

Aplikasi ini menggunakan Sanctum. Terdapat 2 role:

Admin → dapat membuat, mengedit, dan menghapus buku.

User → hanya bisa meminjam dan melihat buku.

Seeder Awal

Saat menjalankan php artisan migrate --seed, akun berikut otomatis dibuat:
10 User dan 30 Buku dan,
1 Admin

{
  "email": "admin@example.com",
  "password": "password"
}


## Running the Server
```bash
php artisan serve
```
Akses API di:
```
http://127.0.0.1:8000/api
```

---

## API Endpoints

### Auth
- `POST /api/auth/register`
- `POST /api/auth/ogin`
- `POST /api/auth/gout`

### Books
- `GET /api/books`
- `GET /api/books/{id}`
- `POST /api/books`
- `PUT /api/books/{id}`
- `DELETE /api/books/{id}`

### Loans
- `POST /api/loans`
- `GET /api/loans`

---

##  API Documentation (Swagger)

Generate docs:
```bash
php artisan l5-swagger:generate
```

Akses Swagger UI:
```
http://127.0.0.1:8000/api/documentation
```

---

## 🧪 Testing

Jalankan unit test:
```bash
php artisan test
```

Filter per modul:
```bash
php artisan test --filter=AuthTest
php artisan test --filter=BookTest
php artisan test --filter=LoanTest
```

---
## 🛠 Tech Stack
-  ⚡ Laravel 12 (PHP 8.2+)

-  🔐 Sanctum (Auth)

-  🗄  MySQL (DB)

-  ✅ PHPUnit (Testing)

-  📜 L5-Swagger (Docs)

---

 ## 👨‍💻 Author
Dikerjakan sebagai **Backend Developer Technical Test** menggunakan Laravel best practices.
