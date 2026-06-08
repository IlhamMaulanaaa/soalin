<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<style>
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #0d47a1;
        margin-bottom: 8px;
    }
</style>

<div class="container-fluid">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <div class="page-title">Hasil Generate Soal</div>
            <div class="page-subtitle text-muted">
                Topik: <?= htmlspecialchars($mata_pelajaran) ?> | Kelas: <?= htmlspecialchars($kelas) ?>
            </div>
        </div>
        <div>
            <a href="/generate-soal" class="btn btn-outline-secondary me-2"><i class="bi bi-arrow-left"></i> Kembali</a>
            <button onclick="window.print()" class="btn btn-primary" style="background:#0d47a1;"><i class="bi bi-printer"></i> Cetak</button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4" style="background: #fff; border-radius: 18px;">
        <div id="aiContent" style="display:none;"><?= htmlspecialchars($aiResponse) ?></div>
        <div id="renderedContent" style="line-height: 1.7; color: #333;"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const aiContent = document.getElementById('aiContent');
        const renderedContent = document.getElementById('renderedContent');
        if (aiContent && renderedContent) {
            renderedContent.innerHTML = marked.parse(aiContent.innerText || aiContent.textContent);
        }
    });
</script>

<?= $this->endSection() ?>
