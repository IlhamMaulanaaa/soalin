<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
.page-title{font-size:28px;font-weight:700;color:#0d47a1;margin-bottom:4px;}
.bank-card{border:none;border-radius:18px;box-shadow:0 6px 18px rgba(0,0,0,0.06);overflow:hidden;transition:0.3s;height:100%;background:#fff;}
.bank-card:hover{transform:translateY(-4px);}
.bank-top{padding:18px 20px 10px;}
.mapel-badge{display:inline-block;font-size:11px;font-weight:700;padding:5px 10px;border-radius:30px;background:#e3f2fd;color:#0d47a1;margin-bottom:10px;}
.bank-title{font-size:16px;font-weight:700;color:#212529;line-height:1.4;}
.bank-meta{font-size:12px;color:#6c757d;margin-top:8px;}
.bank-footer{padding:12px 20px 18px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:6px;}
.btn-view{background:#0d47a1;color:white;border:none;border-radius:10px;padding:7px 16px;font-weight:600;font-size:0.85rem;text-decoration:none;}
.btn-view:hover{background:#08306b;color:white;}
.badge-level{padding:5px 10px;border-radius:30px;font-size:11px;font-weight:700;}
.mudah{background:#dcfce7;color:#16a34a;}
.sedang{background:#fef3c7;color:#b45309;}
.sulit{background:#fee2e2;color:#dc2626;}
.guru-label{font-size:0.8rem;color:#64748b;font-weight:500;}
</style>

<div class="page-title mb-1">Semua Bank Soal</div>
<p class="text-muted mb-4">Seluruh bank soal dari semua guru di sekolah.</p>

<?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div><?php endif; ?>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= session()->getFlashdata('success') ?></div><?php endif; ?>

<?php if (empty($soal_list)): ?>
    <div class="text-center py-5">
        <i class="bi bi-inbox" style="font-size:4rem;color:#cbd5e1;"></i>
        <h5 class="fw-bold mt-3 text-muted">Belum ada bank soal</h5>
        <p class="text-muted">Guru belum membuat soal sama sekali.</p>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($soal_list as $s): ?>
            <div class="col-lg-4 col-md-6">
                <div class="bank-card">
                    <div class="bank-top">
                        <div class="mapel-badge"><?= esc(strtoupper($s['mapel'])) ?></div>
                        <div class="bank-title"><?= esc($s['mapel']) ?> — <?= esc($s['jenjang']) ?></div>
                        <div class="bank-meta">
                            <i class="bi bi-person me-1"></i><?= esc($s['nama_guru'] ?? '—') ?>
                            &nbsp;|&nbsp;
                            <i class="bi bi-journal-text me-1"></i><?= esc($s['jumlah_soal']) ?> Soal
                            &nbsp;|&nbsp;
                            <i class="bi bi-tag me-1"></i><?= esc($s['tipe_soal']) ?>
                        </div>
                    </div>
                    <div class="bank-footer">
                        <a href="<?= base_url('admin/bank-soal/detail/' . $s['id']) ?>" class="btn-view"><i class="bi bi-eye"></i> Lihat</a>
                        <span class="badge-level <?= strtolower(esc($s['kesulitan'])) ?>"><?= strtoupper(esc($s['kesulitan'])) ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
