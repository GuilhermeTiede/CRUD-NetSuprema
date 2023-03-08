<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'NetSuprema');
define('DB_USER', 'postgre');
define('DB_PASS', '190600');

$dsn = "pgsql:host=".DB_HOST.";dbname=".DB_NAME;

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro de conexão com o banco de dados: " . $e->getMessage();
}