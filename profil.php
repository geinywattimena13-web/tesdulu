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