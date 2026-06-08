<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
/* ===== Wizard Container ===== */
.wizard-wrap { max-width: 820px; margin: 0 auto; }

/* ===== Step Indicator ===== */
.step-indicator {
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 2.5rem; gap: 0;
}
.step-item { display: flex; flex-direction: column; align-items: center; position: relative; flex: 1; }
.step-item:not(:last-child)::after {
  content: ''; position: absolute; top: 22px; left: 50%; width: 100%; height: 2px;
  background: #e2e8f0; z-index: 0; transition: background 0.4s;
}
.step-item.done:not(:last-child)::after { background: #0d47a1; }
.step-circle {
  width: 44px; height: 44px; border-radius: 50%; border: 2px solid #e2e8f0;
  background: #fff; display: flex; align-items: center; justify-content: center;
  font-weight: 700; font-size: 1rem; color: #94a3b8;
  transition: all 0.3s; position: relative; z-index: 1;
}
.step-item.active .step-circle { border-color: #0d47a1; background: #0d47a1; color: #fff; box-shadow: 0 0 0 4px rgba(13,71,161,0.15); }
.step-item.done .step-circle { border-color: #0d47a1; background: #0d47a1; color: #fff; }
.step-item.done .step-circle::after { content: '✓'; position: absolute; }
.step-item.done .step-num { display: none; }
.step-label { font-size: 0.78rem; font-weight: 600; color: #94a3b8; margin-top: 0.4rem; text-align: center; }
.step-item.active .step-label { color: #0d47a1; }
.step-item.done .step-label { color: #0d47a1; }

/* ===== Step Panels ===== */
.step-panel { display: none; animation: fadeIn 0.35s ease; }
.step-panel.active { display: block; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }

/* ===== Card ===== */
.wizard-card {
  background: #fff; border-radius: 20px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.07); padding: 2.25rem;
}
.wizard-card-title {
  font-size: 1.2rem; font-weight: 700; color: #0d47a1; margin-bottom: 0.35rem;
  display: flex; align-items: center; gap: 0.6rem;
}
.wizard-card-subtitle { color: #64748b; font-size: 0.9rem; margin-bottom: 1.75rem; }

/* ===== Upload Zone ===== */
.upload-zone {
  border: 2px dashed #bfdbfe; border-radius: 16px; padding: 3rem 2rem;
  text-align: center; background: #f0f7ff; cursor: pointer; transition: all 0.3s;
}
.upload-zone:hover, .upload-zone.drag-over { border-color: #0d47a1; background: #dbeafe; }
.upload-zone i { font-size: 3rem; color: #0d47a1; margin-bottom: 0.75rem; display: block; }
.upload-zone h5 { font-weight: 700; color: #0f172a; margin-bottom: 0.3rem; }
.upload-zone p { color: #64748b; font-size: 0.88rem; margin: 0; }
.upload-zone input[type="file"] { display: none; }
.upload-preview {
  display: none; align-items: center; gap: 1rem; background: #f0fdf4;
  border: 2px solid #86efac; border-radius: 12px; padding: 1rem 1.25rem; margin-top: 1rem;
}
.upload-preview.show { display: flex; }
.upload-preview i { font-size: 1.5rem; color: #16a34a; }
.upload-preview .file-info { flex: 1; }
.upload-preview .file-name { font-weight: 600; font-size: 0.95rem; }
.upload-preview .file-size { font-size: 0.8rem; color: #64748b; }

/* ===== Form Controls ===== */
.form-control, .form-select, textarea.form-control {
  border-radius: 10px; padding: 10px 14px; border: 1.5px solid #e2e8f0; font-size: 0.95rem;
}
.form-control:focus, .form-select:focus, textarea.form-control:focus {
  box-shadow: none; border-color: #0d47a1;
}
.form-label { font-weight: 600; font-size: 0.9rem; color: #374151; margin-bottom: 0.4rem; }

/* ===== Option Cards (tipe soal) ===== */
.option-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(155px, 1fr)); gap: 0.75rem; }
.option-card { border: 2px solid #e2e8f0; border-radius: 12px; padding: 1rem; text-align: center; cursor: pointer; transition: all 0.2s; }
.option-card:hover { border-color: #0d47a1; background: #f0f7ff; }
.option-card.selected { border-color: #0d47a1; background: #eff6ff; }
.option-card i { font-size: 1.6rem; color: #0d47a1; display: block; margin-bottom: 0.4rem; }
.option-card span { font-weight: 600; font-size: 0.88rem; color: #0f172a; }
.option-card input[type="radio"] { display: none; }

/* ===== Result ===== */
.result-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: #f0fdf4; color: #16a34a; border: 1px solid #86efac; border-radius: 8px; padding: 0.3rem 0.75rem; font-size: 0.82rem; font-weight: 600; margin-bottom: 1rem; }
.soal-item { background: #f8fafc; border-radius: 12px; padding: 1.25rem; margin-bottom: 0.875rem; border-left: 4px solid #0d47a1; }
.soal-num { font-size: 0.78rem; font-weight: 700; color: #0d47a1; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.4rem; }
.soal-text { font-weight: 600; margin-bottom: 0.6rem; color: #0f172a; }
.soal-options { list-style: none; padding: 0; margin: 0; }
.soal-options li { font-size: 0.9rem; color: #475569; padding: 0.2rem 0; }
.soal-options li.correct { color: #16a34a; font-weight: 600; }
.soal-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 1.5rem; }
.btn-primary-custom { background: #0d47a1; color: #fff; border: none; border-radius: 10px; padding: 10px 22px; font-weight: 600; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; }
.btn-primary-custom:hover { background: #08306b; color: #fff; transform: translateY(-1px); }
.btn-outline-custom { background: #fff; color: #0d47a1; border: 2px solid #0d47a1; border-radius: 10px; padding: 10px 22px; font-weight: 600; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; }
.btn-outline-custom:hover { background: #eff6ff; color: #0d47a1; }
.btn-success-custom { background: #16a34a; color: #fff; border: none; border-radius: 10px; padding: 10px 22px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.4rem; }
.btn-success-custom:hover { background: #15803d; }

/* ===== Navigation Buttons ===== */
.wizard-nav { display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; }
.btn-next { background: #0d47a1; color: #fff; border: none; border-radius: 10px; padding: 10px 28px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 0.5rem; }
.btn-next:hover { background: #08306b; transform: translateY(-1px); }
.btn-prev { background: #f1f5f9; color: #475569; border: none; border-radius: 10px; padding: 10px 22px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 0.5rem; }
.btn-prev:hover { background: #e2e8f0; }

/* Loading */
.loading-overlay { display: none; position: fixed; inset: 0; background: rgba(255,255,255,0.85); z-index: 999; flex-direction: column; align-items: center; justify-content: center; }
.loading-overlay.show { display: flex; }
.spinner-ring { width: 56px; height: 56px; border: 5px solid #bfdbfe; border-top-color: #0d47a1; border-radius: 50%; animation: spin 0.8s linear infinite; margin-bottom: 1rem; }
@keyframes spin { to { transform: rotate(360deg); } }
.loading-text { font-weight: 600; color: #0d47a1; font-size: 1rem; }

@media (max-width: 600px) { .step-label { display: none; } .wizard-card { padding: 1.25rem; } }
</style>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
  <div class="spinner-ring"></div>
  <div class="loading-text">AI sedang membuat soal...</div>
  <div class="text-muted mt-1" style="font-size:0.85rem">Harap tunggu sebentar ☕</div>
</div>

<div class="wizard-wrap">

  <!-- Step Indicator -->
  <div class="step-indicator" id="stepIndicator">
    <div class="step-item active" id="si-1">
      <div class="step-circle"><span class="step-num">1</span></div>
      <div class="step-label">Upload Materi</div>
    </div>
    <div class="step-item" id="si-2">
      <div class="step-circle"><span class="step-num">2</span></div>
      <div class="step-label">Parameter Soal</div>
    </div>
    <div class="step-item" id="si-3">
      <div class="step-circle"><span class="step-num">3</span></div>
      <div class="step-label">Hasil & Simpan</div>
    </div>
  </div>

  <!-- ===== STEP 1: Upload Materi ===== -->
  <div class="step-panel active" id="panel-1">
    <div class="wizard-card">
      <div class="wizard-card-title"><i class="bi bi-file-earmark-arrow-up"></i> Upload Materi</div>
      <div class="wizard-card-subtitle">Unggah file PDF atau dokumen materi pelajaran yang ingin dijadikan soal. Bisa juga langsung ketik materi di bawah.</div>

      <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
        <i class="bi bi-cloud-arrow-up"></i>
        <h5>Klik atau Seret File ke Sini</h5>
        <p>Mendukung PDF, DOC, DOCX, TXT &nbsp;•&nbsp; Maks. 10 MB</p>
        <input type="file" id="fileInput" accept=".pdf,.doc,.docx,.txt" onchange="handleFile(this)">
      </div>
      <div class="upload-preview" id="uploadPreview">
        <i class="bi bi-file-earmark-check-fill"></i>
        <div class="file-info">
          <div class="file-name" id="fileName">—</div>
          <div class="file-size" id="fileSize">—</div>
        </div>
        <button type="button" onclick="removeFile()" style="background:none;border:none;color:#dc2626;cursor:pointer;font-size:1.1rem;"><i class="bi bi-x-circle"></i></button>
      </div>

      <div class="mt-3 mb-2">
        <div class="d-flex align-items-center gap-2 text-muted mb-2" style="font-size:0.85rem">
          <div style="height:1px;background:#e2e8f0;flex:1"></div>
          <span>atau ketik langsung</span>
          <div style="height:1px;background:#e2e8f0;flex:1"></div>
        </div>
        <label class="form-label">Teks Materi</label>
        <textarea id="materiText" class="form-control" rows="6" placeholder="Tempel atau ketik materi pelajaran di sini..."></textarea>
      </div>

      <div class="wizard-nav">
        <div></div>
        <button class="btn-next" onclick="goStep(2)">
          Selanjutnya <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- ===== STEP 2: Parameter ===== -->
  <div class="step-panel" id="panel-2">
    <div class="wizard-card">
      <div class="wizard-card-title"><i class="bi bi-sliders"></i> Parameter Soal</div>
      <div class="wizard-card-subtitle">Atur preferensi soal sesuai kebutuhan Anda sebelum di-generate.</div>

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label">Mata Pelajaran / Topik</label>
          <input type="text" id="mapel" class="form-control" placeholder="cth: Matematika, Fisika, IPS...">
        </div>
        <div class="col-md-6">
          <label class="form-label">Jenjang Pendidikan</label>
          <select id="jenjang" class="form-select">
            <option value="SD">SD / MI</option>
            <option value="SMP">SMP / MTs</option>
            <option value="SMA" selected>SMA / SMK</option>
            <option value="Perguruan Tinggi">Perguruan Tinggi</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jumlah Soal</label>
          <select id="jumlahSoal" class="form-select">
            <option value="5">5 Soal</option>
            <option value="10" selected>10 Soal</option>
            <option value="15">15 Soal</option>
            <option value="20">20 Soal</option>
            <option value="30">30 Soal</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tingkat Kesulitan</label>
          <select id="kesulitan" class="form-select">
            <option value="Mudah">Mudah</option>
            <option value="Sedang" selected>Sedang</option>
            <option value="Sulit">Sulit</option>
            <option value="Campuran">Campuran</option>
          </select>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Tipe Soal</label>
        <div class="option-grid">
          <label class="option-card selected" onclick="selectTipe(this,'Pilihan Ganda')">
            <input type="radio" name="tipeSoal" value="Pilihan Ganda" checked>
            <i class="bi bi-list-check"></i>
            <span>Pilihan Ganda</span>
          </label>
          <label class="option-card" onclick="selectTipe(this,'Essay')">
            <input type="radio" name="tipeSoal" value="Essay">
            <i class="bi bi-pencil-square"></i>
            <span>Essay</span>
          </label>
          <label class="option-card" onclick="selectTipe(this,'Benar/Salah')">
            <input type="radio" name="tipeSoal" value="Benar/Salah">
            <i class="bi bi-toggle-on"></i>
            <span>Benar / Salah</span>
          </label>
          <label class="option-card" onclick="selectTipe(this,'Campuran')">
            <input type="radio" name="tipeSoal" value="Campuran">
            <i class="bi bi-collection"></i>
            <span>Campuran</span>
          </label>
        </div>
      </div>

      <div class="wizard-nav">
        <button class="btn-prev" onclick="goStep(1)">
          <i class="bi bi-arrow-left"></i> Kembali
        </button>
        <button class="btn-next" onclick="doGenerate()">
          <i class="bi bi-cpu"></i> Generate Soal
        </button>
      </div>
    </div>
  </div>

  <!-- ===== STEP 3: Hasil ===== -->
  <div class="step-panel" id="panel-3">
    <div class="wizard-card">
      <div class="wizard-card-title"><i class="bi bi-check-circle-fill text-success"></i> Soal Berhasil Dibuat!</div>
      <div class="wizard-card-subtitle">Tinjau soal yang telah dibuat AI. Simpan ke bank soal atau mulai ulang.</div>

      <div id="resultContainer">
        <!-- Soal akan ditampilkan di sini -->
      </div>

      <div class="soal-actions">
        <button class="btn-success-custom" id="btnSimpan" onclick="simpanBankSoal()">
          <i class="bi bi-archive"></i> Simpan ke Bank Soal
        </button>
        <button class="btn-primary-custom" onclick="window.print()">
          <i class="bi bi-printer"></i> Cetak / Export
        </button>
        <button class="btn-outline-custom" onclick="resetWizard()">
          <i class="bi bi-arrow-counterclockwise"></i> Buat Soal Baru
        </button>
      </div>
    </div>
  </div>

</div>

<!-- Hidden form for actual server-side submit -->
<form id="generateForm" action="<?= base_url('generate-soal/process') ?>" method="POST" enctype="multipart/form-data" style="display:none">
  <?= csrf_field() ?>
  <input type="file" name="file" id="hiddenFile">
  <input type="hidden" name="materi" id="hiddenMateri">
  <input type="hidden" name="mapel" id="hiddenMapel">
  <input type="hidden" name="jenjang" id="hiddenJenjang">
  <input type="hidden" name="jumlah_soal" id="hiddenJumlah">
  <input type="hidden" name="kesulitan" id="hiddenKesulitan">
  <input type="hidden" name="tipe_soal" id="hiddenTipe">
</form>

<script>
let currentStep = 1;
let uploadedFile = null;
let generatedSoal = [];

// ===== Step Navigation =====
function goStep(step) {
  if (step === 2) {
    const materi = document.getElementById('materiText').value.trim();
    if (!uploadedFile && !materi) {
      alert('Silakan upload file atau ketik materi pelajaran terlebih dahulu.');
      return;
    }
  }
  document.querySelectorAll('.step-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('panel-' + step).classList.add('active');
  updateIndicator(step);
  currentStep = step;
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updateIndicator(step) {
  for (let i = 1; i <= 3; i++) {
    const el = document.getElementById('si-' + i);
    el.classList.remove('active', 'done');
    if (i < step) el.classList.add('done');
    else if (i === step) el.classList.add('active');
  }
}

// ===== File Upload =====
function handleFile(input) {
  const file = input.files[0];
  if (!file) return;
  uploadedFile = file;
  document.getElementById('fileName').textContent = file.name;
  document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(1) + ' KB';
  document.getElementById('uploadPreview').classList.add('show');
}

function removeFile() {
  uploadedFile = null;
  document.getElementById('fileInput').value = '';
  document.getElementById('uploadPreview').classList.remove('show');
}

// Drag & Drop
const zone = document.getElementById('uploadZone');
zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
zone.addEventListener('drop', e => {
  e.preventDefault(); zone.classList.remove('drag-over');
  const file = e.dataTransfer.files[0];
  if (file) { uploadedFile = file; document.getElementById('fileName').textContent = file.name; document.getElementById('fileSize').textContent = (file.size/1024).toFixed(1)+' KB'; document.getElementById('uploadPreview').classList.add('show'); }
});

// ===== Tipe Soal Selection =====
function selectTipe(el, val) {
  document.querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  // Actually check the radio button inside this card
  const radio = el.querySelector('input[type="radio"]');
  if (radio) radio.checked = true;
}

// ===== Generate (submit to server) =====
function doGenerate() {
  const materi = document.getElementById('materiText').value.trim();
  const mapel = document.getElementById('mapel').value.trim();
  if (!mapel) { alert('Isi mata pelajaran / topik dulu ya!'); return; }

  // Populate hidden form
  document.getElementById('hiddenMateri').value = materi;
  document.getElementById('hiddenMapel').value = mapel;
  document.getElementById('hiddenJenjang').value = document.getElementById('jenjang').value;
  document.getElementById('hiddenJumlah').value = document.getElementById('jumlahSoal').value;
  document.getElementById('hiddenKesulitan').value = document.getElementById('kesulitan').value;
  document.getElementById('hiddenTipe').value = document.querySelector('input[name="tipeSoal"]:checked').value;

  if (uploadedFile) {
    const dt = new DataTransfer();
    dt.items.add(uploadedFile);
    document.getElementById('hiddenFile').files = dt.files;
  }

  document.getElementById('loadingOverlay').classList.add('show');
  document.getElementById('generateForm').submit();
}

// ===== If result already exists (server returned result after generation) =====
<?php if (!empty($soal_result)): ?>
(function() {
  goStep(3);
  const rawText = <?= json_encode($soal_result) ?>;
  renderRawSoal(rawText);
})();
<?php elseif (session()->getFlashdata('error')): ?>
(function() {
  alert('<?= session()->getFlashdata('error') ?>');
})();
<?php endif; ?>

function renderRawSoal(text) {
  const container = document.getElementById('resultContainer');
  if (!text) { container.innerHTML = '<p class="text-muted">Tidak ada soal dihasilkan.</p>'; return; }
  // Escape HTML
  const escaped = text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  // Split into lines and group by question number at the START of a line
  const lines = escaped.split('\n');
  const soalBlocks = [];
  let currentBlock = [];
  
  lines.forEach(line => {
    const trimmed = line.trim();
    // Detect new question: line starts with a number followed by dot and a space
    // Only match if the number is reasonable (1-999) and is at line start
    if (/^\d{1,3}\.\s/.test(trimmed) && !/^[A-Ea-e]\./.test(trimmed)) {
      // Check if this looks like a question (not option A-E)
      if (currentBlock.length > 0) {
        soalBlocks.push(currentBlock);
      }
      currentBlock = [trimmed];
    } else {
      currentBlock.push(trimmed);
    }
  });
  if (currentBlock.length > 0) soalBlocks.push(currentBlock);
  
  // Filter out any leading non-question blocks (like intro text)
  const filteredBlocks = soalBlocks.filter(block => /^\d{1,3}\.\s/.test(block[0]));
  const blocks = filteredBlocks.length > 0 ? filteredBlocks : soalBlocks;
  
  let html = `<div class="result-badge"><i class="bi bi-check-circle-fill"></i> ${blocks.length} soal berhasil dibuat oleh AI</div>`;
  blocks.forEach((block, i) => {
    let blockHtml = '<div class="soal-item"><div class="soal-num">Soal ' + (i+1) + '</div>';
    block.forEach(line => {
      const trimmed = line.trim();
      if (!trimmed) return;
      if (/^(Jawaban|Kunci|Kunci Jawaban)\s*:/i.test(trimmed)) {
        blockHtml += `<div style="margin-top:0.5rem;color:#16a34a;font-weight:600;font-size:0.9rem;"><i class="bi bi-check-circle-fill me-1"></i>${trimmed}</div>`;
      } else if (/^[A-Ea-e][.)\s]/.test(trimmed)) {
        blockHtml += `<div style="padding:0.15rem 0;font-size:0.9rem;color:#475569;">${trimmed}</div>`;
      } else if (/^\d{1,3}\.\s/.test(trimmed)) {
        blockHtml += `<div class="soal-text">${trimmed}</div>`;
      } else if (/^(Benar|Salah|True|False)/i.test(trimmed)) {
        blockHtml += `<div style="padding:0.15rem 0;font-size:0.9rem;color:#475569;font-style:italic;">${trimmed}</div>`;
      } else if (/^(Penjelasan|Pembahasan|Explanation)\s*:/i.test(trimmed)) {
        blockHtml += `<div style="margin-top:0.35rem;font-size:0.85rem;color:#64748b;font-style:italic;">${trimmed}</div>`;
      } else {
        blockHtml += `<div style="font-size:0.9rem;color:#475569;">${trimmed}</div>`;
      }
    });
    blockHtml += '</div>';
    html += blockHtml;
  });
  generatedRawText = text;
  container.innerHTML = html;
}

function simpanBankSoal() {
  const btn = document.getElementById('btnSimpan');
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
  btn.disabled = true;
  // Simple placeholder - wire to actual bank soal save
  setTimeout(() => {
    btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Tersimpan di Bank Soal!';
    btn.style.background = '#15803d';
  }, 800);
}

function resetWizard() {
  uploadedFile = null;
  document.getElementById('fileInput').value = '';
  document.getElementById('uploadPreview').classList.remove('show');
  document.getElementById('materiText').value = '';
  document.getElementById('mapel').value = '';
  document.getElementById('resultContainer').innerHTML = '';
  goStep(1);
}
</script>

<?= $this->endSection() ?>