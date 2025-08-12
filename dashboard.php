<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

// Ambil data mobil untuk ditampilkan
$querymobil = $koneksi->query('SELECT * FROM mobil ORDER BY id_mobil DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THO-KING RENTAL - Beranda</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="./assets/css/dashboard_user.css">
    
    <style>
        :root {
            --primary-color: #ea500eff;
            --secondary-color: #15267c;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --bg-light: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
        }
        
        .hero-section {
            position: relative;
            height: 60vh;
            min-height: 400px;
            overflow: hidden;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        
        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        
        .btn-hero {
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-radius: 15px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .section-title {
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 2rem;
        }
        
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .rating-stars {
            color: #ffc107;
            font-size: 1.2rem;
        }
        
        .map-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .social-links a {
            transition: all 0.3s ease;
            color: var(--text-dark);
        }
        
        .social-links a:hover {
            color: var(--primary-color);
            transform: scale(1.2);
        }
        
        .welcome-alert {
            background: linear-gradient(135deg, #667eea 0%, #1117c0ff 100%);
            color: white;
            border: none;
            border-radius: 15px;
        }
        
        .welcome-alert h4 {
            font-weight: 600;
        }
        .social-links a {
    color: white; /* Warna ikon */
    transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
}

.social-links a:hover {
    transform: scale(1.1); /* Efek membesar sedikit */
}

    </style>
</head>
<body>

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/6282248559459" target="_blank" class="whatsapp-float" aria-label="Chat WhatsApp">
    <i class="fab fa-whatsapp text-white" style="font-size: 30px;"></i>
</a>

<!-- Hero Section -->
<section class="hero-section">
    <img src="assets/image/index.jpg" alt="Background THO-KING RENTAL" class="w-100 h-100" style="object-fit: cover;">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1>THO-KING RENTAL</h1>
            <p>Sewa Mobil Terbaik di Kota Ambon dengan Harga Terjangkau</p>
            <?php if (empty($_SESSION['USER'])): ?>
                <a href="index.php" class="btn btn-primary btn-hero">
                    <i class="fas fa-sign-in-alt me-2"></i>Login & Temukan Mobil Favoritmu
                </a>
            <?php else: ?>
                <a href="blog.php" class="btn btn-success btn-hero">
                    <i class="fas fa-car me-2"></i>Temukan Mobil Favoritmu
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Welcome Message -->
<?php if (!empty($_SESSION['USER'])): ?>
<div class="container mt-4">
    <div class="alert welcome-alert">
        <h4 class="alert-heading mb-0">
            <i class="fas fa-user-circle me-2"></i>
            Selamat Datang, <?php echo htmlspecialchars($_SESSION['USER']['nama_pengguna'] ?? 'Pelanggan'); ?>!
        </h4>
    </div>
</div>
<?php endif; ?>

<!-- About Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body p-4">
                        <h2 class="section-title text-center mb-4">
                            <i class="fas fa-star feature-icon"></i>
                            Nikmati Layanan Rental Mobil Terbaik di Kota Ambon
                        </h2>
                        <p class="lead text-center mb-4">
                            <strong>THO-KING RENTAL</strong> adalah penyedia layanan rental mobil terkemuka di Kota Ambon. 
                            Menyediakan berbagai pilihan mobil matic dan manual berkualitas yang siap memenuhi kebutuhan Anda.
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Harga kompetitif</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Layanan 24 jam</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>2 cabang strategis</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Mobil terawat & bersih</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pengemudi profesional</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Paket fleksibel</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Pilihan Mobil Berkualitas</h2>
        <div class="row g-4">
            <?php
            $features = [
                [
                    'image' => 'assets/image/Inova_rebon_pengemudi.png',
                    'title' => 'Innova Reborn',
                    'description' => 'Mobil keluarga nyaman dengan kapasitas besar dan pengemudi berpengalaman atau lepas kunci'
                ],
                [
                    'image' => 'assets/image/686ce11eeb270.png',
                    'title' => 'Mobil Pengantin',
                    'description' => 'Nikmati hari spesial dengan mobil pengantin berkelas dan dekorasi bunga cantik'
                ],
                [
                    'image' => 'assets/image/686ce0aa8ef66.png',
                    'title' => 'Mobil Manual',
                    'description' => 'Pengalaman berkendara responsif, hemat bahan bakar dengan harga terjangkau'
                ],
                [
                    'image' => 'assets/image/686cd4f3e01b1.png',
                    'title' => 'Mobil Matic',
                    'description' => 'Kenyamanan tanpa repot, cocok untuk perjalanan dalam kota maupun wisata keluarga'
                ]
            ];
            
            foreach($features as $feature): ?>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <img src="<?php echo $feature['image']; ?>" class="card-img-top" alt="<?php echo $feature['title']; ?>" 
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $feature['title']; ?></h5>
                        <p class="card-text text-muted"><?php echo $feature['description']; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Maintenance Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-tools feature-icon"></i>
                        <h3 class="section-title">
                            <a href="perawatan.php" style="text-decoration: none; color: inherit;">Perawatan & Kondisi Mobil</a>
                        </h3>
                        <p class="lead">
                            THO-KING RENTAL selalu memastikan setiap unit mobil dalam kondisi <strong>prima dan terawat</strong>. 
                            Semua kendaraan rutin menjalani servis berkala, pengecekan komponen, dan kebersihan interior & eksterior.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Rating Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body p-4">
                        <h3 class="section-title text-center mb-4">
                            <i class="fas fa-star feature-icon"></i>
                            <a href="all_ratings.php" style="text-decoration: none; color: inherit;">Rating Pengguna</a>
                        </h3>
                        
                        <?php
                        $rating_stmt = $koneksi->query("SELECT AVG(rating) as rata_rata, COUNT(*) as total FROM rating");
                        $rating_data = $rating_stmt->fetch();
                        $rata_rata = number_format($rating_data['rata_rata'], 1);
                        $total_rating = $rating_data['total'];
                        ?>
                        
                        <div class="text-center mb-4">
                            <div class="rating-stars mb-2">
                                <?php echo str_repeat('⭐', round($rata_rata)); ?>
                            </div>
                            <h4><?php echo $rata_rata; ?> / 5.0</h4>
                            <p class="text-muted">Dari <?php echo $total_rating; ?> pengguna</p>
                        </div>

                        <?php if (empty($_SESSION['USER'])): ?>
                            <div class="text-center">
                                <a href="index.php" class="btn btn-primary">Login untuk memberikan rating</a>
                            </div>
                        <?php else: ?>
                            <?php
                            $hasRated = false;
                            if (!empty($_SESSION['USER']['nama_pengguna'])) {
                                $username = $_SESSION['USER']['nama_pengguna'];
                                $stmt = $koneksi->prepare("SELECT * FROM rating WHERE nama = ? LIMIT 1");
                                $stmt->execute([$username]);
                                $existingRating = $stmt->fetch(PDO::FETCH_ASSOC);
                                $hasRated = $existingRating ? true : false;
                            }
                            ?>
                            
                            <?php if ($hasRated): ?>
                                <div class="alert alert-info text-center">
                                    <h5>Terima kasih atas rating Anda!</h5>
                                </div>
                            <?php else: ?>
                                <form action="proses_rating.php" method="POST" id="ratingForm">
                                    <div class="mb-3">
                                        <label class="form-label">Rating Anda</label>
                                        <div class="star-rating text-center" style="font-size: 2rem; cursor: pointer;">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="far fa-star" data-rating="<?php echo $i; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <input type="hidden" name="rating" id="ratingValue" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="komentar" class="form-label">Komentar</label>
                                        <textarea class="form-control" name="komentar" rows="3" 
                                                  placeholder="Bagaimana pengalaman Anda dengan layanan kami?"></textarea>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-paper-plane me-2"></i>Kirim Penilaian
                                        </button>
                                    </div>
                                </form>
                                
                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const stars = document.querySelectorAll('.star-rating i');
                                    const ratingInput = document.getElementById('ratingValue');
                                    
                                    stars.forEach((star, index) => {
                                        star.addEventListener('click', function() {
                                            const rating = index + 1;
                                            ratingInput.value = rating;
                                            
                                            stars.forEach((s, i) => {
                                                s.className = i < rating ? 'fas fa-star text-warning' : 'far fa-star';
                                            });
                                        });
                                        
                                        star.addEventListener('mouseover', function() {
                                            const rating = index + 1;
                                            stars.forEach((s, i) => {
                                                s.className = i < rating ? 'fas fa-star text-warning' : 'far fa-star';
                                            });
                                        });
                                    });
                                    
                                    document.querySelector('.star-rating').addEventListener('mouseleave', function() {
                                        const currentRating = ratingInput.value || 0;
                                        stars.forEach((s, i) => {
                                            s.className = i < currentRating ? 'fas fa-star text-warning' : 'far fa-star';
                                        });
                                    });
                                });
                                </script>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">
            <i class="fas fa-map-marker-alt feature-icon"></i>
            Lokasi Kami
        </h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-3">
                            <i class="fas fa-building text-primary me-2"></i>Cabang Galala
                        </h4>
                        <div class="map-container mb-3">
                            <iframe  src="https://www.google.com/maps?q=Jl.+Kapten+Piere+Tendean,+Hative+Kecil,+Kec.+Sirimau,+Kota+Ambon,+Maluku&output=embed" 
                                  width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                        <p class="text-center">
                            <strong>Jl. Kapten Piere Tendean, Hative Kecil</strong><br>
                            Kec. Sirimau, Kota Ambon, Maluku
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-3">
                            <i class="fas fa-building text-primary me-2"></i>Cabang Passo
                        </h4>
                        <div class="map-container mb-3">
                            <iframe  src="https://www.google.com/maps?q=Jl.+Baru,+Passo,+Kec.+Baguala,+Kota+Ambon,+Maluku&output=embed"
                                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                        <p class="text-center">
                            <strong>Jl. Baru, Passo</strong><br>
                            Kec. Baguala, Kota Ambon, Maluku
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <h3 class="section-title mb-4">
                            <i class="fas fa-phone feature-icon"></i>
                            Hubungi Kami
                        </h3>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-phone text-primary me-2"></i>Telepon</h5>
                                <p>
                                    <a href="tel:6282248559459" class="text-decoration-none">0822-4855-9459 (Engki)</a><br>
                                    <a href="tel:6282299293363" class="text-decoration-none">0811-4792-151 (THO-KING)</a>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-envelope text-primary me-2"></i>Email</h5>
                                <p>
                                    <a href="mailto:cvthoking001@gmail.com" class="text-decoration-none">
                                        cvthoking001@gmail.com
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h5><i class="fas fa-clock text-primary me-2"></i>Jam Operasional</h5>
                            <p class="mb-0">Senin - Minggu: 24 Jam Non-Stop</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Social Media Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h3 class="section-title mb-4">
                    <i class="fas fa-share-alt feature-icon"></i>
                    Ikuti Kami
                </h3>
            <div class="social-links d-flex justify-content-center gap-3">
                        <a href="https://www.facebook.com/share/16bk2xjzwW/"
                        class="btn btn-primary btn-lg rounded-circle shadow-sm" 
                        style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/rental_car_thoking?igsh=M3oxenhnd255YXJ6"
                        class="btn btn-danger btn-lg rounded-circle shadow-sm" 
                        style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.tiktok.com/@cv.thoking?_t=ZS-8yhyOsu6Gwh&_r=1"
                        class="btn btn-dark btn-lg rounded-circle shadow-sm" 
                        style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript -->
<script>
// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add loading animation
window.addEventListener('load', function() {
    document.body.classList.add('loaded');
});

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate_animated', 'animate_fadeInUp');
        }
    });
}, observerOptions);

document.querySelectorAll('.card').forEach(card => {
    observer.observe(card);
});
</script>
</body>
</html>