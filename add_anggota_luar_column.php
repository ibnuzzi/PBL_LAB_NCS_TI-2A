<?php
require_once 'core/config.php';

try {
    $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database successfully.\n";

    $sql = "ALTER TABLE tbl_penelitian ADD COLUMN IF NOT EXISTS anggota_luar TEXT NULL";
    $pdo->exec($sql);

    echo "Column 'anggota_luar' added successfully to 'tbl_penelitian'.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
