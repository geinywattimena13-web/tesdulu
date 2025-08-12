<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $info_web->nama_rental; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    
    <!-- css index -->
    <link rel="stylesheet" type="text/css" href="./assets/css/footer_user.css">


</head>
<body>
    <div class="footer">
        <div class="container">
            <span class="footer-text">
                Copyright &copy; <?= date('Y');?> <?= $info_web->nama_rental;?>. All rights reserved.
            </span>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
