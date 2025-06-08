<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../");
}

$query_donatur = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM donatur");
$total_donatur = mysqli_fetch_array($query_donatur)['total'];

$query_pekerjaan = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pekerjaan");
$total_pekerjaan = mysqli_fetch_array($query_pekerjaan)['total'];

$query_distribusi = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM distribusi");
$total_distribusi = mysqli_fetch_array($query_distribusi)['total'];

$query_total_donasi = mysqli_query($koneksi, "SELECT SUM(jumlah_donasi) as total FROM donatur");
$total_donasi = mysqli_fetch_array($query_total_donasi)['total'] ?? 0;

$query_grafik = mysqli_query($koneksi, "SELECT distribusi.nama_penerima, COALESCE(SUM(donatur.jumlah_donasi), 0) as total_donasi 
                                       FROM distribusi 
                                       LEFT JOIN donatur ON distribusi.id = donatur.id_distribusi 
                                       GROUP BY distribusi.id, distribusi.nama_penerima");
$labels = [];
$data = [];
while ($row = mysqli_fetch_array($query_grafik)) {
    $labels[] = $row['nama_penerima'];
    $data[] = (float)$row['total_donasi'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Manajemen Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include '../sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                
                <div class="row fade-in">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h5><i class="fas fa-users me-2"></i>Total Donatur</h5>
                            <h2><?= $total_donatur ?></h2>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card" style="background: linear-gradient(45deg, #27ae60, #2ecc71);">
                            <h5><i class="fas fa-briefcase me-2"></i>Total Pekerjaan</h5>
                            <h2><?= $total_pekerjaan ?></h2>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card" style="background: linear-gradient(45deg, #8e44ad, #9b59b6);">
                            <h5><i class="fas fa-hand-holding-heart me-2"></i>Total Distribusi</h5>
                            <h2><?= $total_distribusi ?></h2>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card" style="background: linear-gradient(45deg, #e67e22, #f39c12);">
                            <h5><i class="fas fa-money-bill-wave me-2"></i>Total Donasi</h5>
                            <h2>Rp <?= number_format($total_donasi, 0, ',', '.') ?></h2>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card fade-in">
                            <div class="card-body">
                                <h5 class="card-title mb-4"><i class="fas fa-chart-bar me-2"></i>Grafik Distribusi Dana</h5>
                                <canvas id="grafikDistribusi" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ctx = document.getElementById('grafikDistribusi');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Total Donasi',
                    data: <?= json_encode($data) ?>,
                    backgroundColor: 'rgba(41, 128, 185, 0.2)',
                    borderColor: '#2980b9',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: '#f8f9fa'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html> 