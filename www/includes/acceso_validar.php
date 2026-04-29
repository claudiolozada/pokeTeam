<?php
// Si alguien intenta entrar directo, esta constante no existirá
if (!defined('ACCESO_DASHBOARD')) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso directo no permitido.");
}