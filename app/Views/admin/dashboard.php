<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
.page-title{font-size:28px;font-weight:700;color:#0d47a1;margin-bottom:4px;}
.stat-card{border:none;border-radius:18px;box-shadow:0 6px 18px rgba(0,0,0,0.06);background:#fff;padding:1.75rem;height:100%;}
.stat-icon{width:54px;height:54px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;margin-bottom:0.8rem;}
.stat-num{font-size:2.2rem;font-weight:800;color:#0f172a;line-height:1;}
.stat-label{color:#64748b;font-size:0.9rem;font-weight:500;margin-top:0.3rem;}
.user-table{font-size:0.9rem;}
.user-table th{color:#64748b;font-weight:600;border-bottom:2px solid #f1f5f9;}
.user-table td{border-bottom:1px solid #f8fafc;vertical-align:middle;}
.badge-role{display:inline-block;padding:4px 12px;border-radius:30px;font-size:0.75rem;font-weight:700;}
.badge-admin{background:#fef3c7;color:#b45309;}
.badge-user{background:#dcfce7;color:#16a34a;}
@media (max-width: 1400px){
  .page-title{font-size:22px;}
  .stat-card{padding:1.25rem;}
  .stat-num{font-size:1.7rem;}
}
@media (max-width: 768px){
  .stat-card{padding:1rem;}
  .stat-num{font-size:1.4rem;}
  .stat-icon{width:44px;height:44px;font-size:1.3rem;}
}
</style>

<div class="page-title mb-4">Dashboard Admin</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e0f2fe;color:#0284c7;"><i class="bi bi-people-fill"></i></div>
            <div class="stat-num"><?= esc($total_guru) ?></div>
            <div class="stat-label">Total Guru Terdaftar</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-journal-text"></i></div>
            <div class="stat-num"><?= esc($total_soal) ?></div>
            <div class="stat-label">Total Bank Soal</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7;color:#b45309;"><i class="bi bi-calendar-check"></i></div>
            <div class="stat-num"><?= esc($soal_hari_ini) ?></div>
            <div class="stat-label">Soal Dibuat Hari Ini</div>
        </div>
    </div>
</div>

<div class="card" style="border:none;border-radius:18px;box-shadow:0 6px 18px rgba(0,0,0,0.06);">
    <div class="card-header bg-white" style="border-radius:18px 18px 0 0;border-bottom:1px solid #f1f5f9;padding:1.25rem 1.5rem;">
        <h6 class="fw-bold mb-0" style="color:#0f172a;">Guru Terbaru</h6>
    </div>
    <div class="card-body p-0">
        <?php if (empty($guru_terbaru)): ?>
            <p class="text-muted p-4 mb-0">Belum ada guru terdaftar.</p>
        <?php else: ?>
            <table class="table user-table mb-0">
                <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Tanggal Daftar</th></tr></thead>
                <tbody>
                    <?php foreach ($guru_terbaru as $g): ?>
                        <tr>
                            <td class="fw-semibold"><?= esc($g['name'] ?? $g['nama'] ?? '-') ?></td>
                            <td><?= esc($g['email']) ?></td>
                            <td><span class="badge-role badge-user">GURU</span></td>
                            <td><?= date('d M Y', strtotime($g['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
