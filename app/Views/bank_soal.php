<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
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

    .custom-card{
        border:none;
        border-radius:18px;
        box-shadow:0 6px 18px rgba(0,0,0,0.06);
        background:#fff;
        padding:22px;
        margin-bottom:24px;
    }

    .filter-box{
        border:none;
        border-radius:14px;
        padding:12px 15px;
        background:#f8fafc;
    }

    .bank-card{
        border:none;
        border-radius:18px;
        box-shadow:0 6px 18px rgba(0,0,0,0.06);
        overflow:hidden;
        transition:0.3s;
        height:100%;
        background:#fff;
    }

    .bank-card:hover{
        transform:translateY(-5px);
    }

    .bank-top{
        padding:18px 20px 8px;
    }

    .mapel-badge{
        display:inline-block;
        font-size:12px;
        font-weight:700;
        padding:6px 12px;
        border-radius:30px;
        background:#e3f2fd;
        color:#0d47a1;
        margin-bottom:12px;
    }

    .bank-title{
        font-size:18px;
        font-weight:700;
        color:#212529;
        line-height:1.4;
        min-height:55px;
    }

    .bank-meta{
        font-size:14px;
        color:#6c757d;
        margin-top:10px;
    }

    .bank-footer{
        padding:15px 20px 20px;
        display:flex;
        justify-content:space-between;
        align-items:center;
    }

    .btn-view{
        background:#0d47a1;
        color:white;
        border:none;
        border-radius:10px;
        padding:8px 18px;
        font-weight:600;
    }

    .btn-view:hover{
        background:#08306b;
        color:white;
    }

    .badge-level{
        padding:6px 12px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
    }

    .mudah{background:#dcfce7;color:#16a34a;}
    .sedang{background:#fef3c7;color:#b45309;}
    .sulit{background:#fee2e2;color:#dc2626;}

    .spotlight{
        background:linear-gradient(135deg,#0d47a1,#1565c0);
        color:white;
        border-radius:18px;
        padding:25px;
        height:100%;
    }

    .spotlight small{
        letter-spacing:1px;
        opacity:0.8;
    }

    .spotlight h4{
        font-weight:700;
        margin:12px 0;
    }

    .folder-box{
        border:2px dashed #cbd5e1;
        border-radius:18px;
        padding:35px 20px;
        text-align:center;
        background:#f8fafc;
        height:100%;
    }

    .folder-icon{
        font-size:42px;
        color:#0d47a1;
        margin-bottom:12px;
    }
</style>

<div class="container-fluid">

    <!-- Judul -->
    <div class="mb-4">
        <div class="page-title">Bank Soal</div>
        <div class="page-subtitle">
            Kelola dan distribusikan materi evaluasi yang telah Anda buat dengan kecerdasan AI.
        </div>
    </div>

    <!-- Filter -->
    <div class="custom-card">
        <div class="row g-3">
            <div class="col-lg-6">
                <input type="text" class="form-control filter-box" placeholder="Cari topik atau mata pelajaran...">
            </div>

            <div class="col-lg-2">
                <select class="form-select filter-box">
                    <option>Mata Pelajaran</option>
                    <option>Matematika</option>
                    <option>Bahasa Inggris</option>
                    <option>Sains</option>
                </select>
            </div>

            <div class="col-lg-2">
                <select class="form-select filter-box">
                    <option>Tipe Soal</option>
                    <option>Pilihan Ganda</option>
                    <option>Essay</option>
                </select>
            </div>

            <div class="col-lg-2">
                <select class="form-select filter-box">
                    <option>Kesulitan</option>
                    <option>Mudah</option>
                    <option>Sedang</option>
                    <option>Sulit</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Card Soal -->
    <div class="row g-4">

        <div class="col-lg-4">
            <div class="bank-card">
                <div class="bank-top">
                    <div class="mapel-badge">MATEMATIKA</div>
                    <div class="bank-title">Kalkulus Dasar: Turunan & Integral</div>
                    <div class="bank-meta">
                        <i class="bi bi-journal-text me-1"></i>25 Soal
                        &nbsp; | &nbsp;
                        <i class="bi bi-calendar3 me-1"></i>12 Okt 2023
                    </div>
                </div>

                <div class="bank-footer">
                    <button class="btn-view">Lihat</button>
                    <span class="badge-level sedang">SEDANG</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bank-card">
                <div class="bank-top">
                    <div class="mapel-badge">BAHASA INGGRIS</div>
                    <div class="bank-title">Advanced Business Communication</div>
                    <div class="bank-meta">
                        <i class="bi bi-journal-text me-1"></i>40 Soal
                        &nbsp; | &nbsp;
                        <i class="bi bi-calendar3 me-1"></i>08 Okt 2023
                    </div>
                </div>

                <div class="bank-footer">
                    <button class="btn-view">Lihat</button>
                    <span class="badge-level sulit">SULIT</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bank-card">
                <div class="bank-top">
                    <div class="mapel-badge">SAINS</div>
                    <div class="bank-title">Siklus Hidrologi & Atmosfer</div>
                    <div class="bank-meta">
                        <i class="bi bi-journal-text me-1"></i>15 Soal
                        &nbsp; | &nbsp;
                        <i class="bi bi-calendar3 me-1"></i>05 Okt 2023
                    </div>
                </div>

                <div class="bank-footer">
                    <button class="btn-view">Lihat</button>
                    <span class="badge-level mudah">MUDAH</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bank-card">
                <div class="bank-top">
                    <div class="mapel-badge">SEJARAH</div>
                    <div class="bank-title">Revolusi Industri: Dampak Global</div>
                    <div class="bank-meta">
                        <i class="bi bi-journal-text me-1"></i>30 Soal
                        &nbsp; | &nbsp;
                        <i class="bi bi-calendar3 me-1"></i>30 Sep 2023
                    </div>
                </div>

                <div class="bank-footer">
                    <button class="btn-view">Lihat</button>
                    <span class="badge-level sedang">SEDANG</span>
                </div>
            </div>
        </div>

        <!-- AI Spotlight -->
        <div class="col-lg-4">
            <div class="spotlight">
                <small>AI SPOTLIGHT</small>
                <h4>Optimalkan Bank Soal Anda</h4>
                <p>
                    Gunakan AI untuk mendeteksi repetisi soal dan
                    menghasilkan variasi baru secara otomatis.
                </p>

                <button class="btn btn-light fw-bold mt-2">
                    Cek Kualitas Soal
                </button>
            </div>
        </div>

        <!-- Folder Baru -->
        <div class="col-lg-4">
            <div class="folder-box">
                <div class="folder-icon">
                    <i class="bi bi-folder-plus"></i>
                </div>
                <h5 class="fw-bold">Buat Folder Baru</h5>
                <p class="text-muted">
                    Organisir soal berdasarkan kelas atau kurikulum
                </p>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>