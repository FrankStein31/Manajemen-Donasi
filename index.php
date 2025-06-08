<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        header("Location: dashboard/");
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Manajemen Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #2980b9, #8e44ad);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: fadeIn 1s;
            backdrop-filter: blur(5px);
            background: rgba(255, 255, 255, 0.95);
        }
        .login-card .card-body {
            padding: 50px;
        }
        .logo {
            width: 90px;
            height: 90px;
            background: linear-gradient(45deg, #2980b9, #3498db);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            color: white;
            font-size: 45px;
            box-shadow: 0 5px 15px rgba(41, 128, 185, 0.3);
            transition: transform 0.3s;
        }
        .logo:hover {
            transform: scale(1.05);
        }
        .input-group {
            margin-bottom: 25px;
        }
        .input-group-text {
            border-radius: 12px 0 0 12px;
            border: 2px solid transparent;
            background: #f8f9fa;
            color: #2980b9;
            width: 50px;
            justify-content: center;
        }
        .input-group .form-control {
            border-radius: 0 12px 12px 0;
            padding: 12px;
            font-size: 16px;
            background: #f8f9fa;
            border: 2px solid transparent;
            transition: all 0.3s;
        }
        .input-group:focus-within .input-group-text {
            border-color: #2980b9;
            background: #fff;
            color: #2980b9;
        }
        .input-group:focus-within .form-control {
            background: #fff;
            border-color: #2980b9;
            box-shadow: none;
        }
        .btn-login {
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .alert {
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
            border: none;
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            font-size: 14px;
            font-weight: 500;
        }
        h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 30px;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card login-card">
                    <div class="card-body">
                        <div class="logo">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h4 class="text-center">Manajemen Donasi</h4>
                        <?php if(isset($error)): ?>
                        <div class="alert alert-danger text-center">
                            <?= $error ?>
                        </div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100 btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>