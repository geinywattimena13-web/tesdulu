<?php
session_start();
require '../koneksi/koneksi.php';

// Proteksi admin login
if (empty($_SESSION['USER']) || $_SESSION['USER']['level'] != 'admin') {
    echo '<script>alert("Silakan login sebagai admin.");window.location="../login.php";</script>';
    exit;
}

$title_web = 'Dashboard';
$url = "../";

// Proses update info web
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
    echo '<script>alert("Update Data Info Website Berhasil!");window.location="index.php";</script>';
    exit;
}

// Proses update profil admin
if (!empty($_POST['nama_pengguna'])) {
    $data = [
        htmlspecialchars($_POST["nama_pengguna"]),
        htmlspecialchars($_POST["username"]),
        md5($_POST["password"]),
        $_SESSION['USER']['id_login']
    ];
    $sql = "UPDATE login SET nama_pengguna = ?, username = ?, password = ? WHERE id_login = ?";
    $row = $koneksi->prepare($sql);
    $row->execute($data);
    echo '<script>alert("Update Data Profil Berhasil!");window.location="index.php";</script>';
    exit;
}

// Hitung jumlah booking dengan status sedang di proses
$stmt = $koneksi->prepare("SELECT COUNT(*) FROM booking WHERE konfirmasi_pembayaran = 'sedang di proses'");
$stmt->execute();
$jumlah_notif_booking = $stmt->fetchColumn();

include '../admin/layouts/sidebar_admin.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../../assets/image/Logo Tab Rental Mobil.png" type="image/png">
    <title><?= $title_web; ?> - THO-KING RENTAL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>
<style>
body {
    background-color: #ffffffff;
    font-family: 'Inter', sans-serif;
}

.card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.24), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    background: #ffffffff;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.stats-card {
    position: relative;
    padding: 1.5rem;
    border-radius: 16px;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: #0056b3;
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 1rem;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stats-label {
    color: #000000ff;
    font-size: 0.875rem;
    font-weight: 500;
}

.chart-container {
    background: #ffffffff;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.36);
}

.chart-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #000000ff;
}

.chart-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f01ffff;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #000000ff;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .stats-number {
        font-size: 1.5rem;
    }
    
    .stats-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
}
</style>

<body>

<div id="main">
    <div class="container-fluid mt-4">
        <h1 class="page-title mb-4">Dashboard Admin</h1>
        
        <div class="row">
            <!-- Total Pengguna -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="stats-icon" style="background: #1f01ffff; color: white;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-number text-primary">
                        <?php
                            $jmlUser = $koneksi->query("SELECT COUNT(*) FROM login WHERE level = 'Pengguna'")->fetchColumn();
                            echo $jmlUser;
                        ?>
                    </div>
                    <div class="stats-label">Total Pengguna</div>
                </div>
            </div>

            <!-- Total Mobil -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="stats-icon" style="background: #dfd700ff; color: white;">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="stats-number text-warning">
                        <?php
                            $jmlMobil = $koneksi->query("SELECT COUNT(*) FROM mobil")->fetchColumn();
                            echo $jmlMobil;
                        ?>
                    </div>
                    <div class="stats-label">Total Mobil</div>
                </div>
            </div>

            <!-- Total Booking -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="stats-icon" style="background: #1fff01ff; color: white;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stats-number text-success">
                        <?php
                            $jmlBooking = $koneksi->query("SELECT COUNT(*) FROM booking")->fetchColumn();
                            echo $jmlBooking;
                        ?>
                    </div>
                    <div class="stats-label">Total Booking</div>
                </div>
            </div>

            <!-- tersedia & Disewa -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="stats-icon" style="background: #5d00ffff; color: white;">
                        <i class="fas fa-car-side"></i>
                    </div>
                    <div class="stats-number text-info">
                        <?php
                            $available = $koneksi->query("SELECT COUNT(*) FROM mobil WHERE status = 'Tersedia'")->fetchColumn();
                            $rented = $koneksi->query("SELECT COUNT(*) FROM mobil WHERE status = 'Tidak Tersedia'")->fetchColumn();
                            echo $available . '/' . $rented;
                        ?>
                    </div>
                    <div class="stats-label">Tersedia / Disewa</div>
                </div>
            </div>

            <!-- Booking Pending -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="stats-icon" style="background: #ff0101ff; color: white;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-number text-danger">
                        <?= $jumlah_notif_booking; ?>
                    </div>
                    <div class="stats-label">Booking Pending</div>
                </div>
            </div>
        </div>

        <!-- Grafik Pemasukan Bulanan -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="chart-container">
                    <div class="chart-header">
                        <h5 class="chart-title mb-0">
                            <i class="fas fa-chart-line mr-2"></i>
                            Grafik Pemasukan Bulanan
                        </h5>
                    </div>
                    <canvas id="grafikPemasukan" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('grafikPemasukan').getContext('2d');

    <?php
    $bulan = [];
    $pemasukan = [];
    for ($i = 1; $i <= 12; $i++) {
        $stmt = $koneksi->prepare("SELECT SUM(total_harga) as total FROM nota WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = YEAR(CURDATE())");
        $stmt->execute([$i]);
        $total = $stmt->fetch()['total'] ?? 0;
        $bulan[] = date('M', mktime(0,0,0,$i,10));
        $pemasukan[] = (int)$total;
    }
    ?>

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($bulan); ?>,
            datasets: [{
                label: 'Pemasukan Bulanan',
                data: <?= json_encode($pemasukan); ?>,
                backgroundColor: 'rgba(37, 99, 235, 0.8)',
                borderColor: 'rgba(37, 99, 235, 1)',
                borderWidth: 0,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>

</body>
</html>