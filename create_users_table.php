<?php
/**
 * Script sekali pakai untuk membuat tabel users.
 * HAPUS file ini setelah berhasil dijalankan!
 */
require_once "config/database.php";

$sql = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

try {
    $pdo->exec($sql);
    echo "<p style='color:green; font-family:sans-serif; font-size:18px;'>
        ✅ Tabel <strong>users</strong> berhasil dibuat!<br><br>
        <strong>Sekarang hapus file ini: <code>create_users_table.php</code></strong>
    </p>";
} catch (PDOException $e) {
    echo "<p style='color:red; font-family:sans-serif;'>❌ Gagal: " . $e->getMessage() . "</p>";
}
