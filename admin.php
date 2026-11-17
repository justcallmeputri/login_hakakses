<?php
require 'auth.php';
cekRole('admin');
require 'config.php';

// Mengambil ringkasan jumlah pengguna dari database untuk statistik dashboard
$stmtTotal = $koneksi->query("SELECT COUNT(*) FROM users");
$totalUser = $stmtTotal->fetchColumn();

$stmtAdmin = $koneksi->query("SELECT COUNT(*) FROM users WHERE role = 'admin'");
$totalAdmin = $stmtAdmin->fetchColumn();

$stmtPetugas = $koneksi->query("SELECT COUNT(*) FROM users WHERE role = 'petugas'");
$totalPetugas = $stmtPetugas->fetchColumn();

$stmtSiswa = $koneksi->query("SELECT COUNT(*) FROM users WHERE role = 'siswa'");
$totalSiswa = $stmtSiswa->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Variabel Warna Tema Gelap (Default) */
        :root[data-theme="dark"] {
            --bg-body: #0b1120;
            --bg-surface: #131c31;
            --bg-surface-hover: #19243e;
            --border-color: #23304d;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent-glow: rgba(59, 130, 246, 0.15);
            --card-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        /* Variabel Warna Tema Terang */
        :root[data-theme="light"] {
            --bg-body: #f1f5f9;
            --bg-surface: #ffffff;
            --bg-surface-hover: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --accent-glow: rgba(37, 99, 235, 0.08);
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

        /* Navbar */
        .navbar-custom {
            background-color: var(--bg-surface);
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
        }

        .brand-badge {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        /* Hero Banner */
        .hero-banner {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem 2.25rem;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #3b82f6, #06b6d4);
        }

        .text-sec {
            color: var(--text-secondary) !important;
        }

        /* Kartu Statistik & Fitur */
        .custom-card {
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #3b82f6;
            background-color: var(--bg-surface-hover);
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

        /* Tombol Switcher Tema */
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
            border-color: #3b82f6;
            color: #3b82f6;
        }

        /* Tombol Outline Adaptif */
        .btn-adaptive-outline {
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            background-color: transparent;
        }

        .btn-adaptive-outline:hover {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3 text-decoration-none" href="admin.php">
                <div class="brand-badge">
                    <i class="bi bi-shield-lock-fill fs-5"></i>
                </div>
                <div>
                    <span class="fw-bold d-block lh-1" style="color: var(--text-primary); font-size: 1.05rem;">Admin Control Panel</span>
                    <small class="text-sec" style="font-size: 0.75rem;">Sistem Manajemen Hak Akses</small>
                </div>
            </a>

            <div class="d-flex align-items-center gap-2 gap-md-3">
                <!-- Info User -->
                <div class="d-none d-md-flex align-items-center gap-2 px-3 py-1 rounded-pill" style="background-color: var(--bg-body); border: 1px solid var(--border-color);">
                    <i class="bi bi-person-check-fill text-primary"></i>
                    <span class="small text-sec">Login sebagai:</span>
                    <strong class="small" style="color: var(--text-primary);"><?= htmlspecialchars($_SESSION['username']) ?></strong>
                </div>

                <!-- Tombol Ganti Tema (Dark / Light) -->
                <button type="button" class="theme-toggle-btn" id="themeToggle" title="Ganti Tema Tampilan">
                    <i class="bi bi-sun-fill" id="themeIcon"></i>
                </button>

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
        <!-- Hero Banner -->
        <div class="hero-banner mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill mb-3 fw-semibold">
                        <i class="bi bi-stars me-1"></i> Hak Akses Penuh (Administrator)
                    </span>
                    <h1 class="fw-bold mb-2" style="font-size: 1.85rem;">Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?></h1>
                    <p class="text-sec mb-0" style="line-height: 1.6;">
                        Anda memiliki kewenangan penuh untuk memantau statistik pengguna, mengelola hak akses peran (Admin, Petugas, dan Siswa), serta memperbarui keamanan profil akun Anda.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="p-3 rounded-3 d-inline-block text-start" style="background-color: var(--bg-body); border: 1px solid var(--border-color);">
                        <small class="text-sec d-block">Status Sesi Aktif</small>
                        <span class="fw-semibold text-success"><i class="bi bi-circle-fill me-1" style="font-size: 0.55rem;"></i> Terautentikasi & Aman</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Statistik Pengguna -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <div class="custom-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-sec fw-medium">Total Pengguna</small>
                            <h3 class="fw-bold mb-0 mt-1"><?= $totalUser ?></h3>
                        </div>
                        <div class="icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="custom-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-sec fw-medium">Administrator</small>
                            <h3 class="fw-bold mb-0 mt-1"><?= $totalAdmin ?></h3>
                        </div>
                        <div class="icon-box bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-shield-check"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="custom-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-sec fw-medium">Petugas</small>
                            <h3 class="fw-bold mb-0 mt-1"><?= $totalPetugas ?></h3>
                        </div>
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <i class="bi bi-person-badge"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="custom-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-sec fw-medium">Siswa</small>
                            <h3 class="fw-bold mb-0 mt-1"><?= $totalSiswa ?></h3>
                        </div>
                        <div class="icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Kontrol Utama -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="custom-card feature-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Manajemen Pengguna</h5>
                                <small class="text-sec">Kontrol Data & Otorisasi Role</small>
                            </div>
                        </div>
                        <p class="text-sec small mb-4" style="line-height: 1.6;">
                            Lihat daftar lengkap seluruh akun yang terdaftar di database, pantau distribusi hak akses (Admin, Petugas, Siswa), dan pastikan integritas data pengguna.
                        </p>
                    </div>
                    <a href="kelola_user.php" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2">
                        <span>Buka Kelola Pengguna</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="custom-card feature-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="icon-box bg-success bg-opacity-10 text-success">
                                <i class="bi bi-person-gear"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Pengaturan Profil</h5>
                                <small class="text-sec">Identitas & Keamanan Akun</small>
                            </div>
                        </div>
                        <p class="text-sec small mb-4" style="line-height: 1.6;">
                            Perbarui nama tampilan lengkap akun administrator Anda atau lakukan penggantian kata sandi secara berkala untuk menjaga keamanan akses panel.
                        </p>
                    </div>
                    <a href="profil.php" class="btn btn-adaptive-outline w-100 py-2 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-sliders"></i>
                        <span>Kelola Profil & Password</span>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Script Pengatur Tema Dark / Light Mode -->
    <script>
        const htmlElement = document.documentElement;
        const themeToggleBtn = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');

        // Cek preferensi tema yang tersimpan di localStorage (default: dark)
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