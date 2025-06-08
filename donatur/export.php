<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../");
    exit;
}

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Donatur.xls");

$where = "1=1";
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $where .= " AND (donatur.nama LIKE '%$keyword%' OR pekerjaan.nama_pekerjaan LIKE '%$keyword%' OR distribusi.nama_penerima LIKE '%$keyword%')";
}
if (isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir'])) {
    $tanggal_awal = $_GET['tanggal_awal'];
    $tanggal_akhir = $_GET['tanggal_akhir'];
    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        $where .= " AND (tanggal_donasi BETWEEN '$tanggal_awal' AND '$tanggal_akhir')";
    }
}

$query = mysqli_query($koneksi, "SELECT donatur.*, pekerjaan.nama_pekerjaan, distribusi.nama_penerima 
                               FROM donatur 
                               LEFT JOIN pekerjaan ON donatur.id_pekerjaan = pekerjaan.id 
                               LEFT JOIN distribusi ON donatur.id_distribusi = distribusi.id
                               WHERE $where
                               ORDER BY tanggal_donasi DESC");
?>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Jumlah Donasi</th>
            <th>Pekerjaan</th>
            <th>Penerima Donasi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($data = mysqli_fetch_array($query)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= date('d/m/Y', strtotime($data['tanggal_donasi'])) ?></td>
            <td><?= $data['nama'] ?></td>
            <td>Rp <?= number_format($data['jumlah_donasi'], 0, ',', '.') ?></td>
            <td><?= $data['nama_pekerjaan'] ?></td>
            <td><?= $data['nama_penerima'] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table> 