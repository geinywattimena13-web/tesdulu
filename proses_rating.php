<?php
session_start();
require 'koneksi/koneksi.php';

// Cek login
if (empty($_SESSION['USER'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari session
$id_login = $_SESSION['USER']['id_login'];
$nama_pengguna = $_SESSION['USER']['nama_pengguna'];

// Ambil data dari form
$komentar = $_POST['komentar'];
$rating = $_POST['rating'];

// Insert ke tabel rating
$stmt = $koneksi->prepare("INSERT INTO rating (id_login, nama, komentar, rating, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->execute([$id_login, $nama_pengguna, $komentar, $rating]);

echo "<script>
    alert('Rating berhasil dikirim.');
    window.location='index.php';
</script>";
?>
