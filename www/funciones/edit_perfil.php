<?php
require_once '../db/conn.php';
session_start();

$accion = $_POST["add"] ?? null;

switch ($accion) {
    case "avatar":
        avatar($conn); // Pasamos la conexión como parámetro
        break;
    case "apodo":
        apodo($conn);
        break;
    case "regis":
        //regis($conn);
        break;
    default:
        // Si no hay acción, redirigimos al index
        header("Location: home.php");
        exit;
}

function avatar($conn)
{

    // 1. Verificación de seguridad
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../index.php?error=no_session");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userId = $_SESSION['user_id'];

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
    } else {
        header("Location: ../pages/home.php");
        exit;
    }
}

function apodo($conn)
{
    
    // 1. Verificación de seguridad
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../index.php?error=no_session");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userId = $_SESSION['user_id'];

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
    } else {
        header("Location: ../pages/home.php");
        exit;
    }
}

function regis($conn)
{
    $modelo = $_POST["Modelo"] ?? '';
    $color = $_POST["Color"] ?? '';

    $stmt = $conn->prepare("INSERT INTO coches (Modelo, Color) VALUES (?, ?)");
    $stmt->bind_param("ss", $modelo, $color);
    $stmt->execute();

    header("Location: index.php?msg=registrado");
}
