<?php

$host     = "localhost";
$dbname   = "database";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Buat tabel admins jika belum ada
    $pdo->exec("CREATE TABLE IF NOT EXISTS `admins` (
        `id`         int          NOT NULL AUTO_INCREMENT,
        `name`       varchar(100) NOT NULL,
        `email`      varchar(100) NOT NULL,
        `password`   varchar(255) NOT NULL,
        `created_at` timestamp    NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");

    // Buat tabel users jika belum ada
    $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
        `id`         int          NOT NULL AUTO_INCREMENT,
        `name`       varchar(100) NOT NULL,
        `email`      varchar(100) NOT NULL,
        `password`   varchar(255) NOT NULL,
        `created_at` timestamp    NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci");

} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}