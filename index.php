<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistem Akademik</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .login-banner {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #2563eb;
        }
        .btn-primary {
            background-color: #2563eb;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="card login-card">
                    <div class="row g-0">
                        <!-- Sisi Kiri: Branding / Informasi -->
                        <div class="col-md-6 login-banner d-none d-md-flex">
                            <div>
                                <h2 class="fw-bold mb-3"><i class="bi bi-mortarboard-fill text-primary"></i> Portal Akademik</h2>
                                <p class="text-white-50 mb-0">Sistem manajemen terintegrasi untuk Admin, Petugas, dan Siswa. Masuk dengan akun Anda untuk mengakses dashboard yang sesuai.</p>
                            </div>
                            <div class="mt-5 text-white-50 small">
                                © 2026 Hak Akses Sistem Terpadu
                            </div>
                        </div>

                        <!-- Sisi Kanan: Form Login -->
                        <div class="col-md-6 bg-white p-5">
                            <div class="text-center mb-4">
                                <h3 class="fw-bold text-dark">Masuk</h3>
                                <p class="text-muted small">Silakan masukkan username dan password Anda</p>
                            </div>

                            <?php if (isset($_GET['error'])): ?>
                                <div class="alert alert-danger d-flex align-items-center p-2 mb-4 small" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <div>Username atau password salah!</div>
                                </div>
                            <?php endif; ?>

                            <form action="proses_login.php" method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">USERNAME</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                        <input type="text" name="username" class="form-control bg-light border-start-0 ps-0" placeholder="Masukkan username" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-muted small fw-bold">PASSWORD</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                        <input type="password" name="password" id="passwordInput" class="form-control bg-light border-start-0 border-end-0 ps-0" placeholder="••••••••" required>
                                        <button class="btn btn-light border border-start-0 text-muted" type="button" id="togglePassword">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 shadow-sm">Masuk ke Sistem</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Minimal untuk Fitur Show/Hide Password -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Ubah ikon mata
            if (type === 'text') {
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        });
    </script>
</body>
</html>