<?php

// Si no hay una sesión iniciada, la iniciamos.
// Esto permite usar $_SESSION para saber qué usuario está conectado.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión a la base de datos.
// __DIR__ ayuda a que la ruta funcione aunque este archivo se incluya desde otra página.
require_once __DIR__ . '/../db/conn.php';

// Archivo donde puedes validar accesos o proteger páginas.
// Por ejemplo, evitar que usuarios no logueados entren a ciertas zonas.
include 'acceso_validar.php';


// Por defecto, no tenemos datos del usuario.
$usuario = null;


// Si existe user_id en la sesión, significa que hay un usuario conectado.
if (isset($_SESSION['user_id'])) {

    // Guardamos el id del usuario que está en sesión.
    $userId = $_SESSION['user_id'];

    // Buscamos en la base de datos todos los datos de ese usuario.
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Guardamos los datos del usuario en un array asociativo.
    $usuario = $stmt->get_result()->fetch_assoc();
}

// Si hay usuario conectado, usamos su username.
// Si no, mostramos "Invitado" (aunq es muy poco provable lo pondre para evitar algun error).
$nombre = $usuario['username'] ?? 'Invitado';


// Ruta del avatar.
// Se usa para mostrar el personaje seleccionado.
$avatar = "../assets/img/personajes/avatar/" . ($usuario['avatar'] ?? "chico1.png");


// Ruta de la imagen de perfil. viene por default al elejir avatar
// Esta es la que se muestra en el navbar y en el menú lateral.
$ftavatar = "../assets/img/personajes/perfil/" . ($usuario['avatar'] ?? "chico1.png");


// Apodo del usuario.
// Si no tiene apodo, usamos el username.
$apodo = $usuario['apodo'] ?? $nombre;


// Edad del usuario.
// Si no tiene edad guardada, mostramos "desconocida".
$edad = $usuario['edad'] ?? "desconocida";

?>

<!-- CSS y JavaScript  -->
<link rel="stylesheet" href="../assets/css/navbar.css">
<script src="../assets/js/navbar.js" defer></script>

<!-- Wrapper para aislar el navbar del resto de la página -->
<div class="navbar-wrapper">

    <!-- Barra de navegación principal -->
    <nav class="navbar-pokemon">

        <!-- Logo de PokeTeam -->
        <div class="navbar-logo">
            <a href="home.php">
                <img src="../assets/img/logo.png" alt="Logo">
            </a>
        </div>


        <!-- Enlaces principales de navegación -->
        <ul class="navbar-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="buscar.php">Enfrentamientos</a></li>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="equipo.php">Equipo</a></li>
            <li><a href="pokedex.php">Pokédex</a></li>
            <li><a href="tipos.php">Tabla de tipos</a></li>
        </ul>


        <!-- Zona del usuario: nombre + avatar -->
        <!-- Al hacer click, JS abre el menú lateral -->
        <div class="navbar-user" id="openUserMenu">

            <span class="navbar-username">
                <?php echo htmlspecialchars($nombre); ?>
            </span>

            <img
                src="<?php echo htmlspecialchars($ftavatar); ?>"
                alt="Avatar"
                class="navbar-avatar">

        </div>

    </nav>


    <!-- Capa oscura que aparece detrás del menú lateral -->
    <div class="overlay-menu" id="overlayMenu"></div>


    <!-- Menú lateral del usuario -->
    <aside class="user-side-menu" id="userSideMenu">

        <!-- Botón para cerrar el menú lateral -->
        <button class="close-menu" id="closeUserMenu">×</button>


        <!-- Información rápida del perfil -->
        <div class="side-profile">

            <img
                src="<?php echo htmlspecialchars($ftavatar); ?>"
                alt="Foto de perfil"
                class="side-avatar">

            <h2>
                <?php echo htmlspecialchars($apodo); ?>
            </h2>

        </div>


        <!-- Opciones del menú lateral -->
        <div class="side-options">

            <a href="../pages/perfil.php">Editar cuenta</a>
            <a href="../pages/pokedex.php">Ver pokedex</a>
            <a href="../pages/equipo.php">Mostrar equipo Pokémon</a>


            <!-- Formulario para cerrar sesión -->
            <!-- Enviamos un POST a login.php indicando que queremos salir -->
            <form id="exit" action="../funciones/login.php" method="POST">

                <input type="text" name="exit" value="exit" hidden>

                <button type="submit" class="logout-link">
                    Cerrar sesión
                </button>

            </form>

        </div>

    </aside>

</div>


<!-- Archivo para mostrar mensajes de error o avisos generales -->
<?php include 'infoerror.php'; ?>