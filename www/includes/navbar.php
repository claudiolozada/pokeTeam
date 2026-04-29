<?php
// 1. Iniciamos sesión de forma segura
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Conexión y extracción de datos (Solo una vez)
require_once __DIR__ . '/../db/conn.php';

$usuario = null;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    // Extraemos todo lo necesario de la tabla 'users' q serian: id,username,psw,apodo,edad,avatar
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $usuario = $stmt->get_result()->fetch_assoc();
}

// 3. Definimos variables por defecto por si falla algo o no hay sesión
$nombre = $usuario['username'] ?? 'Invitado';
$avatar = "../assets/img/personajes/avatar/" . ($usuario['avatar'] ?? "chico1.png");
$ftavatar = "../assets/img/personajes/perfil/" . ($usuario['avatar'] ?? "chico1.png");
$apodo = $usuario['apodo'] ?? $nombre;
$edad = $usuario['edad'] ?? "desconocida";
?>

<link rel="icon" href="../assets/img/logo.png" type="image/png">
<link rel="stylesheet" href="../assets/css/navbar.css">
<script src="../assets/js/navbar.js" defer></script>

<nav class="navbar-pokemon">
    <div class="navbar-logo">
        <a href="home.php">
            <img src="../assets/img/logo.png" alt="Logo" class="navbar-avatar">
        </a>
    </div>

    <ul class="navbar-links">
        <li><a href="home.php">Home</a></li>
        <li><a href="buscar.php">Buscar</a></li>
        <li><a href="perfil.php">Perfil</a></li>
        <li><a href="equipo.php">Equipo</a></li>
        <li><a href="pokedex.php">Pokédex</a></li>
        <li><a href="tipos.php">Tabla de tipos</a></li>
        <li><a href="favoritos.php">Favoritos</a></li>
    </ul>

    <div class="navbar-user" id="openUserMenu">
        <span class="navbar-username">
            <?php echo htmlspecialchars($nombre); ?>
        </span>

        <img src="<?php echo $ftavatar; ?>" 
             alt="Avatar" 
             class="navbar-avatar">
    </div>
</nav>

<div class="overlay-menu" id="overlayMenu"></div>

<aside class="user-side-menu" id="userSideMenu">
    <button class="close-menu" id="closeUserMenu">×</button>

    <div class="side-profile">
        <img src="<?php echo $ftavatar; ?>" 
             alt="Foto de perfil" 
             class="side-avatar">

        <h2>
            <?php echo htmlspecialchars($apodo); ?>
        </h2>
    </div>

    <div class="side-options">
        <a href="../pages/editar-cuenta.php">Editar cuenta</a>
        <a href="../pages/favoritos.php">Ver favoritos</a>
        <a href="../pages/equipo.php">Mostrar equipo Pokémon</a>
        <a href="../index.php" class="logout-link">Cerrar sesión</a>
    </div>
</aside>