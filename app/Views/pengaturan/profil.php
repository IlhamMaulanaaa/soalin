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
.profile-avatar {
  width: 80px; height: 80px; border-radius: 50%;
  background: linear-gradient(135deg, #0d47a1, #1565c0);
  color: white; display: flex; align-items: center; justify-content: center;
  font-size: 2rem; margin-bottom: 1.5rem;
}
.form-control, .form-select {
  border-radius: 10px; padding: 10px 14px; border: 1.5px solid #e2e8f0;
  font-size: 0.95rem; transition: border-color 0.2s;
}
.form-control:focus, .form-select:focus { box-shadow: none; border-color: #0d47a1; }
.btn-save {
  background: #0d47a1; color: #fff; border: none; border-radius: 10px;
  padding: 10px 22px; font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.btn-save:hover { background: #08306b; transform: translateY(-1px); }
.alert-success-custom {
  background: #f0fdf4; border: 1px solid #86efac; color: #166534;
  border-radius: 10px; padding: 0.75rem 1rem; margin-bottom: 1rem; font-size: 0.9rem;
}
</style>

<div class="setting-card">
  <div class="setting-card-title">
    <i class="bi bi-person-circle"></i> Edit Profil
  </div>
  <?php if (session()->getFlashdata('profil_success')): ?>
    <div class="alert-success-custom"><i class="bi bi-check-circle-fill me-1"></i> <?= session()->getFlashdata('profil_success') ?></div>
  <?php endif; ?>
  <div class="profile-avatar"><i class="bi bi-person-fill"></i></div>
  <form action="<?= base_url('pengaturan/profil') ?>" method="POST">
    <?= csrf_field() ?>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label fw-semibold">Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" value="<?= esc(session()->get('nama') ?? '') ?>" placeholder="Nama lengkap Anda">
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" class="form-control" value="<?= esc(session()->get('email') ?? '') ?>" placeholder="email@contoh.com">
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Nama Sekolah</label>
        <input type="text" name="sekolah" class="form-control" placeholder="Nama sekolah / institusi">
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Mata Pelajaran</label>
        <input type="text" name="mapel" class="form-control" placeholder="Misal: Matematika, IPA, dll">
      </div>
      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-save">
          <i class="bi bi-check2 me-1"></i> Simpan Profil
        </button>
      </div>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
