<?php $uri = uri_string(); ?>
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link <?= ($uri === 'home' || $uri === '') ? '' : 'collapsed' ?>" href="<?= base_url('home') ?>">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?= str_starts_with($uri, 'generate-soal') ? '' : 'collapsed' ?>" href="<?= base_url('generate-soal') ?>">
        <i class="bi bi-cpu"></i>
        <span>Generate Soal</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?= str_starts_with($uri, 'bank-soal') ? '' : 'collapsed' ?>" href="<?= base_url('bank-soal') ?>">
        <i class="bi bi-collection"></i>
        <span>Bank Soal</span>
      </a>
    </li>

    <!-- Pengaturan Dropdown -->
    <li class="nav-item">
      <a class="nav-link <?= str_starts_with($uri, 'pengaturan') ? '' : 'collapsed' ?>"
         data-bs-target="#pengaturan-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gear"></i>
        <span>Pengaturan</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="pengaturan-nav" class="nav-content collapse <?= str_starts_with($uri, 'pengaturan') ? 'show' : '' ?>">
        <li>
          <a href="<?= base_url('pengaturan/profil') ?>" class="<?= ($uri === 'pengaturan/profil') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>Edit Profil</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('pengaturan/sandi') ?>" class="<?= ($uri === 'pengaturan/sandi') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>Ganti Sandi</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('pengaturan/preferensi') ?>" class="<?= ($uri === 'pengaturan/preferensi') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>Preferensi Soal</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('pengaturan/tampilan') ?>" class="<?= ($uri === 'pengaturan/tampilan') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>Tampilan</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('pengaturan/api-key') ?>" class="<?= ($uri === 'pengaturan/api-key') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>API Key</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= base_url('logout') ?>">
        <i class="bi bi-box-arrow-right"></i>
        <span>Keluar</span>
      </a>
    </li>

  </ul>
</aside>