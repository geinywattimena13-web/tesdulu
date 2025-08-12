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
