<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../");
}

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah_donasi'];
    $pekerjaan = $_POST['id_pekerjaan'];
    $distribusi = $_POST['id_distribusi'];
    $tanggal = $_POST['tanggal_donasi'];
    
    mysqli_query($koneksi, "INSERT INTO donatur (nama, jumlah_donasi, id_pekerjaan, id_distribusi, tanggal_donasi) 
                           VALUES ('$nama', '$jumlah', '$pekerjaan', '$distribusi', '$tanggal')");
    header("Location: ./");
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah_donasi'];
    $pekerjaan = $_POST['id_pekerjaan'];
    $distribusi = $_POST['id_distribusi'];
    $tanggal = $_POST['tanggal_donasi'];
    
    mysqli_query($koneksi, "UPDATE donatur SET nama='$nama', jumlah_donasi='$jumlah', id_pekerjaan='$pekerjaan', 
                           id_distribusi='$distribusi', tanggal_donasi='$tanggal' WHERE id='$id'");
    header("Location: ./");
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM donatur WHERE id='$id'");
    header("Location: ./");
}

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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Donatur - Manajemen Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include '../sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Data Donatur</h1>
                </div>

                <div class="search-form fade-in">
                    <form method="get" class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-primary"></i></span>
                                <input type="text" name="keyword" class="form-control border-start-0" placeholder="Cari donatur..." value="<?= $_GET['keyword'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-calendar text-primary"></i></span>
                                <input type="date" name="tanggal_awal" class="form-control border-start-0" value="<?= $_GET['tanggal_awal'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-calendar text-primary"></i></span>
                                <input type="date" name="tanggal_akhir" class="form-control border-start-0" value="<?= $_GET['tanggal_akhir'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                            <?php if(isset($_GET['keyword']) || isset($_GET['tanggal_awal']) || isset($_GET['tanggal_akhir'])): ?>
                            <a href="./" class="btn btn-danger">
                                <i class="fas fa-times"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="fas fa-plus me-2"></i>Tambah Donatur
                    </button>
                    <a href="export.php<?= isset($_GET['keyword']) ? '?keyword='.$_GET['keyword'] : '' ?><?= isset($_GET['tanggal_awal']) ? (isset($_GET['keyword']) ? '&' : '?').'tanggal_awal='.$_GET['tanggal_awal'] : '' ?><?= isset($_GET['tanggal_akhir']) ? '&tanggal_akhir='.$_GET['tanggal_akhir'] : '' ?>" class="btn btn-success">
                        <i class="fas fa-file-excel me-2"></i>Export Excel
                    </a>
                </div>

                <div class="card fade-in">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Jumlah Donasi</th>
                                        <th>Pekerjaan</th>
                                        <th>Penerima Donasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = mysqli_query($koneksi, "SELECT donatur.*, pekerjaan.nama_pekerjaan, distribusi.nama_penerima 
                                                                   FROM donatur 
                                                                   LEFT JOIN pekerjaan ON donatur.id_pekerjaan = pekerjaan.id 
                                                                   LEFT JOIN distribusi ON donatur.id_distribusi = distribusi.id
                                                                   WHERE $where
                                                                   ORDER BY tanggal_donasi DESC");
                                    while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= date('d/m/Y', strtotime($data['tanggal_donasi'])) ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td>Rp <?= number_format($data['jumlah_donasi'], 0, ',', '.') ?></td>
                                        <td><?= $data['nama_pekerjaan'] ?></td>
                                        <td><?= $data['nama_penerima'] ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $data['id'] ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="?hapus=<?= $data['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEdit<?= $data['id'] ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Donatur</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama</label>
                                                            <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Donasi</label>
                                                            <input type="date" name="tanggal_donasi" class="form-control" value="<?= $data['tanggal_donasi'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jumlah Donasi</label>
                                                            <input type="number" name="jumlah_donasi" class="form-control" value="<?= $data['jumlah_donasi'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Pekerjaan</label>
                                                            <select name="id_pekerjaan" class="form-control" required>
                                                                <?php
                                                                $query_pekerjaan = mysqli_query($koneksi, "SELECT * FROM pekerjaan");
                                                                while ($pekerjaan = mysqli_fetch_array($query_pekerjaan)) {
                                                                    $selected = $pekerjaan['id'] == $data['id_pekerjaan'] ? 'selected' : '';
                                                                    echo "<option value='".$pekerjaan['id']."' ".$selected.">".$pekerjaan['nama_pekerjaan']."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Penerima Donasi</label>
                                                            <select name="id_distribusi" class="form-control" required>
                                                                <?php
                                                                $query_distribusi = mysqli_query($koneksi, "SELECT * FROM distribusi");
                                                                while ($distribusi = mysqli_fetch_array($query_distribusi)) {
                                                                    $selected = $distribusi['id'] == $data['id_distribusi'] ? 'selected' : '';
                                                                    echo "<option value='".$distribusi['id']."' ".$selected.">".$distribusi['nama_penerima']."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Donatur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Donasi</label>
                            <input type="date" name="tanggal_donasi" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Donasi</label>
                            <input type="number" name="jumlah_donasi" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <select name="id_pekerjaan" class="form-control" required>
                                <?php
                                $query_pekerjaan = mysqli_query($koneksi, "SELECT * FROM pekerjaan");
                                while ($pekerjaan = mysqli_fetch_array($query_pekerjaan)) {
                                    echo "<option value='".$pekerjaan['id']."'>".$pekerjaan['nama_pekerjaan']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Penerima Donasi</label>
                            <select name="id_distribusi" class="form-control" required>
                                <?php
                                $query_distribusi = mysqli_query($koneksi, "SELECT * FROM distribusi");
                                while ($distribusi = mysqli_fetch_array($query_distribusi)) {
                                    echo "<option value='".$distribusi['id']."'>".$distribusi['nama_penerima']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
