<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regis Entrenador Pokémon</title>
    <link rel="stylesheet" href="./css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>

    <div class="main-container">
        
        <form class="pokeform">
            
            <div class="form-header">
                <h1 class="form-title">NUEVO ENTRENADOR</h1>
                <div class="pokedex-lights">
                    <span class="light red"></span>
                    <span class="light yellow"></span>
                    <span class="light green"></span>
                </div>
            </div>

            <div class="inputregis">
                <label for="username">nombre de usuario</label>
                <input type="text" id="username" name="username" placeholder="inserta tu nuevo alias" required>
            </div>

            <div class="inputregis">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="********" required>
            </div>

            <div class="inputregis">
                <label for="password">edad</label>
                <input type="number" id="number" name="numbre" placeholder="cualquier edad es valida" required>
            </div>

            <button type="submit">
                <span class="poke_icon"></span>
                crear
            </button>

            <div class="form-footer">
                <p>¿Ya tienes cuenta? <a href="index.php">¡Iniciar sesion!</a></p>
            </div>
        </form>

    </div>

</body>
</html>