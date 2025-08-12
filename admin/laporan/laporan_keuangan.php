<?php
session_start();
require __DIR__ . '/../../koneksi/koneksi.php';
$title_web = 'Laporan Keuangan';

// Authentication check
if (empty($_SESSION['USER'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['USER']['level'] != 'admin') {
    echo '<script>alert("Akses ditolak."); window.location="../index.php";</script>';
    exit;
}

// Hitung jumlah booking dengan status sedang di proses
$stmt = $koneksi->prepare("SELECT COUNT(*) FROM booking WHERE konfirmasi_pembayaran = 'sedang di proses'");
$stmt->execute();
$jumlah_notif_booking = $stmt->fetchColumn();

// Report filters
$bulan = isset($_GET['bulan']) && is_numeric($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) && is_numeric($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$status = isset($_GET['status']) ? strip_tags($_GET['status']) : '';

// Query construction
$query = "SELECT n.*, l.nama_pengguna FROM nota n JOIN login l ON n.id_login = l.id_login WHERE MONTH(n.tanggal) = ? AND YEAR(n.tanggal) = ?";
$params = [$bulan, $tahun];

if ($status != '') {
    $query .= " AND n.status = ?";
    $params[] = $status;
}

$query .= " ORDER BY n.tanggal ASC";
$stmt = $koneksi->prepare($query);
$stmt->execute($params);
$notaList = $stmt->fetchAll();

// Include the sidebar only once
include '../layouts/sidebar_admin.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title_web); ?> | THO-KING RENTAL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .main-content {
            margin-left: 290px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        .card {
            border: 1px solid rgba(0,0,0,.125);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        .card-header {
            background: #0056b3;
            color: white;
            font-weight: 600;
            border-bottom: 1px solid rgba(0,0,0,.125);
            padding: 1rem 1.5rem;
        }
        .btn {
            font-weight: 600;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        .form-control {
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            background-color: #f8f9fa;
            padding: 1rem;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
        .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
        }
        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .bg-primary {
            background-color: #007bff;
        }
        .text-white {
            color: white;
        }
.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #000000ff;
    margin-bottom: 1.5rem;
}
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container-fluid">
        <h1 class="page-title">
            Laporan Keuangan
        </h1>
            
            <!-- Filter Card -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>
                        Filter Laporan
                    </h5>
                </div>
                <div class="card-body">
                    <form method="get">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Bulan</label>
                                    <select name="bulan" class="form-control">
                                        <?php for($i=1; $i<=12; $i++): ?>
                                            <option value="<?= $i ?>" <?= $i == $bulan ? 'selected' : '' ?>>
                                                <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select name="tahun" class="form-control">
                                        <?php for($i=date('Y'); $i>=2020; $i--): ?>
                                            <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="belum_dibaca" <?= $status == 'belum_dibaca' ? 'selected' : '' ?>>Belum Dibaca</option>
                                        <option value="dibaca" <?= $status == 'dibaca' ? 'selected' : '' ?>>Dibaca</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search me-1"></i> Terapkan
                                        </button>
                                        <a href="cetak_batch_nota.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>&status=<?= $status ?>" 
                                           class="btn btn-success" target="_blank">
                                            <i class="fas fa-file-pdf me-1"></i> PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Report Table -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>
                        Data Transaksi
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="pl-4">No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Kode Booking</th>
                                    <th class="text-right">Total</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($notaList) > 0): ?>
                                    <?php $total = 0; ?>
                                    <?php foreach ($notaList as $i => $row): ?>
                                        <?php $total += $row['total_harga']; ?>
                                        <tr>
                                            <td class="pl-4"><?= $i + 1 ?></td>
                                            <td><?= htmlspecialchars($row['nama_pengguna']) ?></td>
                                            <td><?= htmlspecialchars($row['kode_booking']) ?></td>
                                            <td class="text-right font-weight-bold">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                            <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                                            <td>
                                                <span class="badge badge-<?= $row['status'] == 'dibaca' ? 'success' : 'warning' ?>">
                                                    <?= $row['status'] == 'dibaca' ? 'Nota Dibaca' : 'Nota Belum Dibaca' ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="table-primary font-weight-bold">
                                        <td colspan="3" class="pl-4">Total Pemasukan</td>
                                        <td class="text-right">Rp <?= number_format($total, 0, ',', '.') ?></td>
                                        <td colspan="2"></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-info-circle"></i>
                                                <h5>Tidak ada data transaksi</h5>
                                                <p class="mb-0">Tidak ada data transaksi untuk periode ini</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
