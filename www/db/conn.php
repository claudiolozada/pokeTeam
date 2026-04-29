<?php
require_once 'log.php';

$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = getenv('DB_NAME');

// Forzamos a que MySQLi lance excepciones (mysqli_sql_exception)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Intentamos la conexión directamente
$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

log::info("Base de datos conectada");
// Si llega aquí, la conexión fue exitosa