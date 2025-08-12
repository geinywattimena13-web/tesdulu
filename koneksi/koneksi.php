<?php
// === KONFIGURASI DATABASE ===
$user = 'root';
$pass = '';
try {
    $koneksi = new PDO("mysql:host=localhost;dbname=thoking_rental", $user, $pass);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// === URL GLOBAL ===
global $url;
$url = "http://localhost/THOKING_RENTAL/";

// === INFORMASI WEBSITE ===
$sql_web = "SELECT * FROM infoweb WHERE id = 1";
$row_web = $koneksi->prepare($sql_web);
$row_web->execute();
global $info_web;
$info_web = $row_web->fetch(PDO::FETCH_OBJ);

// === ERROR REPORTING ===
error_reporting(0);
?>