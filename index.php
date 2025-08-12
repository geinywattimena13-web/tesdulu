<?php
session_start();
require 'koneksi/koneksi.php';

// Jika sudah login, redirect ke dashboard
if (!empty($_SESSION['USER'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - THO-KING Rental Mobil</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Style langsung -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('assets/image/login.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
        }
        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            overflow: hidden;
            padding: 20px;
        }
        .login-header h2 {
            color: #00416A;
            font-weight: 700;
        }
        .login-header p {
            font-size: 14px;
            color: #555;
        }
        .input-group-text {
            background: #00416A;
            color: #fff;
            border: none;
        }
        .form-control {
            border-radius: 0 8px 8px 0;
            border: 1px solid #ccc;
        }
        .form-control:focus {
            border-color: #00416A;
            box-shadow: none;
        }
        .btn-primary {
            background: #00416A;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background: #003355;
        }
        .form-check-label {
            font-size: 14px;
            color: #333;
        }
        .text-white a {
            color: #FFD700;
        }
        .modal-header {
            background: #00416A;
            color: white;
            border-bottom: none;
        }
        .modal-title {
            font-weight: 600;
        }
        .modal-footer .btn-primary {
            background: #00416A;
        }
        .modal-footer .btn-primary:hover {
            background: #003355;
        }
    </style>
</head>
<body>
    <div class="login-wrapper d-flex align-items-center justify-content-center min-vh-100">
        <div class="login-container">
            <div class="modal-content shadow">
                <div class="login-header text-center mb-4">
                    <h2>THO-KING Rental</h2>
                    <p>Selamat datang kembali! Silakan masuk ke akun Anda</p>
                </div>

                <form method="post" action="koneksi/proses.php?id=login" class="login-form">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="user" id="username" class="form-control" placeholder="Masukkan username" required />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="pass" id="password" class="form-control" placeholder="Masukkan password" required />
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword" aria-label="Toggle password visibility">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" />
                        <label class="form-check-label" for="rememberMe">Ingat saya</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                    </button>

                    <div class="text-center">
                        <p class="mb-2">
                            Belum punya akun? 
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDaftar">Daftar sekarang</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Daftar -->
    <div class="modal fade" id="modalDaftar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded shadow">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>Pendaftaran Akun Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form method="post" action="koneksi/proses.php?id=daftar">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama lengkap Anda" required />
                            </div>
                            <div class="col-md-6">
                                <label for="user" class="form-label">Username</label>
                                <input type="text" name="user" id="user" class="form-control" placeholder="Username unik" required />
                            </div>
                        </div>
                        
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label for="pass" class="form-label">Password</label>
                                <input type="password" name="pass" id="pass" class="form-control" placeholder="Minimal 6 karakter" required />
                            </div>
                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" name="nik" id="nik" class="form-control" placeholder="16 digit NIK" required maxlength="16" pattern="\d{16}" />
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <label for="no_telepon" class="form-label">Nomor Telepon</label>
                            <input type="tel" name="no_telepon" id="no_telepon" class="form-control" placeholder="Nomor WhatsApp aktif" required pattern="\d{10,15}" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        const togglePasswordBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        togglePasswordBtn.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePasswordBtn.querySelector('i').classList.toggle('fa-eye');
            togglePasswordBtn.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Add loading state to login button on submit
        const loginForm = document.querySelector('.login-form');
        loginForm.addEventListener('submit', () => {
            const submitBtn = loginForm.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>
