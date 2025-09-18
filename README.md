# ðŸ“š Library Management API (Laravel 12)

Backend API untuk sistem manajemen perpustakaan sederhana.  
Dibuat menggunakan **Laravel 12**, **Sanctum**, **MySQL**, dan sudah dilengkapi dengan **Swagger Docs** + **Unit Test**.

---

## âš¡ Features
- ðŸ” **Authentication**
  - Register, Login, Logout (JWT-like via Sanctum)
- ðŸ“– **Books**
  - CRUD buku + pagination & filtering (search, author, year)
- ðŸ“‘ **Loans**
  - Pinjam buku (stok berkurang)
  - Tidak bisa pinjam jika stok 0
  - List pinjaman user
- ðŸ›  **Bonus**
  - Swagger API docs
  - Response helper (standard JSON)
  - Clean Architecture (Service, Request, Resource, Controller)
  - Unit Test (PHPUnit)

---

## ðŸ—ï¸ Installation

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

## ðŸš€ Running the Server
```bash
php artisan serve
```
Akses API di:
```
http://127.0.0.1:8000/api
```

---

## ðŸ”‘ API Endpoints

### Auth
- `POST /api/register`
- `POST /api/login`
- `POST /api/logout`

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

## ðŸ“– API Documentation (Swagger)

Generate docs:
```bash
php artisan l5-swagger:generate
```

Akses Swagger UI:
```
http://127.0.0.1:8000/api/documentation
```

---

## ðŸ§ª Testing

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

## ðŸ›  Tech Stack
- Laravel 12 (PHP 8.2+)
- Sanctum (Auth)
- MySQL (DB)
- PHPUnit (Testing)
- L5-Swagger (Docs)

---

## ðŸ‘¨â€ðŸ’» Author
Dikerjakan sebagai **Backend Developer Technical Test** menggunakan Laravel best practices.
