<?php
require_once '../db/conn.php';

// Iniciamos la sesión para poder saber qué usuario está conectado.
session_start();


// --------------------------------------------------
// 1. VALIDAR SESIÓN
// --------------------------------------------------

// Si no existe user_id en la sesión, significa que el usuario no ha iniciado sesión.
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?error=sinsesion");
    exit;
}


// --------------------------------------------------
// 2. RECIBIR ACCIÓN DEL FORMULARIO
// --------------------------------------------------

// "add" indica qué dato quiere actualizar el usuario.
// Puede ser: avatar, username, apodo, edad o psw.
$accion = $_POST["add"] ?? null;

// Guardamos el id del usuario conectado.
$userId = $_SESSION['user_id'];


// --------------------------------------------------
// 3. ELEGIR QUÉ FUNCIÓN EJECUTAR
// --------------------------------------------------

switch ($accion) {

    case "avatar":
        avatar($conn, $userId);
        break;

    case "username":
        username($conn, $userId);
        break;

    case "apodo":
        apodo($conn, $userId);
        break;

    case "edad":
        edad($conn, $userId);
        break;

    case "psw":
        psw($conn, $userId);
        break;

    default:
        // Si no llega ninguna acción válida, volvemos al perfil.
        header("Location: ../pages/perfil.php?error=empty");
        exit;
}


// --------------------------------------------------
// FUNCIÓN: ACTUALIZAR AVATAR
// --------------------------------------------------

function avatar($conn, $userId)
{
    // Recibimos el nombre del avatar enviado desde el formulario o JS.
    $nuevoAvatar = $_POST['avatar_nombre'] ?? null;

    // Si no llegó ningún avatar, mandamos error.
    if (!$nuevoAvatar) {
        header("Location: ../pages/selec_avatar.php?error=empty");
        exit;
    }

    try {
        // Actualizamos el avatar del usuario.
        $sql = "UPDATE users SET avatar = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        // "s" = string para avatar.
        // "i" = integer para id.
        $stmt->bind_param("si", $nuevoAvatar, $userId);

        if ($stmt->execute()) {

            // Guardamos el avatar en sesión para que se actualice más rápido en la web.
            $_SESSION['user_avatar'] = $nuevoAvatar;

            // Mandamos al home
            header("Location: ../pages/home.php");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        // Guardamos el error real en el log 
        log::error("Error al actualizar avatar: " . $e->getMessage());

        header("Location: ../pages/selec_avatar.php?error=sql");
        exit;
    }
}


// --------------------------------------------------
// FUNCIÓN: ACTUALIZAR USERNAME
// --------------------------------------------------

function username($conn, $userId)
{
    // Recibimos el nuevo username.
    $nuevousername = trim($_POST['username'] ?? '');

    // Si viene vacío, mandamos error.
    if ($nuevousername === '') {
        header("Location: ../pages/perfil.php?error=empty");
        exit;
    }

    // Comprobamos si ya existe otro usuario con ese username.
    $stmt = $conn->prepare("SELECT COUNT(username) FROM users WHERE username = ? AND id != ?");
    $stmt->bind_param("si", $nuevousername, $userId);
    $stmt->execute();

    // Guardamos el número de coincidencias.
    $stmt->bind_result($conteo);
    $stmt->fetch();
    $stmt->close();

    // Si ya existe, no dejamos actualizar.
    if ($conteo > 0) {
        header("Location: ../pages/perfil.php?error=locupado");
        exit;
    }

    try {
        // Actualizamos el username.
        $sql = "UPDATE users SET username = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nuevousername, $userId);

        if ($stmt->execute()) {

            // Actualizamos el username en sesión.
            $_SESSION['username'] = $nuevousername;

            header("Location: ../pages/perfil.php?update=success");
            exit;
        }
    } catch (mysqli_sql_exception $e) {

        log::error("Error al actualizar username: " . $e->getMessage());
        header("Location: ../pages/perfil.php?error=sql");
        exit;
    }
}


// --------------------------------------------------
// FUNCIÓN: ACTUALIZAR APODO
// --------------------------------------------------

function apodo($conn, $userId)
{
    // Recibimos el nuevo apodo.
    $nuevoapodo = trim($_POST['apodo'] ?? '');

    // Si viene vacío, mandamos error.
    if ($nuevoapodo === '') {
        header("Location: ../pages/perfil.php?error=empty");
        exit;
    }

    try {
        // Actualizamos el apodo.
        $sql = "UPDATE users SET apodo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nuevoapodo, $userId);

        if ($stmt->execute()) {

            // Actualizamos el apodo en sesión.
            $_SESSION['apodo'] = $nuevoapodo;

            header("Location: ../pages/perfil.php?update=success");
            exit;
        }
    } catch (mysqli_sql_exception $e) {

        log::error("Error al actualizar apodo: " . $e->getMessage());
        header("Location: ../pages/perfil.php?error=sql");
        exit;
    }
}


// --------------------------------------------------
// FUNCIÓN: ACTUALIZAR EDAD
// --------------------------------------------------

function edad($conn, $userId)
{
    // Recibimos la nueva edad.
    $nuevaedad = $_POST['edad'] ?? null;

    // Validamos que sea un número.
    if (!$nuevaedad || !is_numeric($nuevaedad)) {
        header("Location: ../pages/perfil.php?error=empty");
        exit;
    }

    // Convertimos la edad a entero.
    $nuevaedad = intval($nuevaedad);

    try {
        // Actualizamos la edad.
        $sql = "UPDATE users SET edad = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        // "i" = integer para edad.
        // "i" = integer para id.
        $stmt->bind_param("ii", $nuevaedad, $userId);

        if ($stmt->execute()) {

            // Actualizamos la edad en sesión.
            $_SESSION['edad'] = $nuevaedad;

            header("Location: ../pages/perfil.php?update=success");
            exit;
        }
    } catch (mysqli_sql_exception $e) {

        log::error("Error al actualizar edad: " . $e->getMessage());
        header("Location: ../pages/perfil.php?error=sql");
        exit;
    }
}


// --------------------------------------------------
// FUNCIÓN: ACTUALIZAR CONTRASEÑA
// --------------------------------------------------

function psw($conn, $userId)
{
    // Recibimos la nueva contraseña.
    $nuevapsw = $_POST['psw'] ?? '';

    // Validamos que no venga vacía.
    if ($nuevapsw === '') {
        header("Location: ../pages/perfil.php?error=empty");
        exit;
    }

    // Creamos un hash seguro de la contraseña.
    $hashed_psw = password_hash($nuevapsw, PASSWORD_DEFAULT);

    try {
        // Actualizamos la contraseña guardando el hash.
        $sql = "UPDATE users SET psw = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        // "s" = string para la contraseña hasheada.
        // "i" = integer para id.
        $stmt->bind_param("si", $hashed_psw, $userId);

        if ($stmt->execute()) {

            // No guardamos la contraseña en sesión.
            // Solo redirigimos con aviso de éxito.
            header("Location: ../pages/perfil.php?update=success");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        log::error("Error al actualizar psw: " . $e->getMessage());
        header("Location: ../pages/perfil.php?error=sql");
        exit;
    }
}
