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
  letter-spacing: 1px; color: #94a3b8; padding: 0 1.25rem; margin-bottom: 0.75rem;
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
.settings-nav-link.danger:hover { background: #fff1f2; }

.settings-main { flex: 1; }
.setting-card {
  background: #fff; border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 2rem; margin-bottom: 1.5rem;
}
.setting-card-title {
  font-size: 1.1rem; font-weight: 700; color: #0d47a1; margin-bottom: 1.5rem;
  display: flex; align-items: center; gap: 0.6rem;
  padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9;
}
.form-control, .form-select {
  border-radius: 10px; padding: 10px 14px; border: 1.5px solid #e2e8f0;
  font-size: 0.95rem; transition: border-color 0.2s;
}
.form-control:focus, .form-select:focus {
  box-shadow: none; border-color: #0d47a1; outline: none;
}
.btn-save {
  background: #0d47a1; color: #fff; border: none; border-radius: 10px;
  padding: 10px 20px; font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.btn-save:hover { background: #08306b; transform: translateY(-1px); }
@media (max-width: 768px) {
  .settings-wrap { flex-direction: column; }
  .settings-nav-card { width: 100%; position: static; }
}
</style>

<?php $current = uri_string(); ?>
<div class="settings-wrap">
  <!-- Sidebar Nav -->
  <div class="settings-nav-card">
    <div class="settings-nav-title">Akun</div>
    <a href="<?= base_url('pengaturan/profil') ?>" class="settings-nav-link <?= ($current === 'pengaturan/profil') ? 'active' : '' ?>">
      <i class="bi bi-person-circle"></i> Edit Profil
    </a>
    <a href="<?= base_url('pengaturan/sandi') ?>" class="settings-nav-link <?= ($current === 'pengaturan/sandi') ? 'active' : '' ?>">
      <i class="bi bi-shield-lock"></i> Ganti Sandi
    </a>
    <div class="settings-nav-divider"></div>
    <div class="settings-nav-title">Konfigurasi</div>
    <a href="<?= base_url('pengaturan/preferensi') ?>" class="settings-nav-link <?= ($current === 'pengaturan/preferensi') ? 'active' : '' ?>">
      <i class="bi bi-sliders"></i> Preferensi Soal
    </a>
    <div class="settings-nav-divider"></div>
    <a href="<?= base_url('logout') ?>" class="settings-nav-link danger">
      <i class="bi bi-box-arrow-right"></i> Keluar
    </a>
  </div>

  <!-- Content -->
  <div class="settings-main">
    <?= $this->renderSection('settings_content') ?>
  </div>
</div>

<?= $this->endSection() ?>
