<?php
require_once '../db/conn.php';
session_start(); // Inicia el motor de sesiones. Crea una "ficha" para el usuario en el servidor.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['psw'] ?? '';
    $edad     = $_POST['edad'] ?? 0; 

    // --- ACCIÓN: REGISTRO ---
    if (isset($_POST['register'])) {
        
        // 1. Verificamos si el nombre ya existe (Seguridad para evitar duplicados en AWS)
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        
        if ($check->get_result()->num_rows > 0) {
            header("Location: ../index.php?error=locupado");
            exit;
        } else {
            // 2. Encriptamos la contraseña
            $hashed_psw = password_hash($password, PASSWORD_DEFAULT);
            
            // 3. Insertamos los datos
            $stmt = $conn->prepare("INSERT INTO users (username, psw, edad) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $username, $hashed_psw, $edad);
            
            if ($stmt->execute()) {
                // --- CLAVE DEL RECUERDO ---
                // Guardamos el ID recién creado en la sesión para que la web sepa quién es.
                $_SESSION['user_id'] = $conn->insert_id; 
                $_SESSION['username'] = $username;

                // Mandamos a la página de avatar
                header("Location: ../pages/selec_avatar.php");
            } else {
                header("Location: ../index.php?error=sql");
            }
        }
        exit;
    }

    // --- ACCIÓN: LOGIN ---
    if (isset($_POST['login'])) {
        // 1. Buscamos al usuario por su nombre
        $stmt = $conn->prepare("SELECT id, username, psw FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        // 2. Comparamos la contraseña escrita con la encriptada en la base de datos
        if ($user && password_verify($password, $user['psw'])) {
            // 3. ¡Éxito! Creamos la sesión para que la web lo "recuerde"
            session_regenerate_id(true); // Medida de seguridad extra
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header("Location: ../pages/home.php");
            exit;
        } else {
            header("Location: ../index.php?error=auth");
            exit;
        }
    }
}
?>