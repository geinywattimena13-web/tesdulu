<?php
require '../../koneksi/koneksi.php';

// Cek jika aksi konfirmasi dipilih
if(isset($_GET['id']) && $_GET['id'] == 'konfirmasi') {
    
    // 1. Update Status Mobil
    $data_update = [
        $_POST['status'],      // Status baru
        $_POST['id_mobil']     // ID mobil yang diupdate
    ];
    
    $sql_update = "UPDATE mobil SET status = ? WHERE id_mobil = ?";
    $stmt_update = $koneksi->prepare($sql_update);
    $stmt_update->execute($data_update);

    // 2. Ambil Data Peminjaman
    $id_booking = $_POST['id_booking'];
    $sql_booking = "SELECT * FROM booking WHERE id_booking = ?";
    $stmt_booking = $koneksi->prepare($sql_booking);
    $stmt_booking->execute([$id_booking]);
    $data_booking = $stmt_booking->fetch(PDO::FETCH_ASSOC);

    // 3. Hitung Tanggal Jatuh Tempo
    $tanggal_pinjam = date('Y-m-d'); // Tanggal hari ini
    $lama_sewa = $data_booking['lama_sewa']; // Lama sewa dari database
    $tanggal_jatuh_tempo = date('Y-m-d', strtotime("+$lama_sewa hari", strtotime($tanggal_pinjam)));

    // 4. Catat Data Pengembalian
    $sql_pengembalian = "INSERT INTO pengembalian 
                        (id_booking, tanggal_pinjam, tanggal_jatuh_tempo, status_pengembalian) 
                        VALUES (?, ?, ?, 'Dipinjam')";
    
    $stmt_pengembalian = $koneksi->prepare($sql_pengembalian);
    $stmt_pengembalian->execute([$id_booking, $tanggal_pinjam, $tanggal_jatuh_tempo]);

    // 5. Redirect ke halaman peminjaman
    header("Location: peminjaman.php?status=berhasil");
    exit();

} else {
    // Jika aksi tidak valid
    header("Location: peminjaman.php?status=gagal");
    exit();
}