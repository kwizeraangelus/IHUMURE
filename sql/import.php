<?php
require __DIR__ . '/../config/config.php';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$pdo = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8mb4', DB_USER, DB_PASS, $options);
$dbName = preg_replace('/[^a-zA-Z0-9_]/', '', DB_NAME);
$pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$pdo->exec("USE `$dbName`");

$sql = file_get_contents(__DIR__ . '/ihumure.sql');
$sql = preg_replace('/^--.*$/m', '', $sql);
$parts = array_filter(array_map('trim', explode(';', $sql)));

foreach ($parts as $stmt) {
    if ($stmt === '' || preg_match('/^(CREATE DATABASE|USE)\b/i', $stmt)) {
        continue;
    }
    $pdo->exec($stmt);
}

echo "OK: database `$dbName` is ready.\n";
$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
foreach ($tables as $t) {
    echo "- $t\n";
}
