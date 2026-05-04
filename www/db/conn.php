<?php
require_once 'log.php';

$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = getenv('DB_NAME');

// Forzamos a que MySQLi lance excepciones (mysqli_sql_exception)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Intentamos conectar a la base de datos
    $conn = new mysqli($host, $user, $pass, $db);

    // Configuramos los caracteres
    $conn->set_charset("utf8mb4");

    // Si llega aquí, la conexión fue exitosa
    log::info("Base de datos conectada");

} catch (mysqli_sql_exception $e) {

    // Guardamos el error real en el log, pero NO se lo mostramos al usuario
    log::error("Error al conectar con la base de datos: " . $e->getMessage());

    // Redirigimos al index con un mensaje de error
    header("Location: ../index.php?error=sql");
    exit;
}