<!-- <?php
    session_start();
    session_destroy();

    echo '<script>alert("Anda Telah Logout");window.location="../dashboard.php";</script>';
?> -->

<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Logout',
            text: 'Anda telah keluar dari sistem.',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            window.location = "../dashboard.php";
        });
    </script>
</body>
</html>