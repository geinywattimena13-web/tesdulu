<?php
// File: perawatan.php
require 'header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perawatan & Kondisi Mobil - THO-KING RENTAL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        h2 {
            color: #3498db;
            font-weight: 700;
            margin-bottom: 10px;
        }
        p.description {
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
        }
        .gallery img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .gallery img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Perawatan & Kondisi Mobil</h2>
    <p class="description">
        Kami selalu memastikan mobil dalam kondisi prima melalui perawatan rutin seperti ganti oli, pembersihan interior & eksterior, pengecekan rem, dan perawatan ban. 
        Berikut adalah dokumentasi dari proses perawatan mobil di THO-KING RENTAL.
    </p>

    <div class="gallery">
        <img src="assets/image/background.jpg" alt="Pembersihan eksterior mobil">
        <img src="assets/image/background.jpg" alt="Penggantian oli mesin">
        <img src="assets/image/background.jpg" alt="Pengecekan rem mobil">
        <img src="assets/image/background.jpg" alt="Perawatan interior mobil">
    </div>
</div>
</body>
</html>
