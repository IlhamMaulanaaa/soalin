<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
.settings-wrap { display: flex; gap: 1.5rem; align-items: flex-start; }
.settings-nav-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 1.25rem 0; width: 230px; flex-shrink: 0; position: sticky; top: 80px; }
.settings-nav-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; padding: 0 1.25rem; margin-bottom: 0.5rem; }
.settings-nav-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.65rem 1.25rem; color: #475569; font-weight: 500; font-size: 0.95rem; text-decoration: none; transition: all 0.2s; border-left: 3px solid transparent; }
.settings-nav-link:hover { background: #f1f5f9; color: #0d47a1; }
.settings-nav-link.active { background: #eff6ff; color: #0d47a1; font-weight: 600; border-left-color: #0d47a1; }
.settings-nav-link i { font-size: 1.05rem; width: 20px; text-align: center; }
.settings-nav-divider { height: 1px; background: #f1f5f9; margin: 0.5rem 0; }
.settings-nav-link.danger { color: #dc2626; }
.settings-nav-link.danger:hover { background: #fff1f2; color: #dc2626; }
.settings-main { flex: 1; }
.setting-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 2rem; margin-bottom: 1.5rem; }
.setting-card-title { font-size: 1.15rem; font-weight: 700; color: #0d47a1; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.6rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9; }
.form-control, .form-select { border-radius: 10px; padding: 10px 14px; border: 1.5px solid #e2e8f0; font-size: 0.95rem; }
.form-control:focus, .form-select:focus { box-shadow: none; border-color: #0d47a1; }
.btn-save { background: #0d47a1; color: #fff; border: none; border-radius: 10px; padding: 10px 22px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-save:hover { background: #08306b; transform: translateY(-1px); }
.btn-danger-outline { background: transparent; color: #dc2626; border: 1.5px solid #dc2626; border-radius: 10px; padding: 10px 22px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-danger-outline:hover { background: #dc2626; color: #fff; }
.apikey-row { display: flex; align-items: center; gap: 0.75rem; background: #f8fafc; border-radius: 12px; padding: 0.875rem 1.25rem; margin-bottom: 0.75rem; border: 1.5px solid #e2e8f0; }
.apikey-row .key-name { font-weight: 600; min-width: 120px; font-size: 0.95rem; }
.apikey-row .key-val { font-family: monospace; color: #64748b; font-size: 0.85rem; flex: 1; }
.apikey-row .key-actions { display: flex; gap: 0.5rem; }
.btn-icon-sm { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; font-size: 0.95rem; transition: all 0.2s; }
.btn-icon-sm.edit { background: #eff6ff; color: #0d47a1; }
.btn-icon-sm.edit:hover { background: #0d47a1; color: #fff; }
.btn-icon-sm.delete { background: #fff1f2; color: #dc2626; }
.btn-icon-sm.delete:hover { background: #dc2626; color: #fff; }
.empty-state { text-align: center; padding: 2.5rem 1rem; color: #94a3b8; }
.empty-state i { font-size: 2.5rem; margin-bottom: 0.75rem; display: block; }
@media (max-width: 768px) { .settings-wrap { flex-direction: column; } .settings-nav-card { width: 100%; position: static; } }
</style>

<div class="settings-wrap">
  <div class="settings-nav-card">
    <div class="settings-nav-title" style="margin-top:0.5rem">Akun</div>
    <a href="<?= base_url('pengaturan/profil') ?>" class="settings-nav-link <?= (uri_string() === 'pengaturan/profil') ? 'active' : '' ?>"><i class="bi bi-person-circle"></i> Edit Profil</a>
    <a href="<?= base_url('pengaturan/sandi') ?>" class="settings-nav-link <?= (uri_string() === 'pengaturan/sandi') ? 'active' : '' ?>"><i class="bi bi-shield-lock"></i> Ganti Sandi</a>
    <div class="settings-nav-divider"></div>
    <div class="settings-nav-title">Konfigurasi</div>
    <a href="<?= base_url('pengaturan/preferensi') ?>" class="settings-nav-link <?= (uri_string() === 'pengaturan/preferensi') ? 'active' : '' ?>"><i class="bi bi-sliders"></i> Preferensi Soal</a>
    <a href="<?= base_url('pengaturan/tampilan') ?>" class="settings-nav-link <?= (uri_string() === 'pengaturan/tampilan') ? 'active' : '' ?>"><i class="bi bi-palette"></i> Tampilan</a>
    <a href="<?= base_url('pengaturan/api-key') ?>" class="settings-nav-link <?= (uri_string() === 'pengaturan/api-key') ? 'active' : '' ?>"><i class="bi bi-key"></i> API Key</a>
    <div class="settings-nav-divider"></div>
    <a href="<?= base_url('logout') ?>" class="settings-nav-link danger"><i class="bi bi-box-arrow-right"></i> Keluar</a>
  </div>

  <div class="settings-main">
    <!-- Tambah API Key -->
    <div class="setting-card">
      <div class="setting-card-title"><i class="bi bi-plus-circle"></i> Tambah API Key</div>
      <?php if (session()->getFlashdata('api_success')): ?>
        <div class="alert alert-success border-0 rounded-3 mb-3"><?= session()->getFlashdata('api_success') ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('api_error')): ?>
        <div class="alert alert-danger border-0 rounded-3 mb-3"><?= session()->getFlashdata('api_error') ?></div>
      <?php endif; ?>
      <form action="<?= base_url('pengaturan/api-key/store') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold">Nama Key</label>
            <input type="text" name="key_name" class="form-control" placeholder="cth: Groq Production" required>
          </div>
          <div class="col-md-8">
            <label class="form-label fw-semibold">API Key</label>
            <input type="text" name="api_key" class="form-control" placeholder="sk-xxxxxxxxxxxxxxxxxxxx" required>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-save"><i class="bi bi-plus-lg me-1"></i> Simpan API Key</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Daftar API Key -->
    <div class="setting-card">
      <div class="setting-card-title"><i class="bi bi-list-ul"></i> API Key Tersimpan</div>
      <?php if (!empty($apiKeys)): ?>
        <?php foreach ($apiKeys as $key): ?>
        <div class="apikey-row">
          <span class="key-name"><?= esc($key['key_name']) ?></span>
          <span class="key-val"><?= esc(substr($key['api_key'], 0, 8)) ?>••••••••••••••••••••</span>
          <div class="key-actions">
            <a href="<?= base_url('pengaturan/api-key/edit/' . $key['id']) ?>" class="btn-icon-sm edit" title="Edit">
              <i class="bi bi-pencil"></i>
            </a>
            <form action="<?= base_url('pengaturan/api-key/delete/' . $key['id']) ?>" method="POST" onsubmit="return confirm('Hapus API Key ini?')">
              <?= csrf_field() ?>
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit" class="btn-icon-sm delete" title="Hapus"><i class="bi bi-trash"></i></button>
            </form>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="empty-state">
          <i class="bi bi-key"></i>
          <p class="mb-0">Belum ada API Key tersimpan.<br>Tambahkan API Key Groq Anda di atas.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
