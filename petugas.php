<?php
require 'auth.php';
cekRole('petugas');
require 'config.php';
?>
<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - Portal Akademik</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Variabel Warna Tema Gelap (Default Petugas - Aksen Emerald/Hijau) */
        :root[data-theme="dark"] {
            --bg-body: #0b1120;
            --bg-surface: #131c31;
            --bg-surface-hover: #19243e;
            --border-color: #23304d;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --card-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        /* Variabel Warna Tema Terang */
        :root[data-theme="light"] {
            --bg-body: #f8fafc;
            --bg-surface: #ffffff;
            --bg-surface-hover: #f1f5f9;
            --border-color: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --card-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.06);
        }

        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            transition: background-color 0.25s ease, border-color 0.25s ease, color 0.25s ease;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-primary);
            min-height: 100vh;
        }

        .navbar-custom {
            background-color: var(--bg-surface);
            border-bottom: 1px solid var(--border-color);
        }

        .brand-badge-petugas {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        /* Hero Banner khusus Petugas */
        .hero-banner-petugas {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem 2.25rem;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .hero-banner-petugas::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #10b981, #34d399);
        }

        .text-sec {
            color: var(--text-secondary) !important;
        }

        .custom-card {
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: transform 0.25s ease, border-color 0.25s ease;
        }

        .custom-card:hover {
            transform: translateY(-4px);
            border-color: #10b981;
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .theme-toggle-btn {
            background-color: var(--bg-body);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .theme-toggle-btn:hover {
            border-color: #10b981;
            color: #10b981;
        }
    </style>
</head>
<body>

    <!-- Navbar Petugas -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3 text-decoration-none" href="petugas.php">
                <div class="brand-badge-petugas">
                    <i class="bi bi-person-badge-fill fs-5"></i>
                </div>
                <div>
                    <span class="fw-bold d-block lh-1" style="color: var(--text-primary); font-size: 1.05rem;">Panel Petugas</span>
                    <small class="text-sec" style="font-size: 0.75rem;">Manajemen Data & Operasional</small>
                </div>
            </a>

            <div class="d-flex align-items-center gap-2 gap-md-3">
                <!-- Info User -->
                <div class="d-none d-md-flex align-items-center gap-2 px-3 py-1 rounded-pill" style="background-color: var(--bg-body); border: 1px solid var(--border-color);">
                    <i class="bi bi-person-check-fill text-success"></i>
                    <span class="small text-sec">Petugas:</span>
                    <strong class="small" style="color: var(--text-primary);"><?= htmlspecialchars($_SESSION['username']) ?></strong>
                </div>

                <!-- Tombol Ganti Tema -->
                <button type="button" class="theme-toggle-btn" id="themeToggle" title="Ganti Tema Tampilan">
                    <i class="bi bi-sun-fill" id="themeIcon"></i>
                </button>

                <!-- Tombol Profil -->
                <a href="profil.php" class="btn btn-outline-success btn-sm px-3 py-2 rounded-3 fw-semibold d-flex align-items-center gap-2 text-success border-success">
                    <i class="bi bi-person-gear"></i>
                    <span class="d-none d-sm-inline">Profil</span>
                </a>

                <!-- Tombol Logout -->
                <a href="logout.php" class="btn btn-danger btn-sm px-3 py-2 rounded-3 fw-semibold d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="d-none d-sm-inline">Logout</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="container py-5">
        <!-- Hero Banner Petugas -->
        <div class="hero-banner-petugas mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill mb-3 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Hak Akses: Petugas Sekolah
                    </span>
                    <h1 class="fw-bold mb-2" style="font-size: 1.85rem;">Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?>!</h1>
                    <p class="text-sec mb-0" style="line-height: 1.6;">
                        Anda masuk menggunakan hak akses petugas. Melalui panel ini, Anda dapat mengelola tugas operasional harian serta memperbarui pengaturan kredensial profil Anda dengan aman.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="p-3 rounded-3 d-inline-block text-start" style="background-color: var(--bg-body); border: 1px solid var(--border-color);">
                        <small class="text-sec d-block">Identitas Akun</small>
                        <span class="fw-semibold text-success"><i class="bi bi-shield-fill-check me-1"></i> <?= htmlspecialchars($_SESSION['username']) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Kartu Fitur Petugas -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="custom-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="icon-box bg-success bg-opacity-10 text-success">
                                <i class="bi bi-clipboard2-data-fill"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Pengelolaan Data</h5>
                                <small class="text-sec">Operasional & Layanan Tertentu</small>
                            </div>
                        </div>
                        <p class="text-sec small mb-4" style="line-height: 1.6;">
                            Kelola data operasional harian sesuai dengan kewenangan petugas sekolah yang telah ditentukan dalam sistem aplikasi.
                        </p>
                    </div>
                    <div class="alert alert-success bg-success bg-opacity-10 border-0 text-success small mb-0 py-2">
                        <i class="bi bi-info-circle-fill me-1"></i> Sistem operasional petugas berjalan normal.
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="custom-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-person-gear"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Pengaturan Profil</h5>
                                <small class="text-sec">Identitas & Keamanan Akun</small>
                            </div>
                        </div>
                        <p class="text-sec small mb-4" style="line-height: 1.6;">
                            Perbarui nama lengkap akun petugas Anda atau lakukan perubahan kata sandi secara berkala untuk menjaga keamanan akses panel.
                        </p>
                    </div>
                    <a href="profil.php" class="btn btn-outline-success w-100 py-2 rounded-3 fw-semibold text-success border-success d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-sliders"></i>
                        <span>Kelola Profil & Ubah Sandi</span>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Script Pengatur Tema Sinkron -->
    <script>
        const htmlElement = document.documentElement;
        const themeToggleBtn = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');

        // Sinkronisasi tema dengan localStorage
        const savedTheme = localStorage.getItem('adminTheme') || 'dark';
        applyTheme(savedTheme);

        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            applyTheme(newTheme);
            localStorage.setItem('adminTheme', newTheme);
        });

        function applyTheme(theme) {
            htmlElement.setAttribute('data-theme', theme);
            if (theme === 'dark') {
                themeIcon.classList.remove('bi-moon-stars-fill');
                themeIcon.classList.add('bi-sun-fill');
            } else {
                themeIcon.classList.remove('bi-sun-fill');
                themeIcon.classList.add('bi-moon-stars-fill');
            }
        }
    </script>
</body>
</html> 