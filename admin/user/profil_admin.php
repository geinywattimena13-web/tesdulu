<?php
session_start();
require __DIR__ . '/../../koneksi/koneksi.php';

$title_web = 'User';

// Cek login dan akses admin
if (empty($_SESSION['USER'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['USER']['level'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$url = "../../";

// Proses update Info Website
if (!empty($_POST['nama_rental'])) {
    $data = [
        htmlspecialchars($_POST["nama_rental"]),
        htmlspecialchars($_POST["telp"]),
        htmlspecialchars($_POST["alamat"]),
        htmlspecialchars($_POST["email"]),
        htmlspecialchars($_POST["no_rek"]),
        1
    ];
    $sql = "UPDATE infoweb SET nama_rental = ?, telp = ?, alamat = ?, email = ?, no_rek = ? WHERE id = ?";
    $row = $koneksi->prepare($sql);
    $row->execute($data);
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data Info Website berhasil diperbarui.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location = window.location.href;
        });
    </script>";
}

// Proses update Profil Admin
if (!empty($_POST['nama_pengguna'])) {
    $id_login = $_SESSION['USER']['id_login'];
    $nama_pengguna = htmlspecialchars($_POST["nama_pengguna"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];

    if (!empty($password)) {
        $password_hash = md5($password);
        $sql = "UPDATE login SET nama_pengguna = ?, username = ?, password = ? WHERE id_login = ?";
        $data = [$nama_pengguna, $username, $password_hash, $id_login];
    } else {
        $sql = "UPDATE login SET nama_pengguna = ?, username = ? WHERE id_login = ?";
        $data = [$nama_pengguna, $username, $id_login];
    }

    $row = $koneksi->prepare($sql);
    $row->execute($data);

    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Profil Admin berhasil diperbarui.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location = window.location.href;
        });
    </script>";
}

// Hitung jumlah booking dengan status sedang di proses
$stmt = $koneksi->prepare("SELECT COUNT(*) FROM booking WHERE konfirmasi_pembayaran = 'sedang di proses'");
$stmt->execute();
$jumlah_notif_booking = $stmt->fetchColumn();

include '../layouts/sidebar_admin.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title_web); ?> | THO-KING RENTAL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #000001ff;
            margin-bottom: 2rem;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.4), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            background: #ffffff;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.4), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: #0056b3;
            color: white;
            font-weight: 600;
            font-size: 1.125rem;
            padding: 1.25rem 1.5rem;
            border: none;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #0056b3;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-primary {
            background: #0056b3;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .container-dashboard {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .container-dashboard {
                padding: 1rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div id="main">
    <div class="container-dashboard">
        <h1 class="page-title">Pengaturan Profil & Website</h1>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-cog me-2"></i>Info Website
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="post">
                            <?php
                                $sql = "SELECT * FROM infoweb WHERE id = 1";
                                $row = $koneksi->prepare($sql);
                                $row->execute();
                                $edit = $row->fetch(PDO::FETCH_OBJ);
                            ?>
                            <div class="form-group">
                                <label for="nama_rental">Nama Rental</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($edit->nama_rental); ?>" name="nama_rental" id="nama_rental" placeholder="Masukkan nama rental">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" value="<?= htmlspecialchars($edit->email); ?>" name="email" id="email" placeholder="email@example.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telp">Telepon</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($edit->telp); ?>" name="telp" id="telp" placeholder="Nomor telepon">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Alamat lengkap rental"><?= htmlspecialchars($edit->alamat); ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="no_rek">Nomor Rekening</label>
                                <textarea class="form-control" name="no_rek" id="no_rek" rows="2" placeholder="Nomor rekening untuk pembayaran"><?= htmlspecialchars($edit->no_rek); ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user-shield me-2"></i>Profil Admin
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="post">
                        <?php
                            $id = $_SESSION["USER"]["id_login"];
                            $sql = "SELECT * FROM login WHERE id_login = ?";
                            $row = $koneksi->prepare($sql);
                            $row->execute(array($id));
                            $edit_profil = $row->fetch(PDO::FETCH_OBJ);
                        ?>
                            <div class="form-group">
                                <label for="nama_pengguna">Nama Pengguna</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($edit_profil->nama_pengguna); ?>" name="nama_pengguna" id="nama_pengguna" placeholder="Nama lengkap">
                            </div>
                            
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" required class="form-control" value="<?= htmlspecialchars($edit_profil->username); ?>" name="username" id="username" placeholder="Username login">
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengubah">
                                <small class="form-text text-muted">Minimal 6 karakter</small>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Profil
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// SweetAlert Logout
$(document).ready(function () {
    $('#btnLogout').click(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: 'Sesi Anda akan diakhiri.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../logout.php';
            }
        });
    });
});
</script>

</body>
</html>
