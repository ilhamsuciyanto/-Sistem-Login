<?php
session_start();
require_once "../config/database.php";

// Jika sudah login, redirect sesuai role
if (isset($_SESSION['admin_id'])) {
    header("Location: ../dashboard/index.php");
    exit;
}
if (isset($_SESSION['user_id'])) {
    header("Location: ../user_dashboard/index.php");
    exit;
}

$error   = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = trim($_POST["name"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (empty($name) || empty($email) || empty($password)) {
        $error = "Semua kolom wajib diisi.";
    } else {
        // Cek apakah email sudah terdaftar di tabel admins
        $stmtAdmin = $pdo->prepare("SELECT id FROM admins WHERE email = :email LIMIT 1");
        $stmtAdmin->execute(["email" => $email]);
        $isAdmin = $stmtAdmin->fetch();

        // Cek apakah email sudah terdaftar di tabel users
        $stmtUser = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $stmtUser->execute(["email" => $email]);
        $isUser = $stmtUser->fetch();

        if ($isAdmin || $isUser) {
            $error = "Email sudah digunakan, silakan gunakan email lain.";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)"
            );
            try {
                $stmt->execute([
                    "name"     => $name,
                    "email"    => $email,
                    "password" => $passwordHash,
                ]);
                $success = "Registrasi berhasil! Silakan login dengan akun Anda.";
                // Kosongkan POST agar form bersih setelah berhasil
                $_POST = [];
            } catch (PDOException $e) {
                $error = "Terjadi kesalahan saat menyimpan data.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman registrasi pengguna baru.">
    <title>Registrasi Pengguna</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">

            <div class="login-header">
                <div class="admin-icon">📝</div>
                <h1>Buat Akun</h1>
                <p>Silakan daftar untuk membuat akun baru</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert-error" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert-success" role="status">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" autocomplete="off">

                <!-- NAMA LENGKAP -->
                <div class="form-group">
                    <label for="reg-name">Nama Lengkap</label>
                    <input
                        type="text"
                        id="reg-name"
                        name="name"
                        placeholder="Masukkan nama lengkap"
                        value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                        required
                    >
                </div>

                <!-- EMAIL -->
                <div class="form-group">
                    <label for="reg-email">Email</label>
                    <input
                        type="email"
                        id="reg-email"
                        name="email"
                        placeholder="Masukkan email"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        required
                    >
                </div>

                <!-- PASSWORD -->
                <div class="form-group">
                    <label for="reg-password">Password</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="reg-password"
                            name="password"
                            placeholder="Buat password"
                            required
                        >
                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>
                    </div>
                </div>

                <!-- TOMBOL DAFTAR -->
                <button type="submit" class="btn-login">Daftar</button>

                <a href="login.php" class="auth-link">Sudah punya akun? Login di sini</a>
            </form>

        </div>
    </div>

    <script src="../assets/js/login.js"></script>
</body>
</html>
