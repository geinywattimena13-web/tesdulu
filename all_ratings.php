<?php
// File: all_ratings.php
session_start();
require 'koneksi/koneksi.php';
require 'header.php';

// Ambil semua data rating terbaru
$ratings_stmt = $koneksi->prepare("SELECT * FROM rating ORDER BY created_at DESC");
$ratings_stmt->execute();
$ratings = $ratings_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Rating Pengguna - THO-KING RENTAL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .rating-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 16px;
        }
        .rating-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .rating-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .rating-card strong {
            color: #2c3e50;
            font-size: 1.1em;
        }
        .rating-card span {
            color: #f39c12;
            font-size: 1.2em;   
        }
        .rating-card p {
            margin: 8px 0;
            color: #333;
        }
        .rating-card small {
            color: #7f8c8d;
        }
    </style>
</head>
<body>
<div class="container mt-4 mb-4">
    <h2 class="mb-3" style="color:#3498db; font-weight:700;">Semua Rating & Komentar Pengguna</h2>

    <?php if (count($ratings) === 0): ?>
        <p>Belum ada rating dari pengguna.</p>
    <?php else: ?>
        <div class="rating-grid">
        <?php foreach ($ratings as $row): ?>
            <div class="rating-card">
                <strong><?php echo htmlspecialchars($row['nama']); ?></strong><br>
                <span><?php echo str_repeat('⭐', intval($row['rating'])); ?></span>
                <p><?php echo nl2br(htmlspecialchars($row['komentar'])); ?></p>
                <small><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></small>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
