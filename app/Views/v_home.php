<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
    /* Custom Styles for Dashboard */
    .hero-card {
        background: #0d47a1;
        color: white;
        border-radius: 1.25rem;
        padding: 3rem 2.5rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .hero-card h2 {
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 2rem;
    }
    .hero-card p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 65%;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    .hero-card .btn-white {
        background-color: white;
        color: #0d47a1;
        font-weight: 600;
        border-radius: 2rem;
        padding: 0.75rem 1.8rem;
        border: none;
        transition: all 0.3s;
    }
    .hero-card .btn-white:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
    }
    .hero-card .btn-outline-light-custom {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        font-weight: 600;
        border-radius: 2rem;
        padding: 0.75rem 1.8rem;
        transition: all 0.3s;
    }
    .hero-card .btn-outline-light-custom:hover {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        transform: translateY(-2px);
    }
    .hero-icon-container {
        position: absolute;
        right: 8%;
        top: 15%;
        width: 60px;
        height: 180px;
        background: rgba(255,255,255,0.15);
        border-radius: 2rem;
        transform: rotate(45deg);
    }
    .hero-icon-container::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background: #0d47a1;
        border-radius: 50%;
        top: 20px;
        left: 20px;
    }
    .hero-stars {
        position: absolute;
        right: 18%;
        top: 15%;
    }
    .hero-stars i {
        color: rgba(255, 255, 255, 0.2);
        position: absolute;
    }
    .star-1 { top: -20px; right: 120px; font-size: 2.5rem; }
    .star-2 { top: 40px; right: 40px; font-size: 3rem; }
    .star-3 { top: 100px; right: 90px; font-size: 2rem; }

    .stat-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        transition: transform 0.2s;
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        background-color: #f1f5f9;
        color: #0d47a1;
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-right: 1.2rem;
    }
    .stat-info .stat-title {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 0.2rem;
        font-weight: 600;
    }
    .stat-info .stat-val {
        color: #0f172a;
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }

    .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0d47a1;
        margin-bottom: 1.2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .section-title a {
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        color: #0d47a1;
    }

    .action-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        padding: 2rem 1.7rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
        cursor: pointer;
    }
    .action-card:hover {
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transform: translateY(-3px);
    }
    .action-icon {
        width: 55px;
        height: 55px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1.2rem;
    }
    .action-card.theme-primary .action-icon {
        background-color: #0d47a1;
        color: white;
    }
    .action-card.theme-secondary .action-icon {
        background-color: #bfdbfe;
        color: #1e40af;
    }
    .action-card h5 {
        font-weight: 700;
        color: #0f172a;
        font-size: 1.15rem;
        margin-bottom: 0.8rem;
    }
    .action-card p {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 0;
        line-height: 1.6;
    }
    .action-bg-icon {
        position: absolute;
        right: -20px;
        bottom: -30px;
        font-size: 10rem;
        color: #f8fafc;
        z-index: 0;
        opacity: 0.7;
    }
    .action-card > * {
        position: relative;
        z-index: 1;
    }

    @media (max-width: 1400px) {
        .hero-card { padding: 2.5rem 2rem; }
        .hero-card h2 { font-size: 1.7rem; }
        .hero-card p { font-size: 1rem; max-width: 75%; }
        .stat-info .stat-val { font-size: 1.6rem; }
        .action-card { padding: 1.5rem 1.25rem; }
        .activity-item { padding: 1rem 1.25rem; }
    }
    @media (max-width: 1199px) {
        .hero-card h2 { font-size: 1.5rem; }
        .hero-card p { max-width: 100%; font-size: 0.95rem; }
        .stat-info .stat-val { font-size: 1.4rem; }
        .stat-card { padding: 1rem; }
        .stat-icon { width: 48px; height: 48px; font-size: 1.4rem; margin-right: 0.8rem; }
    }
    @media (max-width: 768px) {
        .hero-card { padding: 2rem 1.5rem; }
        .hero-card p { max-width: 100%; }
        .hero-icon-container, .hero-stars { display: none; }
    }
    @media (max-width: 576px) {
        .hero-card h2 { font-size: 1.25rem; }
        .stat-card { flex-direction: column; text-align: center; }
        .stat-icon { margin-right: 0; margin-bottom: 0.5rem; }
    }
</style>

<div class="container-fluid px-0">
    <!-- Hero Section -->
    <div class="hero-card">
        <h2>Halo, <?= esc($nama ?? 'Pengguna') ?>! 👋</h2>
        <p>Hari ini adalah waktu yang tepat untuk mengotomatisasi evaluasi belajar. AI siap membantu Anda membuat soal berkualitas dalam hitungan detik.</p>
        <div class="d-flex gap-3">
            <a href="<?= base_url('generate-soal') ?>" class="btn btn-white">Mulai Sesi Baru</a>
            <a href="<?= base_url('bank-soal') ?>" class="btn btn-outline-light-custom">Lihat Bank Soal</a>
        </div>
        <div class="hero-stars">
            <i class="bi bi-star-fill star-1"></i>
            <i class="bi bi-star-fill star-2"></i>
            <i class="bi bi-star-fill star-3"></i>
        </div>
        <div class="hero-icon-container"></div>
    </div>

    <!-- Stat Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="stat-card bg-white">
                <div class="stat-icon">
                    <i class="bi bi-question-square"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-title">Total Soal</div>
                    <div class="stat-val">128</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="stat-card bg-white">
                <div class="stat-icon">
                    <i class="bi bi-server"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-title">Bank Soal</div>
                    <div class="stat-val">12</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-white">
                <div class="stat-icon">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-title">Mapel Aktif</div>
                    <div class="stat-val">4</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Columns -->
    <div class="row">
        <!-- Aksi Cepat -->
        <div class="col-12 mb-4">
            <div class="section-title">
                <span>Aksi Cepat</span>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="action-card bg-white theme-primary h-100">
                        <div class="action-icon">
                            <i class="bi bi-file-earmark-arrow-up"></i>
                        </div>
                        <h5>Upload Materi & Generate Soal</h5>
                        <p>Unggah PDF atau dokumen materi. Biarkan AI kami mengekstrak poin penting dan membuat butir soal.</p>
                        <i class="bi bi-file-text-fill action-bg-icon"></i>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="action-card bg-white theme-secondary h-100">
                        <div class="action-icon">
                            <i class="bi bi-list-task"></i>
                        </div>
                        <h5>Lihat Bank Soal</h5>
                        <p>Kelola ribuan soal yang sudah Anda buat. Kategorikan berdasarkan tingkat kesulitan dan kurikulum.</p>
                        <i class="bi bi-star-fill action-bg-icon" style="right: -40px; bottom: -50px; font-size: 14rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
