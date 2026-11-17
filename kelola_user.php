<?php
require 'auth.php';
cekRole('admin'); // Memastikan hanya admin yang bisa akses
require 'config.php';

// Ambil semua daftar pengguna
$stmt = $koneksi->query("SELECT id, nama, username, role FROM users");
$daftar_user = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Panel Admin</title>
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
            --table-hover: #1a2540;
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
            --table-hover: #f8fafc;
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

        .custom-card {
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--card-shadow);
        }

        .text-sec {
            color: var(--text-secondary) !important;
        }

        /* Kustomisasi Tabel agar Adaptif */
        .table {
            color: var(--text-primary);
            border-color: var(--border-color);
            margin-bottom: 0;
            background-color: transparent;
        }

        .table th {
            background-color: var(--bg-surface-hover);
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: var(--border-color);
            color: var(--text-primary);
            background-color: transparent !important;
        }

        .table-hover tbody tr:hover td {
            background-color: var(--table-hover) !important;
            color: var(--text-primary);
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
            border-color: #3b82f6;
            color: #3b82f6;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="admin.php">
                <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3">
                    <i class="bi bi-people-fill fs-5"></i>
                </div>
                <span class="fw-bold" style="color: var(--text-primary); font-size: 1.05rem;">Panel Admin - Kelola Pengguna</span>
            </a>

            <div class="d-flex align-items-center gap-3">
                <!-- Tombol Ganti Tema -->
                <button type="button" class="theme-toggle-btn" id="themeToggle" title="Ganti Tema Tampilan">
                    <i class="bi bi-sun-fill" id="themeIcon"></i>
                </button>

                <!-- Tombol Kembali -->
                <a href="admin.php" class="btn btn-outline-primary btn-sm px-3 py-2 rounded-3 fw-semibold d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="container py-5">
        <div class="custom-card p-4 p-md-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--border-color) !important;">
                <div>
                    <h3 class="fw-bold mb-1">Daftar Seluruh Pengguna Sistem</h3>
                    <p class="text-sec small mb-0">Kelola dan pantau seluruh akun terdaftar beserta tingkat hak aksesnya.</p>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill fw-semibold align-self-start">
                    <i class="bi bi-shield-lock me-1"></i> Area Khusus Admin
                </span>
            </div>

            <!-- Tabel Data Pengguna -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 35%;">Nama Lengkap</th>
                            <th style="width: 35%;">Username</th>
                            <th style="width: 25%;">Role / Peran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($daftar_user as $index => $u): ?>
                        <tr>
                            <th scope="row" class="text-sec"><?= $index + 1 ?></th>
                            <td class="fw-semibold"><?= htmlspecialchars($u['nama']) ?></td>
                            <td>
                                <span class="text-sec"><i class="bi bi-at"></i><?= htmlspecialchars($u['username']) ?></span>
                            </td>
                            <td>
                                <?php if ($u['role'] === 'admin'): ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 fw-semibold">
                                        <i class="bi bi-shield-fill-check me-1"></i>ADMIN
                                    </span>
                                <?php elseif ($u['role'] === 'petugas'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 fw-semibold">
                                        <i class="bi bi-person-badge-fill me-1"></i>PETUGAS
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 fw-semibold">
                                        <i class="bi bi-mortarboard-fill me-1"></i>SISWA
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Script Pengatur Tema Sinkron dengan Admin -->
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