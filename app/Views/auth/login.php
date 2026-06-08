<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — SoalAI Intelligence</title>
  <meta name="description" content="Masuk ke platform SoalAI">

  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light" style="font-family: 'Inter', sans-serif;">

  <!-- Wrapper for Vertical & Horizontal Centering -->
  <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 py-4">

    <!-- Brand Header -->
    <div class="text-center mb-4">
      <!-- Icon Kotak -->
      <div class="bg-primary text-white rounded-4 d-inline-flex align-items-center justify-content-center shadow-sm mb-3" style="width: 54px; height: 54px;">
        <i class="bi bi-stars fs-3"></i>
      </div>
      <!-- Title & Subtitle -->
      <h1 class="h3 fw-bold text-primary mb-1">Soalin</h1>
      <p class="text-secondary small mb-0">Platform AI untuk Generate Soal Cerdas</p>
    </div>

    <!-- Login Card -->
    <div class="card border-0 shadow-sm rounded-4 w-100" style="max-width: 420px;">
      <div class="card-body p-4 p-md-5">

        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success rounded-3 small py-2 d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div><?= session()->getFlashdata('success') ?></div>
          </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="/login" method="post">
          <?= csrf_field() ?>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label small fw-semibold text-secondary mb-1">Email</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0 text-secondary rounded-start-3 px-3">
                <i class="bi bi-at"></i>
              </span>
              <input type="email" id="email" name="email" class="form-control bg-light border-start-0 ps-0 rounded-end-3 shadow-none" placeholder="nama@sekolah.sch.id" value="<?= old('email') ?? '' ?>" required>
            </div>
          </div>

          <!-- Password -->
          <div class="mb-4">
            <label for="password" class="form-label small fw-semibold text-secondary mb-1">Password</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0 text-secondary rounded-start-3 px-3">
                <i class="bi bi-lock"></i>
              </span>
              <input type="password" id="password" name="password" class="form-control bg-light border-start-0 border-end-0 ps-0 shadow-none" placeholder="••••••••" required>
              <span class="input-group-text bg-light border-start-0 text-secondary rounded-end-3 px-3" style="cursor: pointer;" onclick="togglePasswordVisibility()">
                <i class="bi bi-eye" id="eyeIcon"></i>
              </span>
            </div>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold py-2 shadow-sm mb-4">
            Masuk <i class="bi bi-arrow-right ms-1"></i>
          </button>

          <!-- Register  -->
          <div class="text-center small text-secondary">
            Belum punya akun? <a href="/register" class="text-decoration-none fw-semibold">Daftar Sekarang</a>
          </div>
        </form>

      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('bi-eye');
        eyeIcon.classList.add('bi-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('bi-eye-slash');
        eyeIcon.classList.add('bi-eye');
      }
    }

  </script>

</body>
</html>