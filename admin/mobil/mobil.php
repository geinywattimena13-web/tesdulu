<?php
session_start();
require __DIR__ . '/../../koneksi/koneksi.php';
$title_web = 'Data Mobil - Admin';

if (empty($_SESSION['USER']) || $_SESSION['USER']['level'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$mobil = $koneksi->query("SELECT * FROM mobil ORDER BY id_mobil DESC")->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="icon" href="../../assets/image/Logo Tab Rental Mobil2.png" type="image/x-icon">
    <title><?= htmlspecialchars($title_web); ?> - THO-KING RENTAL</title>
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
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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

.stats-icon.mobil {
    background: #d97706;
    color: white;
}

.stats-icon.tersedia {
    background: #059669;
    color: white;
}

.stats-icon.dipinjam {
    background: #dc2626;
    color: white;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stats-label {
    color: #000002ff;
    font-size: 0.875rem;
    font-weight: 500;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #000000ff;
    margin-bottom: 1.5rem;
}

.table-container {
    background: #fdfdfdff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.table thead {
    background: #0056b3;
    color: white;
}

.table tbody tr:hover {
    background-color: rgba(59, 131, 246, 0.15);
}

.btn-custom {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-edit {
    background: #d97706;
    color: white;
}

.btn-delete {
    background: #dc2626;
    color: white;
}

.btn-add {
    background: #059669;
    color: white;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
}

.empty-state {
    text-align: center;
    padding: 3rem;
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">Data Mobil</h1>
            <a href="tambah.php" class="btn btn-add">
                <i class="fas fa-plus"></i> Tambah Mobil Baru
            </a>
        </div>

        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['flash']['msg']) ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Gambar</th>
                            <th>Merk & Tipe</th>
                            <th>No Plat</th>
                            <th>Harga/Hari</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($mobil): ?>
                            <?php foreach ($mobil as $index => $m): ?>
                                <tr>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-light"><?= $index + 1 ?></span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <img src="../../assets/image/<?= htmlspecialchars($m['gambar']) ?>" 
                                             class="rounded" 
                                             style="width: 80px; height: 60px; object-fit: cover;" 
                                             alt="<?= htmlspecialchars($m['merk']) ?>">
                                    </td>
                                    <td class="align-middle">
                                        <strong><?= htmlspecialchars($m['merk']) ?></strong><br>
                                        <small class="text-muted"><?= htmlspecialchars($m['tipe']) ?></small>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-secondary"><?= htmlspecialchars($m['no_plat']) ?></span>
                                    </td>
                                    <td class="align-middle">
                                        <strong class="text-primary">Rp <?= number_format($m['harga'], 0, ',', '.') ?></strong>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-<?= $m['status'] == 'Tersedia' ? 'success' : 'danger' ?>">
                                            <?= htmlspecialchars($m['status']) ?>
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <small class="text-black">
                                            <?= strlen($m['deskripsi']) > 50 ? substr($m['deskripsi'], 0, 50) . '...' : $m['deskripsi'] ?>
                                        </small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group" role="group">
                                            <a href="edit.php?id=<?= $m['id_mobil'] ?>" 
                                               class="btn btn-sm btn-custom btn-edit" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="proses.php?aksi=hapus&id=<?= $m['id_mobil'] ?>&gambar=<?= urlencode($m['gambar']) ?>" 
                                               class="btn btn-sm btn-custom btn-delete" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus mobil ini?')" 
                                               title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="empty-state">
                                        <i class="fas fa-car-side fa-3x mb-3"></i>
                                        <h5>Belum ada data mobil</h5>
                                        <p class="text-muted">Tambahkan mobil pertama Anda untuk memulai</p>
                                        <a href="tambah.php" class="btn btn-add mt-3">
                                            <i class="fas fa-plus"></i> Tambah Mobil
                                        </a>
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
// Auto-hide alerts after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        $(alert).alert('close');
    });
}, 5000);
</script>

</body>
</html>
