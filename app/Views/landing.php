<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SOALin – Generate Soal Otomatis dengan AI</title>
  <meta name="description" content="SOALin membantu guru membuat soal berkualitas dalam hitungan detik menggunakan kecerdasan buatan. Upload materi, pilih jenis soal, dan biarkan AI bekerja untuk Anda.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --primary: #2563eb;
      --primary-dark: #1d4ed8;
      --primary-light: #dbeafe;
      --accent: #7c3aed;
      --accent-light: #ede9fe;
      --text: #0f172a;
      --text-muted: #64748b;
      --bg: #f8fafc;
      --white: #ffffff;
      --border: #e2e8f0;
      --shadow: 0 4px 24px rgba(37,99,235,0.10);
      --shadow-lg: 0 20px 60px rgba(37,99,235,0.15);
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      position: fixed; top: 0; left: 0; right: 0; z-index: 100;
      padding: 1rem 2rem;
      display: flex; align-items: center; justify-content: space-between;
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(226,232,240,0.8);
      transition: all 0.3s;
    }
    .navbar-brand {
      font-size: 1.4rem; font-weight: 800; color: var(--primary);
      text-decoration: none; letter-spacing: -0.5px;
      display: flex; align-items: center; gap: 0.5rem;
    }
    .navbar-brand .logo-icon {
      width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary), var(--accent));
      border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white;
      font-size: 1.1rem;
    }
    .navbar-links { display: flex; align-items: center; gap: 0.5rem; }
    .nav-link-item {
      padding: 0.5rem 1rem; color: var(--text-muted); text-decoration: none;
      border-radius: 8px; font-weight: 500; font-size: 0.95rem; transition: all 0.2s;
    }
    .nav-link-item:hover { background: var(--primary-light); color: var(--primary); }
    .btn-nav-login {
      padding: 0.5rem 1.25rem; background: var(--white); color: var(--primary);
      border: 2px solid var(--primary); border-radius: 10px; font-weight: 600;
      font-size: 0.95rem; text-decoration: none; transition: all 0.2s;
    }
    .btn-nav-login:hover { background: var(--primary-light); }
    .btn-nav-register {
      padding: 0.5rem 1.25rem; background: var(--primary); color: white;
      border: 2px solid var(--primary); border-radius: 10px; font-weight: 600;
      font-size: 0.95rem; text-decoration: none; transition: all 0.2s; margin-left: 0.25rem;
    }
    .btn-nav-register:hover { background: var(--primary-dark); border-color: var(--primary-dark); }

    /* ===== HERO ===== */
    .hero {
      min-height: 100vh;
      padding: 8rem 2rem 5rem;
      background: linear-gradient(135deg, #f0f7ff 0%, #faf5ff 50%, #f0f7ff 100%);
      display: flex; align-items: center; justify-content: center;
      text-align: center; position: relative; overflow: hidden;
    }
    .hero::before {
      content: '';
      position: absolute; top: -200px; left: -200px;
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(37,99,235,0.08) 0%, transparent 70%);
      border-radius: 50%; animation: pulse 6s ease-in-out infinite;
    }
    .hero::after {
      content: '';
      position: absolute; bottom: -200px; right: -200px;
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(124,58,237,0.08) 0%, transparent 70%);
      border-radius: 50%; animation: pulse 6s ease-in-out infinite 3s;
    }
    @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.1); } }

    .hero-content { position: relative; z-index: 1; max-width: 760px; }
    .hero-badge {
      display: inline-flex; align-items: center; gap: 0.5rem;
      background: linear-gradient(135deg, var(--primary-light), var(--accent-light));
      color: var(--primary); font-weight: 700; font-size: 0.85rem;
      padding: 0.4rem 1rem; border-radius: 100px;
      margin-bottom: 1.5rem; letter-spacing: 0.5px;
      animation: fadeInDown 0.6s ease;
    }
    .hero h1 {
      font-size: clamp(2.2rem, 6vw, 3.8rem);
      font-weight: 800; line-height: 1.15; letter-spacing: -1.5px;
      color: var(--text); margin-bottom: 1.25rem;
      animation: fadeInUp 0.7s ease 0.1s both;
    }
    .hero h1 .highlight {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .hero p {
      font-size: 1.15rem; color: var(--text-muted); max-width: 580px;
      margin: 0 auto 2rem; line-height: 1.7;
      animation: fadeInUp 0.7s ease 0.2s both;
    }
    .hero-buttons {
      display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;
      animation: fadeInUp 0.7s ease 0.3s both;
    }
    .btn-hero-primary {
      padding: 0.875rem 2rem; background: linear-gradient(135deg, var(--primary), var(--accent));
      color: white; border-radius: 14px; font-weight: 700; font-size: 1rem;
      text-decoration: none; transition: all 0.3s; box-shadow: 0 8px 25px rgba(37,99,235,0.35);
    }
    .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 12px 35px rgba(37,99,235,0.45); color: white; }
    .btn-hero-secondary {
      padding: 0.875rem 2rem; background: var(--white); color: var(--text);
      border-radius: 14px; font-weight: 700; font-size: 1rem;
      text-decoration: none; transition: all 0.3s; border: 2px solid var(--border);
    }
    .btn-hero-secondary:hover { border-color: var(--primary); color: var(--primary); transform: translateY(-3px); }

    .hero-stats {
      display: flex; gap: 2rem; justify-content: center; margin-top: 3.5rem; flex-wrap: wrap;
      animation: fadeInUp 0.7s ease 0.4s both;
    }
    .stat-item { text-align: center; }
    .stat-num { font-size: 1.8rem; font-weight: 800; color: var(--primary); }
    .stat-lbl { font-size: 0.85rem; color: var(--text-muted); font-weight: 500; }

    /* ===== FEATURES ===== */
    .section { padding: 6rem 2rem; }
    .section-tag {
      text-align: center; font-size: 0.85rem; font-weight: 700; color: var(--primary);
      letter-spacing: 1px; text-transform: uppercase; margin-bottom: 0.75rem;
    }
    .section-title {
      text-align: center; font-size: clamp(1.6rem, 4vw, 2.4rem);
      font-weight: 800; letter-spacing: -0.5px; margin-bottom: 0.75rem; color: var(--text);
    }
    .section-subtitle {
      text-align: center; color: var(--text-muted); font-size: 1.05rem;
      max-width: 540px; margin: 0 auto 3.5rem; line-height: 1.7;
    }

    .features-grid {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem; max-width: 1100px; margin: 0 auto;
    }
    .feature-card {
      background: var(--white); border-radius: 20px; padding: 2rem;
      border: 1px solid var(--border); transition: all 0.3s;
      position: relative; overflow: hidden;
    }
    .feature-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      transform: scaleX(0); transition: transform 0.3s; transform-origin: left;
    }
    .feature-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-6px); }
    .feature-card:hover::before { transform: scaleX(1); }
    .feature-icon {
      width: 56px; height: 56px; border-radius: 14px; display: flex;
      align-items: center; justify-content: center; font-size: 1.5rem;
      margin-bottom: 1.2rem;
    }
    .feature-icon.blue { background: var(--primary-light); color: var(--primary); }
    .feature-icon.purple { background: var(--accent-light); color: var(--accent); }
    .feature-icon.green { background: #dcfce7; color: #16a34a; }
    .feature-icon.orange { background: #ffedd5; color: #ea580c; }
    .feature-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.6rem; color: var(--text); }
    .feature-card p { color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; }

    /* ===== HOW IT WORKS ===== */
    .how-section { background: linear-gradient(135deg, #f0f7ff, #faf5ff); }
    .steps { display: flex; gap: 2rem; max-width: 900px; margin: 0 auto; flex-wrap: wrap; }
    .step {
      flex: 1; min-width: 200px; text-align: center; position: relative;
    }
    .step-num {
      width: 56px; height: 56px; border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: white; font-weight: 800; font-size: 1.3rem;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1rem; box-shadow: 0 8px 20px rgba(37,99,235,0.35);
    }
    .step h4 { font-weight: 700; margin-bottom: 0.5rem; }
    .step p { color: var(--text-muted); font-size: 0.95rem; }

    /* ===== CTA ===== */
    .cta-section {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: white; text-align: center; padding: 6rem 2rem;
    }
    .cta-section h2 { font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 800; margin-bottom: 1rem; }
    .cta-section p { font-size: 1.05rem; opacity: 0.85; max-width: 480px; margin: 0 auto 2rem; }
    .btn-cta-white {
      padding: 0.875rem 2.5rem; background: white; color: var(--primary);
      border-radius: 14px; font-weight: 700; font-size: 1rem;
      text-decoration: none; transition: all 0.3s; display: inline-block;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .btn-cta-white:hover { transform: translateY(-3px); box-shadow: 0 12px 35px rgba(0,0,0,0.2); }

    /* ===== FOOTER ===== */
    .footer {
      background: var(--text); color: rgba(255,255,255,0.6); text-align: center;
      padding: 2rem; font-size: 0.9rem;
    }
    .footer span { color: white; font-weight: 600; }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp   { from { opacity: 0; transform: translateY(20px);  } to { opacity: 1; transform: translateY(0); } }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 640px) {
      .navbar-links .nav-link-item { display: none; }
      .hero-stats { gap: 1.5rem; }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <a href="<?= base_url() ?>" class="navbar-brand">
      <div class="logo-icon"><i class="bi bi-lightning-charge-fill"></i></div>
      SOALin
    </a>
    <div class="navbar-links">
      <a href="#fitur" class="nav-link-item">Fitur</a>
      <a href="#cara-kerja" class="nav-link-item">Cara Kerja</a>
      <a href="<?= base_url('login') ?>" class="btn-nav-login">Masuk</a>
      <a href="<?= base_url('register') ?>" class="btn-nav-register">Daftar Gratis</a>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero" id="hero">
    <div class="hero-content">
      <div class="hero-badge">
        <i class="bi bi-stars"></i> Didukung Kecerdasan Buatan
      </div>
      <h1>Buat Soal Ujian <span class="highlight">Berkualitas</span> dalam Hitungan Detik</h1>
      <p>SOALin membantu guru dan pendidik membuat soal otomatis dari materi pelajaran menggunakan AI. Upload dokumen, pilih jenis soal, selesai!</p>
      <div class="hero-buttons">
        <a href="<?= base_url('register') ?>" class="btn-hero-primary">
          <i class="bi bi-rocket-takeoff-fill"></i> Mulai Gratis Sekarang
        </a>
        <a href="#cara-kerja" class="btn-hero-secondary">
          <i class="bi bi-play-circle"></i> Lihat Cara Kerja
        </a>
      </div>
      <div class="hero-stats">
        <div class="stat-item">
          <div class="stat-num">10.000+</div>
          <div class="stat-lbl">Soal Dibuat</div>
        </div>
        <div class="stat-item">
          <div class="stat-num">500+</div>
          <div class="stat-lbl">Guru Aktif</div>
        </div>
        <div class="stat-item">
          <div class="stat-num">&lt; 30 dtk</div>
          <div class="stat-lbl">Waktu Generate</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="section" id="fitur">
    <p class="section-tag">Fitur Unggulan</p>
    <h2 class="section-title">Semua yang Anda Butuhkan</h2>
    <p class="section-subtitle">Dari upload materi hingga soal siap cetak — SOALin menangani semuanya secara otomatis.</p>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon blue"><i class="bi bi-file-earmark-arrow-up"></i></div>
        <h3>Upload Materi</h3>
        <p>Unggah PDF atau dokumen Word materi pelajaran Anda. AI akan membaca dan memahami kontennya secara otomatis.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon purple"><i class="bi bi-cpu"></i></div>
        <h3>Generate Soal AI</h3>
        <p>Buat soal pilihan ganda, essay, atau benar/salah dalam hitungan detik menggunakan model AI mutakhir.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon green"><i class="bi bi-collection"></i></div>
        <h3>Bank Soal</h3>
        <p>Simpan dan kelola semua soal yang sudah dibuat dalam bank soal terorganisir berdasarkan mata pelajaran.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon orange"><i class="bi bi-sliders"></i></div>
        <h3>Kustomisasi Penuh</h3>
        <p>Atur jumlah soal, tingkat kesulitan, jenis soal, dan jenjang kelas sesuai kebutuhan Anda.</p>
      </div>
    </div>
  </section>

  <!-- How It Works -->
  <section class="section how-section" id="cara-kerja">
    <p class="section-tag">Cara Kerja</p>
    <h2 class="section-title">Mudah dalam 3 Langkah</h2>
    <p class="section-subtitle">Tidak perlu keahlian teknis. Siapapun bisa menggunakan SOALin.</p>
    <div class="steps">
      <div class="step">
        <div class="step-num">1</div>
        <h4>Daftar & Masuk</h4>
        <p>Buat akun gratis dan login ke dashboard Anda dalam hitungan menit.</p>
      </div>
      <div class="step">
        <div class="step-num">2</div>
        <h4>Upload Materi</h4>
        <p>Unggah file PDF atau teks materi pelajaran yang ingin dijadikan soal.</p>
      </div>
      <div class="step">
        <div class="step-num">3</div>
        <h4>Generate & Download</h4>
        <p>AI langsung membuat soal. Tinjau hasilnya dan simpan ke bank soal Anda.</p>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section">
    <h2>Siap Menghemat Waktu Membuat Soal?</h2>
    <p>Bergabunglah dengan ratusan guru yang sudah merasakan manfaat SOALin. Gratis untuk memulai.</p>
    <a href="<?= base_url('register') ?>" class="btn-cta-white">
      <i class="bi bi-person-plus-fill"></i> Daftar Sekarang — Gratis
    </a>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; 2025 <span>SOALin</span>. Dibuat dengan ❤️ untuk para pendidik Indonesia.</p>
  </footer>

  <script>
    // Smooth navbar on scroll
    window.addEventListener('scroll', () => {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 30) {
        navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.08)';
      } else {
        navbar.style.boxShadow = 'none';
      }
    });
  </script>
</body>
</html>
