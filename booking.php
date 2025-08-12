<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

if (empty($_SESSION['USER'])) {
    echo '<script>alert("Harap login !");window.location="index.php"</script>';
    exit;
}

$id = $_GET['id'];
$isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();

// Ambil waktu_sewa dari paket_mobil berdasarkan tipe mobil
$paket = $koneksi->query("SELECT waktu_sewa FROM paket_mobil WHERE tipe = '{$isi['tipe']}'")->fetch();
$waktu_sewa_options = array_map('trim', explode(',', strtolower($paket['waktu_sewa'])));
?>
<script>
// Masukkan API Key Google Maps milikmu
const GOOGLE_MAPS_API_KEY = "YOUR_API_KEY_HERE";

function ambilLokasi() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Browser Anda tidak mendukung Geolocation.");
    }
}

function showPosition(position) {
    let lat = position.coords.latitude;
    let lng = position.coords.longitude;

    // Panggil Google Geocoding API
    fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${GOOGLE_MAPS_API_KEY}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === "OK") {
                let alamat = data.results[0].formatted_address;
                document.getElementById("alamat").value = alamat;
            } else {
                alert("Gagal mendapatkan alamat dari Google Maps.");
            }
        })
        .catch(err => console.error("Error:", err));
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("Akses lokasi ditolak. Silakan isi alamat secara manual.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Informasi lokasi tidak tersedia.");
            break;
        case error.TIMEOUT:
            alert("Waktu pencarian lokasi habis.");
            break;
        default:
            alert("Terjadi kesalahan saat mengambil lokasi.");
            break;
    }
}
</script>
<br><br>
<div class="container">
    <div class="row">
        <!-- Detail Mobil -->
        <div class="col-sm-4 mb-4">
            <div class="card shadow-sm">
                <img src="assets/image/<?php echo $isi['gambar']; ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                <div class="card-body bg-light">
                    <h5 class="card-title"><?= htmlspecialchars($isi['merk']); ?></h5>
                </div>
                <ul class="list-group list-group-flush">
                    <?php if ($isi['status'] == 'Tersedia') { ?>
                        <li class="list-group-item bg-primary text-white">
                            <i class="fa fa-check"></i> Available
                        </li>
                    <?php } else { ?>
                        <li class="list-group-item bg-danger text-white">
                            <i class="fa fa-close"></i> Not Available
                        </li>
                    <?php } ?>
                    <li class="list-group-item bg-dark text-white">
                        <i class="fa fa-money"></i> Rp. <?= number_format($isi['harga']); ?> / day
                    </li>
                </ul>
            </div>
        </div>

        <!-- Form Booking -->
        <div class="col-sm-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3" style="font-weight:700; color:#3498db;">Form Booking</h4>
                    <form method="post" action="koneksi/proses.php?id=booking">
                        
                        <!-- Nama -->
                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" 
                                   value="<?= htmlspecialchars($_SESSION['USER']['nama_pengguna']); ?>" readonly>
                        </div>

                        <!-- NIK -->
                        <div class="form-group mb-3">
                            <label for="nik">NIK</label>
                            <input type="text" name="ktp" id="nik" class="form-control" 
                                   value="<?= htmlspecialchars($_SESSION['USER']['nik']); ?>" readonly>
                        </div>

                        <!-- Alamat -->
<div class="form-group mb-3">
    <label for="alamat">Alamat</label>
    <div class="input-group">
        <input type="text" name="alamat" id="alamat" required class="form-control" placeholder="Alamat Anda">
        <button type="button" class="btn btn-primary" onclick="ambilLokasi()">📍 Ambil Lokasi Saya</button>
    </div>
    <small class="form-text text-muted">Klik tombol untuk mengisi alamat otomatis dari Google Maps.</small>
</div>

                        <!-- Telepon -->
                        <div class="form-group mb-3">
                            <label for="no_tlp">Telepon</label>
                            <input type="text" name="no_tlp" id="no_tlp" required class="form-control" 
                                   value="<?= htmlspecialchars($_SESSION['USER']['no_telepon']); ?>" placeholder="Nomor Telepon">
                        </div>

                        <!-- Tanggal Sewa -->
                        <div class="form-group mb-3">
                            <label for="tanggal">Tanggal Sewa</label>
                            <input type="date" name="tanggal" id="tanggal" required class="form-control" 
                                   min="<?php echo date('Y-m-d'); ?>" 
                                   max="<?php echo date('Y-m-d', strtotime('+7 days')); ?>">
                        </div>

                        <!-- Waktu Sewa + Lama Sewa -->
                        <?php if (!in_array('pengantin', $waktu_sewa_options) && !in_array('12 jam', $waktu_sewa_options)) { ?>
                            <div class="form-group mb-3">
                                <label for="waktu_sewa">Pilih Waktu Sewa</label>
                                <select name="waktu_sewa" id="waktu_sewa" class="form-control" required>
                                    <option value="">-- Pilih Waktu Sewa --</option>
                                    <?php foreach ($waktu_sewa_options as $option) { ?>
                                        <option value="<?= $option ?>"><?= ucfirst($option) ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Lama Sewa -->
                            <div class="form-group mb-3" id="lamaSewaGroup" style="display:none;">
                                <label for="lama_sewa">Lama Sewa</label>
                                <input type="number" name="lama_sewa" id="lama_sewa" class="form-control" placeholder="(Hari/Minggu/Bulan)">
                            </div>

                                                        <!-- Metode Pengambilan -->
                            <div class="form-group mb-3">
                                <label>Metode Pengambilan Mobil</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="metode_pengambilan" value="diantar">
                                    <label class="form-check-label" for="diantar">Diantar Ke Alamat Anda</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="metode_pengambilan" value="ambil_sendiri">
                                    <label class="form-check-label" for="ambil_sendiri">Jemput Di Rental</label>
                                </div>
                            </div>

                        <?php } elseif (in_array('12 jam', $waktu_sewa_options)) { ?>
                            <input type="hidden" name="waktu_sewa" value="12 jam">
                            <input type="hidden" name="lama_sewa" value="1">
                            <div class="alert alert-info">Mobil ini hanya dapat disewa selama 12 jam.</div>

                        <?php } elseif (in_array('pengantin', $waktu_sewa_options)) { ?>
                            <input type="hidden" name="waktu_sewa" value="pengantin">
                            <input type="hidden" name="lama_sewa" value="1">
                            <div class="alert alert-info">Lanjutkan proses booking dan konfirmasi waktu ke WA THO-KING</div>
                        <?php } ?>

                        <!-- Hidden Data -->
                        <input type="hidden" name="id_login" value="<?= $_SESSION['USER']['id_login']; ?>">
                        <input type="hidden" name="id_mobil" value="<?= $isi['id_mobil']; ?>">
                        <input type="hidden" name="total_harga" value="<?= $isi['harga']; ?>">

                        <!-- Tombol Submit -->
                        <hr>
                        <?php if ($isi['status'] == 'Tersedia') { ?>
                            <button type="submit" class="btn btn-primary w-100" style="font-weight:600;">Booking Sekarang</button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-danger w-100" disabled>Mobil Tidak Tersedia</button>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>

<script>
    const waktuSewaSelect = document.getElementById('waktu_sewa');
    const lamaSewaGroup = document.getElementById('lamaSewaGroup');
    const lamaSewaInput = document.getElementById('lama_sewa');

    if (waktuSewaSelect) {
        waktuSewaSelect.addEventListener('change', function() {
            const value = waktuSewaSelect.value.toLowerCase();
            if (['harian', 'mingguan', 'bulanan'].includes(value)) {
                lamaSewaGroup.style.display = 'block';
                lamaSewaInput.required = true;
            } else {
                lamaSewaGroup.style.display = 'none';
                lamaSewaInput.required = false;
                lamaSewaInput.value = 1;
            }
        });
    }
</script>

<?php include 'footer.php'; ?>
