<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
.page-title{font-size:28px;font-weight:700;color:#0d47a1;margin-bottom:8px;}
.page-subtitle{color:#6c757d;margin-bottom:28px;}
.detail-card{border:none;border-radius:18px;box-shadow:0 6px 18px rgba(0,0,0,0.06);background:#fff;padding:2rem;margin-bottom:1.5rem;}
.meta-label{font-size:0.8rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;}
.meta-value{font-size:1rem;font-weight:600;color:#0f172a;}
.soal-item{background:#f8fafc;border-radius:12px;padding:1.25rem;margin-bottom:0.875rem;border-left:4px solid #0d47a1;}
.soal-num{font-size:0.78rem;font-weight:700;color:#0d47a1;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.4rem;}
.soal-text{font-weight:600;margin-bottom:0.6rem;color:#0f172a;}
.btn-back{background:#f1f5f9;color:#475569;border:none;border-radius:10px;padding:10px 22px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;}
.btn-back:hover{background:#e2e8f0;color:#475569;}
.btn-hapus{background:#fee2e2;color:#dc2626;border:none;border-radius:10px;padding:10px 22px;font-weight:600;display:inline-flex;align-items:center;gap:0.4rem;}
.btn-hapus:hover{background:#fecaca;color:#dc2626;}
.badge-level{display:inline-block;padding:4px 12px;border-radius:30px;font-size:0.8rem;font-weight:700;}
.mudah{background:#dcfce7;color:#16a34a;}
.sedang{background:#fef3c7;color:#b45309;}
.sulit{background:#fee2e2;color:#dc2626;}
.kunci-highlight{color:#16a34a;font-weight:700;font-size:0.9rem;margin-top:0.5rem;}
.option-line{font-size:0.9rem;color:#475569;padding:0.15rem 0;}
.correct-option{color:#16a34a;font-weight:600;}
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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="meta-label" style="font-size:0.9rem;">Daftar Soal</div>
    </div>
    <div id="soalContainer"></div>
</div>

<form id="formHapus" method="POST" style="display:none">
    <?= csrf_field() ?>
</form>

<script>
const rawText = <?= json_encode($soal['soal_text']) ?>;

function parseAndRender(text) {
  const container = document.getElementById('soalContainer');
  if (!text) { container.innerHTML = '<p class="text-muted">Tidak ada soal.</p>'; return; }

  const escaped = text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  const lines = escaped.split('\n');
  const blocks = [];
  let current = [];

  lines.forEach(line => {
    const t = line.trim();
    if (/^\d{1,3}\.\s/.test(t) && !/^[A-Ea-e]\./.test(t)) {
      if (current.length) blocks.push(current);
      current = [t];
    } else {
      current.push(t);
    }
  });
  if (current.length) blocks.push(current);

  const filtered = blocks.filter(b => /^\d{1,3}\.\s/.test(b[0]));
  const soal = filtered.length ? filtered : blocks;

  let html = '';
  soal.forEach((block, i) => {
    let blockHtml = `<div class="soal-item"><div class="soal-num">Soal ${i+1}</div>`;
    let answer = '';

    block.forEach(line => {
      const t = line.trim();
      if (!t) return;

      if (/^(Jawaban|Kunci|Kunci Jawaban)\s*:/i.test(t)) {
        answer = t;
      } else if (/^[A-Ea-e][.)\s]/.test(t)) {
        const letter = t[0].toUpperCase();
        if (answer && answer.includes(letter + ')') || answer.includes(letter + '.') || answer.toUpperCase().includes(': ' + letter)) {
          blockHtml += `<div class="option-line correct-option">${t} <i class="bi bi-check-circle-fill" style="color:#16a34a;"></i></div>`;
        } else {
          blockHtml += `<div class="option-line">${t}</div>`;
        }
      } else if (/^\d{1,3}\.\s/.test(t)) {
        blockHtml += `<div class="soal-text">${t}</div>`;
      } else {
        blockHtml += `<div class="option-line">${t}</div>`;
      }
    });

    if (answer) {
      blockHtml += `<div class="kunci-highlight"><i class="bi bi-check-circle-fill me-1"></i>${answer}</div>`;
    }
    blockHtml += '</div>';
    html += blockHtml;
  });

  if (!soal.length) {
    html = `<div class="soal-block" style="background:#f8fafc;border-radius:12px;padding:1.5rem;white-space:pre-wrap;">${escaped}</div>`;
  }

  container.innerHTML = html;
}

parseAndRender(rawText);

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
