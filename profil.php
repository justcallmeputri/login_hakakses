<?php
require 'auth.php';
cekLogin();
require 'config.php';

$success = '';
$error = '';
$userId = $_SESSION['user_id'];

// Proses Update Profil / Password (Logika Asli Dipertahankan)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_nama'])) {
        $namaBaru = trim($_POST['nama']);
        if (!empty($namaBaru)) {
            $stmt = $koneksi->prepare("UPDATE users SET nama = ? WHERE id = ?");
            $stmt->execute([$namaBaru, $userId]);
            $_SESSION['nama'] = $namaBaru;
            $success = "Nama berhasil diperbarui!";
        } else {
            $error = "Nama tidak boleh kosong!";
        }
    } elseif (isset($_POST['update_password'])) {
        $passwordLama = $_POST['password_lama'];
        $passwordBaru = $_POST['password_baru'];
        
        // Ambil password lama dari DB
        $stmt = $koneksi->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $currentUser = $stmt->fetch();

        if (password_verify($passwordLama, $currentUser['password'])) {
            if (!empty($passwordBaru)) {
                $hashBaru = password_hash($passwordBaru, PASSWORD_DEFAULT);
                $stmt = $koneksi->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->execute([$hashBaru, $userId]);
                $success = "Kata sandi berhasil diubah!";
            } else {
                $error = "Kata sandi baru tidak boleh kosong!";
            }
        } else {
            $error = "Kata sandi lama salah!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - Panel Akun</title>
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
            --input-bg: #0b1120;
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
            --input-bg: #f8fafc;
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

        .form-control {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 0.7rem 1rem;
            border-radius: 10px;
        }

        .form-control:focus {
            background-color: var(--input-bg);
            color: var(--text-primary);
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .text-sec {
            color: var(--text-secondary) !important;
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

        .divider {
            border-color: var(--border-color);
            opacity: 1;
            margin: 2rem 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="dashboard.php">
                <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3">
                    <i class="bi bi-person-badge-fill fs-5"></i>
                </div>
                <span class="fw-bold" style="color: var(--text-primary); font-size: 1.05rem;">Profil Pengguna</span>
            </a>

            <div class="d-flex align-items-center gap-3">
                <!-- Tombol Ganti Tema -->
                <button type="button" class="theme-toggle-btn" id="themeToggle" title="Ganti Tema Tampilan">
                    <i class="bi bi-sun-fill" id="themeIcon"></i>
                </button>

                <!-- Tombol Kembali -->
                <a href="dashboard.php" class="btn btn-outline-primary btn-sm px-3 py-2 rounded-3 fw-semibold d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="custom-card p-4 p-md-5">
                    
                    <!-- Header Profil -->
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--border-color) !important;">
                        <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-4 fs-3">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1"><?= htmlspecialchars($_SESSION['nama']) ?></h3>
                            <div class="d-flex align-items-center gap-2 text-sec small">
                                <span><i class="bi bi-at"></i><?= htmlspecialchars($_SESSION['username']) ?></span>
                                <span>•</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 text-uppercase px-2 py-1">
                                    <?= htmlspecialchars($_SESSION['role']) ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Notifikasi Pesan -->
                    <?php if ($success): ?>
                        <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4" role="alert">
                            <i class="bi bi-check-circle-fill"></i>
                            <div><?= $success ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger d-flex align-items-center gap-2 rounded-3 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div><?= $error ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Form 1: Ubah Nama -->
                    <form method="POST">
                        <h5 class="fw-bold mb-3 d-flex align-items-center gap-2 text-primary">
                            <i class="bi bi-pencil-square"></i>
                            <span>Ubah Nama Pengguna</span>
                        </h5>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($_SESSION['nama']) ?>" required>
                        </div>
                        <button type="submit" name="update_nama" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan Nama
                        </button>
                    </form>

                    <hr class="divider">

                    <!-- Form 2: Ubah Kata Sandi -->
                    <form method="POST">
                        <h5 class="fw-bold mb-3 d-flex align-items-center gap-2 text-warning">
                            <i class="bi bi-shield-lock"></i>
                            <span>Ubah Kata Sandi</span>
                        </h5>
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi Lama</label>
                            <input type="password" name="password_lama" class="form-control" placeholder="••••••••" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi Baru</label>
                            <input type="password" name="password_baru" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" name="update_password" class="btn btn-warning px-4 py-2 rounded-3 fw-semibold text-dark">
                            <i class="bi bi-key me-1"></i> Perbarui Kata Sandi
                        </button>
                    </form>

                </div>
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