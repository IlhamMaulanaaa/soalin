<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
body{
    background:#f6f8fc;
}

/* Judul */
.page-title{
    font-size:28px;
    font-weight:700;
    color:#0d47a1;
    margin-bottom:8px;
}

.page-subtitle{
    color:#6c757d;
    margin-bottom:28px;
}

/* Card */
.setting-card{
    border:none;
    border-radius:18px;
    box-shadow:0 6px 18px rgba(0,0,0,0.06);
    background:#fff;
    margin-bottom:24px;
}

.setting-card .card-body{
    padding:24px;
}

.setting-title{
    font-size:18px;
    font-weight:700;
    color:#0d47a1;
    margin-bottom:20px;
}

.form-control,
.form-select{
    border-radius:12px;
    padding:10px 14px;
}

.form-control:focus,
.form-select:focus{
    box-shadow:none;
    border-color:#0d47a1;
}

.btn-save{
    background:#0d47a1;
    color:#fff;
    border:none;
    border-radius:12px;
    padding:10px 18px;
    font-weight:600;
}

.btn-save:hover{
    background:#08306b;
    color:#fff;
}

.profile-img{
    width:78px;
    height:78px;
    border-radius:50%;
    background:#e3f2fd;
    color:#0d47a1;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:32px;
    margin-bottom:18px;
}

.switch-area{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 0;
    border-bottom:1px solid #eef2f7;
}

.switch-area:last-child{
    border-bottom:none;
}
</style>

<div class="container-fluid">

    <!-- Judul -->
    <div class="mb-4">
        <div class="page-title">Pengaturan</div>
        <div class="page-subtitle">
            Kelola akun dan preferensi aplikasi Anda.
        </div>
    </div>

    <div class="row">

        <!-- KIRI -->
        <div class="col-lg-8">

            <!-- Profil -->
            <div class="card setting-card">
                <div class="card-body">

                    <div class="setting-title">
                        <i class="bi bi-person-circle me-2"></i>
                        Profil Pengguna
                    </div>

                    <div class="profile-img">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control" value="Pak Budi">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" value="pakbudi@gmail.com">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Sekolah</label>
                            <input type="text" class="form-control" value="SMA Negeri 1">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mata Pelajaran</label>
                            <input type="text" class="form-control" value="Matematika">
                        </div>

                        <div class="col-12 mt-3">
                            <button class="btn btn-save">
                                Simpan Profil
                            </button>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Preferensi -->
            <div class="card setting-card">
                <div class="card-body">

                    <div class="setting-title">
                        <i class="bi bi-sliders me-2"></i>
                        Preferensi Generate Soal
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenjang Default</label>
                            <select class="form-select">
                                <option>SMA</option>
                                <option>SMP</option>
                                <option>SD</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jumlah Soal</label>
                            <select class="form-select">
                                <option>10 Soal</option>
                                <option>20 Soal</option>
                                <option>30 Soal</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tingkat Kesulitan</label>
                            <select class="form-select">
                                <option>Sedang</option>
                                <option>Mudah</option>
                                <option>Sulit</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tipe Soal</label>
                            <select class="form-select">
                                <option>Pilihan Ganda</option>
                                <option>Essay</option>
                                <option>Benar / Salah</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <button class="btn btn-save">
                                Simpan Preferensi
                            </button>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        <!-- KANAN -->
        <div class="col-lg-4">

            <!-- Keamanan -->
            <div class="card setting-card">
                <div class="card-body">

                    <div class="setting-title">
                        <i class="bi bi-shield-lock me-2"></i>
                        Keamanan
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Lama</label>
                        <input type="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <input type="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konfirmasi Password</label>
                        <input type="password" class="form-control">
                    </div>

                    <button class="btn btn-save w-100">
                        Update Password
                    </button>

                </div>
            </div>

            <!-- Tampilan -->
            <div class="card setting-card">
                <div class="card-body">

                    <div class="setting-title">
                        <i class="bi bi-palette me-2"></i>
                        Tampilan
                    </div>

                    <div class="switch-area">
                        <span>Dark Mode</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox">
                        </div>
                    </div>

                    <div class="switch-area">
                        <span>Sidebar Mini</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                        </div>
                    </div>

                    <div class="switch-area">
                        <span>Notifikasi Email</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>