<?php

// Si alguien intenta entrar directo, esta constante no existirá
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?error=denegado");
    exit();
}