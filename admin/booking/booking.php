<?php
session_start();
require __DIR__ . '/../../koneksi/koneksi.php';
$title_web = 'Daftar Booking';

// Cek login dan akses admin
if (empty($_SESSION['USER'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['USER']['level'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Ambil data booking
if (!empty($_GET['id'])) {  
    $id = strip_tags($_GET['id']);
    $sql = "SELECT mobil.merk, booking.* FROM booking 
            JOIN mobil ON booking.id_mobil = mobil.id_mobil 
            WHERE id_login = ? ORDER BY id_booking DESC";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([$id]);
    $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT mobil.merk, booking.* FROM booking 
            JOIN mobil ON booking.id_mobil = mobil.id_mobil 
            ORDER BY id_booking DESC";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
    $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="icon" href="../../assets/image/Logo Tab Rental Mobil2.png" type="image/x-icon">
    <title><?= $title_web; ?> - THO-KING RENTAL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
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

.card-header {
    background: #0056b3;
    color: white;
    font-weight: 600;
    border: none;
    padding: 1.5rem;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #000000ff;
    margin-bottom: 1.5rem;
}

.table {
    margin-bottom: 0;
}

.table th {
    background-color: #f8f9fa;
    border: none;
    font-weight: 600;
    color: #000000ff;
    padding: 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 8px;
}

.btn-info {
    background: #0056b3;
    border: none;
}

.btn-info:hover {
    background: #0056b3;
}

.badge-warning {
    background: #f9e026ff;
    color: #000000ff;
}
.badge-danger {
    background: #f50909ff;
    color: #000000ff;
}
.badge-success {
    background: #0cbd0cff;
    color: #000000ff;
}

.dataTables_wrapper .dataTables_filter input {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 0.375rem 0.75rem;
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 0.375rem 0.75rem;
}

@media (max-width: 768px) {
    .card-header {
        padding: 1rem;
    }
    
    .page-title {
        font-size: 1.25rem;
    }
}
</style>

<body>

<div id="main">
    <div class="container-fluid mt-4">
        <h1 class="page-title mb-4">Data Booking</h1>

        <!-- Tabel Booking -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-table"></i> Daftar Booking</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabelBooking" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Booking</th>
                                <th>Merk Mobil</th>
                                <th>Nama</th>
                                <th>Tanggal Sewa</th>
                                <th class="text-center">Lama Sewa</th>
                                <th class="text-right">Total Harga</th>
                                <th class="text-center">Konfirmasi</th>
                                <th class="text-center">Lihat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($hasil as $isi): ?>
                                <tr>
                                    <td class="text-center font-weight-bold"><?= $no++; ?></td>
                                    <td><strong><?= htmlspecialchars($isi['kode_booking']); ?></strong></td>
                                    <td><?= htmlspecialchars($isi['merk']); ?></td>
                                    <td><?= htmlspecialchars($isi['nama']); ?></td>
                                    <td><?= htmlspecialchars($isi['tanggal']); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($isi['lama_sewa']); ?> hari</td>
                                    <td class="text-right font-weight-bold">Rp <?= number_format($isi['total_harga'], 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <span class="badge badge-<?= 
                                            strtolower(trim($isi['konfirmasi_pembayaran'])) === 'pembayaran di terima' ? 'success' :
                                            (strtolower(trim($isi['konfirmasi_pembayaran'])) === 'sedang di proses' ? 'warning' :
                                            (strtolower(trim($isi['konfirmasi_pembayaran'])) === 'belum bayar' ? 'danger' : 'secondary'))
                                        ?>">
                                            <?= htmlspecialchars($isi['konfirmasi_pembayaran']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="bayar.php?id=<?= urlencode($isi['kode_booking']); ?>" class="btn btn-info btn-sm" title="Detail">
                                            <i>Bokingan</i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (count($hasil) === 0): ?>
                                <tr><td colspan="9" class="text-center">Data booking tidak ditemukan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables + Buttons -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function(){
    $('#tabelBooking').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            { 
                extend: 'copyHtml5', 
                className: 'btn btn-sm btn-secondary', 
                text: '<i class="fas fa-copy"></i> Salin' 
            },
            { 
                extend: 'excelHtml5', 
                className: 'btn btn-sm btn-success', 
                text: '<i class="fas fa-file-excel"></i> Excel' 
            },
            { 
                extend: 'pdfHtml5', 
                className: 'btn btn-sm btn-danger', 
                text: '<i class="fas fa-file-pdf"></i> PDF' 
            },
            { 
                extend: 'print', 
                className: 'btn btn-sm btn-info', 
                text: '<i class="fas fa-print"></i> Cetak' 
            }
        ],
        pageLength: 10,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { first: "Pertama", last: "Terakhir", next: "→", previous: "←" },
            zeroRecords: "Data tidak ditemukan",
            infoEmpty: "Menampilkan 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)"
        }
    });
});
</script>

</body>
</html>
