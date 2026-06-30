# PANDUAN PROYEK SOALin — UAS

## 📁 Struktur Folder Inti (MVC)

```
app/
├── Controllers/     ← logika / otak aplikasi
├── Models/          ← komunikasi ke database
├── Views/           ← tampilan HTML
├── Config/          ← routing, filter, dll
├── Database/
│   └── Migrations/  ← struktur tabel database
├── Filters/         ← middleware (penjaga akses)
└── ...
```

### Penjelasan MVC:
- **Route** → menerima request URL → panggil **Controller** method
- **Controller** → ambil data dari **Model**, kirim ke **View**
- **Model** → query database
- **View** → render HTML + CSS + JavaScript

---

## 🌐 ROUTES (app/Config/Routes.php)

Semua rute aplikasi. Buka file ini dulu kalau ditanya "URL ini panggil controller mana?"

| URL | Method | Controller::Method | Keterangan |
|---|---|---|---|
| `/` | GET | `Home::index` | Landing page |
| `/home` | GET | `Home::dashboard` | Dashboard user |
| `/login` | GET | `AuthController::index` | Form login |
| `/login` | POST | `AuthController::login` | Proses login |
| `/register` | GET | `AuthController::register` | Form register |
| `/register` | POST | `AuthController::registerProcess` | Proses register |
| `/logout` | GET | `AuthController::logout` | Hapus session |
| `/generate-soal` | GET | `GenerateSoal::index` | Form wizard |
| `/generate-soal/process` | POST | `GenerateSoal::process` | Generate pake AI |
| `/bank-soal` | GET | `BankSoal::index` | Lihat bank soal saya |
| `/bank-soal/simpan` | POST | `BankSoal::simpan` | Simpan soal (AJAX) |
| `/bank-soal/detail/(:num)` | GET | `BankSoal::detail/$1` | Detail soal |
| `/bank-soal/hapus/(:num)` | POST | `BankSoal::hapus/$1` | Hapus soal (AJAX) |
| `/pengaturan/profil` | GET | `Pengaturan::profil` | Edit profil |
| `/pengaturan/profil` | POST | `Pengaturan::profilUpdate` | Simpan profil |
| `/pengaturan/sandi` | GET | `Pengaturan::sandi` | Ganti password |
| `/pengaturan/sandi` | POST | `Pengaturan::sandiUpdate` | Simpan password |
| `/admin/dashboard` | GET | `AdminController::dashboard` | Dashboard admin |
| `/admin/users` | GET | `AdminController::users` | Kelola guru |
| `/admin/users/hapus/(:num)` | POST | `AdminController::hapusUser/$1` | Hapus user |
| `/admin/bank-soal` | GET | `AdminController::bankSoal` | Semua bank soal |
| `/admin/bank-soal/detail/(:num)` | GET | `AdminController::bankSoalDetail/$1` | Detail (admin) |
| `/admin/bank-soal/hapus/(:num)` | POST | `AdminController::hapusSoal/$1` | Hapus soal (admin) |

> **PENTING:** Route group `admin` pakai filter `'admin'` → cek session role harus `admin`.

---

## 🔐 FILTER (app/Filters/AdminFilter.php)

File: `app/Filters/AdminFilter.php`

Method `before()`:
1. Cek apakah `session('logged_in')` = true? Kalau tidak → redirect `/login`
2. Cek apakah `session('role')` = `'admin'`? Kalau bukan → redirect `/home` + error "Akses hanya untuk Kepala Sekolah (Admin)!"

Daftarkan di `app/Config/Filters.php`:
```php
'admin' => \App\Filters\AdminFilter::class,
```

Lalu dipasang di route group: `['filter' => 'admin']`

---

## 🗄️ DATABASE (dari Migrations)

### Tabel: `users`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT(11) UNSIGNED | Primary Key, Auto Increment |
| `name` | VARCHAR(50) | Nama user |
| `nama` | VARCHAR(100) | Sama kayak name (nullable, added by migration #4) |
| `email` | VARCHAR(50) | Unique, buat login |
| `password` | VARCHAR(255) | Hash (bcrypt) |
| `role` | VARCHAR(20) | `'user'` atau `'admin'` (default: `'user'`) |
| `created_at` | DATETIME | |
| `updated_at` | DATETIME | |

### Tabel: `soal`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT(11) UNSIGNED | Primary Key, Auto Increment |
| `user_id` | INT(11) UNSIGNED | Foreign Key ke `users.id` (ON DELETE CASCADE) |
| `mapel` | VARCHAR(100) | Mata pelajaran |
| `jenjang` | VARCHAR(50) | SD / SMP / SMA / PT |
| `jumlah_soal` | INT(11) | Jumlah soal yang digenerate |
| `kesulitan` | VARCHAR(50) | Mudah / Sedang / Sulit / Campuran |
| `tipe_soal` | VARCHAR(50) | Pilihan Ganda / Essay / Benar/Salah / Campuran |
| `soal_text` | LONGTEXT | Hasil generate AI (isi soal mentah) |
| `created_at` | DATETIME | |
| `updated_at` | DATETIME | |

### Relasi
- **One-to-Many:** 1 user → banyak soal
- **CASCADE:** Kalau user dihapus, semua soal-nya ikut terhapus

### Migration Files
```
2026-04-26-122423_Users.php           → bikin tabel users
2026-06-30-000001_CreateSoalTable.php → bikin tabel soal (plus foreign key)
2026-06-30-000002_AddRoleToUsers.php  → tambah kolom role di users
2026-06-30-000003_AddNamaToUsers.php  → tambah kolom nama di users
```

---

## 👤 FLOW LOGIN / REGISTER

### Register

**File:** `app/Controllers/AuthController.php` method `registerProcess()`

1. User isi form di `app/Views/auth/register.php`
2. Submit POST `/register`
3. Controller cek email udah ada? Kalau ada → error
4. Hash password pake `password_hash()`
5. Insert ke tabel `users` dengan `role = 'user'`
6. Redirect ke `/login` + flashdata success

### Login

**File:** `app/Controllers/AuthController.php` method `login()`

1. User isi email + password di `app/Views/auth/login.php`
2. Submit POST `/login`
3. Controller cari user by email di database
4. Verifikasi password pake `password_verify()`
5. Kalau cocok → set session:
```php
[
  'logged_in' => true,
  'email'     => ...,
  'nama'      => ...,
  'user_id'   => ...,
  'role'      => 'user' // atau 'admin'
]
```
6. Kalau role = `admin` → redirect `/admin/dashboard`
7. Kalau role = `user` → redirect `/home`
8. Kalau password salah → redirect `/login` + error

### Logout

**File:** `app/Controllers/AuthController.php` method `logout()`

1. `session()->destroy()`
2. Redirect `/login`

---

## 🤖 FLOW GENERATE SOAL

### Controller: `app/Controllers/GenerateSoal.php`

### index() → GET /generate-soal
- Cuma nampilin halaman wizard dengan `soal_result = null`

### process() → POST /generate-soal/process
Langkah-langkah:

1. **Ambil data formulir:** `mapel`, `jenjang`, `jumlah_soal`, `kesulitan`, `tipe_soal`
2. **Ambil konten file** (kalau ada upload):
   - TXT: `file_get_contents()` langsung
   - PDF: pake `shell_exec('pdftotext ...')` kalau ada, fallback baca raw binary + cleanup regex
   - DOCX: pake `ZipArchive` ekstrak `word/document.xml`, stripping XML tag
   - Lainnya: baca raw + cleanup karakter aneh
3. **Fallback** ke text dari textarea `materi` kalau gak ada file
4. **Truncate** ke 12.000 karakter max
5. **Bikin prompt AI** → formatnya beda tergantung tipe soal:
   - Pilihan Ganda → minta format: `1. Pertanyaan\n   A. ...\n   B. ...\n   C. ...\n   D. ...\n   Jawaban: ...`
   - Essay → Pertanyaan + Jawaban
   - Benar/Salah → Pernyataan + Jawaban: Benar/Salah
   - Campuran → campur semua tipe
6. **Panggil Groq API** (model `llama-3.3-70b-versatile`) dengan API key dari `env('GROQ_API_KEY')`
7. **Kirim result** ke view `generate_soal.php` → JavaScript auto-render di Step 3

### View: `app/Views/generate_soal.php`

Wizard 3 langkah (client-side JavaScript):
- **Step 1:** Upload file / ketik materi
- **Step 2:** Parameter soal (mapel, jenjang, jumlah, kesulitan, tipe)
- **Step 3:** Hasil generate + tombol Simpan, Cetak, Buat Baru

**Hidden form** `#generateForm` dikirim pas klik "Generate Soal". JavaScript populate hidden inputs (file, materi, mapel, dll) lalu submit.

**Simpan ke Bank Soal:** AJAX POST ke `/bank-soal/simpan` dengan FormData:
- `soal_text`, `mapel`, `jenjang`, `jumlah_soal`, `kesulitan`, `tipe_soal`

---

## 📚 FLOW BANK SOAL

### Controller: `app/Controllers/BankSoal.php`

### index() → GET /bank-soal
- Panggil `SoalModel::getByUser(session('user_id'))`
- Tampilkan `app/Views/bank_soal.php`

### View: `app/Views/bank_soal.php`
- Cards grid tiap soal
- Search filter (client-side JavaScript)
- Fitur hapus langsung dari card (AJAX)
- Tombol "Buat Soal Baru" → link ke `/generate-soal`

### simpan() → POST /bank-soal/simpan
- AJAX endpoint
- Insert ke tabel `soal` + return JSON `{status, message, id}`

### detail($id) → GET /bank-soal/detail/(:num)
- Validasi kepemilikan (soal punya user yang login)
- Tampilkan `app/Views/bank_soal_detail.php`
- View-nya parsing `soal_text` → pisah per nomor soal, highlight jawaban

### hapus($id) → POST /bank-soal/hapus/(:num)
- AJAX endpoint
- Validasi kepemilikan
- Delete + return JSON

---

## 👑 FLOW ADMIN

### Controller: `app/Controllers/AdminController.php`

Semua route pake filter `admin` → harus login + role = `admin`.

- **dashboard()** → Statistik (total guru, total soal, soal hari ini, 5 guru terbaru)
- **users()** → Semua user (tabel), bisa hapus (kecuali diri sendiri)
- **bankSoal()** → Semua soal dari semua guru (JOIN dengan users)
- **bankSoalDetail($id)** → Detail soal + info pembuat
- **hapusSoal($id)** → Hapus soal (AJAX)

### Views:
- `app/Views/admin/dashboard.php` → Stat cards + tabel guru terbaru
- `app/Views/admin/users.php` → Tabel semua user
- `app/Views/admin/bank_soal.php` → Cards semua soal (dari semua guru)
- `app/Views/admin/bank_soal_detail.php` → Detail soal + nama/email pembuat

### Akun Admin Default
- **Email:** `admin@soalin.com`
- **Password:** `admin123`
- **Role:** `admin`
- Dibuat oleh `app/Database/Seeds/AdminSeeder.php`

---

## ⚙️ MODELS

### UserModel (`app/Models/UserModel.php`)
- Tabel: `users`
- Field: `name`, `nama`, `username`, `email`, `password`, `role`
- Gak ada custom method → pake bawaan CI4 aja (`find`, `insert`, `update`, `delete`, `where`, dll)

### SoalModel (`app/Models/SoalModel.php`)
- Tabel: `soal`
- Field: `user_id`, `mapel`, `jenjang`, `jumlah_soal`, `kesulitan`, `tipe_soal`, `soal_text`
- Custom method:
  - `getByUser($userId)` → SELECT * FROM soal WHERE user_id = ? ORDER BY created_at DESC
  - `getWithUser($id)` → SELECT soal.*, users.name FROM soal JOIN users ON users.id = soal.user_id WHERE soal.id = ?

---

## 🎨 VIEWS & LAYOUT

### Layout Utama: `app/Views/layout.php`
- Template NiceAdmin (Bootstrap 5)
- Include: header, sidebar, main content, footer
- Load CSS/JS: Bootstrap, Boxicons, Quill, Remixicon, ApexCharts, Chart.js, ECharts

### Sidebar: `app/Views/components/sidebar.php`
- Navigasi berdasarkan session `role`
- Menu Admin cuma muncul kalau `session('role') === 'admin'`
- Active link pake `uri_string()`

### Header: `app/Views/components/header.php`
- Logo, search bar, profil dropdown

Setiap view spesifik ada di folder masing-masing (lihat tabel routing di atas).

---

## 🔧 SKENARIO YANG SERING DITANYA DOSEN

### "Ganti arahkan ke halaman lain setelah login"

Edit di `AuthController.php` method `login()`:
```php
// Cari bagian:
if ($user['role'] === 'admin') {
    return redirect()->to('/admin/dashboard');
} else {
    return redirect()->to('/home');
}
// Ganti /home dengan URL lain
```

### "Tambah menu baru di sidebar"

Edit `app/Views/components/sidebar.php`:
```php
<li class="nav-item">
  <a class="nav-link" href="<?= base_url('url-baru') ?>">
    <i class="bi bi-icon"></i>
    <span>Nama Menu</span>
  </a>
</li>
```

### "Cegah user biasa akses halaman tertentu"

Bisa pake filter (cek role di `before()` method) atau langsung di controller:
```php
if (session()->get('role') !== 'admin') {
    return redirect()->to('/home');
}
```

### "Tambah kolom di database"
1. Bikin migration baru: `php spark make:migration NamaMigration`
2. Tulis `$this->forge->addColumn('nama_tabel', ['kolom' => ...])`
3. Jalankan: `php spark migrate`
4. Tambah field di `$allowedFields` model
5. Update view/controller untuk pakai kolom baru

### "Data tidak muncul di halaman"

Cek alurnya:
1. Route → method controller benar?
2. Controller ambil data dari model?
3. Model panggil database dengan benar?
4. Data dikirim ke view? (`return view('nama_view', ['key' => $data])`)
5. View pake `$key` dengan benar?

### "Halaman error 404"
1. Cek route di `Routes.php` → URL-nya bener?
2. Cek nama class controller dan method → case sensitive
3. Cek apakah route pake parameter `(:num)` atau `(:any)`?

---

## 📌 TIPS PRESENTASI

1. **Buka Routes.php dulu** kalau ditanya alur URL
2. **Tunjukkan struktur MVC**:
   - "Ini controllernya, ini modelnya, ini viewnya"
3. **Flow login**: tunjukin `AuthController::login()` → set session → redirect
4. **Bedanya user dan admin**: tunjukin kolom `role` di tabel users + `AdminFilter.php`
5. **Generate soal**: jelaskan wizard 3 langkah → API Groq → simpan
6. **Bank soal**: CRUD sederhana (Create via simpan, Read via index/detail, Delete via hapus)
7. **Foreign key CASCADE**: kalau hapus user, soal otomatis kehapus
