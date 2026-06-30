# SOALin — Dokumentasi Sistem

Aplikasi web generate soal otomatis berbasis AI untuk platform sekolah.
**Kepala Sekolah** sebagai **Admin** — **Guru** sebagai **User**.

---

## 1. Analogi Platform Sekolah

```
            ┌─────────────────────────────────────┐
            │         SOALin - Platform Sekolah     │
            │                                      │
            │  ┌─────────────┐   ┌──────────────┐  │
            │  │  KEPSEK     │   │    GURU       │  │
            │  │  (Admin)    │   │   (User)      │  │
            │  ├─────────────┤   ├──────────────┤  │
            │  │ Melihat     │   │ Generate Soal │  │
            │  │ semua guru  │   │ via AI        │  │
            │  │ & soal      │   │               │  │
            │  │─────────────│   │ Simpan ke     │  │
            │  │ Mengelola   │   │ Bank Soal     │  │
            │  │ akun guru   │   │ pribadi       │  │
            │  └─────────────┘   └──────────────┘  │
            └─────────────────────────────────────┘
```

---

## 2. Siapa Saja Penggunanya?

| Peran | Di Sistem | Bisa Apa? |
|-------|-----------|-----------|
| **Pengunjung** | Guest | Lihat landing page, daftar akun |
| **Guru** | User (role: `user`) | Generate soal AI, simpan bank soal, atur profil |
| **Kepala Sekolah** | Admin (role: `admin`) | Semua bisa Guru + kelola semua guru & soal |

---

## 3. Alur Guru (User Flow)

### 3.1. Pertama Kali (Registrasi)

```
Guru baru datang ke sekolah (website)
         │
         v
 Membuka halaman SOALin
         │
         v
 Klik "Daftar" → isi nama, email, password
         │
         v
 Admin secara otomatis memberikan kartu guru
 dengan role = 'user'
         │
         v
 Guru siap login dan mulai bekerja
```

### 3.2. Guru Mulai Bekerja (Login)

```
Guru masuk ruang guru (login)
         │
         v
 Lihat dashboard → ada ringkasan:
   - Total soal yang sudah dibuat
   - Jumlah bank soal
   - Tombol "Buat Soal Baru"
         │
         v
 Klik "Generate Soal"
```

### 3.3. Guru Membuat Soal (Generate Soal AI)

```
LANGKAH 1 — Upload Materi
  Guru upload file pelajaran (PDF/DOC/TXT)
  atau ketik materi langsung
         │
         v
LANGKAH 2 — Atur Soal
  Guru pilih:
  ├── Mata Pelajaran (Matematika, IPA, dll)
  ├── Jenjang Kelas (SD/SMP/SMA)
  ├── Jumlah Soal (maks 20)
  ├── Tingkat Kesulitan (Mudah/Sedang/Sulit)
  └── Tipe Soal (Pilihan Ganda/Essay/Benar-Salah/Campuran)
         │
         v
LANGKAH 3 — AI Bekerja
  Soal langsung dibuat oleh AI (Groq)
  Guru lihat hasilnya di layar
         │
         v
 Guru bisa:
   ├── ❌ Hapus & ulang
   ├── 🖨 Cetak langsung
   └── ✅ Simpan ke Bank Soal pribadi
```

### 3.4. Guru Menyimpan Soal

```
Setelah soal jadi, guru klik "Simpan ke Bank Soal"
         │
         v
 Soal tersimpan di Bank Soal pribadi milik guru itu sendiri
         │
         v
 Guru bisa buka kapan saja:
   ├── /bank-soal       → Lihat daftar semua soal yang pernah dibuat
   ├── /bank-soal/detail/1 → Lihat isi soal lengkap
   └── Hapus soal yang tidak dipakai lagi
```

### 3.5. Guru Mengatur Profil

```
Guru bisa ubah:
   ├── /pengaturan/profil      → Ganti nama & email
   ├── /pengaturan/sandi       → Ganti password
   ├── /pengaturan/preferensi  → Atur default soal (biar每次 tidak isi ulang)
   ├── /pengaturan/tampilan    → Atur tema tampilan
   └── /pengaturan/api-key     → Input API key Groq (koneksi AI)
```

---

## 4. Alur Kepala Sekolah (Admin Flow)

### 4.1. Kepsek Masuk

```
Kepala Sekolah login dengan akun khusus (role = admin)
         │
         v
 Langsung diarahkan ke Dashboard Admin
 (bukan dashboard guru biasa)
```

### 4.2. Dashboard Admin

```
         ┌──────────────────────────────────┐
         │     DASHBOARD KEPALA SEKOLAH      │
         ├──────────────────────────────────┤
         │  📊 Total Guru Terdaftar: 25     │
         │  📚 Total Soal Dibuat: 1.247     │
         │  🏫 Rata-rata Soal/Guru: 50     │
         └──────────────────────────────────┘
         │
         v
 Dari sini Kepsek bisa pantau aktivitas sekolah
```

### 4.3. Kelola Guru

```
Kepala Sekolah buka menu /admin/users
         │
         v
 Lihat daftar semua guru:
   ┌──────┬────────────┬──────────┬──────────────┐
   │ Nama │   Email    │  Role    │  Tgl Daftar  │
   ├──────┼────────────┼──────────┼──────────────┤
   │ Bu Ani│ ani@sch.id│ user     │ 12 Jun 2026  │
   │ Pak Budi│ budi@...│ user     │ 10 Jun 2026  │
   │ ...   │            │          │              │
   └──────┴────────────┴──────────┴──────────────┘
         │
         v
 Kepsek bisa hapus guru yang sudah pindah/tidak aktif
 (semua soal guru itu juga ikut terhapus)
```

### 4.4. Pantau Bank Soal Semua Guru

```
Kepala Sekolah buka menu /admin/bank-soal
         │
         v
 Lihat daftar semua soal dari seluruh guru:
   ┌──────────┬──────────┬──────────┬──────────┐
   │ Mapel    │ Pembuat  │ Jumlah   │ Tanggal  │
   ├──────────┼──────────┼──────────┼──────────┤
   │ Matematika│ Bu Ani  │ 20 soal  │ 28 Jun   │
   │ IPA      │ Pak Budi│ 15 soal  │ 27 Jun   │
   │ ...      │          │          │          │
   └──────────┴──────────┴──────────┴──────────┘
         │
         v
 Kepsek bisa:
   ├── Lihat detail soal siapa pun
   └── Hapus soal yang tidak sesuai
```

### 4.5. Ringkasan Kewenangan Kepsek vs Guru

| Aktivitas | Guru | Kepala Sekolah |
|-----------|------|----------------|
| Generate soal AI | ✅ | ✅ |
| Simpan bank soal sendiri | ✅ | ✅ |
| Lihat bank soal sendiri | ✅ | ✅ |
| Hapus soal sendiri | ✅ | ✅ |
| Atur profil sendiri | ✅ | ✅ |
| Lihat semua guru | — | ✅ |
| Hapus akun guru | — | ✅ |
| Lihat bank soal guru lain | — | ✅ |
| Hapus soal guru lain | — | ✅ |
| Lihat statistik sekolah | — | ✅ |

---

## 5. Teknis Singkat

```
Tech Stack: PHP 8.2, CodeIgniter 4.7, MySQL, Groq AI
Template:   NiceAdmin (Bootstrap 5.2 via CDN)
Database:   users, api_keys, soal
```

### Struktur Database

```
users
├── id, name, email, password
├── role (user / admin)
└── created_at, updated_at

api_keys → menyimpan API key Groq
├── id, key_name, api_key
└── created_at, updated_at

soal → bank soal tiap guru
├── id, user_id (FK ke users)
├── mapel, jenjang, jumlah_soal
├── kesulitan, tipe_soal, soal_text
└── created_at, updated_at
```

### Proteksi Halaman Admin

Semua halaman admin dilindungi filter. Jika guru biasa coba akses `/admin/*`, akan dialihkan ke dashboard guru sendiri.

---

## 6. Cara Install

```bash
# 1. Clone dari GitHub
git clone https://github.com/IlhamMaulanaaa/soalin.git
cd soalin

# 2. Install dependensi PHP
composer install

# 3. Copy file env
cp .env.example .env
# lalu edit isinya: database, GROQ_API_KEY

# 4. Jalankan migrasi database
php spark migrate

# 5. Buat akun Kepala Sekolah (admin)
# Lewat MySQL:
# INSERT INTO users (name, email, password, role)
# VALUES ('Kepala Sekolah', 'kepsek@soalin.com',
#   '$2y$10$hash_password_here', 'admin');

# 6. Jalankan aplikasi
php spark serve
# Buka http://localhost:8080
```

### Catatan

| Aspek | Detail |
|-------|--------|
| Minimal PHP | 8.2 |
| Database | MySQL / MariaDB |
| AI Model | Groq Llama 3.3 70B |
| Upload file | PDF/DOC/DOCX/TXT max 10 MB |
| CSS/JS | Pakai CDN (tak perlu vendor folder) |
| Base URL | Auto-detect (cocok di server mana pun) |

---
