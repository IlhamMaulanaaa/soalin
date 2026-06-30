# SOALin — Dokumentasi Sistem

Aplikasi web generate soal otomatis berbasis AI (Groq API) menggunakan CodeIgniter 4.

---

## 1. Arsitektur

```
Tech Stack: PHP 8.2+ / CodeIgniter 4.7 / MySQL / Groq API (Llama 3.3 70B)
Template Admin: NiceAdmin (Bootstrap 5.2 + CDN)
```

### Struktur Direktori (app/)

```
app/
├── Config/
│   ├── App.php          → baseURL auto-detect dari request
│   ├── Routes.php       → semua routing
│   └── Filters.php      → config filter (admin nanti)
├── Controllers/
│   ├── AuthController     → login / register / logout
│   ├── Home               → landing page + dashboard user
│   ├── GenerateSoal       → wizard generate soal via AI
│   ├── BankSoal           → CRUD bank soal (per user)
│   ├── Pengaturan         → profil, sandi, preferensi, API key
│   └── BaseController     → class dasar
├── Models/
│   ├── UserModel          → users
│   ├── SoalModel          → soal (bank soal)
│   └── ApiKeyModel        → api_keys (Groq API key)
├── Views/
│   ├── layout.php         → template utama (sidebar + header + footer)
│   ├── landing.php        → halaman depan (guest)
│   ├── v_home.php         → dashboard user
│   ├── generate_soal.php  → wizard 3 langkah
│   ├── bank_soal.php      → daftar bank soal user
│   ├── bank_soal_detail.php → detail soal tersimpan
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   ├── pengaturan/
│   │   ├── profil.php, sandi.php, preferensi.php
│   │   ├── tampilan.php, api_key.php
│   │   └── layout_pengaturan.php
│   └── components/
│       ├── header.php
│       ├── sidebar.php
│       └── footer.php
├── Database/Migrations/
│   ├── 2026-04-26-122423_Users.php
│   ├── 2026-05-25-000001_CreateApiKeysTable.php
│   └── 2026-06-30-000001_CreateSoalTable.php
└── Filters/ (akan dibuat)
    └── AdminFilter.php    → filter role admin
```

### Database

```sql
-- users
id INT PK AUTO_INCREMENT
name VARCHAR(50)
email VARCHAR(50) UNIQUE
password VARCHAR(255)
role VARCHAR(20) DEFAULT 'user'       -- 'user' | 'admin'
created_at DATETIME
updated_at DATETIME

-- api_keys
id INT PK AUTO_INCREMENT
key_name VARCHAR(100)
api_key TEXT
created_at DATETIME
updated_at DATETIME

-- soal
id INT PK AUTO_INCREMENT
user_id INT FK → users.id
mapel VARCHAR(100)
jenjang VARCHAR(50)
jumlah_soal INT
kesulitan VARCHAR(50)
tipe_soal VARCHAR(50)
soal_text LONGTEXT
created_at DATETIME
updated_at DATETIME
```

---

## 2. Role & Hak Akses

| Fitur | Guest | User | Admin |
|-------|-------|------|-------|
| Landing page | ✅ | — | — |
| Register | ✅ | — | — |
| Login | ✅ | — | — |
| Dashboard user | — | ✅ | ✅ |
| Generate Soal (AI) | — | ✅ | ✅ |
| Bank Soal (milik sendiri) | — | ✅ | ✅ |
| Pengaturan (profil/sandi/pref/api) | — | ✅ | ✅ |
| Kelola semua user | — | — | ✅ |
| Lihat semua bank soal | — | — | ✅ |
| Hapus user/soal lain | — | — | ✅ |

---

## 3. Routes

### Guest & Auth

| Method | URL | Controller | Keterangan |
|--------|-----|------------|------------|
| GET | `/` | `Home::index` | Landing page (guest) |
| GET | `/login` | `AuthController::index` | Form login |
| POST | `/login` | `AuthController::login` | Proses login |
| GET | `/register` | `AuthController::register` | Form register |
| POST | `/register` | `AuthController::registerProcess` | Proses register |
| GET | `/logout` | `AuthController::logout` | Logout + destroy session |

### User (harus login)

| Method | URL | Controller | Keterangan |
|--------|-----|------------|------------|
| GET | `/home` | `Home::dashboard` | Dashboard user |
| GET | `/generate-soal` | `GenerateSoal::index` | Wizard step 1-2 |
| POST | `/generate-soal/process` | `GenerateSoal::process` | Panggil Groq API |
| GET | `/bank-soal` | `BankSoal::index` | Daftar bank soal (milik sendiri) |
| POST | `/bank-soal/simpan` | `BankSoal::simpan` | Simpan hasil generate (AJAX) |
| GET | `/bank-soal/detail/(:num)` | `BankSoal::detail` | Detail soal |
| POST | `/bank-soal/hapus/(:num)` | `BankSoal::hapus` | Hapus soal sendiri |
| GET | `/pengaturan` | `Pengaturan::index` | Redirect ke profil |
| GET | `/pengaturan/profil` | `Pengaturan::profil` | Edit profil |
| POST | `/pengaturan/profil` | `Pengaturan::profilUpdate` | Simpan profil |
| GET | `/pengaturan/sandi` | `Pengaturan::sandi` | Ganti password |
| POST | `/pengaturan/sandi` | `Pengaturan::sandiUpdate` | Simpan password |
| GET | `/pengaturan/preferensi` | `Pengaturan::preferensi` | Preferensi default soal |
| POST | `/pengaturan/preferensi` | `Pengaturan::preferensiUpdate` | Simpan preferensi |
| GET | `/pengaturan/tampilan` | `Pengaturan::tampilan` | Pengaturan tampilan |
| GET | `/pengaturan/api-key` | `Pengaturan::apiKey` | Kelola API key Groq |
| POST | `/pengaturan/api-key/store` | `Pengaturan::apiKeyStore` | Tambah API key |
| GET | `/pengaturan/api-key/edit/(:num)` | `Pengaturan::apiKeyEdit` | Form edit API key |
| POST | `/pengaturan/api-key/update/(:num)` | `Pengaturan::apiKeyUpdate` | Simpan edit API key |
| POST | `/pengaturan/api-key/delete/(:num)` | `Pengaturan::apiKeyDelete` | Hapus API key |

### Admin (hanya role = admin)

| Method | URL | Controller | Keterangan |
|--------|-----|------------|------------|
| GET | `/admin/dashboard` | `Admin::dashboard` | Dashboard admin (statistik) |
| GET | `/admin/users` | `Admin::users` | Daftar semua user |
| POST | `/admin/users/hapus/(:num)` | `Admin::hapusUser` | Hapus user + soal-nya |
| GET | `/admin/bank-soal` | `Admin::bankSoal` | Semua bank soal (seluruh user) |
| GET | `/admin/bank-soal/detail/(:num)` | `Admin::bankSoalDetail` | Detail soal milik siapapun |
| POST | `/admin/bank-soal/hapus/(:num)` | `Admin::hapusSoal` | Hapus soal milik siapapun |

Semua route `/admin/*` diproteksi oleh `AdminFilter`.

---

## 4. Auth Flow

```
Register                           Login
  │                                  │
  v                                  v
UserModel::insert                  UserModel::where(email)
role = 'user' (default)            password_verify()
  │                                  │
  v                                  v
redirect /login                  session set:
                                   logged_in = true
                                   user_id, email, nama, role
                                      │
                                      v
                              role = 'admin'? ──yes──→ /admin/dashboard
                                      │ no
                                      v
                                   /home
```

### Session Data

```php
$_SESSION['logged_in'] = true
$_SESSION['user_id']   = 1
$_SESSION['email']     = 'user@mail.com'
$_SESSION['nama']      = 'Nama User'
$_SESSION['role']      = 'user' | 'admin'
```

---

## 5. Generate Soal Flow

```
Step 1: Upload Materi
  ├── Upload file (PDF/DOC/DOCX/TXT) → baca teks
  └── Atau ketik manual
        │
        v
Step 2: Parameter Soal
  ├── Mata Pelajaran
  ├── Jenjang (SD/SMP/SMA/PT)
  ├── Jumlah Soal (1-20, dibatasi)
  ├── Tingkat Kesulitan (Mudah/Sedang/Sulit/Campuran)
  └── Tipe Soal (PG/Essay/BenarSalah/Campuran)
        │
        v
Step 3: AI Generate (Groq API)
  ├── Prompt dinamis sesuai tipe soal
  ├── Materi dipotong max 12.000 char
  ├── JSON payload dengan JSON_INVALID_UTF8_SUBSTITUTE
  └── max_tokens = 4096
        │
        v
  Hasil ditampilkan → bisa "Simpan ke Bank Soal"
```

### Prompt Template (per tipe)

- **Pilihan Ganda**: format `1. [Soal] \n A. ... B. ... C. ... D. ... \n Jawaban: [huruf]`
- **Essay**: format `1. [Soal] \n Jawaban: ...`
- **Benar/Salah**: format `1. [Pernyataan] \n Jawaban: Benar/Salah`
- **Campuran**: kombinasi ketiganya

---

## 6. Bank Soal Flow

```
User: Generate Soal → Hasil → Klik "Simpan ke Bank Soal"
                                    │
                                    v
                              AJAX POST /bank-soal/simpan
                              { mapel, jenjang, jumlah_soal,
                                kesulitan, tipe_soal, soal_text }
                                    │
                                    v
                              SoalModel::insert()
                                    │
                                    v
                              Response JSON { status: 'success' }
                                    │
                                    v
                              Tombol berubah "Tersimpan di Bank Soal!"

User: Navigasi ke Bank Soal
         │
         v
   GET /bank-soal
   SoalModel::getByUser(user_id)
         │
         v
   Tampil kartu-kartu bank soal milik user
   ├── Lihat detail → GET /bank-soal/detail/(:num)
   └── Hapus → POST /bank-soal/hapus/(:num)
```

---

## 7. Admin Flow

```
Admin Login
    │
    v
Redirect ke /admin/dashboard
    │
    ├── Statistik: total user, total soal
    │
    ├── /admin/users
    │   ├── Tabel semua user (nama, email, role, tgl daftar)
    │   └── Tombol hapus user
    │
    └── /admin/bank-soal
        ├── Tabel semua bank soal (mapel, jenjang, pembuat, jumlah, tgl)
        ├── Lihat detail → /admin/bank-soal/detail/(:num)
        └── Hapus → POST /admin/bank-soal/hapus/(:num)
```

### Filter Admin

```php
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/home')
                ->with('error', 'Akses hanya untuk admin!');
        }
    }
}
```

---

## 8. Environment Config

File `.env` (tidak ikut git, lihat `.env.example`):

```ini
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = team
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306

GROQ_API_KEY = "gsk_xxxxxxxxxxxx"
```

Base URL auto-detect dari `$_SERVER['HTTP_HOST']` di `App.php`.

---

## 9. Cara Install

```bash
# 1. Clone
git clone https://github.com/IlhamMaulanaaa/soalin.git
cd soalin

# 2. Install dependency PHP
composer install

# 3. Copy env & sesuaikan
cp .env.example .env
# edit .env: database, GROQ_API_KEY

# 4. Migrasi database
php spark migrate

# 5. Seed admin (manual atau via seeder nanti)
# Contoh: INSERT INTO users (name, email, password, role)
# VALUES ('Admin', 'admin@soalin.com',
#   '$2y$10$...', 'admin');
# (password_hash('admin123', PASSWORD_DEFAULT))

# 6. Jalankan
php spark serve
# atau arahkan web server ke folder public/
```

---

## 10. Catatan Teknis

| Aspek | Detail |
|-------|--------|
| Framework | CodeIgniter 4.7 |
| PHP min | 8.2 |
| Database | MySQL / MariaDB |
| AI Model | Groq Llama 3.3 70B (via API) |
| UI Template | NiceAdmin (Bootstrap 5.2) |
| Assets vendor | CDN (bootstrap, icons, charts) |
| File upload | PDF/DOC/DOCX/TXT max 10MB |
| Token limit | Input ~12rb char, output 4096 token |

---
