<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
.page-title{font-size:28px;font-weight:700;color:#0d47a1;margin-bottom:4px;}
.user-table{font-size:0.9rem;}
.user-table th{color:#64748b;font-weight:600;border-bottom:2px solid #f1f5f9;background:#f8fafc;}
.user-table td{border-bottom:1px solid #f1f5f9;vertical-align:middle;}
.badge-role{display:inline-block;padding:4px 12px;border-radius:30px;font-size:0.75rem;font-weight:700;}
.badge-admin{background:#fef3c7;color:#b45309;}
.badge-user{background:#dcfce7;color:#16a34a;}
.btn-hapus{background:transparent;color:#dc2626;border:1px solid #fecaca;border-radius:8px;padding:4px 12px;font-size:0.8rem;font-weight:600;cursor:pointer;}
.btn-hapus:hover{background:#fee2e2;}
</style>

<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <div class="page-title">Kelola Guru</div>
        <p class="text-muted">Daftar semua guru yang terdaftar di platform.</p>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div><?php endif; ?>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= session()->getFlashdata('success') ?></div><?php endif; ?>

<div class="card" style="border:none;border-radius:18px;box-shadow:0 6px 18px rgba(0,0,0,0.06);overflow:hidden;">
    <div class="table-responsive">
        <table class="table user-table mb-0">
            <thead>
                <tr><th>#</th><th>Nama</th><th>Email</th><th>Role</th><th>Tanggal Daftar</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pengguna.</td></tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($users as $u): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-semibold"><?= esc($u['name'] ?? $u['nama'] ?? '-') ?></td>
                            <td><?= esc($u['email']) ?></td>
                            <td>
                                <?php if ($u['role'] === 'admin'): ?>
                                    <span class="badge-role badge-admin">KEPSEK</span>
                                <?php else: ?>
                                    <span class="badge-role badge-user">GURU</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                            <td>
                                <?php if ($u['id'] != session()->get('user_id')): ?>
                                    <form method="POST" action="<?= base_url('admin/users/hapus/' . $u['id']) ?>" onsubmit="return confirm('Yakin ingin menghapus guru <?= esc($u['name'] ?? $u['email']) ?>? Semua soal-nya akan ikut terhapus.')">
                                        <?= csrf_field() ?>
                                        <button class="btn-hapus"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted" style="font-size:0.8rem;">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
