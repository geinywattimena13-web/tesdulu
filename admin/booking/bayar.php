<?php
require '../../koneksi/koneksi.php';
session_start();

$title_web = 'Konfirmasi';

if (empty($_SESSION['USER'])) {
    echo '<script>alert("Login dulu");window.location="../../login.php"</script>';
    exit;
}

if ($hasil['status_admin'] == 'belum_dibaca') {
    $koneksi->prepare("UPDATE booking SET status_admin = 'sedang diproses' WHERE id_booking = ?")
            ->execute([$hasil['id_booking']]);
}


$kode_booking = $_GET['id'] ?? '';
$hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();
$id_booking = $hasil['id_booking'] ?? null;

if (!$id_booking) {
    echo '<script>alert("Data tidak ditemukan!");window.location="../booking/booking.php"</script>';
    exit;
}

$hsl = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->fetch();
$c = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->rowCount();

$id_mobil = $hasil['id_mobil'];
$mobil = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id_mobil'")->fetch();

$url = "../../"; // Link bukti bayar
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title_web) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        #wrapper {
            display: flex;
            min-height: 100vh;
        }
        #sidebar-wrapper {
            min-width: 250px;
            width: 250px;
            background: #fff;
            border-right: 1px solid #dee2e6;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
        }
        #main-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
            transition: all 0.3s;
        }
        .card-header h5 {
            margin: 0;
        }
        .btn-block {
            font-weight: 600;
        }
        .table td {
            vertical-align: middle;
        }
        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: -250px;
            }
            #main-content {
                margin-left: 0;
                width: 100%;
            }
            #sidebar-wrapper.active {
                margin-left: 0;
            }
            #main-content.active {
                margin-left: 250px;
            }
        }
    </style>
</head>
<?php if (!empty($_GET['status']) && $_GET['status'] == 'berhasil'): ?>
    <div class="alert alert-success">Status berhasil diperbarui.</div>
<?php endif; ?>
<?php if (!empty($_GET['status']) && $_GET['status'] == 'gagal'): ?>
    <div class="alert alert-danger">Gagal memperbarui status.</div>
<?php endif; ?>

<body>

<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <?php include '../layouts/sidebar_admin.php'; ?>
    </div>

    <!-- Main Content -->
    <div id="main-content">
        <div class="container-fluid">
            <div class="row">
                <!-- Detail Pembayaran dan Mobil -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
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
                                <?php else: ?>
                                    <div class="alert alert-warning mb-0">Bukti bayar belum diupload.</div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="alert alert-warning mb-0">Belum melakukan pembayaran.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-info text-white">
                            <h5><?= htmlspecialchars($mobil['merk']) ?></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item <?= $mobil['status'] == 'Tersedia' ? 'bg-success' : 'bg-danger' ?> text-white">
                                <i class="fa <?= $mobil['status'] == 'Tersedia' ? 'fa-check' : 'fa-times' ?>"></i>
                                <?= $mobil['status'] == 'Tersedia' ? 'Tersedia' : 'Dalam Penyewaan' ?>
                            </li>
                            <li class="list-group-item bg-light">
                                <i class="fa fa-money-bill"></i> Rp. <?= number_format($mobil['harga']) ?>/hari
                            </li>
                        </ul>
                                <form method="post" action="proses.php?id=konfirmasi">
                                    <input type="hidden" name="id_booking" value="<?= htmlspecialchars($hasil['id_booking']) ?>">
                                    <select name="status" class="form-control">
                                        <option <?= $hasil['konfirmasi_pembayaran'] == 'Sedang di proses' ? 'selected' : '' ?>>Sedang di proses</option>
                                        <option <?= $hasil['konfirmasi_pembayaran'] == 'Pembayaran di terima' ? 'selected' : '' ?>>Pembayaran di terima</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-block mt-2">
                                        <i class="fas fa-sync"></i> Ubah Status
                                    </button>
                                </form>
                                <a href="kirim_nota.php?id=<?= urlencode($hasil['id_booking']) ?>" 
                                    class="btn btn-warning btn-block mt-2" 
                                    onclick="return confirm('Kirim nota ke pengguna?');">
                                    <i class="fa fa-paper-plane"></i> Kirim Nota Booking
                                </a>
                                </form>
                    </div>
                </div>

                <!-- Detail Booking -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5>Detail Booking</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="proses.php?id=konfirmasi">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Kode Booking</td>
                                        <td><?= htmlspecialchars($hasil['kode_booking']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td><?= htmlspecialchars($hasil['nama']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <td><?= htmlspecialchars($hasil['ktp']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><?= htmlspecialchars($hasil['alamat']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Telepon</td>
                                        <td><?= htmlspecialchars($hasil['no_tlp']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Sewa</td>
                                        <td><?= htmlspecialchars($hasil['tanggal']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Lama Sewa</td>
                                        <td><?= htmlspecialchars($hasil['lama_sewa']) ?> hari</td>
                                    </tr>
                                    <tr>
                                        <td>Total Harga</td>
                                        <td>Rp. <?= number_format($hasil['total_harga']) ?></td>
                                    </tr>
                                    <tr>
                                    <td>Metode Pengambilan</td>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Toggle sidebar for mobile
$(document).ready(function() {
    $('#sidebarToggle').click(function() {
        $('#sidebar-wrapper, #main-content').toggleClass('active');
    });
});
</script>
</body>
</html>