<?php
require_once '../db/conn.php';
session_start();


//si la web no encuentra la sesion
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?error=no_session");
    exit;
}

$accion = $_POST["add"] ?? null;
$userId = $_SESSION['user_id'];

switch ($accion) {
    case "avatar":
        avatar($conn, $userId); // Pasamos la conexión como parámetro
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
        pws($conn, $userId);
        break;
    default:
        // Si no hay acción, redirigimos al perfil
        header("Location: ../pages/perfil.php");
        exit;
}


function avatar($conn, $userId)
{
    // 2. Capturamos el nombre que viene del JS
    $nuevoAvatar = $_POST['avatar_nombre'] ?? null;

    if ($nuevoAvatar) {
        try {
            // 3. Preparamos el UPDATE
            $sql = "UPDATE users SET avatar = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            // "si" -> s (string para el avatar), i (integer para el ID)
            $stmt->bind_param("si", $nuevoAvatar, $userId);

            // Ejecutamos una sola vez dentro del IF
            if ($stmt->execute()) {
                // Actualizamos la sesión para que el Home muestre el cambio al instante
                $_SESSION['user_avatar'] = $nuevoAvatar;

                header("Location: ../pages/home.php?update=success");
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            // Error de base de datos en AWS (ej: si la columna no existe)
            header("Location: ../pages/selec_avatar.php?error=sql");
            exit;
        }
    } else {
        // Si por alguna razón no llegó el nombre del avatar
        header("Location: ../pages/selec_avatar.php?error=empty");
        exit;
    }
}

function username($conn, $userId)
{

    // 1. El nombre que quieres verificar
    $nuevousername = $_POST['username'];

    $stmt = $conn->prepare("SELECT COUNT(username) FROM users WHERE username = ?");

    // 2. Pasar el valor al parámetro "?" (la "s" es porque username es un string)
    $stmt->bind_param("s", $nuevousername);

    // 3. Ejecutar
    $stmt->execute();

    // 4. Vincular el resultado a una variable (aquí se guarda el número)
    $stmt->bind_result($conteo);

    // 5. Capturar el valor
    $stmt->fetch();

    // 6. Cerrar
    $stmt->close();


    if ($conteo > 0) {
        header("Location: ../pages/perfil.php?error=locupado");
        exit();
    } else {

        try {
            // 3. Preparamos el UPDATE
            $sql = "UPDATE users SET username = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("si", $nuevousername, $userId);

            if ($stmt->execute()) {
                // Actualizamos la sesión para que el Home muestre el cambio al instante
                $_SESSION['apodo'] = $nuevousername;

                header("Location: ../pages/perfil.php?update=success");
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            header("Location: ../pages/perfil.php?error=sql");
            exit;
        }
    }
}

function apodo($conn, $userId)
{

    $nuevoapodo = $_POST['apodo'] ?? null;

    if ($nuevoapodo) {
        try {
            // 3. Preparamos el UPDATE
            $sql = "UPDATE users SET apodo = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("si", $nuevoapodo, $userId);

            if ($stmt->execute()) {
                // Actualizamos la sesión para que el Home muestre el cambio al instante
                $_SESSION['apodo'] = $nuevoapodo;

                header("Location: ../pages/perfil.php?update=success");
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            header("Location: ../pages/perfil.php?error=sql");
            exit;
        }
    } else {
        // Si por alguna razón no llegó el apodo
        header("Location: ../pages/perfil.php?error=empty");
        exit;
    }
}

function edad($conn, $userId)
{

    $nuevaedad = $_POST['apodo'] ?? null;

    if ($nuevaedad) {
        try {
            // 3. Preparamos el UPDATE
            $sql = "UPDATE users SET edad = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("si", $nuevaedad, $userId);

            if ($stmt->execute()) {
                // Actualizamos la sesión para que el Home muestre el cambio al instante
                $_SESSION['edad'] = $nuevaedad;

                header("Location: ../pages/perfil.php?update=success");
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            header("Location: ../pages/perfil.php?error=sql");
            exit;
        }
    } else {
        // Si por alguna razón no llegó el apodo
        header("Location: ../pages/perfil.php?error=empty");
        exit;
    }
}

function psw($conn, $userId)
{

    //$nuevapsw = $_POST['psw'] ?? null;

    if ($nuevapsw) {
        try {
            // 3. Preparamos el UPDATE
            $sql = "UPDATE users SET psw = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("si", $nuevapsw, $userId);

            if ($stmt->execute()) {
                // Actualizamos la sesión para que el Home muestre el cambio al instante
                $_SESSION['edad'] = $nuevapsw;

                header("Location: ../pages/perfil.php?update=success");
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            header("Location: ../pages/perfil.php?error=sql");
            exit;
        }
    } else {
        // Si por alguna razón no llegó el apodo
        header("Location: ../pages/perfil.php?error=empty");
        exit;
    }
}
