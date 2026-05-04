<?php
if (session_status() === PHP_SESSION_NONE) {
    //Esta función busca una cookie en el navegador del usuario llamada PHPSESSID.
    //Si la encuentra, recupera la información guardada en el servidor (como el ID del usuario).
    //Nota: Siempre debe ir en la primera línea de tu archivo, antes de cualquier HTML o espacio en blanco.
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // Si no hay sesión, mandarlo al login
    header("Location: login.php?error=sinsesion");
    exit;
}
?>