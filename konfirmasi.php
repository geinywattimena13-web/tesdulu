<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

if(empty($_SESSION['USER'])) {
    echo '<script>alert("Harap Login");window.location="index.php"</script>';
    exit;
}

$kode_booking = $_GET['id'];
$hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();

$id = $hasil['id_mobil'];
$isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();
?>
<br><br>
<div class="container">
<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body text-center">
                <h5>Pembayaran Dapat Melalui:</h5>
                <hr/>
                <p>BRI 2132131246 A/N Engky</p>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                <form method="post" action="koneksi/proses.php?id=konfirmasi" enctype="multipart/form-data">
                    <table class="table table-borderless">
                        <tr>
                            <td>Kode Booking</td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars($hasil['kode_booking']); ?></td>
                        </tr>
                        <tr>
                            <td>No Rekening</td>
                            <td>:</td>
                            <td><input type="text" name="no_rekening" required class="form-control">
                                <small class="text-muted">Contoh: BRI 1234567890</small></td>
                        </tr>
                        <tr>
                            <td>Atas Nama</td>
                            <td>:</td>
                            <td><input type="text" name="nama" required class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Total yang Harus Dibayar</td>
                            <td>:</td>
                            <td>Rp. <?php echo number_format($hasil['total_harga']); ?></td>
                        </tr>
                        <tr>
                            <td>Upload Bukti Bayar</td>
                            <td>:</td>
                            <td>
                                <input type="file" name="bukti_bayar" accept="image/*,application/pdf" required class="form-control">
                                <small class="text-muted">Format: jpg, png, pdf (max 2MB)</small>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="id_booking" value="<?php echo $hasil['id_booking']; ?>">
                    <button type="submit" class="btn btn-primary float-right">Kirim</button>
                </form>
            </div>
        </div> 
    </div>
</div>
</div>
<br><br><br>
<?php include 'footer.php'; ?>
