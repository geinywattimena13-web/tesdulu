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
