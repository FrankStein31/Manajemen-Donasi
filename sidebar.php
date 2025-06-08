<?php
if (!isset($_SESSION['id'])) {
    header("Location: ../");
}
?>
<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar min-vh-100">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4">
            <h5 class="text-white">Manajemen Donasi</h5>
            <small class="text-muted">Selamat datang, <?= $_SESSION['nama'] ?></small>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'dashboard') ? 'active bg-primary' : '' ?>" href="../dashboard">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'pekerjaan') ? 'active bg-primary' : '' ?>" href="../pekerjaan">
                    <i class="fas fa-briefcase me-2"></i>
                    Pekerjaan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'distribusidana') ? 'active bg-primary' : '' ?>" href="../distribusidana">
                    <i class="fas fa-hand-holding-usd me-2"></i>
                    Distribusi Dana
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'donatur') ? 'active bg-primary' : '' ?>" href="../donatur">
                    <i class="fas fa-users me-2"></i>
                    Donatur
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'profile') ? 'active bg-primary' : '' ?>" href="../profile">
                    <i class="fas fa-user me-2"></i>
                    Profile
                </a>
            </li>
            <li class="nav-item mt-3">
                <a class="nav-link text-danger" href="../logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</nav>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
.sidebar {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.nav-link {
    padding: 0.8rem 1rem;
    border-radius: 5px;
    margin: 0.2rem 0.5rem;
    transition: all 0.3s;
}

.nav-link:hover {
    background-color: rgba(255,255,255,0.1);
}

.nav-link.active {
    font-weight: bold;
}

.text-muted {
    color: #adb5bd !important;
}
</style> 