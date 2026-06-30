<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
    .page-title{font-size:28px;font-weight:700;color:#0d47a1;margin-bottom:8px;}
    .page-subtitle{color:#6c757d;margin-bottom:28px;}
    .custom-card{border:none;border-radius:18px;box-shadow:0 6px 18px rgba(0,0,0,0.06);background:#fff;padding:22px;margin-bottom:24px;}
    .filter-box{border:none;border-radius:14px;padding:12px 15px;background:#f8fafc;}
    .bank-card{border:none;border-radius:18px;box-shadow:0 6px 18px rgba(0,0,0,0.06);overflow:hidden;transition:0.3s;height:100%;background:#fff;}
    .bank-card:hover{transform:translateY(-5px);}
    .bank-top{padding:18px 20px 8px;}
    .mapel-badge{display:inline-block;font-size:12px;font-weight:700;padding:6px 12px;border-radius:30px;background:#e3f2fd;color:#0d47a1;margin-bottom:12px;}
    .bank-title{font-size:18px;font-weight:700;color:#212529;line-height:1.4;min-height:55px;}
    .bank-meta{font-size:14px;color:#6c757d;margin-top:10px;}
    .bank-footer{padding:15px 20px 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;}
    .btn-view{background:#0d47a1;color:white;border:none;border-radius:10px;padding:8px 18px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:0.3rem;}
    .btn-view:hover{background:#08306b;color:white;}
    .btn-hapus-card{background:transparent;color:#dc2626;border:1px solid #fecaca;border-radius:10px;padding:8px 14px;font-size:0.85rem;font-weight:600;cursor:pointer;transition:all 0.2s;}
    .btn-hapus-card:hover{background:#fee2e2;}
    .badge-level{padding:6px 12px;border-radius:30px;font-size:12px;font-weight:700;}
    .mudah{background:#dcfce7;color:#16a34a;}
    .sedang{background:#fef3c7;color:#b45309;}
    .sulit{background:#fee2e2;color:#dc2626;}
    .spotlight{background:linear-gradient(135deg,#0d47a1,#1565c0);color:white;border-radius:18px;padding:25px;height:100%;}
    .spotlight small{letter-spacing:1px;opacity:0.8;}
    .spotlight h4{font-weight:700;margin:12px 0;}
    .folder-box{border:2px dashed #cbd5e1;border-radius:18px;padding:35px 20px;text-align:center;background:#f8fafc;height:100%;}
    .folder-icon{font-size:42px;color:#0d47a1;margin-bottom:12px;}
    .kosong{text-align:center;padding:4rem 1rem;color:#94a3b8;}
    .kosong i{font-size:4rem;display:block;margin-bottom:1rem;}
</style>

<div class="container-fluid">
    <div class="mb-4">
        <div class="page-title">Bank Soal</div>
        <div class="page-subtitle">Kelola soal yang telah Anda buat dengan AI.</div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="filter-box d-flex flex-wrap align-items-center gap-2 mb-4">
        <i class="bi bi-search text-muted"></i>
        <input type="text" id="searchSoal" class="form-control" placeholder="Cari mapel, jenjang, tipe..." style="max-width:320px;border-radius:10px;font-size:0.9rem;" oninput="filterSoal()">
        <select id="filterTipe" class="form-select" style="max-width:160px;border-radius:10px;font-size:0.9rem;" onchange="filterSoal()">
            <option value="">Semua Tipe</option>
            <option value="Pilihan Ganda">Pilihan Ganda</option>
            <option value="Essay">Essay</option>
            <option value="Benar/Salah">Benar/Salah</option>
            <option value="Campuran">Campuran</option>
        </select>
    </div>

    <div class="row g-4" id="soalGrid">
        <?php if (empty($soal_list)): ?>
            <div class="col-12">
                <div class="kosong">
                    <i class="bi bi-inbox"></i>
                    <h5 class="fw-bold">Belum ada soal tersimpan</h5>
                    <p class="text-muted">Generate soal terlebih dahulu, lalu simpan ke Bank Soal.</p>
                    <a href="<?= base_url('generate-soal') ?>" class="btn btn-primary">Mulai Generate</a>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($soal_list as $s): ?>
                <div class="col-lg-4 soal-card" data-mapel="<?= strtolower(esc($s['mapel'])) ?>" data-jenjang="<?= strtolower(esc($s['jenjang'])) ?>" data-tipe="<?= strtolower(esc($s['tipe_soal'])) ?>">
                    <div class="bank-card">
                        <div class="bank-top">
                            <div class="mapel-badge"><?= esc(strtoupper($s['mapel'])) ?></div>
                            <div class="bank-title"><?= esc($s['mapel']) ?> &mdash; <?= esc($s['jenjang']) ?></div>
                            <div class="bank-meta">
                                <i class="bi bi-journal-text me-1"></i><?= esc($s['jumlah_soal']) ?> Soal
                                &nbsp;|&nbsp;
                                <i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($s['created_at'])) ?>
                                &nbsp;|&nbsp;
                                <i class="bi bi-tag me-1"></i><?= esc($s['tipe_soal']) ?>
                            </div>
                        </div>
                        <div class="bank-footer">
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('bank-soal/detail/' . $s['id']) ?>" class="btn-view"><i class="bi bi-eye"></i> Lihat</a>
                                <button class="btn-hapus-card" onclick="hapusSoal(<?= $s['id'] ?>, this)"><i class="bi bi-trash"></i></button>
                            </div>
                            <span class="badge-level <?= strtolower(esc($s['kesulitan'])) ?>"><?= strtoupper(esc($s['kesulitan'])) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="col-lg-4">
                <div class="spotlight">
                    <small>AI SPOTLIGHT</small>
                    <h4>Buat Soal Baru</h4>
                    <p>Gunakan AI untuk membuat soal baru dari materi pelajaran apa pun.</p>
                    <a href="<?= base_url('generate-soal') ?>" class="btn btn-light fw-bold mt-2">Generate Sekarang</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function filterSoal() {
  const q = document.getElementById('searchSoal').value.toLowerCase();
  const t = document.getElementById('filterTipe').value.toLowerCase();
  document.querySelectorAll('.soal-card').forEach(card => {
    const text = card.dataset.mapel + ' ' + card.dataset.jenjang + ' ' + card.dataset.tipe;
    const matchSearch = !q || text.includes(q);
    const matchTipe = !t || card.dataset.tipe === t;
    card.style.display = (matchSearch && matchTipe) ? '' : 'none';
  });
}

function hapusSoal(id, btn) {
  if (!confirm('Yakin ingin menghapus soal ini?')) return;
  fetch('<?= base_url('bank-soal/hapus') ?>/' + id, {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
  })
  .then(r => r.json())
  .then(res => {
    if (res.status === 'success') {
      const card = btn.closest('.soal-card');
      card.style.transition = 'all 0.3s';
      card.style.opacity = '0';
      setTimeout(() => card.remove(), 300);
    } else {
      alert(res.message);
    }
  });
}
</script>

<?= $this->endSection() ?>
