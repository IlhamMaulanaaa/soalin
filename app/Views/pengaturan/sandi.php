<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
.setting-card {
  background: #fff; border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 2rem; max-width: 680px; margin: 0 auto;
}
.setting-card-title {
  font-size: 1.15rem; font-weight: 700; color: #0d47a1; margin-bottom: 1.5rem;
  display: flex; align-items: center; gap: 0.6rem;
  padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9;
}
.form-control, .form-select {
  border-radius: 10px; padding: 10px 14px; border: 1.5px solid #e2e8f0; font-size: 0.95rem;
}
.form-control:focus, .form-select:focus { box-shadow: none; border-color: #0d47a1; }
.btn-save {
  background: #0d47a1; color: #fff; border: none; border-radius: 10px;
  padding: 10px 22px; font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.btn-save:hover { background: #08306b; transform: translateY(-1px); }
.strength-bar { height: 6px; border-radius: 10px; background: #e2e8f0; margin-top: 6px; }
.strength-fill { height: 100%; border-radius: 10px; width: 0%; transition: width 0.4s, background 0.4s; }
</style>

<div class="setting-card">
  <div class="setting-card-title">
    <i class="bi bi-shield-lock"></i> Ganti Sandi
  </div>
  <?php if (session()->getFlashdata('sandi_success')): ?>
    <div class="alert alert-success border-0 rounded-3"><?= session()->getFlashdata('sandi_success') ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('sandi_error')): ?>
    <div class="alert alert-danger border-0 rounded-3"><?= session()->getFlashdata('sandi_error') ?></div>
  <?php endif; ?>
  <form action="<?= base_url('pengaturan/sandi') ?>" method="POST">
    <?= csrf_field() ?>
    <div class="row g-3">
      <div class="col-12">
        <label class="form-label fw-semibold">Password Lama</label>
        <input type="password" name="password_lama" id="passLama" class="form-control" placeholder="Masukkan password saat ini" required>
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Password Baru</label>
        <input type="password" name="password_baru" id="passBaru" class="form-control" placeholder="Min. 8 karakter" required oninput="checkStrength(this.value)">
        <div class="strength-bar mt-2"><div class="strength-fill" id="strengthFill"></div></div>
        <div id="strengthText" class="text-muted" style="font-size:0.8rem;margin-top:4px;"></div>
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
        <input type="password" name="konfirmasi_password" id="passKonfirm" class="form-control" placeholder="Ulangi password baru" required>
      </div>
      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-save">
          <i class="bi bi-shield-check me-1"></i> Perbarui Sandi
        </button>
      </div>
    </div>
  </form>
</div>

<script>
function checkStrength(val) {
  const fill = document.getElementById('strengthFill');
  const text = document.getElementById('strengthText');
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const levels = [
    {w:'0%', c:'', t:''},
    {w:'25%', c:'#ef4444', t:'Lemah'},
    {w:'50%', c:'#f97316', t:'Cukup'},
    {w:'75%', c:'#eab308', t:'Baik'},
    {w:'100%', c:'#22c55e', t:'Kuat'},
  ];
  const l = levels[score];
  fill.style.width = l.w; fill.style.background = l.c; text.textContent = l.t;
  text.style.color = l.c;
}
</script>

<?= $this->endSection() ?>
