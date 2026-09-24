<?php
session_start();

// Cek apakah user biasa sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

$userName  = $_SESSION["user_name"]  ?? "";
$userEmail = $_SESSION["user_email"] ?? "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard pengguna.">
    <title>Dashboard Pengguna</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">

        <!-- NAVBAR -->
        <nav class="navbar">
            <h2>User Panel</h2>
            <a href="../auth/logout.php" class="btn-logout" id="btnLogout">Logout</a>
        </nav>

        <!-- CONTENT -->
        <main class="dashboard-content">
            <div class="dashboard-card">
                <h1>Selamat Datang, <?= htmlspecialchars($userName) ?>!</h1>
                <p>Anda berhasil login sebagai pengguna.</p>
                <br>
                <p><strong>Email:</strong> <?= htmlspecialchars($userEmail) ?></p>
            </div>
        </main>

    </div>

    <!-- LOGOUT CONFIRMATION MODAL -->
    <div class="logout-overlay" id="logoutOverlay" role="dialog" aria-modal="true" aria-labelledby="logoutModalTitle">
        <div class="logout-modal">
            <div class="logout-modal-icon">🚪</div>
            <h2 id="logoutModalTitle">Konfirmasi Logout</h2>
            <p>Apakah Anda yakin ingin keluar dari sistem?</p>
            <div class="logout-modal-actions">
                <button class="btn-cancel-logout" id="btnCancelLogout">Batal</button>
                <button class="btn-confirm-logout" id="btnConfirmLogout">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <script src="../assets/js/logout-modal.js"></script>
</body>
</html>
