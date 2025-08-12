<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $info_web->nama_rental; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    
    <!-- css index -->
    <link rel="stylesheet" type="text/css" href="./assets/css/footer_user.css">


</head>
<body>
    <div class="footer">
        <div class="container">
            <span class="footer-text">
                Copyright &copy; <?= date('Y');?> <?= $info_web->nama_rental;?>. All rights reserved.
            </span>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']); // untuk mendeteksi halaman aktif
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Mobil THO-KING</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">

    <!-- css index -->
<Style>
            .navbar {
            background-color: #fff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 12px 0;
        }
        .navbar-brand img {
            max-height: 60px;
            transition: all 0.3s;
        }
        .navbar-brand img:hover {
            transform: scale(1.05);
        }
        .brand-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.rem;
            color: #1e6798ff;
            transition: color 0.3s, transform 0.3s;
        }
        .brand-text:hover {
            color: #2c80b4;
            transform: translateY(-2px);
        }
        .nav-link {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: rgba(90, 90, 90, 0.94) !important; /* warna redup default */
            margin: 0 12px;
            position: relative;
            font-size: 1.05rem;
            transition: color 0.3s;
        }
        .nav-item.active .nav-link {
            color: #1e6798ff !important; /* warna terang untuk aktif */
        }
        @media (max-width: 768px) {
            .navbar-brand img { max-height: 50px; }
            .brand-text { font-size: 1.1rem; }
            .nav-link { font-size: 1rem; }
        }

</Style>

</head>

<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container d-flex align-items-center">
        <!-- Logo + Tulisan -->
        <a class="navbar-brand d-flex align-items-center mr-auto" href="dashboard.php">
            <img src="assets/image/logo.jpg" alt="THO-KING RENTAL">
            <span class="ml-2 brand-text">THO-KING RENTAL</span>
        </a>

        <!-- Toggle Mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Navigasi -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="dashboard.php">Beranda</a>
                </li>
                <li class="nav-item <?php echo ($currentPage == 'blog.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="blog.php">Mobil</a>
                </li>
                <?php if(isset($_SESSION['USER'])) { ?>
                    <li class="nav-item <?php echo ($currentPage == 'profil.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="profil.php">Profil</a>
                    </li>
                <?php if(isset($_SESSION['USER'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="nota_pesanan.php" title="Notifikasi Nota Pesanan">
                            <i class="fas fa-bell"></i>
                            <!-- Tambahkan badge merah jika ada notifikasi -->
                            <?php
                            // contoh cek notifikasi dari database
                            require_once 'koneksi/koneksi.php';
                            $id_login = $_SESSION['USER']['id_login'];
                            $notifCount = $koneksi->query("SELECT COUNT(*) FROM nota WHERE id_login='$id_login' AND status='belum_dibaca'")->fetchColumn();
                            if ($notifCount > 0) {
                                echo '<span class="badge badge-danger position-absolute" style="top:0; right:0;">'.$notifCount.'</span>';
                            }
                            ?>
                        </a>
                    </li>
                <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" onclick="return confirm('Apakah anda ingin logout?');" href="admin/logout.php">Logout</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

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

<?php phpinfo(); ?>

<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

if(empty($_SESSION['USER'])) {
    echo '<script>alert("Harap Login");window.location="index.php"</script>';
    exit;
}

$kode_booking = $_GET['id'];
$hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();

$id = $hasil['id_mobil'];
$isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();
?>
<br><br>
<div class="container">
<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body text-center">
                <h5>Pembayaran Dapat Melalui:</h5>
                <hr/>
                <p>BRI 2132131246 A/N Engky</p>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                <form method="post" action="koneksi/proses.php?id=konfirmasi" enctype="multipart/form-data">
                    <table class="table table-borderless">
                        <tr>
                            <td>Kode Booking</td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars($hasil['kode_booking']); ?></td>
                        </tr>
                        <tr>
                            <td>No Rekening</td>
                            <td>:</td>
                            <td><input type="text" name="no_rekening" required class="form-control">
                                <small class="text-muted">Contoh: BRI 1234567890</small></td>
                        </tr>
                        <tr>
                            <td>Atas Nama</td>
                            <td>:</td>
                            <td><input type="text" name="nama" required class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Total yang Harus Dibayar</td>
                            <td>:</td>
                            <td>Rp. <?php echo number_format($hasil['total_harga']); ?></td>
                        </tr>
                        <tr>
                            <td>Upload Bukti Bayar</td>
                            <td>:</td>
                            <td>
                                <input type="file" name="bukti_bayar" accept="image/*,application/pdf" required class="form-control">
                                <small class="text-muted">Format: jpg, png, pdf (max 2MB)</small>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="id_booking" value="<?php echo $hasil['id_booking']; ?>">
                    <button type="submit" class="btn btn-primary float-right">Kirim</button>
                </form>
            </div>
        </div> 
    </div>
</div>
</div>
<br><br><br>
<?php include 'footer.php'; ?>

<?php
session_start();
require 'koneksi/koneksi.php';

if (!isset($_SESSION['USER'])) {
    echo '<script>alert("Silakan login terlebih dahulu."); window.location="login.php";</script>';
    exit;
}

$id_login = $_SESSION['USER']['id_login'];
$nota = $koneksi->prepare("SELECT * FROM nota WHERE id_login=? ORDER BY tanggal DESC");
$nota->execute([$id_login]);
$data = $nota->fetchAll(PDO::FETCH_ASSOC);

// update status menjadi 'dibaca' setelah diakses
$koneksi->prepare("UPDATE nota SET status='dibaca' WHERE id_login=?")->execute([$id_login]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pesanan - THO-KING</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    
    <!-- css index -->
    <!-- <link rel="stylesheet" type="text/css" href="./assets/css/profil.css"> -->

</head>
<body>
<?php include 'header.php'; ?>
<div class="container my-5">
    <h3 class="page-title text-center">
        <i class="fas fa-file-invoice me-2"></i>Nota Pesanan Anda
    </h3>
    
    <?php if ($data): ?>
        <?php foreach ($data as $row): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>Kode Booking: <?= htmlspecialchars($row['kode_booking']); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label"><i class="fas fa-money-bill-wave me-2"></i>Total Harga</div>
                                <div>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label"><i class="fas fa-calendar-alt me-2"></i>Tanggal Nota</div>
                                <div><?= date('d M Y H:i', strtotime($row['tanggal'])); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="info-label me-2"><i class="fas fa-info-circle me-2"></i>Status:</span>
                            <?php if ($row['status'] == 'dibaca'): ?>
                                <span class="badge bg-success badge-status">Dibaca</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark badge-status">Belum Dibaca</span>
                            <?php endif; ?>
                        </div>
                        
                        <a href="cetak_nota.php?id=<?= $row['id_nota']; ?>" 
                        target="_blank" 
                        class="btn btn-print">
                            <i class="fas fa-print me-1"></i> Cetak Nota
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-data">
            <i class="fas fa-file-excel fa-3x mb-3" style="color: #3498db;"></i>
            <h4>Belum ada nota pesanan</h4>
            <p class="text-muted">Anda belum memiliki nota pesanan dari admin</p>
        </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'footer.php'; ?>
</html>

<?php
// File: perawatan.php
require 'header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perawatan & Kondisi Mobil - THO-KING RENTAL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        h2 {
            color: #3498db;
            font-weight: 700;
            margin-bottom: 10px;
        }
        p.description {
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
        }
        .gallery img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .gallery img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Perawatan & Kondisi Mobil</h2>
    <p class="description">
        Kami selalu memastikan mobil dalam kondisi prima melalui perawatan rutin seperti ganti oli, pembersihan interior & eksterior, pengecekan rem, dan perawatan ban. 
        Berikut adalah dokumentasi dari proses perawatan mobil di THO-KING RENTAL.
    </p>

    <div class="gallery">
        <img src="assets/image/background.jpg" alt="Pembersihan eksterior mobil">
        <img src="assets/image/background.jpg" alt="Penggantian oli mesin">
        <img src="assets/image/background.jpg" alt="Pengecekan rem mobil">
        <img src="assets/image/background.jpg" alt="Perawatan interior mobil">
    </div>
</div>
</body>
</html>

<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

if (empty($_SESSION['USER'])) {
    echo '<script>alert("Harap Login");window.location="index.php"</script>';
}

if (!empty($_POST['nama_pengguna'])) {
    // Siapkan data untuk update
    $data = [
        htmlspecialchars($_POST["nama_pengguna"]),
        htmlspecialchars($_POST["username"]),
        htmlspecialchars($_POST["nik"]),
        htmlspecialchars($_POST["no_telepon"]),
        $_SESSION['USER']['id_login']
    ];

    // Cek apakah password diisi
    if (!empty($_POST['password'])) {
        // Jika password diisi, update dengan password baru
        $sql = "UPDATE login SET nama_pengguna = ?, username = ?, password = ?, nik = ?, no_telepon = ? WHERE id_login = ?";
        array_splice($data, 2, 0, md5($_POST["password"])); // Sisipkan password baru
    } else {
        // Jika password tidak diisi, update tanpa password
        $sql = "UPDATE login SET nama_pengguna = ?, username = ?, nik = ?, no_telepon = ? WHERE id_login = ?";
    }

    $row = $koneksi->prepare($sql);
    $row->execute($data);

    echo '<script>alert("Update Data Profil Berhasil!");window.location="profil.php"</script>';
    exit;
}

// Ambil data user
$id = $_SESSION["USER"]["id_login"];
$sql = "SELECT * FROM login WHERE id_login = ?";
$row = $koneksi->prepare($sql);
$row->execute([$id]);
$edit_profil = $row->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - THO-KING</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            padding-top: 80px; /* Sesuaikan dengan tinggi header */
        }
        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }
        .btn-primary {
            background-color: #1f5f89;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
        }
    </style>
</head>
<body>
    <h3 class="page-title text-center">
        <i class="fas fa-file-invoice me-2"></i>Profil
    </h3>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4" style="color:#3498db; font-weight:700;">
                        <i class="fas fa-user-edit"></i> Edit Profil
                    </h4>

                    <form action="" method="post">
                        <div class="form-group mb-3">
                            <label class="form-label" for="nama_pengguna">
                                <i class="fas fa-user"></i> Nama Lengkap
                            </label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($edit_profil->nama_pengguna); ?>" name="nama_pengguna" id="nama_pengguna" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="username">
                                <i class="fas fa-user-circle"></i> Username
                            </label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($edit_profil->username); ?>" name="username" id="username" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="nik">
                                <i class="fas fa-id-card"></i> NIK
                            </label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($edit_profil->nik); ?>" name="nik" id="nik" maxlength="16" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="no_telepon">
                                <i class="fas fa-phone"></i> No. Telepon
                            </label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($edit_profil->no_telepon); ?>" name="no_telepon" id="no_telepon" maxlength="15" required>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="password">
                                <i class="fas fa-lock"></i> Password Baru
                            </label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block py-2">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'footer.php'; ?>
<?php
session_start();
require 'koneksi/koneksi.php';

// Cek login
if (empty($_SESSION['USER'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari session
$id_login = $_SESSION['USER']['id_login'];
$nama_pengguna = $_SESSION['USER']['nama_pengguna'];

// Ambil data dari form
$komentar = $_POST['komentar'];
$rating = $_POST['rating'];

// Insert ke tabel rating
$stmt = $koneksi->prepare("INSERT INTO rating (id_login, nama, komentar, rating, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->execute([$id_login, $nama_pengguna, $komentar, $rating]);

echo "<script>
    alert('Rating berhasil dikirim.');
    window.location='index.php';
</script>";
?>

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Jul 2025 pada 04.59
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thoking_rental`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking`
--

CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL,
  `kode_booking` varchar(255) NOT NULL,
  `id_login` int(11) NOT NULL,
  `id_mobil` int(11) NOT NULL,
  `ktp` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_tlp` varchar(15) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `lama_sewa` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `konfirmasi_pembayaran` varchar(255) NOT NULL,
  `status_admin` enum('belum_dibaca','dibaca') DEFAULT 'belum_dibaca',
  `tgl_input` varchar(255) NOT NULL,
  `bukti_transfer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `booking`
--

INSERT INTO `booking` (`id_booking`, `kode_booking`, `id_login`, `id_mobil`, `ktp`, `nama`, `alamat`, `no_tlp`, `tanggal`, `lama_sewa`, `total_harga`, `konfirmasi_pembayaran`, `status_admin`, `tgl_input`, `bukti_transfer`) VALUES
(13, '1751959959', 9, 16, '8171051307054', 'Zindy Wattimena', 'Hutumuri', '081236252462', '2025-07-10', 1, 300823, 'Belum Bayar', 'belum_dibaca', '2025-07-08', ''),
(14, '1751960910', 4, 16, '81710513070001', 'Geiny Wattimena', 'Hutumuri', '081245397955', '2025-07-10', 1, 300808, 'Belum Bayar', 'belum_dibaca', '2025-07-08', ''),
(15, '1751961490', 11, 8, '81710513070001', 'Leonel Sariwating', 'Batu Meja', '08`236252462', '2025-07-10', 1, 400476, 'Pembayaran di terima', 'belum_dibaca', '2025-07-08', ''),
(16, '1752124021', 5, 34, '817105130704', 'jessy', 'Hutumuri', '08123467848', '2025-07-10', 1, 850398, 'Belum Bayar', 'belum_dibaca', '2025-07-10', ''),
(17, '1752124038', 5, 34, '817105130704', 'jessy', 'Hutumuri', '08123467848', '2025-07-10', 1, 850509, 'Pembayaran diterima', 'belum_dibaca', '2025-07-10', ''),
(18, '1752125582', 9, 34, '817105130704', 'jessy', 'Hutumuri', '08123467848', '2025-07-10', 1, 850755, 'Belum Bayar', 'belum_dibaca', '2025-07-10', ''),
(19, '1752566226', 15, 17, '81711203700002', 'Marthen', 'Hutumuri', '085392076394', '2025-07-16', 2, 700634, 'Pembayaran diterima', 'belum_dibaca', '2025-07-15', ''),
(20, '1752566954', 9, 30, '8171056201050001', 'Zindy Wattimena', 'Hutumuri', '082198019354', '2025-07-16', 1, 350324, 'Belum Bayar', 'belum_dibaca', '2025-07-15', ''),
(21, '1752587219', 15, 35, '81711203700002', 'Marthen', 'Hutumuri', '085392076394', '2025-07-16', 1, 850659, 'Belum Bayar', 'belum_dibaca', '2025-07-15', ''),
(22, '1752587665', 15, 35, '81711203700002', 'Marthen', 'Hutumuri', '085392076394', '2025-07-16', 1, 850730, 'Belum Bayar', 'belum_dibaca', '2025-07-15', ''),
(23, '1752590164', 15, 30, '81711203700002', 'Marthen', 'Hutumuri', '085392076394', '2025-07-16', 1, 350909, 'Belum Bayar', 'belum_dibaca', '2025-07-15', ''),
(24, '1752594880', 15, 14, '81711203700002', 'Marthen', 'Hutumuri', '085392076394', '2025-07-17', 1, 350344, 'Sedang di proses', 'belum_dibaca', '2025-07-15', ''),
(25, '1752598200', 4, 33, '8171051307030001', 'Geiny Wattimena', 'Hutumuri', '081245397955', '2025-07-17', 1, 350865, 'Pembayaran diterima', 'belum_dibaca', '2025-07-15', ''),
(26, '1752598929', 9, 29, '8171056201050001', 'Zindy Wattimena', 'Hutumuri', '082198019354', '2025-07-17', 1, 350766, 'Pembayaran diterima', 'belum_dibaca', '2025-07-15', ''),
(27, '1752643138', 15, 26, '81711203700002', 'Marthen', 'Hutumuri', '085392076394', '2025-07-17', 1, 350545, 'Sedang di proses', 'belum_dibaca', '2025-07-16', ''),
(28, '1752654209', 16, 22, '8171111200000211', 'Putri', 'Bos Silale', '082256066079', '2025-07-17', 1, 650734, 'Pembayaran diterima', 'belum_dibaca', '2025-07-16', ''),
(29, '1752657553', 9, 7, '8171056201050001', 'Zindy Wattimena', 'Hutumuri', '082198019354', '2025-07-16', 1, 300558, 'Pembayaran diterima', 'belum_dibaca', '2025-07-16', ''),
(30, '1752669030', 6, 15, '', 'reinzy', 'Hutumuri', '081245397955', '2025-07-16', 1, 350184, 'Pembayaran diterima', 'belum_dibaca', '2025-07-16', ''),
(31, '1752683351', 6, 35, '81712711960001', 'reinzy', 'Hutumuri', '081245397955', '2025-07-16', 1, 850216, 'Pembayaran di terima', 'belum_dibaca', '2025-07-16', ''),
(32, '1752732415', 15, 11, '81711203700002', 'Marthen', 'Hutumuri', '085392076394', '2025-07-17', 1, 350990, 'Pembayaran di terima', 'belum_dibaca', '2025-07-17', ''),
(33, '1752763890', 5, 30, '8171051510030001', 'jessy keiluhu', 'Hutumuri', '0852447825', '2025-07-18', 1, 350950, 'Pembayaran di terima', 'belum_dibaca', '2025-07-17', ''),
(34, '1752771814', 5, 25, '8171051510030001', 'jessy keiluhu', 'hutumuri', '0852447825', '2025-07-18', 1, 350482, 'Pembayaran di terima', 'belum_dibaca', '2025-07-17', ''),
(35, '1752808103', 5, 35, '8171051510030001', 'jessy keiluhu', 'hutumuri', '0852447825', '2025-07-18', 1, 850965, 'Sedang di proses', 'belum_dibaca', '2025-07-18', ''),
(36, '1752819649', 15, 23, '81711203700001', 'Marthen', 'Hutumuri', '085392076394', '2025-07-17', 1, 350888, 'Sedang di proses', 'belum_dibaca', '2025-07-18', ''),
(37, '1752836413', 4, 35, '8171051307030001', 'Geiny Wattimena', 'Hutumuri', '081245397955', '2025-07-17', 1, 850799, 'Pembayaran di terima', 'belum_dibaca', '2025-07-18', ''),
(38, '1752884875', 9, 16, '8171056201050001', 'Zindy Wattimena', 'Hutumuri', '082198019354', '2025-07-17', 2, 700659, 'Pembayaran di terima', 'belum_dibaca', '2025-07-19', ''),
(39, '1752892424', 15, 15, '81711203700001', 'Marthen', 'Hutumuri', '085392076394', '2025-07-19', 3, 1050842, 'Pembayaran di terima', 'belum_dibaca', '2025-07-19', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `infoweb`
--

CREATE TABLE `infoweb` (
  `id` int(11) NOT NULL,
  `nama_rental` varchar(255) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_rek` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `infoweb`
--

INSERT INTO `infoweb` (`id`, `nama_rental`, `telp`, `alamat`, `email`, `no_rek`, `updated_at`) VALUES
(1, 'THO-KING RENTAL', '082248559459 ', 'Jl. Kapten Piere Tendean, Hative Kecil, Kec. Sirimau, Kota Ambon, Maluku', 'cvthoking001@gmail.com', 'BRI 88383838 A/N engki', '2022-01-23 20:57:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id_login`, `nama_pengguna`, `username`, `password`, `nik`, `no_telepon`, `level`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, 'admin'),
(4, 'Geiny Wattimena', 'geiny', '16d222a5fac9d8d7a3ee790f9ee46af5', '8171051307030001', '081245397955', 'pengguna'),
(5, 'jessy keiluhu', 'jessy', 'ba9ce6abc7f38bf0649e9ba9a8de0e0c', '8171051510030002', '0852447825', 'pengguna'),
(6, 'reinzy', 'rey', '96035a131113e89c754800119cdca879', '81712711960001', '081245397955', 'pengguna'),
(7, 'Andhini', 'dini', '9015e536b1458c33bd7f595a7c832b5e', NULL, NULL, 'pengguna'),
(8, 'Giselle Thenu', 'icell', '7ada45f9f36defde8d1dbc4191c5043a', NULL, NULL, 'pengguna'),
(9, 'Zindy Wattimena', 'zindy', '480f529722ed931fb9b14eae7bd10722', '8171056201050001', '082198019354', 'pengguna'),
(10, 'Yensi Wattimena', 'yensi', '5401a6f7c90ed50d912159ddbec0bf6b', NULL, NULL, 'pengguna'),
(11, 'Leonel Sariwating', 'leonel', '5bf13ff38ede45abcae3772a86453444', NULL, NULL, 'pengguna'),
(12, 'Christ', 'christ', 'bfb3206155832047330e55a331d6734e', NULL, NULL, 'pengguna'),
(13, 'Necha Wattimena', 'necha', '6f7cd236cf8ce870cfb8f364915b9600', NULL, NULL, 'pengguna'),
(14, 'Hendrick', 'endiko', 'f165dce6707da9af8b309ea9eafaad5c', NULL, NULL, 'pengguna'),
(15, 'Marthen', 'margo', 'bd8553b8c52e04567c72881ad7d75b4f', '81711203700001', '085392076394', 'pengguna'),
(16, 'Putri', 'puput', '9c721b544e577c85f7e0d19b59824e12', '8171111200000211', '082256066079', 'pengguna'),
(17, 'hasan', 'dino', '9e309c08c5f50d20979d31ddb2b7c892', '8171060520030002', '081234567890', 'pengguna'),
(18, 'wilhelmina', 'yoan', 'a0c5e9b2920016a269c6cce10b582d0f', '8171052311690002', '081234567890', 'pengguna'),
(19, 'johanis', 'jo', 'd54d1702ad0f8326224b817c796763c9', '1111222233334444', '123443211234', 'pengguna'),
(20, 'barcelona', 'barca', '6ba9e07b0b68433151a21635201ff8b4', '1307200313072003', '130720031307200', 'pengguna');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int(11) NOT NULL,
  `no_plat` varchar(255) NOT NULL,
  `merk` varchar(255) NOT NULL,
  `tipe` varchar(100) DEFAULT NULL,
  `harga` int(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `no_plat`, `merk`, `tipe`, `harga`, `deskripsi`, `status`, `gambar`) VALUES
(7, 'DE 1300 AH', 'Avansa All New', 'Avanza All New 24 Jam', 300000, '24 jam', 'Tersedia', '686cd3ed9cdee.png'),
(8, 'DE 1105 AN', 'Avansa All New', 'Avanza All New 24 Jam', 300000, '24 jam', 'Tersedia', '686cd42c9fc81.png'),
(10, 'DE 1019 G', 'Avansa All New', 'Avanza All New 24 Jam', 300000, '24 jam', 'Tersedia', '686cd465baf09.png'),
(11, 'DE 1317 AN', 'Avansa G 2017-2020', 'Avanza G 24 Jam', 350000, '24 jam', 'Tersedia', '686cd4f3e01b1.png'),
(12, 'DE 927 XX', 'Avansa G 2017-2020', 'Avanza G 24 Jam', 350000, 'PRODUK BARU (24 jam)', 'Tersedia', '686cd56810445.png'),
(13, 'DE 141 XX', 'Avansa G 2017-2020', 'Avanza G 24 Jam', 350000, 'PRODUK BARU(24 jam)', 'Tersedia', '686cd7985a633.png'),
(14, 'DE 1514 AP', 'Avansa G 2017-2020', 'Avanza G 24 Jam', 350000, 'baik', 'Tersedia', '686cd655036c5.png'),
(15, 'DE 1929 AH', 'Avansa G 2017-2020', 'Avanza G 24 Jam', 350000, '24 jam', 'Tidak Tersedia', '686cd69b15224.png'),
(16, 'DE 1615 AI', 'Avansa G 2017-2020', 'Avanza G 24 Jam', 350000, '24 jam', 'Tersedia', '686cd70c7c698.png'),
(17, 'DE 1159 AH', 'Avansa G 2017-2020', 'Avanza G 24 Jam', 350000, '24 jam', 'Tersedia', '686cd7518fd5c.png'),
(18, 'DE 817 XX', 'Inova Reborn ', 'Innova Reborn dengan Pengemudi', 900000, 'PRODUK BARU (Pengemudi)', 'Tersedia', '686cd86a3376c.png'),
(19, 'DE 1955 AN', 'Innova Reborn ', 'Innova Reborn 12 Jam', 650000, '12 Jam', 'Tersedia', '686cd8ced1040.png'),
(20, 'DE 1924 LT', 'Innova Reborn ', 'Innova Reborn 12 Jam', 650000, '12 Jam', 'Tersedia', '686cd91c26acf.png'),
(21, 'B 2968 SKW', 'Innova Reborn ', 'Innova Reborn 12 Jam', 650000, '12 Jam', 'Tersedia', '686cd94aab9c4.png'),
(22, 'H 9036 QS', 'Innova Reborn ', 'Innova Reborn 12 Jam', 650000, '12 Jam', 'Tersedia', '686cd9a1d8fc9.png'),
(23, 'DE 1548 B', 'Honda Br-V', 'Honda BR-V dan Mobilio', 350000, '24 jam', 'Tersedia', '686cda77eee6f.png'),
(24, 'DE 1611 AP', 'Honda Br-V', 'Honda BR-V dan Mobilio', 350000, '24 jam', 'Tersedia', '686cdab00b3a7.png'),
(25, 'DE 1082 AO', 'Honda Brio (Manual)', 'Manual', 350000, '24 jam', 'Tersedia', '686cdb6ddb3bb.png'),
(26, 'DE 1926 LD', 'Honda Brio Matic', 'Matic', 350000, '24 jam', 'Tersedia', '686cdbd7183ed.png'),
(29, 'DE 906 AG', 'Toyota Yaris Matic', 'Matic', 350000, '24 jam', 'Tersedia', '686cdcbb3eb63.png'),
(30, 'DE 1611 AP', 'Honda Jazz Matic', 'Matic', 350000, '24 jam', 'Tersedia', '686cdd7ec5780.png'),
(31, 'DE 1123 D', 'Mitsubishi Xpander', 'Matic', 350000, '24 jam', 'Tersedia', '686cddf48d664.png'),
(32, 'DE 1830 AP', 'Honda Brio Manual', 'Manual', 350000, '24 jam', 'Tersedia', '686cdf1dbf032.png'),
(33, 'DE 1156 AO', 'Honda Brio (Manual)', 'Manual', 350000, '24 jam', 'Tersedia', '686ce0aa8ef66.png'),
(34, 'DE 1911 AL', 'Honda Jazz Mobil Pengantin', 'Mobil Pengantin', 850000, 'Mobil Pengantin', 'Tersedia', '686ce11eeb270.png'),
(35, 'DE 1926 LD', 'Honda Jazz Mobil Pengantin', 'Mobil Pengantin', 850000, 'Mobil Pengantin', 'Tersedia', '686ce21476762.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL,
  `id_login` int(11) DEFAULT NULL,
  `id_booking` int(11) DEFAULT NULL,
  `kode_booking` varchar(50) DEFAULT NULL,
  `total_harga` bigint(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `status` enum('belum_dibaca','dibaca') DEFAULT 'belum_dibaca'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nota`
--

INSERT INTO `nota` (`id_nota`, `id_login`, `id_booking`, `kode_booking`, `total_harga`, `tanggal`, `status`) VALUES
(1, 16, 28, '1752654209', 650734, '2025-07-16 11:18:08', 'belum_dibaca'),
(2, 9, 29, '1752657553', 300558, '2025-07-16 11:20:41', 'dibaca'),
(3, 9, 29, '1752657553', 300558, '2025-07-16 11:20:47', 'dibaca'),
(4, 6, 30, '1752669030', 350184, '2025-07-16 14:31:59', 'dibaca'),
(5, 5, 33, '1752763890', 350950, '2025-07-17 17:07:01', 'dibaca'),
(6, 5, 34, '1752771814', 350482, '2025-07-17 19:04:33', 'dibaca'),
(7, 6, 31, '1752683351', 850216, '2025-07-18 07:06:15', 'belum_dibaca'),
(8, 4, 37, '1752836413', 850799, '2025-07-18 13:01:40', 'dibaca'),
(9, 9, 38, '1752884875', 700659, '2025-07-19 02:29:01', 'belum_dibaca'),
(10, 15, 39, '1752892424', 1050842, '2025-07-19 04:36:29', 'dibaca');

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket_mobil`
--

CREATE TABLE `paket_mobil` (
  `id_paket` int(11) NOT NULL,
  `tipe` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `paket_mobil`
--

INSERT INTO `paket_mobil` (`id_paket`, `tipe`, `deskripsi`) VALUES
(1, 'Avanza G 24 Jam', 'Paket hemat Avanza G untuk perjalanan dalam kota 24 jam.'),
(2, 'Avanza All New 24 Jam', 'Avanza All New nyaman untuk kebutuhan transportasi keluarga seharian.'),
(3, 'Innova Reborn 12 Jam', 'Innova Reborn mewah untuk kebutuhan bisnis setengah hari.'),
(4, 'Innova Reborn dengan Pengemudi', 'Paket Innova Reborn termasuk pengemudi, lebih aman dan nyaman.'),
(5, 'Honda BR-V dan Mobilio', 'Paket SUV dan MPV untuk kebutuhan keluarga atau wisata.'),
(6, 'Matic', 'Mobil matic yang nyaman untuk perjalanan jarak dekat maupun jauh.'),
(7, 'Manual', 'Mobil manual ekonomis untuk perjalanan harian.'),
(8, 'Mobil Pengantin', 'Mobil pengantin elegan untuk hari spesial Anda.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_booking` int(255) NOT NULL,
  `no_rekening` int(255) NOT NULL,
  `nama_rekening` varchar(255) NOT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `nominal` int(255) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_booking`, `no_rekening`, `nama_rekening`, `bukti_bayar`, `nominal`, `tanggal`, `status`) VALUES
(8, 9, 11223300, 'reinzy', NULL, 0, '2025-07-07', 'Pending'),
(9, 11, 11223300, 'reinzy', NULL, 0, '2025-07-07', 'Pending'),
(10, 12, 11223344, 'Zindy Wattimena', NULL, 0, '2025-07-08', 'Pending'),
(11, 15, 11223344, 'Leonel Sariwating', NULL, 0, '2025-07-08', 'Pending'),
(12, 17, 11223344, 'jessy', NULL, 850509, '2025-07-10', 'Pending'),
(13, 19, 11223344, 'Marthen', NULL, 700634, '2025-07-15', 'Pending'),
(14, 24, 1234567890, 'Marthen', 'bukti_1752594924.jpg', 0, '', 'Pending'),
(15, 25, 130703, 'Geiny Wattimena', 'bukti_1752598226.jpg', 0, '', 'Pending'),
(16, 26, 22012005, 'Zindy Wattimena', 'bukti_1752598979.png', 0, '', 'Pending'),
(17, 27, 2147483647, 'Marthen', 'bukti_1752643160.png', 0, '', 'Pending'),
(18, 28, 77889933, 'melkichan', 'bukti_1752654235.png', 0, '', 'Validasi'),
(19, 29, 66779900, 'Zindy Wattimena', 'bukti_1752657584.png', 0, '', 'Validasi'),
(20, 30, 899900, 'reinzy', 'bukti_1752669074.png', 0, '', 'Validasi'),
(21, 31, 899900, 'reinzy', 'bukti_1752683402.png', 0, '', 'Pending'),
(22, 32, 123456, 'Marthen', 'bukti_1752732448.png', 0, '', 'Pending'),
(23, 33, 273623633, 'jessy keiluhu', 'bukti_1752763911.png', 0, '', 'Validasi'),
(24, 34, 11223344, 'Marthen', 'bukti_1752771829.png', 0, '', 'Validasi'),
(25, 36, 11223344, 'Marthen', 'bukti_1752819663.png', 0, '', 'Pending'),
(26, 37, 4545454, 'Geiny Wattimena', 'bukti_1752836430.png', 0, '', 'Pending'),
(27, 38, 4545454, 'Zindy Wattimena', 'bukti_1752884903.png', 0, '', 'Validasi'),
(28, 39, 12345677, 'Marthen', 'bukti_1752892538.png', 0, '', 'Pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `kode_booking` varchar(255) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `denda` int(255) NOT NULL,
  `status_pengembalian` enum('belum_kembali','sudah_kembali','jatuh_tempo') DEFAULT 'belum_kembali'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rating`
--

INSERT INTO `rating` (`id`, `nama`, `komentar`, `rating`, `created_at`) VALUES
(1, 'Geiny Wattimena', 'bagus', 5, '2025-07-18 20:11:01'),
(2, 'jessy', 'mantap', 5, '2025-07-18 20:21:47'),
(3, 'dini', 'mantap', 4, '2025-07-18 20:28:22'),
(4, 'margo', 'keren', 5, '2025-07-18 20:33:42'),
(5, 'zindy', 'lebih baik lagi', 5, '2025-07-18 20:35:04'),
(6, 'christ', 'ya', 5, '2025-07-18 20:38:01'),
(7, 'christ', 'ya', 5, '2025-07-18 20:38:11'),
(8, 'christ', 'ya', 4, '2025-07-18 20:38:25'),
(9, 'endiko', 'bagus', 5, '2025-07-18 20:40:05'),
(10, 'barca', 'viscaaa', 5, '2025-07-18 20:54:06'),
(11, 'jessy', 'toppp', 5, '2025-07-18 21:05:04'),
(12, 'necha', 'kembangkan', 5, '2025-07-18 21:29:22');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `idx_booking_id` (`id_booking`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indeks untuk tabel `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`),
  ADD KEY `idx_mobil_id` (`id_mobil`);

--
-- Indeks untuk tabel `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `id_login` (`id_login`),
  ADD KEY `id_booking` (`id_booking`);

--
-- Indeks untuk tabel `paket_mobil`
--
ALTER TABLE `paket_mobil`
  ADD PRIMARY KEY (`id_paket`),
  ADD UNIQUE KEY `tipe` (`tipe`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `idx_pembayaran_id` (`id_pembayaran`);

--
-- Indeks untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `paket_mobil`
--
ALTER TABLE `paket_mobil`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`),
  ADD CONSTRAINT `nota_ibfk_2` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id_booking`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

<?php
// File: all_ratings.php
session_start();
require 'koneksi/koneksi.php';
require 'header.php';

// Ambil semua data rating terbaru
$ratings_stmt = $koneksi->prepare("SELECT * FROM rating ORDER BY created_at DESC");
$ratings_stmt->execute();
$ratings = $ratings_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Rating Pengguna - THO-KING RENTAL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .rating-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 16px;
        }
        .rating-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .rating-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .rating-card strong {
            color: #2c3e50;
            font-size: 1.1em;
        }
        .rating-card span {
            color: #f39c12;
            font-size: 1.2em;   
        }
        .rating-card p {
            margin: 8px 0;
            color: #333;
        }
        .rating-card small {
            color: #7f8c8d;
        }
    </style>
</head>
<body>
<div class="container mt-4 mb-4">
    <h2 class="mb-3" style="color:#3498db; font-weight:700;">Semua Rating & Komentar Pengguna</h2>

    <?php if (count($ratings) === 0): ?>
        <p>Belum ada rating dari pengguna.</p>
    <?php else: ?>
        <div class="rating-grid">
        <?php foreach ($ratings as $row): ?>
            <div class="rating-card">
                <strong><?php echo htmlspecialchars($row['nama']); ?></strong><br>
                <span><?php echo str_repeat('⭐', intval($row['rating'])); ?></span>
                <p><?php echo nl2br(htmlspecialchars($row['komentar'])); ?></p>
                <small><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></small>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>

<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';
if(empty($_SESSION['USER'])) {
    echo '<script>alert("Harap login !");window.location="index.php"</script>';
}
$kode_booking = $_GET['id'];
$hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();

$id = $hasil['id_mobil'];
$isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();

// === Update total harga otomatis saat user buka halaman bayar ===
$lama_sewa = intval($hasil['lama_sewa']);
$harga_mobil = intval($isi['harga']);
$kode_unik = random_int(100, 999);
$total_harga = ($harga_mobil * $lama_sewa) + $kode_unik;

$update = $koneksi->prepare("UPDATE booking SET total_harga = ? WHERE kode_booking = ?");
$update->execute([$total_harga, $kode_booking]);

// Refresh data hasil agar total_harga terbaru ditampilkan
$hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();
?>

<br>
<br>
<div class="container">
<div class="row">
    <div class="col-sm-4">

        <div class="card">
            <div class="card-body text-center">
                <h5>Pembayaran Dapat Melalui :</h5>
                <hr/>
                <p> <?= $info_web->no_rek;?> </p>
            </div>
        </div>
        <br/>
        <div class="card">
                <div class="card-body" style="background:#ddd">
                <h5 class="card-title"><?php echo $isi['merk'];?></h5>
                </div>
                <ul class="list-group list-group-flush">

                <?php if($isi['status'] == 'Tersedia'){?>

                    <li class="list-group-item bg-primary text-white">
                        <i class="fa fa-check"></i> Tersedia
                    </li>

                <?php }else{?>

                    <li class="list-group-item bg-danger text-white">
                        <i class="fa fa-close"></i> Dalam Masa sewa
                    </li>

                <?php }?>
            
            
                <!-- <li class="list-group-item bg-info text-white"><i class="fa fa-check"></i> Free E-toll 50k</li> -->
                <li class="list-group-item bg-dark text-white">
                    <i class="fa fa-money"></i> Rp. <?php echo number_format($isi['harga']);?>/ day
                </li>
                </ul>
            </div>
    </div>
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Kode Booking  </td>
                            <td> :</td>
                            <td><?php echo $hasil['kode_booking'];?></td>
                        </tr>
                        <tr>
                            <td>KTP  </td>
                            <td> :</td>
                            <td><?php echo $hasil['ktp'];?></td>
                        </tr>
                        <tr>
                            <td>Nama  </td>
                            <td> :</td>
                            <td><?php echo $hasil['nama'];?></td>
                        </tr>
                        <tr>
                            <td>telepon  </td>
                            <td> :</td>
                            <td><?php echo $hasil['no_tlp'];?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Sewa </td>
                            <td> :</td>
                            <td><?php echo $hasil['tanggal'];?></td>
                        </tr>
                        <tr>
                            <td>Lama Sewa </td>
                            <td> :</td>
                            <td><?php echo $hasil['lama_sewa'];?> hari</td>
                        </tr>
                        <tr>
                            <td>Total Harga </td>
                            <td> :</td>
                            <td>Rp. <?php echo number_format($hasil['total_harga']);?></td>
                        </tr>
                        <tr>
                            <td>Status </td>
                            <td> :</td>
                            <td><?php echo $hasil['konfirmasi_pembayaran'];?></td>
                        </tr>
                        <tr>
                            <td>Waktu Sewa </td>
                            <td> :</td>
                            <td><?php echo ucfirst($hasil['waktu_sewa']); ?></td>
                        </tr>
                        <tr>
                            <td>Metode Pengambilan</td>
                            <td>:</td>
                                <td>
                                    <?php 
                                    if ($hasil['metode_pengambilan'] == 'diantar') {
                                        echo "Diantar ke Alamat Anda";
                                    } elseif ($hasil['metode_pengambilan'] == 'ambil_sendiri') {
                                        echo "Jemput Di Rental";
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                        </tr>
                    </table>
                <?php if($hasil['konfirmasi_pembayaran'] == 'Belum Bayar'){?>
                    <a href="konfirmasi.php?id=<?php echo $kode_booking;?>" 
                    class="btn btn-primary float-right">Konfirmasi Pembayaran</a>
                <?php }?>
               
           </div>
         </div> 
    </div>
</div>
</div>
<br>
<br>
<br>

<?php include 'footer.php';?>
<?php
session_start();
require 'koneksi/koneksi.php';
$title_web = 'Paket Mobil';

include 'header.php';

// Ambil semua paket untuk dropdown
$paket_stmt = $koneksi->query("SELECT * FROM paket_mobil ORDER BY id_paket ASC");
$paket_list_all = $paket_stmt->fetchAll(PDO::FETCH_ASSOC);

// Cek apakah user memilih filter paket
$filter_tipe = $_GET['tipe'] ?? '';

if (!empty($filter_tipe)) {
    // Jika filter aktif, hanya ambil paket dengan tipe tersebut
    $paket_stmt = $koneksi->prepare("SELECT * FROM paket_mobil WHERE tipe = ? ORDER BY id_paket ASC");
    $paket_stmt->execute([$filter_tipe]);
} else {
    // Jika tidak, ambil semua paket
    $paket_stmt = $koneksi->query("SELECT * FROM paket_mobil ORDER BY id_paket ASC");
}
$paket_list = $paket_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
.section-title {
    font-weight: 600;
    border-left: 5px solid #007bff;
    padding-left: 10px;
    margin-top: 40px;
    font-size: 18px;
}

/* Responsif untuk layar kecil */
@media (max-width: 768px) {
    .section-title {
        font-size: 16px;
        margin-top: 25px;
    }
    .card-img-top {
        height: 140px; /* lebih rendah biar muat di HP */
    }
    .card-title {
        font-size: 14px;
    }
    .list-group-item {
        font-size: 13px;
        padding: 8px;
    }
    .btn {
        font-size: 13px;
        padding: 6px 10px;
    }
    .form-inline label {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
    }
    .form-inline select,
    .form-inline button,
    .form-inline a {
        width: 100%;
        margin-bottom: 8px;
    }
}
.card { border-radius: 12px; overflow: hidden; transition: 0.3s; }
.card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
.card-img-top { height: 180px; object-fit: cover; }
.card-title { font-size: 16px; font-weight: 600; text-align: center; }
</style>

<div class="container mt-4">
    <h2 class="text-center mb-4"><i class="fas fa-layer-group"></i> Paket Mobil</h2>

    <!-- Form Filter -->
    <form method="get" class="form-inline justify-content-center mb-4">
        <label class="mr-2">Filter Paket:</label>
        <select name="tipe" class="form-control mr-2">
            <option value=""> Semua Paket Mobil</option>
            <?php foreach ($paket_list_all as $p): ?>
                <option value="<?= htmlspecialchars($p['tipe']); ?>" <?= ($filter_tipe == $p['tipe']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($p['tipe']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary mr-2">
            <i class="fas fa-search"></i> Cari
        </button>
        <?php if (!empty($filter_tipe)): ?>
            <a href="blog.php" class="btn btn-secondary">
                <i class="fas fa-sync"></i> Reset
            </a>
        <?php endif; ?>
    </form>

    <?php if (count($paket_list) > 0): ?>
        <?php foreach ($paket_list as $paket): ?>
            <div class="section-title">
                <?= htmlspecialchars($paket['tipe']); ?>
            </div>
            <p><?= nl2br(htmlspecialchars($paket['deskripsi'])); ?></p>

            <div class="row">
                <?php
                $mobil_stmt = $koneksi->prepare("SELECT * FROM mobil WHERE tipe = :tipe ORDER BY id_mobil DESC");
                $mobil_stmt->execute([':tipe' => $paket['tipe']]);
                $mobil_list = $mobil_stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <?php if (count($mobil_list) > 0): ?>
                    <?php foreach ($mobil_list as $m): ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card h-100">
                                <img src="assets/image/<?= htmlspecialchars($m['gambar']); ?>" class="card-img-top" alt="<?= htmlspecialchars($m['merk']); ?>">
                                <div class="card-body bg-light text-center">
                                    <h5 class="card-title"><?= htmlspecialchars($m['merk']); ?></h5>
                                    <p class="mb-1">
                                        <span class="badge badge-secondary"><?= htmlspecialchars($m['tipe']); ?></span>
                                    </p>
                                    <p>
                                        <span class="badge badge-<?= $m['status'] == 'Tersedia' ? 'success' : 'danger' ?>">
                                            <?= htmlspecialchars($m['status']); ?>
                                        </span>
                                    </p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-info text-white text-center">
                                        <i class="fa fa-money-bill-wave"></i>
                                        Rp <?= number_format($m['harga'], 0, ',', '.'); ?> / Hari
                                    </li>
                                </ul>
                                <div class="card-body text-center">
                                    <?php if ($m['status'] == 'Tersedia'): ?>
                                        <a href="booking.php?id=<?= $m['id_mobil']; ?>" class="btn btn-success btn-sm mb-1">
                                            <i class="fa fa-car"></i> Pesan Sekarang
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm mb-1" disabled>
                                            <i class="fa fa-ban"></i> Dalam Masa Sewa
                                        </button>
                                    <?php endif; ?>
                                        <a href="detail.php?id=<?php echo $isi['id_mobil'];?>" class="btn btn-info">Detail</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            Tidak ada mobil tersedia pada paket ini saat ini.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center">Belum ada paket mobil yang tersedia.</div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

if (empty($_SESSION['USER'])) {
    echo '<script>alert("Harap login !");window.location="index.php"</script>';
    exit;
}

$id = $_GET['id'];
$isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();

// Ambil waktu_sewa dari paket_mobil berdasarkan tipe mobil
$paket = $koneksi->query("SELECT waktu_sewa FROM paket_mobil WHERE tipe = '{$isi['tipe']}'")->fetch();
$waktu_sewa_options = array_map('trim', explode(',', strtolower($paket['waktu_sewa'])));
?>
<script>
// Masukkan API Key Google Maps milikmu
const GOOGLE_MAPS_API_KEY = "YOUR_API_KEY_HERE";

function ambilLokasi() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Browser Anda tidak mendukung Geolocation.");
    }
}

function showPosition(position) {
    let lat = position.coords.latitude;
    let lng = position.coords.longitude;

    // Panggil Google Geocoding API
    fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${GOOGLE_MAPS_API_KEY}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === "OK") {
                let alamat = data.results[0].formatted_address;
                document.getElementById("alamat").value = alamat;
            } else {
                alert("Gagal mendapatkan alamat dari Google Maps.");
            }
        })
        .catch(err => console.error("Error:", err));
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("Akses lokasi ditolak. Silakan isi alamat secara manual.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Informasi lokasi tidak tersedia.");
            break;
        case error.TIMEOUT:
            alert("Waktu pencarian lokasi habis.");
            break;
        default:
            alert("Terjadi kesalahan saat mengambil lokasi.");
            break;
    }
}
</script>
<br><br>
<div class="container">
    <div class="row">
        <!-- Detail Mobil -->
        <div class="col-sm-4 mb-4">
            <div class="card shadow-sm">
                <img src="assets/image/<?php echo $isi['gambar']; ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                <div class="card-body bg-light">
                    <h5 class="card-title"><?= htmlspecialchars($isi['merk']); ?></h5>
                </div>
                <ul class="list-group list-group-flush">
                    <?php if ($isi['status'] == 'Tersedia') { ?>
                        <li class="list-group-item bg-primary text-white">
                            <i class="fa fa-check"></i> Available
                        </li>
                    <?php } else { ?>
                        <li class="list-group-item bg-danger text-white">
                            <i class="fa fa-close"></i> Not Available
                        </li>
                    <?php } ?>
                    <li class="list-group-item bg-dark text-white">
                        <i class="fa fa-money"></i> Rp. <?= number_format($isi['harga']); ?> / day
                    </li>
                </ul>
            </div>
        </div>

        <!-- Form Booking -->
        <div class="col-sm-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3" style="font-weight:700; color:#3498db;">Form Booking</h4>
                    <form method="post" action="koneksi/proses.php?id=booking">
                        
                        <!-- Nama -->
                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" 
                                   value="<?= htmlspecialchars($_SESSION['USER']['nama_pengguna']); ?>" readonly>
                        </div>

                        <!-- NIK -->
                        <div class="form-group mb-3">
                            <label for="nik">NIK</label>
                            <input type="text" name="ktp" id="nik" class="form-control" 
                                   value="<?= htmlspecialchars($_SESSION['USER']['nik']); ?>" readonly>
                        </div>

                        <!-- Alamat -->
<div class="form-group mb-3">
    <label for="alamat">Alamat</label>
    <div class="input-group">
        <input type="text" name="alamat" id="alamat" required class="form-control" placeholder="Alamat Anda">
        <button type="button" class="btn btn-primary" onclick="ambilLokasi()">📍 Ambil Lokasi Saya</button>
    </div>
    <small class="form-text text-muted">Klik tombol untuk mengisi alamat otomatis dari Google Maps.</small>
</div>

                        <!-- Telepon -->
                        <div class="form-group mb-3">
                            <label for="no_tlp">Telepon</label>
                            <input type="text" name="no_tlp" id="no_tlp" required class="form-control" 
                                   value="<?= htmlspecialchars($_SESSION['USER']['no_telepon']); ?>" placeholder="Nomor Telepon">
                        </div>

                        <!-- Tanggal Sewa -->
                        <div class="form-group mb-3">
                            <label for="tanggal">Tanggal Sewa</label>
                            <input type="date" name="tanggal" id="tanggal" required class="form-control" 
                                   min="<?php echo date('Y-m-d'); ?>" 
                                   max="<?php echo date('Y-m-d', strtotime('+7 days')); ?>">
                        </div>

                        <!-- Waktu Sewa + Lama Sewa -->
                        <?php if (!in_array('pengantin', $waktu_sewa_options) && !in_array('12 jam', $waktu_sewa_options)) { ?>
                            <div class="form-group mb-3">
                                <label for="waktu_sewa">Pilih Waktu Sewa</label>
                                <select name="waktu_sewa" id="waktu_sewa" class="form-control" required>
                                    <option value="">-- Pilih Waktu Sewa --</option>
                                    <?php foreach ($waktu_sewa_options as $option) { ?>
                                        <option value="<?= $option ?>"><?= ucfirst($option) ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Lama Sewa -->
                            <div class="form-group mb-3" id="lamaSewaGroup" style="display:none;">
                                <label for="lama_sewa">Lama Sewa</label>
                                <input type="number" name="lama_sewa" id="lama_sewa" class="form-control" placeholder="(Hari/Minggu/Bulan)">
                            </div>

                                                        <!-- Metode Pengambilan -->
                            <div class="form-group mb-3">
                                <label>Metode Pengambilan Mobil</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="metode_pengambilan" value="diantar">
                                    <label class="form-check-label" for="diantar">Diantar Ke Alamat Anda</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="metode_pengambilan" value="ambil_sendiri">
                                    <label class="form-check-label" for="ambil_sendiri">Jemput Di Rental</label>
                                </div>
                            </div>

                        <?php } elseif (in_array('12 jam', $waktu_sewa_options)) { ?>
                            <input type="hidden" name="waktu_sewa" value="12 jam">
                            <input type="hidden" name="lama_sewa" value="1">
                            <div class="alert alert-info">Mobil ini hanya dapat disewa selama 12 jam.</div>

                        <?php } elseif (in_array('pengantin', $waktu_sewa_options)) { ?>
                            <input type="hidden" name="waktu_sewa" value="pengantin">
                            <input type="hidden" name="lama_sewa" value="1">
                            <div class="alert alert-info">Lanjutkan proses booking dan konfirmasi waktu ke WA THO-KING</div>
                        <?php } ?>

                        <!-- Hidden Data -->
                        <input type="hidden" name="id_login" value="<?= $_SESSION['USER']['id_login']; ?>">
                        <input type="hidden" name="id_mobil" value="<?= $isi['id_mobil']; ?>">
                        <input type="hidden" name="total_harga" value="<?= $isi['harga']; ?>">

                        <!-- Tombol Submit -->
                        <hr>
                        <?php if ($isi['status'] == 'Tersedia') { ?>
                            <button type="submit" class="btn btn-primary w-100" style="font-weight:600;">Booking Sekarang</button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-danger w-100" disabled>Mobil Tidak Tersedia</button>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>

<script>
    const waktuSewaSelect = document.getElementById('waktu_sewa');
    const lamaSewaGroup = document.getElementById('lamaSewaGroup');
    const lamaSewaInput = document.getElementById('lama_sewa');

    if (waktuSewaSelect) {
        waktuSewaSelect.addEventListener('change', function() {
            const value = waktuSewaSelect.value.toLowerCase();
            if (['harian', 'mingguan', 'bulanan'].includes(value)) {
                lamaSewaGroup.style.display = 'block';
                lamaSewaInput.required = true;
            } else {
                lamaSewaGroup.style.display = 'none';
                lamaSewaInput.required = false;
                lamaSewaInput.value = 1;
            }
        });
    }
</script>

<?php include 'footer.php'; ?>

<?php
ob_start();
require 'koneksi/koneksi.php';
require 'assets/tcpdf/tcpdf.php';

session_start();

if (empty($_SESSION['USER'])) {
    echo '<script>alert("Silakan login terlebih dahulu."); window.location="login.php";</script>';
    exit;
}

$id_nota = $_GET['id'] ?? null;
if (!$id_nota) {
    echo '<script>alert("ID nota tidak ditemukan."); window.history.back();</script>';
    exit;
}

$nota = $koneksi->query("SELECT n.*, l.nama_pengguna, b.tanggal as tanggal_sewa, b.lama_sewa, m.merk, m.no_plat 
                        FROM nota n 
                        JOIN login l ON n.id_login = l.id_login 
                        JOIN booking b ON n.kode_booking = b.kode_booking
                        JOIN mobil m ON b.id_mobil = m.id_mobil
                        WHERE n.id_nota = '$id_nota'")->fetch();

if (!$nota) {
    echo '<script>alert("Data nota tidak ditemukan."); window.history.back();</script>';
    exit;
}

$tanggal_sewa = new DateTime($nota['tanggal_sewa']);
$tanggal_kembali = clone $tanggal_sewa;
$tanggal_kembali->add(new DateInterval('P'.$nota['lama_sewa'].'D'));

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(15, 20, 15);
$pdf->AddPage();

$logo = 'assets/image/logo_thoking.jpg';
$ttd  = 'assets/image/signature.jpg'; // Gambar tanda tangan

$html = '
<div style="text-align:center;">
    <img src="'.$logo.'" height="70"><br>
    <h2 style="color:#1e6798; margin-top:5px;">NOTA PESANAN - THO-KING RENTAL</h2>
</div>
<br>
<table cellpadding="8" cellspacing="0" border="1" align="center" width="100%">
    <tr style="background-color:#f5f5f5;">
        <td width="35%"><strong>Nama Pelanggan</strong></td>
        <td width="65%">'.$nota['nama_pengguna'].'</td>
    </tr>
    <tr>
        <td><strong>Kode Booking</strong></td>
        <td>'.$nota['kode_booking'].'</td>
    </tr>
    <tr>
        <td><strong>Merk Mobil</strong></td>
        <td>'.$nota['merk'].'</td>
    </tr>
    <tr>
        <td><strong>Nomor Plat</strong></td>
        <td>'.$nota['no_plat'].'</td>
    </tr>
    <tr>
        <td><strong>Tanggal Sewa</strong></td>
        <td>'.$nota['tanggal_sewa'].'</td>
    </tr>
    <tr>
        <td><strong>Lama Sewa</strong></td>
        <td>'.$nota['lama_sewa'].' hari</td>
    </tr>
    <tr>
        <td><strong>Tanggal Pengembalian</strong></td>
        <td>'.$tanggal_kembali->format('Y-m-d').'</td>
    </tr>
    <tr>
        <td><strong>Total Harga</strong></td>
        <td>Rp '.number_format($nota['total_harga'],0,',','.').'</td>
    </tr>
</table>
<br><br>
<div style="text-align:center; font-size:12px;">
<i color="red">Diwajibkan membawa KTP saat pengambilan mobil<br></i>
    <strong>Ketentuan Pengembalian:</strong><br>
    - Pengembalian mobil sesuai tanggal yang telah ditentukan<br>
    - Mobil harus dikembalikan dalam kondisi sama seperti pada saat pengambilan,<br> 
    apabila ada kerusakan maka menjadi tanggung jawab penyewa<br>
    <br>
    
    Terima kasih telah menggunakan jasa <strong>THO-KING RENTAL</strong>.<br>

</div>
<br><br>
<div style="text-align:right; margin-right:50px;">
    <p>Hormat Kami,</p>
    <img src="'.$ttd.'" height="70"><br>
</div>
';

$pdf->writeHTML($html, true, false, true, false, '');

ob_end_clean();
$pdf->Output('Nota_Booking_'.$nota['kode_booking'].'.pdf', 'I');
?>

<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

// Ambil data mobil untuk ditampilkan
$querymobil = $koneksi->query('SELECT * FROM mobil ORDER BY id_mobil DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THO-KING RENTAL - Beranda</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="./assets/css/dashboard_user.css">
    
    <style>
        :root {
            --primary-color: #ea500eff;
            --secondary-color: #15267c;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --bg-light: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
        }
        
        .hero-section {
            position: relative;
            height: 60vh;
            min-height: 400px;
            overflow: hidden;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        
        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        
        .btn-hero {
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-radius: 15px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .section-title {
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 2rem;
        }
        
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .rating-stars {
            color: #ffc107;
            font-size: 1.2rem;
        }
        
        .map-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .social-links a {
            transition: all 0.3s ease;
            color: var(--text-dark);
        }
        
        .social-links a:hover {
            color: var(--primary-color);
            transform: scale(1.2);
        }
        
        .welcome-alert {
            background: linear-gradient(135deg, #667eea 0%, #1117c0ff 100%);
            color: white;
            border: none;
            border-radius: 15px;
        }
        
        .welcome-alert h4 {
            font-weight: 600;
        }
        .social-links a {
    color: white; /* Warna ikon */
    transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
}

.social-links a:hover {
    transform: scale(1.1); /* Efek membesar sedikit */
}

    </style>
</head>
<body>

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/6282248559459" target="_blank" class="whatsapp-float" aria-label="Chat WhatsApp">
    <i class="fab fa-whatsapp text-white" style="font-size: 30px;"></i>
</a>

<!-- Hero Section -->
<section class="hero-section">
    <img src="assets/image/index.jpg" alt="Background THO-KING RENTAL" class="w-100 h-100" style="object-fit: cover;">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1>THO-KING RENTAL</h1>
            <p>Sewa Mobil Terbaik di Kota Ambon dengan Harga Terjangkau</p>
            <?php if (empty($_SESSION['USER'])): ?>
                <a href="index.php" class="btn btn-primary btn-hero">
                    <i class="fas fa-sign-in-alt me-2"></i>Login & Temukan Mobil Favoritmu
                </a>
            <?php else: ?>
                <a href="blog.php" class="btn btn-success btn-hero">
                    <i class="fas fa-car me-2"></i>Temukan Mobil Favoritmu
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Welcome Message -->
<?php if (!empty($_SESSION['USER'])): ?>
<div class="container mt-4">
    <div class="alert welcome-alert">
        <h4 class="alert-heading mb-0">
            <i class="fas fa-user-circle me-2"></i>
            Selamat Datang, <?php echo htmlspecialchars($_SESSION['USER']['nama_pengguna'] ?? 'Pelanggan'); ?>!
        </h4>
    </div>
</div>
<?php endif; ?>

<!-- About Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body p-4">
                        <h2 class="section-title text-center mb-4">
                            <i class="fas fa-star feature-icon"></i>
                            Nikmati Layanan Rental Mobil Terbaik di Kota Ambon
                        </h2>
                        <p class="lead text-center mb-4">
                            <strong>THO-KING RENTAL</strong> adalah penyedia layanan rental mobil terkemuka di Kota Ambon. 
                            Menyediakan berbagai pilihan mobil matic dan manual berkualitas yang siap memenuhi kebutuhan Anda.
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Harga kompetitif</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Layanan 24 jam</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>2 cabang strategis</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Mobil terawat & bersih</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pengemudi profesional</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Paket fleksibel</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Pilihan Mobil Berkualitas</h2>
        <div class="row g-4">
            <?php
            $features = [
                [
                    'image' => 'assets/image/Inova_rebon_pengemudi.png',
                    'title' => 'Innova Reborn',
                    'description' => 'Mobil keluarga nyaman dengan kapasitas besar dan pengemudi berpengalaman atau lepas kunci'
                ],
                [
                    'image' => 'assets/image/686ce11eeb270.png',
                    'title' => 'Mobil Pengantin',
                    'description' => 'Nikmati hari spesial dengan mobil pengantin berkelas dan dekorasi bunga cantik'
                ],
                [
                    'image' => 'assets/image/686ce0aa8ef66.png',
                    'title' => 'Mobil Manual',
                    'description' => 'Pengalaman berkendara responsif, hemat bahan bakar dengan harga terjangkau'
                ],
                [
                    'image' => 'assets/image/686cd4f3e01b1.png',
                    'title' => 'Mobil Matic',
                    'description' => 'Kenyamanan tanpa repot, cocok untuk perjalanan dalam kota maupun wisata keluarga'
                ]
            ];
            
            foreach($features as $feature): ?>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <img src="<?php echo $feature['image']; ?>" class="card-img-top" alt="<?php echo $feature['title']; ?>" 
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $feature['title']; ?></h5>
                        <p class="card-text text-muted"><?php echo $feature['description']; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Maintenance Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-tools feature-icon"></i>
                        <h3 class="section-title">
                            <a href="perawatan.php" style="text-decoration: none; color: inherit;">Perawatan & Kondisi Mobil</a>
                        </h3>
                        <p class="lead">
                            THO-KING RENTAL selalu memastikan setiap unit mobil dalam kondisi <strong>prima dan terawat</strong>. 
                            Semua kendaraan rutin menjalani servis berkala, pengecekan komponen, dan kebersihan interior & eksterior.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Rating Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body p-4">
                        <h3 class="section-title text-center mb-4">
                            <i class="fas fa-star feature-icon"></i>
                            <a href="all_ratings.php" style="text-decoration: none; color: inherit;">Rating Pengguna</a>
                        </h3>
                        
                        <?php
                        $rating_stmt = $koneksi->query("SELECT AVG(rating) as rata_rata, COUNT(*) as total FROM rating");
                        $rating_data = $rating_stmt->fetch();
                        $rata_rata = number_format($rating_data['rata_rata'], 1);
                        $total_rating = $rating_data['total'];
                        ?>
                        
                        <div class="text-center mb-4">
                            <div class="rating-stars mb-2">
                                <?php echo str_repeat('⭐', round($rata_rata)); ?>
                            </div>
                            <h4><?php echo $rata_rata; ?> / 5.0</h4>
                            <p class="text-muted">Dari <?php echo $total_rating; ?> pengguna</p>
                        </div>

                        <?php if (empty($_SESSION['USER'])): ?>
                            <div class="text-center">
                                <a href="index.php" class="btn btn-primary">Login untuk memberikan rating</a>
                            </div>
                        <?php else: ?>
                            <?php
                            $hasRated = false;
                            if (!empty($_SESSION['USER']['nama_pengguna'])) {
                                $username = $_SESSION['USER']['nama_pengguna'];
                                $stmt = $koneksi->prepare("SELECT * FROM rating WHERE nama = ? LIMIT 1");
                                $stmt->execute([$username]);
                                $existingRating = $stmt->fetch(PDO::FETCH_ASSOC);
                                $hasRated = $existingRating ? true : false;
                            }
                            ?>
                            
                            <?php if ($hasRated): ?>
                                <div class="alert alert-info text-center">
                                    <h5>Terima kasih atas rating Anda!</h5>
                                </div>
                            <?php else: ?>
                                <form action="proses_rating.php" method="POST" id="ratingForm">
                                    <div class="mb-3">
                                        <label class="form-label">Rating Anda</label>
                                        <div class="star-rating text-center" style="font-size: 2rem; cursor: pointer;">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="far fa-star" data-rating="<?php echo $i; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <input type="hidden" name="rating" id="ratingValue" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="komentar" class="form-label">Komentar</label>
                                        <textarea class="form-control" name="komentar" rows="3" 
                                                  placeholder="Bagaimana pengalaman Anda dengan layanan kami?"></textarea>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-paper-plane me-2"></i>Kirim Penilaian
                                        </button>
                                    </div>
                                </form>
                                
                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const stars = document.querySelectorAll('.star-rating i');
                                    const ratingInput = document.getElementById('ratingValue');
                                    
                                    stars.forEach((star, index) => {
                                        star.addEventListener('click', function() {
                                            const rating = index + 1;
                                            ratingInput.value = rating;
                                            
                                            stars.forEach((s, i) => {
                                                s.className = i < rating ? 'fas fa-star text-warning' : 'far fa-star';
                                            });
                                        });
                                        
                                        star.addEventListener('mouseover', function() {
                                            const rating = index + 1;
                                            stars.forEach((s, i) => {
                                                s.className = i < rating ? 'fas fa-star text-warning' : 'far fa-star';
                                            });
                                        });
                                    });
                                    
                                    document.querySelector('.star-rating').addEventListener('mouseleave', function() {
                                        const currentRating = ratingInput.value || 0;
                                        stars.forEach((s, i) => {
                                            s.className = i < currentRating ? 'fas fa-star text-warning' : 'far fa-star';
                                        });
                                    });
                                });
                                </script>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">
            <i class="fas fa-map-marker-alt feature-icon"></i>
            Lokasi Kami
        </h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-3">
                            <i class="fas fa-building text-primary me-2"></i>Cabang Galala
                        </h4>
                        <div class="map-container mb-3">
                            <iframe  src="https://www.google.com/maps?q=Jl.+Kapten+Piere+Tendean,+Hative+Kecil,+Kec.+Sirimau,+Kota+Ambon,+Maluku&output=embed" 
                                  width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                        <p class="text-center">
                            <strong>Jl. Kapten Piere Tendean, Hative Kecil</strong><br>
                            Kec. Sirimau, Kota Ambon, Maluku
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-3">
                            <i class="fas fa-building text-primary me-2"></i>Cabang Passo
                        </h4>
                        <div class="map-container mb-3">
                            <iframe  src="https://www.google.com/maps?q=Jl.+Baru,+Passo,+Kec.+Baguala,+Kota+Ambon,+Maluku&output=embed"
                                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                        <p class="text-center">
                            <strong>Jl. Baru, Passo</strong><br>
                            Kec. Baguala, Kota Ambon, Maluku
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <h3 class="section-title mb-4">
                            <i class="fas fa-phone feature-icon"></i>
                            Hubungi Kami
                        </h3>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-phone text-primary me-2"></i>Telepon</h5>
                                <p>
                                    <a href="tel:6282248559459" class="text-decoration-none">0822-4855-9459 (Engki)</a><br>
                                    <a href="tel:6282299293363" class="text-decoration-none">0811-4792-151 (THO-KING)</a>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-envelope text-primary me-2"></i>Email</h5>
                                <p>
                                    <a href="mailto:cvthoking001@gmail.com" class="text-decoration-none">
                                        cvthoking001@gmail.com
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h5><i class="fas fa-clock text-primary me-2"></i>Jam Operasional</h5>
                            <p class="mb-0">Senin - Minggu: 24 Jam Non-Stop</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Social Media Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h3 class="section-title mb-4">
                    <i class="fas fa-share-alt feature-icon"></i>
                    Ikuti Kami
                </h3>
            <div class="social-links d-flex justify-content-center gap-3">
                        <a href="https://www.facebook.com/share/16bk2xjzwW/"
                        class="btn btn-primary btn-lg rounded-circle shadow-sm" 
                        style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/rental_car_thoking?igsh=M3oxenhnd255YXJ6"
                        class="btn btn-danger btn-lg rounded-circle shadow-sm" 
                        style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.tiktok.com/@cv.thoking?_t=ZS-8yhyOsu6Gwh&_r=1"
                        class="btn btn-dark btn-lg rounded-circle shadow-sm" 
                        style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript -->
<script>
// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add loading animation
window.addEventListener('load', function() {
    document.body.classList.add('loaded');
});

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate_animated', 'animate_fadeInUp');
        }
    });
}, observerOptions);

document.querySelectorAll('.card').forEach(card => {
    observer.observe(card);
});
</script>
</body>
</html>
<?php
    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
    $id = strip_tags($_GET['id']);
    $hasil = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();
?>
<div class="container mt-5">
<div class="row">
    <div class="col-sm-6">
        <img class="card-img-top w-100" 
            style="object-fit:cover;" 
            src="assets/image/<?php echo $hasil['gambar'];?>" alt="">
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $hasil['merk'];?></h4>
                <p class="card-text">
                    Deskripsi :
                    <?php echo $hasil['deskripsi'];?>
                </p>
                <ul class="list-group list-group-flush">
                    <?php if($hasil['status'] == 'Tersedia'){?>
                    <li class="list-group-item bg-primary text-white">
                        <i class="fa fa-check"></i> Available
                    </li>
                    <?php }else{?>
                    <li class="list-group-item bg-danger text-white">
                        <i class="fa fa-close"></i> Not Available
                    </li>
                    <?php }?>
                    <!-- <li class="list-group-item bg-info text-white"><i class="fa fa-check"></i> Free E-toll 50k</li> -->
                    <li class="list-group-item bg-dark text-white">
                        <i class="fa fa-money"></i> Rp. <?php echo number_format($hasil['harga']);?>/ day
                    </li>
                </ul>
                <hr/>
                <center>
                    <a href="booking.php?id=<?php echo $hasil['id_mobil'];?>" class="btn btn-success">Booking now!</a>
                    <a href="index.php" class="btn btn-info">Back</a>
                </center>
            </div>
         </div> 
    </div>
</div>
</div>


<?php include 'footer.php';?>
