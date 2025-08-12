<?php
require __DIR__ . '/../../koneksi/koneksi.php';

if ($_GET['id'] == 'konfirmasi') {
    // 1️⃣ Update status pembayaran pada tabel booking
    $data2[] = $_POST['status'];       // status pembayaran
    $data2[] = $_POST['id_booking'];   // id_booking
    $sql2 = "UPDATE `booking` SET `konfirmasi_pembayaran` = ? WHERE id_booking = ?";
    $row2 = $koneksi->prepare($sql2);
    $row2->execute($data2);

    // 2️⃣ Ambil id_mobil dari booking
    $stmt = $koneksi->prepare("SELECT id_mobil FROM booking WHERE id_booking = ?");
    $stmt->execute([$_POST['id_booking']]);
    $hasil = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_mobil = $hasil['id_mobil'];

    // 3️⃣ Tentukan status mobil berdasarkan status pembayaran
    $status_mobil = ($_POST['status'] == 'Pembayaran di terima') ? 'Tidak Tersedia' : 'Tersedia';

    // 4️⃣ Update status mobil
    $sql_mobil = "UPDATE mobil SET status = ? WHERE id_mobil = ?";
    $row_mobil = $koneksi->prepare($sql_mobil);
    $row_mobil->execute([$status_mobil, $id_mobil]);

    // 5️⃣ Feedback ke user
    echo '<script>alert("Kirim Sukses, Pembayaran berhasil. Status mobil diperbarui.");history.go(-1);</script>';
    exit;
}
?>
