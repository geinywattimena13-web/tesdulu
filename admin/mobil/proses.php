<?php
session_start();
require __DIR__ . '/../../koneksi/koneksi.php';

if (empty($_SESSION['USER']) || $_SESSION['USER']['level'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

$aksi = $_GET['aksi'] ?? '';
switch ($aksi) {
    case 'tambah':
        tambahMobil();
        break;
    case 'edit':
        editMobil();
        break;
    case 'hapus':
        hapusMobil();
        break;
    default:
        header('Location: mobil.php');
        exit;
}

function tambahMobil() {
    global $koneksi;
    $fields = ['no_plat', 'merk', 'harga', 'deskripsi', 'status', 'tipe'];
    foreach ($fields as $f) {
        if (empty($_POST[$f])) {
            setFlash("Field $f wajib diisi.", 'danger');
            redirect('tambah.php');
        }
    }

    $gambar = uploadGambar();
    if (!$gambar) redirect('tambah.php');

    try {
        $stmt = $koneksi->prepare("INSERT INTO mobil (no_plat, merk, harga, deskripsi, status, gambar, tipe) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            htmlspecialchars($_POST['no_plat']),
            htmlspecialchars($_POST['merk']),
            (float) $_POST['harga'],
            htmlspecialchars($_POST['deskripsi']),
            htmlspecialchars($_POST['status']),
            $gambar,
            htmlspecialchars($_POST['tipe'])
        ]);
        setFlash("Data mobil berhasil ditambahkan.", 'success');
        redirect('mobil.php');
    } catch (PDOException $e) {
        setFlash("Gagal menambahkan mobil: " . $e->getMessage(), 'danger');
        redirect('tambah.php');
    }
}

function editMobil() {
    global $koneksi;
    $id = $_GET['id'] ?? '';
    if (!$id) redirect('mobil.php');

    $fields = ['no_plat', 'merk', 'harga', 'deskripsi', 'status', 'tipe'];
    foreach ($fields as $f) {
        if (empty($_POST[$f])) {
            setFlash("Field $f wajib diisi.", 'danger');
            redirect("edit.php?id=$id");
        }
    }

    $gambar = $_POST['gambar_cek'] ?? '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
        $gambarUpload = uploadGambar();
        if ($gambarUpload) {
            if ($gambar && file_exists('../../assets/image/' . $gambar)) unlink('../../assets/image/' . $gambar);
            $gambar = $gambarUpload;
        }
    }

    try {
        $stmt = $koneksi->prepare("UPDATE mobil SET no_plat=?, merk=?, harga=?, deskripsi=?, status=?, gambar=?, tipe=? WHERE id_mobil=?");
        $stmt->execute([
            htmlspecialchars($_POST['no_plat']),
            htmlspecialchars($_POST['merk']),
            (float) $_POST['harga'],
            htmlspecialchars($_POST['deskripsi']),
            htmlspecialchars($_POST['status']),
            $gambar,
            htmlspecialchars($_POST['tipe']),
            $id
        ]);
        setFlash("Data mobil berhasil diupdate.", 'success');
        redirect('mobil.php');
    } catch (PDOException $e) {
        setFlash("Gagal mengupdate mobil: " . $e->getMessage(), 'danger');
        redirect("edit.php?id=$id");
    }
}

function hapusMobil() {
    global $koneksi;
    $id = $_GET['id'] ?? '';
    $gambar = $_GET['gambar'] ?? '';
    if (!$id) redirect('mobil.php');

    if ($gambar && file_exists('../../assets/image/' . $gambar)) {
        unlink('../../assets/image/' . $gambar);
    }

    try {
        $stmt = $koneksi->prepare("DELETE FROM mobil WHERE id_mobil=?");
        $stmt->execute([$id]);
        setFlash("Data mobil berhasil dihapus.", 'success');
    } catch (PDOException $e) {
        setFlash("Gagal menghapus mobil: " . $e->getMessage(), 'danger');
    }
    redirect('mobil.php');
}

function uploadGambar() {
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] === UPLOAD_ERR_NO_FILE) {
        setFlash("Gambar wajib diupload.", 'danger');
        return false;
    }
    if ($_FILES['gambar']['size'] > 4 * 1024 * 1024) {
        setFlash("Ukuran gambar maksimal 4MB.", 'danger');
        return false;
    }
    $type = mime_content_type($_FILES['gambar']['tmp_name']);
    if (!isset($allowed[$type])) {
        setFlash("Format gambar tidak valid (jpg, png, webp).", 'danger');
        return false;
    }
    $ext = $allowed[$type];
    $name = uniqid() . ".$ext";
    if (!move_uploaded_file($_FILES['gambar']['tmp_name'], '../../assets/image/' . $name)) {
        setFlash("Gagal upload gambar.", 'danger');
        return false;
    }
    return $name;
}

function setFlash($msg, $type = 'success') {
    $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
}

function redirect($loc) {
    header("Location: $loc");
    exit;
}
?>
