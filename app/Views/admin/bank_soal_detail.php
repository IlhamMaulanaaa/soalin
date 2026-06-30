<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
.page-title{font-size:26px;font-weight:700;color:#0d47a1;margin-bottom:4px;}
.meta-card{border:none;border-radius:14px;box-shadow:0 4px 12px rgba(0,0,0,0.05);background:#fff;padding:1.25rem;height:100%;}
.meta-label{font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;}
.meta-value{font-size:0.95rem;font-weight:600;color:#0f172a;margin-top:4px;}
.soal-block{background:#f8fafc;border-radius:12px;padding:1.5rem;white-space:pre-wrap;font-size:0.92rem;line-height:1.7;color:#334155;}
.badge-level{display:inline-block;padding:4px 12px;border-radius:30px;font-size:0.75rem;font-weight:700;}
.mudah{background:#dcfce7;color:#16a34a;}
.sedang{background:#fef3c7;color:#b45309;}
.sulit{background:#fee2e2;color:#dc2626;}
</style>

<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <div class="page-title">Detail Soal</div>
        <p class="text-muted mb-0">Oleh: <?= esc($soal['nama_guru']) ?> &mdash; <?= esc($soal['email_guru']) ?></p>
    </div>
    <a href="<?= base_url('admin/bank-soal') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-4 col-md">
        <div class="meta-card"><div class="meta-label">Mapel</div><div class="meta-value"><?= esc($soal['mapel']) ?></div></div>
    </div>
    <div class="col-4 col-md">
        <div class="meta-card"><div class="meta-label">Jenjang</div><div class="meta-value"><?= esc($soal['jenjang']) ?></div></div>
    </div>
    <div class="col-4 col-md">
        <div class="meta-card"><div class="meta-label">Jumlah</div><div class="meta-value"><?= esc($soal['jumlah_soal']) ?></div></div>
    </div>
    <div class="col-4 col-md">
        <div class="meta-card"><div class="meta-label">Tipe</div><div class="meta-value"><?= esc($soal['tipe_soal']) ?></div></div>
    </div>
    <div class="col-4 col-md">
        <div class="meta-card"><div class="meta-label">Kesulitan</div><div class="meta-value"><span class="badge-level <?= strtolower(esc($soal['kesulitan'])) ?>"><?= strtoupper(esc($soal['kesulitan'])) ?></span></div></div>
    </div>
</div>

<div class="card" style="border:none;border-radius:14px;box-shadow:0 4px 12px rgba(0,0,0,0.05);">
    <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom:1px solid #f1f5f9;border-radius:14px 14px 0 0;">
        <span class="fw-bold" style="font-size:0.9rem;">Isi Soal</span>
        <button class="btn btn-sm btn-outline-danger" onclick="hapusSoal(<?= $soal['id'] ?>)"><i class="bi bi-trash"></i> Hapus</button>
    </div>
    <div class="card-body">
        <div class="soal-block"><?= esc($soal['soal_text']) ?></div>
    </div>
</div>

<script>
function hapusSoal(id) {
    if (!confirm('Yakin ingin menghapus soal ini?')) return;
    fetch('<?= base_url('admin/bank-soal/hapus') ?>/' + id, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
    .then(r => r.json())
    .then(res => {
        if (res.status === 'success') {
            window.location.href = '<?= base_url('admin/bank-soal') ?>';
        } else {
            alert(res.message);
        }
    });
}
</script>

<?= $this->endSection() ?>
