<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regis Entrenador Pokémon</title>
    <?php include '../includes/metas.php'; ?>
    <link rel="icon" href="../assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

    <div class="main-container">
        
        <form id="rsvpForm" class="pokeform" action="../funciones/login.php" method="POST">
            
            <div class="form-header">
                <h1 class="form-title">NUEVO ENTRENADOR</h1>
                <div class="pokedex-lights">
                    <span class="light red"></span>
                    <span class="light yellow"></span>
                    <span class="light green"></span>
                </div>
            </div>

            <input type="text" name="register" value="register" hidden>

            <div class="inputregis">
                <label for="username">nombre de usuario</label>
                <input type="text" id="username" name="username" placeholder="inserta tu nuevo alias" required>
            </div>

            <div class="inputregis">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="psw" placeholder="********" required>
            </div>

            <div class="inputregis">
                <label for="edad">edad</label>
                <input type="number" id="edad" name="edad" placeholder="cualquier edad es valida" required>
            </div>

            <button type="submit">
                <span class="poke_icon"></span>
                crear
            </button>

            <div class="form-footer">
                <p>¿Ya tienes cuenta? <a href="../index.php">¡Iniciar sesion!</a></p>
            </div>
        </form>

    </div>

</body>
<?php include 'infoerror.php'; ?>
</html>