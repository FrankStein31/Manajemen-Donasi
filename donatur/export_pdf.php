<?php
session_start();
include '../koneksi.php';
require('../assets/fpdf/fpdf.php');

if (!isset($_SESSION['id'])) {
    header("Location: ../");
}

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Times', 'B', 16);
        $this->Cell(0, 10, 'Laporan Data Donatur', 0, 1, 'C');
        $this->Ln(10);
        
        $this->SetFont('Times', 'B', 11);
        $this->Cell(10, 10, 'No', 1, 0, 'C');
        $this->Cell(30, 10, 'Tanggal', 1, 0, 'C');
        $this->Cell(40, 10, 'Nama', 1, 0, 'C');
        $this->Cell(35, 10, 'Pekerjaan', 1, 0, 'C');
        $this->Cell(40, 10, 'Penerima', 1, 0, 'C');
        $this->Cell(35, 10, 'Jumlah Donasi', 1, 1, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage('L', 'A4');
$pdf->SetFont('Times', '', 10);

// Query pencarian
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

$no = 1;
$query = mysqli_query($koneksi, "SELECT donatur.*, pekerjaan.nama_pekerjaan, distribusi.nama_penerima 
    FROM donatur 
    LEFT JOIN pekerjaan ON donatur.id_pekerjaan = pekerjaan.id 
    LEFT JOIN distribusi ON donatur.id_distribusi = distribusi.id
    WHERE $where
    ORDER BY tanggal_donasi DESC");

while ($data = mysqli_fetch_array($query)) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C');
    $pdf->Cell(30, 10, date('d/m/Y', strtotime($data['tanggal_donasi'])), 1, 0, 'C');
    $pdf->Cell(40, 10, $data['nama'], 1, 0, 'L');
    $pdf->Cell(35, 10, $data['nama_pekerjaan'], 1, 0, 'L');
    $pdf->Cell(40, 10, $data['nama_penerima'], 1, 0, 'L');
    $pdf->Cell(35, 10, 'Rp ' . number_format($data['jumlah_donasi'], 0, ',', '.'), 1, 1, 'R');
}

$pdf->Output('Laporan-Donatur.pdf', 'D'); 