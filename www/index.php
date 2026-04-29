<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Entrenador Pokémon</title>
    <?php include './includes/metas.php'; ?>
    <link rel="icon" href="./assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>

    <?php
    // Verificamos si existe el parámetro "error" en la URL
    if (isset($_GET['error'])) {
        if ($_GET['error'] == "exists") {
            $error = "El nombre de usuario ya está en uso. Prueba con otro.";
        } elseif ($_GET['error'] == "empty") {
            $error = "Todos los campos son obligatorios.";
        }
        // Puedes agregar más condiciones aquí
    }
    ?>

    <div class="main-container">

        <form id="rsvpForm" class="pokeform" action="./funciones/login.php" method="POST">

            <div class="form-header">
                <h1 class="form-title">ACCESO ENTRENADOR</h1>
                <div class="pokedex-lights">
                    <span class="light red"></span>
                    <span class="light yellow"></span>
                    <span class="light green"></span>
                </div>
            </div>

            <input type="text" name="login" value="login" hidden>

            <div class="inputregis">
                <label for="username">nombre de usuario</label>
                <input type="text" id="username" name="username" placeholder="inserta tu alias..." required>
            </div>

            <div class="inputregis">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="psw" placeholder="********" required>
            </div>

            <div>
                <button type="submit">
                    <span class="poke_icon"></span> INGRESAR
                </button>

                <!-- mostrar error -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-error">
                        <p style="color: red;">
                            <?php echo htmlspecialchars($error); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-footer">
                <p>¿No tienes cuenta? <a href="./pages/registrarse.php">¡Regístrate aquí!</a></p>
            </div>
        </form>

    </div>

</body>

</html>