<?php

require_once "config/database.php";

$name     = "Administrator";
$email    = "admin@gmail.com";
$password = "admin123";

// Membuat password hash
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
// Masukkan ke database
$sql = "INSERT INTO admins (name, email, password) VALUES (:name, :email, :password)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "name"     => $name,
    "email"    => $email,
    "password" => $passwordHash
]);

echo "Admin berhasil dibuat.<br>";
echo "Email: " . htmlspecialchars($email) . "<br>";
echo "Password: " . htmlspecialchars($password);