<?php
session_start();
if ($_SESSION['USER']['level'] != 'admin') {
    echo '<script>alert("Akses ditolak."); window.location="../index.php";</script>';
    exit;
}

$database = 'thoking_rental'; // sesuaikan nama database
$user = 'root';
$pass = '';
$host = 'localhost';
$backup_file = 'backup_' . $database . '_' . date("Ymd_His") . '.sql';

exec("mysqldump --user=$user --password=$pass --host=$host $database > $backup_file", $output, $result);

if ($result == 0) {
    echo "<script>alert('Backup berhasil disimpan sebagai $backup_file'); window.location='dashboard.php';</script>";
} else {
    echo "<script>alert('Backup gagal.'); window.location='dashboard.php';</script>";
}
?>
