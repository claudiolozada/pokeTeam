<?php
session_start();
// Recogemos el ID del Pokémon que viene de la pantalla anterior
$pokemon_id = isset($_POST['add']) ? $_POST['add'] : null;

// Si se intenta acceder sin un ID válido, redirigimos al home
if (!$pokemon_id) {
    header("Location: ../pages/home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Un momento!</title>
    <!-- Importamos la fuente que usas en tu proyecto principal -->
    <link rel="stylesheet" href="../css/tu_estilo.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: "Jersey 25", sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            color: white;

            background:
                radial-gradient(circle at 15% 20%, rgba(112, 114, 212, 0.18) 0 70px, transparent 72px),
                radial-gradient(circle at 85% 75%, rgba(41, 59, 98, 0.16) 0 120px, transparent 122px),
                radial-gradient(circle at 75% 18%, rgba(0, 0, 255, 0.11) 0 55px, transparent 57px),
                linear-gradient(135deg, #05012e 0%, #000 45%, #08012a 100%);

            background-attachment: fixed;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -1;

            background-image:
                linear-gradient(rgba(255, 255, 255, 0.05) 2px, transparent 2px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 2px, transparent 2px);

            background-size: 45px 45px;
        }

        /* Ventana de mensaje estilo Game Boy Advance / DS */
        .pokemon-dialog-box {
            background-color: #f8f8f8;
            border: 6px solid #202020;
            border-radius: 12px;
            box-shadow: 10px 10px 0 rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 550px;
            padding: 35px;
            position: relative;
            image-rendering: pixelated;
        }

        /* Icono de flecha que parpadea abajo a la derecha */
        .pokemon-dialog-box::after {
            content: "▼";
            position: absolute;
            right: 25px;
            font-size: 1.5em;
            color: #202020;
            animation: bounce 0.6s infinite alternate;
        }

        @keyframes bounce {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(6px);
            }
        }

        h2 {
            font-size: 2.4em;
            color: #202020;
            margin: 0 0 30px 0;
            line-height: 1.1;
            text-transform: uppercase;
        }

        .opciones-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Botones con el estilo .addpoke de tu CSS original */
        .btn-pokemon {
            padding: 15px;
            font-size: 1.6em;
            font-family: "Jersey 25", sans-serif;
            cursor: pointer;
            border: 4px solid #202020;
            background: white;
            border-radius: 15px;
            box-shadow: 5px 5px 0 #202020;
            transition: all 0.1s;
            text-transform: uppercase;
        }

        .btn-pokemon:active {
            transform: translate(3px, 3px);
            box-shadow: 2px 2px 0 #202020;
        }

        .btn-si:hover {
            background-color: #5FBD58;
            color: white;
        }

        .btn-no:hover {
            background-color: #D3425F;
            color: white;
        }

        /* Contenedor del Input (oculto inicialmente) */
        #input-container {
            display: none;
            margin-top: 20px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-mote {
            width: 100%;
            padding: 15px;
            font-size: 1.8em;
            font-family: "Jersey 25", sans-serif;
            border: 4px solid #202020;
            border-radius: 10px;
            box-sizing: border-box;
            background: #fff;
            margin-bottom: 20px;
        }

        .btn-full {
            width: 100%;
            background-color: #202020;
            color: white;
        }
    </style>
</head>

<body>

    <div class="pokemon-dialog-box">
        <h2 id="pregunta">¿Quieres ponerle un apodo a tu nuevo POKÉMON?</h2>

        <!-- Botones de decisión -->
        <div class="opciones-grid" id="menu-opciones">
            <button type="button" class="btn-pokemon btn-si" onclick="activarMote()">SÍ</button>
            <button type="button" class="btn-pokemon btn-no" onclick="enviarDirecto()">NO</button>
        </div>

        <!-- Formulario oculto -->
        <form id="form-poke" action="../funciones/equipo_poke.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($pokemon_id); ?>">

            <div id="input-container">
                <input type="text" name="apodo" class="input-mote" placeholder="NOMBRE DEL MOTE..." maxlength="15" id="field-mote" autocomplete="off">
                <button type="submit" class="btn-pokemon btn-full">¡CONFIRMAR!</button>
            </div>
        </form>
    </div>

    <script>
        function activarMote() {
            // Cambiamos el texto para que parezca que el profesor te pregunta
            document.getElementById('pregunta').innerText = "¿Qué mote le pondrás?";
            document.getElementById('menu-opciones').style.display = 'none';
            document.getElementById('input-container').style.display = 'block';
            document.getElementById('field-mote').focus();
        }

        function enviarDirecto() {
            // Envía el formulario tal cual (el campo 'mote' irá vacío)
            document.getElementById('form-poke').submit();
        }
    </script>
</body>

</html>