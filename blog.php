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
