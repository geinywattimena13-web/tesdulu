<?php
require 'koneksi.php';

// === LOGIN ===
if ($_GET['id'] == 'login') {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $row = $koneksi->prepare("SELECT * FROM login WHERE username = ? AND password = md5(?)");
    $row->execute([$user, $pass]);

    if ($row->rowCount() > 0) {
        session_start();
        $hasil = $row->fetch();

        $_SESSION['USER'] = $hasil;

        if ($_SESSION['USER']['level'] == 'admin') {
            $redirect = $url . 'admin/index.php';
        } else {
            $redirect = $url . 'dashboard.php';
        }

        // Alert sukses
        echo '
        <html>
        <head>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        </head>
<body style="background-color: #fdf9f4;">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: "success",
            title: "Selamat Datang!",
            text: "Login berhasil. Selamat menggunakan layanan rental mobil Toraja.",
            background: "#fff7f0",
            color: "#f1a55eff",
            iconColor: "#b87333",
            showConfirmButton: false, // Hilangkan tombol
            timer: 2000, // Tutup otomatis setelah 2 detik
            timerProgressBar: true // Progress bar di bawah
        }).then(() => {
            window.location = "' . $redirect . '";
        });
    </script>
</body>

        </html>';
    } else {
        // Alert gagal
        echo '
        <html>
        <head>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        </head>
        <body style="background-color: #fdf9f4;">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Login Gagal",
                    text: "Periksa kembali username dan password Anda.",
                    background: "#fff7f0",
                    color: "#5a3e2b",
                    iconColor: "#b87333",
                    confirmButtonText: "Coba Lagi",
                    confirmButtonColor: "#8B4513"
                }).then(() => {
                    window.location = "' . $url . 'index.php";
                });
            </script>
        </body>
        </html>';
    }
}


// === DAFTAR ===
if ($_GET['id'] == 'daftar') {
    $nama = trim($_POST['nama']);
    $user = trim($_POST['user']);
    $pass = md5(trim($_POST['pass']));
    $nik = trim($_POST['nik']);
    $no_telepon = trim($_POST['no_telepon']);
    $level = 'pengguna';

    if (empty($nik) || !preg_match('/^\d{16}$/', $nik)) {
        echo '<script>alert("NIK wajib diisi dengan 16 digit angka."); window.history.back();</script>';
        exit;
    }

    if (empty($no_telepon) || !preg_match('/^\d{10,15}$/', $no_telepon)) {
        echo '<script>alert("Nomor Telepon wajib diisi dengan 10-15 digit angka."); window.history.back();</script>';
        exit;
    }

    $row = $koneksi->prepare("SELECT * FROM login WHERE username = ?");
    $row->execute([$user]);

    if ($row->rowCount() > 0) {
echo '
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body style="background-color: #fdf9f4;">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: "warning",
            title: "Username Sudah Terdaftar",
            text: "Gunakan username lain untuk melanjutkan.",
            background: "#fff7f0",
            color: "#5a3e2b",
            iconColor: "#b87333",
            confirmButtonText: "OK",
            confirmButtonColor: "#8B4513"
        }).then(() => {
            window.location = "' . $url . 'index.php";
        });
    </script>
</body>
</html>';

    } else {
        $sql = "INSERT INTO login (nama_pengguna, username, password, nik, no_telepon, level) VALUES (?,?,?,?,?,?)";
        $insert = $koneksi->prepare($sql);
        $insert->execute([$nama, $user, $pass, $nik, $no_telepon, $level]);

        echo '<script>alert("Pendaftaran berhasil, silakan login."); window.location="'.$url.'index.php";</script>';
    }
}

// === BOOKING ===
// === BOOKING ===
if ($_GET['id'] == 'booking') {
    $unik = random_int(100, 999);

    // Ambil harga mobil dari database agar aman
    $id_mobil = $_POST['id_mobil'];
    $stmt = $koneksi->prepare("SELECT harga FROM mobil WHERE id_mobil = ?");
    $stmt->execute([$id_mobil]);
    $mobil = $stmt->fetch();

    if (!$mobil) {
        echo '<script>
        alert("Mobil tidak ditemukan.");
        window.history.back();
        </script>';
        exit;
    }

    $harga_mobil = $mobil['harga'];

    // Ambil metode pengambilan dari form
    $metode_pengambilan = $_POST['metode_pengambilan'];

    // Ambil dan sesuaikan lama_sewa sesuai paket waktu_sewa
    $lama_sewa_input = intval($_POST['lama_sewa']);
    $waktu_sewa = $_POST['waktu_sewa'];

    if ($waktu_sewa == 'harian') {
        $lama_sewa = $lama_sewa_input * 1;
    } elseif ($waktu_sewa == 'mingguan') {
        $lama_sewa = $lama_sewa_input * 7;
    } elseif ($waktu_sewa == 'bulanan') {
        $lama_sewa = $lama_sewa_input * 30;
    } elseif ($waktu_sewa == '12_jam') {
        $lama_sewa = 0.5 * $lama_sewa_input;
    } else {
        $lama_sewa = $lama_sewa_input;
    }

    // Hitung total harga sesuai lama_sewa yang sudah dikonversi
    $total_harga = ($harga_mobil * $lama_sewa) + $unik;

    $data[] = time(); // kode_booking
    $data[] = $_POST['id_login'];
    $data[] = $_POST['id_mobil'];
    $data[] = $_POST['ktp'];
    $data[] = $_POST['nama'];
    $data[] = $_POST['alamat'];
    $data[] = $_POST['no_tlp'];
    $data[] = $_POST['tanggal'];
    $data[] = $lama_sewa;
    $data[] = $total_harga;
    $data[] = "Belum Bayar";
    $data[] = date('Y-m-d');
    $data[] = $waktu_sewa;
    $data[] = $_POST['metode_pengambilan'];

    $sql = "INSERT INTO booking (
                kode_booking, id_login, id_mobil, ktp, nama, alamat, no_tlp,
                tanggal, lama_sewa, total_harga, konfirmasi_pembayaran, tgl_input, waktu_sewa, metode_pengambilan
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $insert = $koneksi->prepare($sql);
    $insert->execute($data);

    echo '<script>
    alert("Booking berhasil, silakan melakukan pembayaran.");
    window.location="../bayar.php?id='.time().'";
    </script>';
}
// === KONFIRMASI PEMBAYARAN ===
if ($_GET['id'] == 'konfirmasi') {
    $id_booking = $_POST['id_booking'];
    $no_rekening = $_POST['no_rekening'];
    $nama = $_POST['nama'];

    $bukti_bayar = '';
    if (isset($_FILES['bukti_bayar']) && $_FILES['bukti_bayar']['error'] == 0) {
        $allowed_ext = ['jpg','jpeg','png','pdf'];
        $file_name = $_FILES['bukti_bayar']['name'];
        $file_tmp = $_FILES['bukti_bayar']['tmp_name'];
        $file_size = $_FILES['bukti_bayar']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_ext) && $file_size <= 2097152) {
            $new_name = 'bukti_' . time() . '.' . $file_ext;
            move_uploaded_file($file_tmp, '../assets/bukti_bayar/' . $new_name);
            $bukti_bayar = $new_name;
        } else {
            echo '<script>alert("Format atau ukuran file tidak valid (max 2MB, jpg/png/pdf)."); history.go(-1);</script>';
            exit;
        }
    } else {
        echo '<script>alert("Harap upload bukti bayar."); history.go(-1);</script>';
        exit;
    }

    $sql = "INSERT INTO pembayaran (id_booking, no_rekening, nama_rekening, bukti_bayar) VALUES (?,?,?,?)";
    $insert = $koneksi->prepare($sql);
    $insert->execute([$id_booking, $no_rekening, $nama, $bukti_bayar]);

    $update = $koneksi->prepare("UPDATE booking SET konfirmasi_pembayaran = ? WHERE id_booking = ?");
    $update->execute(['Sedang di proses', $id_booking]);

echo '
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body style="background-color: #fdf9f4;">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: "success",
            title: "Konfirmasi Berhasil",
            text: "Mohon tunggu nota booking.",
            background: "#fff7f0",
            color: "#5a3e2b",
            iconColor: "#b87333",
            confirmButtonText: "OK",
            confirmButtonColor: "#8B4513"
        }).then(() => {
            window.location = "../dashboard.php";
        });
    </script>
</body>
</html>';

}

// === LOGOUT ===
if ($_GET['id'] == 'logout') {
    session_start();
    session_destroy();
    echo '<script>alert("Anda berhasil logout."); window.location="'.$url.'index.php";</script>';
}
?>
