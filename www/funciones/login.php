<?php
// Conectamos con la base de datos.
require_once '../db/conn.php';

// Iniciamos la sesión.
// La sesión sirve para recordar qué usuario está conectado.
session_start();

// --------------------------------------------------
// 1. COMPROBAR QUE EL FORMULARIO LLEGÓ POR POST
// --------------------------------------------------

// Solo procesamos el archivo si el formulario fue enviado por POST.
// Así evitamos que alguien entre directamente al archivo desde la URL.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recibimos el nombre de usuario.
    // trim() elimina espacios al principio y al final.
    $username = trim($_POST['username'] ?? '');

    // Recibimos la contraseña.
    $password = $_POST['psw'] ?? '';

    // Recibimos la edad.
    // Si no llega edad, usamos 0.
    $edad = $_POST['edad'] ?? 0;


    // --------------------------------------------------
    // 2. ACCIÓN: REGISTRO
    // --------------------------------------------------

    // Si el formulario envió register, procesamos el registro.
    if (isset($_POST['register'])) {

        // Primero comprobamos si el nombre de usuario ya existe.
        // Esto evita tener dos usuarios con el mismo username.
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();

        // Si la consulta devuelve resultados, significa que el username ya está ocupado.
        if ($check->get_result()->num_rows > 0) {

            // Mandamos al index con un error.
            header("Location: ../index.php?error=locupado");
            exit;

        } else {

            // Si el nombre está libre, encriptamos la contraseña.
            // password_hash() guarda la contraseña de forma segura.
            $hashed_psw = password_hash($password, PASSWORD_DEFAULT);

            // Insertamos el nuevo usuario en la base de datos.
            $stmt = $conn->prepare("INSERT INTO users (username, psw, edad) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $username, $hashed_psw, $edad);

            // Si el insert funciona, iniciamos sesión automáticamente.
            if ($stmt->execute()) {

                // Guardamos el id del usuario recién creado en la sesión.
                // insert_id contiene el último id generado por AUTO_INCREMENT.
                $_SESSION['user_id'] = $conn->insert_id;

                // Guardamos también el username en sesión.
                $_SESSION['username'] = $username;

                // Esta constante puede servir para validar acceso a home. (en otro archivo la uso)
                define('ACCESO_HOME', true);

                // Después del registro, mandamos al usuario a elegir avatar.
                header("Location: ../pages/selec_avatar.php?update=new");
                exit;

            } else {

                // Si algo falla al insertar, mandamos error de base de datos.
                header("Location: ../index.php?error=db");
                exit;
            }
        }
    }


    // --------------------------------------------------
    // 3. ACCIÓN: LOGIN
    // --------------------------------------------------

    // Si el formulario envió login, procesamos el inicio de sesión.
    if (isset($_POST['login'])) {

        // Buscamos al usuario por su username.
        $stmt = $conn->prepare("SELECT id, username, psw FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        // Obtenemos los datos del usuario.
        $user = $stmt->get_result()->fetch_assoc();

        // Verificamos que el usuario exista y que la contraseña sea correcta.
        // password_verify() compara la contraseña escrita con la contraseña encriptada.
        if ($user && password_verify($password, $user['psw'])) {

            // Regeneramos el id de sesión como medida de seguridad.
            // Esto ayuda a evitar ataques de fijación de sesión.
            session_regenerate_id(true);

            // Guardamos los datos principales del usuario en sesión.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Esta constante puede servir para validar acceso a home si la usas en otro archivo.
            define('ACCESO_HOME', true);

            // Mandamos al usuario al home.
            header("Location: ../pages/home.php");
            exit;

        } else {

            // Si el usuario no existe o la contraseña está mal, mandamos error.
            header("Location: ../index.php?error=auth");
            exit;
        }
    }


    // --------------------------------------------------
    // 4. ACCIÓN: CERRAR SESIÓN
    // --------------------------------------------------

    // Si llega exit por POST, cerramos la sesión.
    if (isset($_POST['exit'])) {

        // Por seguridad, comprobamos que la sesión esté iniciada.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vaciamos todas las variables guardadas en la sesión.
        session_unset();

        // Destruimos la sesión actual.
        session_destroy();

        // Mandamos al usuario al index.
        header("Location: ../index.php");
        exit;
    }
}

?>