<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
.page-title{font-size:28px;font-weight:700;color:#0d47a1;margin-bottom:8px;}
.page-subtitle{color:#6c757d;margin-bottom:28px;}
.detail-card{border:none;border-radius:18px;box-shadow:0 6px 18px rgba(0,0,0,0.06);background:#fff;padding:2rem;margin-bottom:1.5rem;}
.meta-label{font-size:0.8rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;}
.meta-value{font-size:1rem;font-weight:600;color:#0f172a;}
.soal-block{background:#f8fafc;border-radius:12px;padding:1.5rem;margin-top:1rem;white-space:pre-wrap;font-size:0.95rem;line-height:1.7;color:#334155;}
.btn-back{background:#f1f5f9;color:#475569;border:none;border-radius:10px;padding:10px 22px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;}
.btn-back:hover{background:#e2e8f0;color:#475569;}
.btn-hapus{background:#fee2e2;color:#dc2626;border:none;border-radius:10px;padding:10px 22px;font-weight:600;display:inline-flex;align-items:center;gap:0.4rem;}
.btn-hapus:hover{background:#fecaca;color:#dc2626;}
.badge-level{display:inline-block;padding:4px 12px;border-radius:30px;font-size:0.8rem;font-weight:700;}
.mudah{background:#dcfce7;color:#16a34a;}
.sedang{background:#fef3c7;color:#b45309;}
.sulit{background:#fee2e2;color:#dc2626;}
</style>

<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <div class="page-title">Detail Soal</div>
        <div class="page-subtitle"><?= esc($soal['mapel']) ?> &mdash; <?= esc($soal['jenjang']) ?></div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('bank-soal') ?>" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali</a>
        <button class="btn-hapus" onclick="hapusSoal(<?= $soal['id'] ?>)"><i class="bi bi-trash"></i> Hapus</button>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="detail-card h-100">
            <div class="meta-label">Mata Pelajaran</div>
            <div class="meta-value"><?= esc($soal['mapel']) ?></div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="detail-card h-100">
            <div class="meta-label">Jenjang</div>
            <div class="meta-value"><?= esc($soal['jenjang']) ?></div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="detail-card h-100">
            <div class="meta-label">Jumlah Soal</div>
            <div class="meta-value"><?= esc($soal['jumlah_soal']) ?></div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="detail-card h-100">
            <div class="meta-label">Tipe Soal</div>
            <div class="meta-value"><?= esc($soal['tipe_soal']) ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="detail-card h-100">
            <div class="meta-label">Kesulitan</div>
            <div class="meta-value"><span class="badge-level <?= strtolower(esc($soal['kesulitan'])) ?>"><?= strtoupper(esc($soal['kesulitan'])) ?></span></div>
        </div>
    </div>
</div>

<div class="detail-card">
    <div class="meta-label mb-2">Soal</div>
    <div class="soal-block"><?= esc($soal['soal_text']) ?></div>
</div>

<form id="formHapus" method="POST" style="display:none">
    <?= csrf_field() ?>
</form>

<script>
function hapusSoal(id) {
    if (!confirm('Yakin ingin menghapus soal ini?')) return;
    fetch('<?= base_url('bank-soal/hapus') ?>/' + id, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
    .then(r => r.json())
    .then(res => {
        if (res.status === 'success') {
            window.location.href = '<?= base_url('bank-soal') ?>';
        } else {
            alert(res.message);
        }
    });
}
</script>

<?= $this->endSection() ?>
