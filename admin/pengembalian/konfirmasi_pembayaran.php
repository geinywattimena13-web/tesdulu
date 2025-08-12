<?php
session_start();
require __DIR__ . '/../../koneksi/koneksi.php';
$title_web = 'Konfirmasi Pembayaran';

// Cek login dan akses admin
if (empty($_SESSION['USER'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['USER']['level'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Query data pembayaran
$data = $koneksi->query("
    SELECT p.*, b.kode_booking, b.total_harga, l.nama_pengguna 
    FROM pembayaran p
    JOIN booking b ON p.id_booking = b.id_booking
    JOIN login l ON b.id_login = l.id_login
    ORDER BY p.id_pembayaran DESC
")->fetchAll(PDO::FETCH_ASSOC);

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
    background: #1f01ffff;
}

.badge-warning {
    background: #fff701ff;
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
        <h1 class="page-title mb-4">Konfirmasi Pembayaran</h1>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-money-check-alt"></i> Daftar Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabelKonfirmasi" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Booking</th>
                                <th>Nama Pengguna</th>
                                <th>No Rekening</th>
                                <th>Nama Rekening</th>
                                <th class="text-right">Total Bayar</th>
                                <th class="text-center">Bukti Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($data): ?>
                                <?php foreach ($data as $i => $row): ?>
                                    <tr>
                                        <td class="text-center font-weight-bold"><?= $i+1; ?></td>
                                        <td><strong><?= htmlspecialchars($row['kode_booking']); ?></strong></td>
                                        <td><?= htmlspecialchars($row['nama_pengguna']); ?></td>
                                        <td><?= htmlspecialchars($row['no_rekening']); ?></td>
                                        <td><?= htmlspecialchars($row['nama_rekening']); ?></td>
                                        <td class="text-right font-weight-bold">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                        <td class="text-center">
                                            <?php if ($row['bukti_bayar']): ?>
                                                <a href="../../assets/bukti_bayar/<?= $row['bukti_bayar']; ?>" target="_blank" class="btn btn-info btn-sm" title="Lihat Bukti">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="badge badge-warning">Belum Upload</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="text-center">Belum ada pembayaran untuk dikonfirmasi.</td></tr>
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
    $('#tabelKonfirmasi').DataTable({
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
