<?php
session_start();
require __DIR__ . '/../../koneksi/koneksi.php';
$title_web = 'Kalender Booking';

// Cek login dan akses admin
if (empty($_SESSION['USER'])) { 
    header("Location: ../login.php");
    exit;
}
if ($_SESSION['USER']['level'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Ambil data booking yang masih dalam masa sewa
$sql = "SELECT kode_booking, nama, tanggal, lama_sewa, mobil.tipe
        FROM booking 
        JOIN mobil ON booking.id_mobil = mobil.id_mobil
        WHERE DATE(tanggal) <= CURDATE() 
        AND DATE_ADD(tanggal, INTERVAL lama_sewa DAY) >= CURDATE()";
$stmt = $koneksi->prepare($sql);
$stmt->execute();
$hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mapping warna berdasarkan tipe mobil
function warnaBerdasarkanPaket($tipe) {
    $tipe = strtolower(trim($tipe));
    $warna = [
        'avanza all new 24 jam' => '#dc3545', // biru muda
        'avanza g 24 jam'       => '#007bff', // biru tua
        'innova reborn'         => '#28a745', // hijau
        'honda br-v dan mobilio'            => '#fd7e14', // oranye
        'manual'                => '#6c757d', // abu
        'matic'                 => '#ffc107', // kuning
        'mobil pengantin'       => '#8e44ad'  // ungu
    ];
    return $warna[$tipe] ?? '#343a40'; // default hitam
}

// Konversi ke format event untuk FullCalendar
$events = [];
foreach ($hasil as $row) {
    $start_date = $row['tanggal'];
    $end_date = date('Y-m-d', strtotime($row['tanggal'] . ' + ' . $row['lama_sewa'] . ' days'));

    $events[] = [
        'title' => $row['tipe'] . " - " . $row['nama'],
        'start' => $start_date,
        'end'   => $end_date,
        'color' => warnaBerdasarkanPaket($row['tipe'])
    ];
}

include '../layouts/sidebar_admin.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../../assets/image/Logo Tab Rental Mobil2.png" type="image/x-icon">
    <title><?= $title_web; ?> - THO-KING RENTAL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .page-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1.5rem;
        }
        #main {
            margin-left: 250px; /* sesuaikan lebar sidebar */
            padding: 20px;
        }
        #calendar {
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        /* Hover efek event */
        .fc-event {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .fc-event:hover {
            transform: scale(1.02);
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        }
        /* Legend */
        .legend {
            margin-top: 15px;
            padding: 10px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .legend span {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            margin-right: 10px;
            color: #fff;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div id="main" class="container-fluid">
    <h1 class="page-title">📅 Kalender Masa Sewa</h1>
    <div id="calendar"></div>
    <div class="legend mt-3">
        <span style="background:#dc3545">Avanza All New 24 Jam</span>
        <span style="background:#007bff">Avanza G 24 Jam</span>
        <span style="background:#28a745">Innova Reborn</span>
        <span style="background:#fd7e14">Honda BR-V dan Mobilio</span>
        <span style="background:#6c757d">Manual</span>
        <span style="background:#ffc107; color:#000">Matic</span>
        <span style="background:#8e44ad">Mobil Pengantin</span>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listWeek'
        },
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu'
        },
        events: <?= json_encode($events); ?>
    });

    calendar.render();
});
</script>
</body>
</html>
