<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../");
}

if (isset($_POST['edit'])) {
    $id = $_SESSION['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    mysqli_query($koneksi, "UPDATE user SET nama='$nama', username='$username', password='$password' WHERE id='$id'");
    $_SESSION['nama'] = $nama;
    header("Location: ./");
}

$query = mysqli_query($koneksi, "SELECT * FROM user WHERE id='".$_SESSION['id']."'");
$data = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile - Manajemen Donasi</title>
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
                    <h1 class="h2">Profile</h1>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card fade-in">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <div class="avatar mb-3">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <h4><?= $data['nama'] ?></h4>
                                </div>
                                <form method="post">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-user text-primary"></i></span>
                                            <input type="text" name="nama" class="form-control border-start-0" value="<?= $data['nama'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-user-tag text-primary"></i></span>
                                            <input type="text" name="username" class="form-control border-start-0" value="<?= $data['username'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-lock text-primary"></i></span>
                                            <input type="password" name="password" class="form-control border-start-0" value="<?= $data['password'] ?>" required>
                                        </div>
                                    </div>
                                    <button type="submit" name="edit" class="btn btn-primary w-100">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #2980b9, #3498db);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: white;
            font-size: 50px;
            box-shadow: 0 5px 15px rgba(41, 128, 185, 0.3);
        }
        h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 30px;
        }
    </style>
</body>
</html> 