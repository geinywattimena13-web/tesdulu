<?php
ob_start();
require __DIR__ . '/../../koneksi/koneksi.php';
require __DIR__ . '/../../assets/tcpdf/tcpdf.php';

session_start();
if (!isset($_SESSION['USER']) || $_SESSION['USER']['level'] != 'admin') {
    echo '<script>alert("Akses ditolak."); window.location="../index.php";</script>';
    exit;
}

$bulan = isset($_GET['bulan']) && is_numeric($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) && is_numeric($_GET['tahun']) ? $_GET['tahun'] : date('Y');

$pdf = new TCPDF();
$pdf->SetCreator('THO-KING RENTAL');
$pdf->SetAuthor('Admin THO-KING');
$pdf->SetTitle('Laporan Nota '.$bulan.'-'.$tahun);
$pdf->SetSubject('Laporan Nota');
$pdf->SetKeywords('Laporan, Nota, THO-KING RENTAL');
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 10);

// Logo dan judul
$pdf->Image('../assets/image/logo_thoking.jpg', 15, 10, 25);
$pdf->Ln(30);

$html = '<h2 style="text-align:center; color:#1e6798;">Laporan Nota Bulan '.$bulan.'-'.$tahun.'</h2><hr>';

$notaList = $koneksi->query("SELECT n.*, l.nama_pengguna FROM nota n 
    JOIN login l ON n.id_login = l.id_login
    WHERE MONTH(n.tanggal) = '$bulan' AND YEAR(n.tanggal) = '$tahun'
    ORDER BY n.tanggal ASC");

if (!$notaList) {
    echo "Query error: " . $koneksi->error;
    exit;
}

if ($notaList->rowCount() == 0) {
    echo "Tidak ada data untuk bulan $bulan dan tahun $tahun.";
    exit;
}

$no = 1;
$html .= '<table border="1" cellpadding="5">
<tr style="background-color:#f2f2f2;"><th width="5%">No</th><th width="30%">Nama</th><th width="20%">Kode Booking</th><th width="25%">Total</th><th width="20%">Tanggal</th></tr>';

$totalPemasukan = 0;
while ($row = $notaList->fetch()) {
    $totalPemasukan += $row['total_harga'];
    $html .= '<tr>
    <td>'.$no++.'</td>
    <td>'.$row['nama_pengguna'].'</td>
    <td>'.$row['kode_booking'].'</td>
    <td>Rp '.number_format($row['total_harga'],0,',','.').'</td>
    <td>'.$row['tanggal'].'</td>
    </tr>';
}
$html .= '</table>';

$html .= '<br><h4>Total Pemasukan: Rp '.number_format($totalPemasukan,0,',','.').'</h4>';

$pdf->writeHTML($html);

ob_end_clean();
$pdf->Output('Laporan_Nota_'.$bulan.'_'.$tahun.'.pdf', 'I');
?>