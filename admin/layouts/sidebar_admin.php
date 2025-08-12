<?php
// Pastikan variabel ini sudah didefinisikan di file yang memanggil:
// $url, $title_web, $jumlah_notif_booking
?>

<style>
/* ===== MODERN ENHANCED SIDEBAR CSS THO-KING ===== */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
#sidebar-wrapper {
    min-width: 280px;
    max-width: 280px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    overflow-y: auto;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: #ffffffff;
    border-right: #f30000ff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
}

#sidebar-wrapper::-webkit-scrollbar {
    width: 4px;
}

#sidebar-wrapper::-webkit-scrollbar-track {
    background: transparent;
}

#sidebar-wrapper::-webkit-scrollbar-thumb {
    background: #020efb52;
    border-radius: 2px;
}

#sidebar-wrapper::-webkit-scrollbar-thumb:hover {
    background: #020efbff;
}

.sidebar-heading {
    text-align: center;
    padding: 30px 20px;
    background: #010cdcff;
    color: white;
    position: relative;
    overflow: hidden;
}


@keyframes shimmer {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.sidebar-heading img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 3px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.sidebar-heading img:hover {
    transform: scale(1.1);
    border-color: rgba(255, 255, 255, 0.5);
}

.sidebar-heading h5 {
    margin-top: 10px;
    font-size: 18px;
    font-weight: 600;
    letter-spacing: 0.5px;
    position: relative;
    z-index: 1px;
}

.list-group {
    padding: 10px;
}

.list-group-item {
    background: transparent;
    border: none;
    border-radius: 10px;
    font-weight: 500;
    font-size: 14px;
    padding: 14px 20px;
    margin: -2px -1px ;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.list-group-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(37, 100, 235, 0.57), transparent);
    transition: left 0.5s;
}

.list-group-item:hover::before {
    left: 100%;
}

.list-group-item i {
    min-width: 20px;
    text-align: center;
    font-size: 16px;
    color: #010cdcff;
    transition: all 0.3s ease;
}

.list-group-item:hover i {
    color: #58585aff;
    transform: scale(1.1);
}

.list-group-item.active i {
    color: #ffffffff;
}

.badge-custom {
    background: #dc2626;
    color: white;
    font-size: 11px;
    font-weight: 600;SSS
    padding: 4px 8px;
    border-radius: 20px;
    margin-left: auto;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
    animation: pulse-badge 2s infinite;
}

@keyframes pulse-badge {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

#main {
    flex: 1;
    padding: 20px;
    margin-left: 280px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Icon Animations */
.list-group-item i {
    transition: all 0.3s ease;
}

.list-group-item:hover i {
    transform: translateX(2px);
}

/* Responsive improvements */
@media (max-width: 1024px) {
    #sidebar-wrapper {
        min-width: 260px;
        max-width: 260px;
    }
    
    #main {
        margin-left: 260px;
    }
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
</style>

<div id="sidebar-wrapper">
    <div class="sidebar-heading">
    <img src="<?= $url; ?>assets/image/logo.jpg" alt="Logo">
    <h5>THO-KING RENTAL</h5>
    <h8 style="color : #ffffff;" ><?= htmlspecialchars($_SESSION['USER']['nama_pengguna']); ?></h8>
    <small style="color:#888;"><?= htmlspecialchars($_SESSION['USER']['role']); ?></small>
</div>
    <div class="list-group list-group-flush">
        <a href="<?= $url; ?>admin/"
            class="list-group-item list-group-item-action <?= ($title_web == 'Dashboard') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="<?= $url; ?>admin/user/profil_admin.php"
            class="list-group-item list-group-item-action <?= ($title_web == 'User') ? 'active' : ''; ?>">
            <i class="fas fa-user"></i> Profil
        </a>
        <a href="<?= $url; ?>admin/mobil/mobil.php"
            class="list-group-item list-group-item-action <?= (in_array($title_web, ['Data Mobil - Admin', 'Tambah Mobil', 'Edit Mobil'])) ? 'active' : ''; ?>">
            <i class="fas fa-car"></i> Data Mobil
        </a>
        <a href="<?= $url; ?>admin/booking/booking.php"
            class="list-group-item list-group-item-action <?= (in_array($title_web, ['Daftar Booking', 'Konfirmasi'])) ? 'active' : ''; ?>">
            <i class="fas fa-calendar-check"></i> Data Booking
            <?php if ($jumlah_notif_booking > 0): ?>
                <span class="badge badge-custom"><?= $jumlah_notif_booking; ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= $url; ?>admin\pengembalian\konfirmasi_pembayaran.php"
            class="list-group-item list-group-item-action <?= ($title_web == 'Konfirmasi Pembayaran') ? 'active' : ''; ?>">
            <i class="fas fa-money-check-alt"></i> Data Transaksi
        </a>
        <a href="<?= $url; ?>admin/pengembalian/cek_jatuh_tempo.php"
            class="list-group-item list-group-item-action <?= ($title_web == 'Cek Jatuh Tempo') ? 'active' : ''; ?>">
            <i class="fas fa-clock"></i> Cek Jatuh Tempo
        </a>
        <a href="<?= $url; ?>admin/laporan/laporan_keuangan.php"
            class="list-group-item list-group-item-action <?= ($title_web == 'Laporan Keuangan') ? 'active' : ''; ?>">
            <i class="fas fa-file-invoice-dollar"></i> Data Keuangan
        </a>
        <a href="<?= $url; ?>admin/booking/kalender_booking.php" 
        class="list-group-item list-group-item-action" <?= ($title_web == 'Kalender Booking') ? 'active' : ''; ?>>
        <i class="fas fa-calendar-alt"></i> Kalender booking</a>
        <a href="<?= $url; ?>admin/logout.php"
            class="list-group-item list-group-item-action"
            onclick="return confirm('Apakah anda ingin logout ?');">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>
