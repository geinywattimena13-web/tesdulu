<?php
session_start();
require __DIR__ . '/../../koneksi/koneksi.php';
$title_web = 'Peminjaman';

// Cek login dan akses admin
if (empty($_SESSION['USER'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['USER']['level'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Ambil data jika ada kode booking
if (!empty($_GET['id'])) {
    $kode_booking = $_GET['id'];
    $hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();

    $id_booking = $hasil['id_booking'] ?? null;
    if (!$id_booking) {
        echo '<script>alert("Tidak Ada Data !");window.location="peminjaman.php"</script>';
        exit;
    }

    $hsl = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->fetch();
    $id = $hasil['id_mobil'];
    $isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();
    
    // Check if payment exists
    $c = $koneksi->query("SELECT COUNT(*) as count FROM pembayaran WHERE id_booking = '$id_booking'")->fetch()['count'];
}

include '../layouts/sidebar_admin.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title_web); ?> | Rental Mobil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        #sidebar-wrapper {
            min-width: 250px;
            background: #fff;
            border-right: 1px solid #dee2e6;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
        #main {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
        }
        @media (max-width: 768px) {
            #sidebar-wrapper {
                min-width: 0;
                width: 0;
                overflow: hidden;
            }
            #main {
                margin-left: 0;
            }
        }
        .card-header {
            font-weight: 600;
        }
        .img-bukti {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }
    </style>
</head>
<body>

<div id="main">
    <div class="container-fluid mt-4">
        <div class="card mb-4">
            <div class="card-header text-dark">
                <h5 class="mb-0">Data Booking</h5>
            </div>
            <div class="card-body">
                <form method="get" action="peminjaman.php">
                    <input type="text" class="form-control" name="id" placeholder="Tulis Kode Booking [ENTER]"
                           value="<?= $_GET['id'] ?? '' ?>">
                </form>
            </div>
        </div>

        <?php if (!empty($_GET['id'])): ?>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5>Detail Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($c > 0): ?>
                            <table class="table table-bordered mb-3">
                                <tr>
                                    <td>No Rekening</td>
                                    <td><?= htmlspecialchars($hsl['no_rekening']) ?></td>
                                </tr>
                                <tr>
                                    <td>Atas Nama</td>
                                    <td><?= htmlspecialchars($hsl['nama_rekening']) ?></td>
                                </tr>
                            </table>
                            <?php if (!empty($hsl['bukti_bayar'])): ?>
                                <a href="<?= $url; ?>assets/bukti_bayar/<?= htmlspecialchars($hsl['bukti_bayar']); ?>" 
                                   target="_blank" 
                                   class="btn btn-info btn-block">
                                    <i class="fas fa-eye"></i> Lihat Bukti Bayar
                                </a>
                                <div class="mt-3 text-center">
                                    <img src="<?= $url; ?>assets/bukti_bayar/<?= htmlspecialchars($hsl['bukti_bayar']); ?>" 
                                         alt="Bukti Bayar" 
                                         class="img-bukti"
                                         style="max-height: 200px;">
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning mb-0">Bukti bayar belum diupload.</div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0">Belum melakukan pembayaran.</div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><?= $isi['merk']; ?></h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item <?= $isi['status'] == 'Tersedia' ? 'bg-primary' : 'bg-danger' ?> text-white">
                            <i class="fa <?= $isi['status'] == 'Tersedia' ? 'fa-check' : 'fa-times' ?>"></i>
                            <?= $isi['status'] == 'Tersedia' ? 'Tersedia' : 'Dalam Penyewaan' ?>
                        </li>
                        <li class="list-group-item bg-info text-white"><i class="fa fa-money"></i> Rp. <?= number_format($isi['harga']); ?>/ day</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">Detail Booking & Status Mobil</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="proses.php?id=konfirmasi">
                            <table class="table">
                                <tr><td>Kode Booking</td><td>:</td><td><?= $hasil['kode_booking']; ?></td></tr>
                                <tr><td>KTP</td><td>:</td><td><?= $hasil['ktp']; ?></td></tr>
                                <tr><td>Nama</td><td>:</td><td><?= $hasil['nama']; ?></td></tr>
                                <tr><td>Telepon</td><td>:</td><td><?= $hasil['no_tlp']; ?></td></tr>
                                <tr><td>Tanggal Sewa</td><td>:</td><td><?= $hasil['tanggal']; ?></td></tr>
                                <tr><td>Lama Sewa</td><td>:</td><td><?= $hasil['lama_sewa']; ?> hari</td></tr>
                                <tr><td>Total Harga</td><td>:</td><td>Rp. <?= number_format($hasil['total_harga']); ?></td></tr>
                                <tr>
                                    <td>Status Mobil</td>
                                    <td>:</td>
                                    <td>
                                        <select class="form-control" name="status">
                                            <option value="Tersedia" <?= $isi['status'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia </option>
                                            <option value="Tidak Tersedia" <?= $isi['status'] == 'Tidak Tersedia' ? 'selected' : '' ?>>Dalam Penyewaan</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="id_mobil" value="<?= $isi['id_mobil']; ?>">
                            <button type="submit" class="btn btn-primary float-right">Ubah Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>