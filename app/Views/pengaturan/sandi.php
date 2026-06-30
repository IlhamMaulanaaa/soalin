<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
.settings-wrap { display: flex; gap: 1.5rem; align-items: flex-start; }
.settings-nav-card {
  background: #fff; border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  padding: 1.25rem 0; width: 230px; flex-shrink: 0; position: sticky; top: 80px;
}
.settings-nav-title {
  font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 1px; color: #94a3b8; padding: 0 1.25rem; margin-bottom: 0.5rem;
}
.settings-nav-link {
  display: flex; align-items: center; gap: 0.75rem;
  padding: 0.65rem 1.25rem; color: #475569; font-weight: 500; font-size: 0.95rem;
  text-decoration: none; transition: all 0.2s; border-left: 3px solid transparent;
}
.settings-nav-link:hover { background: #f1f5f9; color: #0d47a1; }
.settings-nav-link.active { background: #eff6ff; color: #0d47a1; font-weight: 600; border-left-color: #0d47a1; }
.settings-nav-link i { font-size: 1.05rem; width: 20px; text-align: center; }
.settings-nav-divider { height: 1px; background: #f1f5f9; margin: 0.5rem 0; }
.settings-nav-link.danger { color: #dc2626; }
.settings-nav-link.danger:hover { background: #fff1f2; color: #dc2626; }
.settings-main { flex: 1; }
.setting-card {
  background: #fff; border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 2rem; margin-bottom: 1.5rem;
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
@media (max-width: 768px) {
  .settings-wrap { flex-direction: column; }
  .settings-nav-card { width: 100%; position: static; }
}
</style>

<div class="settings-wrap">
  <div class="settings-nav-card">
    <div class="settings-nav-title" style="margin-top:0.5rem">Akun</div>
    <a href="<?= base_url('pengaturan/profil') ?>" class="settings-nav-link <?= (uri_string() === 'pengaturan/profil') ? 'active' : '' ?>">
      <i class="bi bi-person-circle"></i> Edit Profil
    </a>
    <a href="<?= base_url('pengaturan/sandi') ?>" class="settings-nav-link <?= (uri_string() === 'pengaturan/sandi') ? 'active' : '' ?>">
      <i class="bi bi-shield-lock"></i> Ganti Sandi
    </a>
    <div class="settings-nav-divider"></div>
    <div class="settings-nav-title">Konfigurasi</div>
    <a href="<?= base_url('pengaturan/preferensi') ?>" class="settings-nav-link <?= (uri_string() === 'pengaturan/preferensi') ? 'active' : '' ?>">
      <i class="bi bi-sliders"></i> Preferensi Soal
    </a>
    <div class="settings-nav-divider"></div>
    <a href="<?= base_url('logout') ?>" class="settings-nav-link danger">
      <i class="bi bi-box-arrow-right"></i> Keluar
    </a>
  </div>

  <div class="settings-main">
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
  </div>
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
