<?php
$hlm = "SOALin";
if (uri_string() != "") {
  $hlm = ucwords(uri_string());
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $hlm ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url() ?>NiceAdmin/assets/img/favicon.png" rel="icon">
  <link href="<?= base_url() ?>NiceAdmin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-dev.4/dist/quill.snow.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-dev.4/dist/quill.bubble.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url() ?>NiceAdmin/assets/css/style.css" rel="stylesheet">

  <style>
    /* Responsive fix for small laptops */
    @media (min-width: 1200px) and (max-width: 1400px) {
      #main { padding: 15px 18px; }
      .sidebar { width: 260px; padding: 15px; }
      #main, #footer { margin-left: 260px; }
      .sidebar-nav .nav-link { font-size: 0.88rem; padding: 0.6rem 0.9rem; }
    }
    @media (max-width: 1199px) {
      .sidebar { width: 260px; }
    }
    .container-fluid { overflow-x: hidden; }
  </style>

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <?= $this->include('components/header') ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?= $this->include('components/sidebar') ?>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle d-none">
      <h1><?= $hlm ?></h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <?php
          if ($hlm != "Home") {
            ?>
            <li class="breadcrumb-item"><?php echo $hlm ?></li>
            <?php
          }
          ?>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
      <?= $this->renderSection('content') ?>
    </section>

  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <?= $this->include('components/footer') ?>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS (CDN) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url() ?>NiceAdmin/assets/js/main.js"></script>

</body>

</html>