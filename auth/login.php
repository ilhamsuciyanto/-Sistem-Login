<?php
session_start();
require_once "../config/database.php";

// Jika sudah login
if (isset($_SESSION['admin_id'])) {
    header("Location: ../dashboard/index.php");
    exit;
}
if (isset($_SESSION['user_id'])) {
    header("Location: ../user_dashboard/index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (empty($email) || empty($password)) {
        $error = "Email dan password wajib diisi.";
    } else {
        // Cek admin dulu
        $sqlAdmin = "SELECT * FROM admins WHERE email = :email LIMIT 1";
        $stmtAdmin = $pdo->prepare($sqlAdmin);
        $stmtAdmin->execute(["email" => $email]);
        $admin = $stmtAdmin->fetch();

        if ($admin && password_verify($password, $admin["password"])) {
            session_regenerate_id(true);
            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_name"] = $admin["name"];
            $_SESSION["admin_email"] = $admin["email"];
            header("Location: ../dashboard/index.php");
            exit;
        } else {
            // Cek user biasa
            $sqlUser = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmtUser = $pdo->prepare($sqlUser);
            $stmtUser->execute(["email" => $email]);
            $user = $stmtUser->fetch();

            if ($user && password_verify($password, $user["password"])) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];
                header("Location: ../user_dashboard/index.php");
                exit;
            } else {
                $error = "Email atau password salah.";
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
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="admin-icon">👤</div>
                <h1>Login Sistem</h1>
                <p>Silakan login untuk melanjutkan</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" autocomplete="off">
                <!-- EMAIL -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Masukkan email" 
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        required
                    >
                </div>

                <!-- PASSWORD -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password" 
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

                <!-- BUTTON -->
                <button type="submit" class="btn-login">Login</button>
                <a href="register.php" class="auth-link">Belum punya akun? Daftar di sini</a>
            </form>
        </div>
    </div>

    <script src="../assets/js/login.js"></script>
</body>
</html>