<?php
require_once '../db/conn.php';
session_start();

$accion = $_POST["add"] ?? null;

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?error=no_session");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];

    switch ($accion) {
        case "avatar":
            avatar($conn, $userId); // Pasamos la conexión como parámetro
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
            // Si no hay acción, redirigimos al home
            header("Location: home.php");
            exit;
    }
} else {
    header("Location: ../pages/home.php");
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
