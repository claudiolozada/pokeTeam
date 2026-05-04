<?php

// --------------------------------------------------
// 1. PREPARAR VARIABLES DEL AVISO
// --------------------------------------------------

// Aquí guardaremos el mensaje que se va a mostrar.
// Si queda vacío, no se muestra ningún aviso.
$mensaje = "";

// Aquí guardaremos el título del aviso.
// Puede ser "ERROR" o "AVISO", dependiendo del caso.
$titulo_aviso = "";


// --------------------------------------------------
// 2. COMPROBAR SI LLEGÓ UN ERROR POR GET
// --------------------------------------------------

// Ejemplo de URL:
// login.php?error=auth
//
// Si existe $_GET['error'], mostramos un aviso de error.
if (isset($_GET['error'])) {

    // Título principal del aviso cuando es un error.
    $titulo_aviso = "¡¡ERROR!!";

    // Según el valor de error, mostramos un mensaje diferente.
    switch ($_GET['error']) {

        case 'locupado':
            $mensaje = "Ese nombre de usuario ya está en uso. Elige otro.";
            break;

        case 'denegado':
            $mensaje = "Acceso no permitido. Inicia sesión antes de entrar.";
            break;

        case 'auth':
            $mensaje = "Nombre de usuario o contraseña incorrectos.";
            break;

        case 'empty':
            $mensaje = "Asegúrate de insertar bien los datos.";
            break;

        case 'sql':
            $mensaje = "Hubo un problema con la base de datos. Inténtalo más tarde.";
            break;

        case 'sinsesion':
            $mensaje = "No se ha encontrado la sesión. Ingresa nuevamente.";
            break;

        case 'api':
            $mensaje = "No se pudo conectar con la PokéAPI. Intenta nuevamente.";
            break;

        case 'noinfo':
            $mensaje = "Ha ocurrido un error desconocido. Intenta nuevamente.";
            break;

        default:
            $mensaje = "Ha ocurrido un error desconocido en la aventura.";
            break;
    }


    // --------------------------------------------------
    // 3. COMPROBAR SI LLEGÓ UN AVISO DE ACTUALIZACIÓN
    // --------------------------------------------------

    // Ejemplo de URL:
    // perfil.php?update=success
    //
    // Si existe $_GET['update'], mostramos un aviso normal.
} else if (isset($_GET['update'])) {

    // Título principal cuando no es error, sino aviso.
    $titulo_aviso = "¡AVISO!";

    switch ($_GET['update']) {

        case 'success':
            $mensaje = "Cambios realizados exitosamente.";
            break;

        case 'new':
            $mensaje = "Bienvenido a PokeTeam.<br>Selecciona un avatar para continuar.";
            break;

        default:
            $mensaje = "Operación realizada.";
            break;
    }
}


// --------------------------------------------------
// 4. MOSTRAR EL AVISO SOLO SI HAY MENSAJE
// --------------------------------------------------

// Si $mensaje tiene contenido, se pinta el HTML del aviso.
// Si está vacío, no se muestra nada.
if ($mensaje != "") {
?>

    <!-- Fondo oscuro que cubre toda la pantalla -->
    <div id="avisoGlobalOverlay" class="aviso-pantalla">

        <!-- Caja principal del aviso estilo Pokédex -->
        <div class="aviso-pokedex">

            <!-- Luces decorativas superiores -->
            <div class="aviso-luces">
                <div class="aviso-foco rojo"></div>
                <div class="aviso-foco amarillo"></div>
                <div class="aviso-foco verde"></div>
            </div>

            <!-- Título del aviso -->
            <div class="aviso-cabecera">
                <h2 class="aviso-titulo">
                    <?php echo htmlspecialchars($titulo_aviso); ?>
                </h2>
            </div>

            <!-- Mensaje del aviso -->
            <div class="aviso-cuerpo">
                <p>
                    <?php echo $mensaje; ?>
                </p>
            </div>

            <!-- Botón para cerrar el aviso -->
            <button type="button" class="aviso-boton-cerrar" onclick="cerrarAviso()">
                <div class="aviso-bola-centro"></div>
                ENTENDIDO
            </button>

        </div>

    </div>


    <!-- JavaScript para cerrar el aviso y limpiar la URL -->
    <script>
        function cerrarAviso() {
            // Ocultamos el aviso.
            document.getElementById('avisoGlobalOverlay').style.display = 'none';

            // Limpiamos los parámetros de la URL.
            // Así no vuelve a aparecer el aviso al recargar la página.
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>


    <!-- Estilos del aviso global -->
    <style>
        /* Fondo oscuro de pantalla completa */
        .aviso-pantalla {
            position: fixed;
            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            display: flex;
            justify-content: center;
            align-items: center;

            background: rgba(0, 0, 0, 0.75);

            z-index: 10000;
        }

        /* Caja principal del aviso */
        .aviso-pokedex {
            width: 90%;
            max-width: 380px;

            padding: 30px;

            position: relative;

            background-color: #f0f0f0;

            border: 6px solid #333;
            border-radius: 20px;

            box-shadow: 10px 10px 0px rgba(0, 0, 0, 0.4);

            animation: avisoBounce 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        /* Contenedor de las luces */
        .aviso-luces {
            display: flex;
            justify-content: center;
            gap: 12px;

            margin-bottom: 20px;
        }

        /* Estilo general de cada luz */
        .aviso-foco {
            width: 14px;
            height: 14px;

            border-radius: 50%;
            border: 2px solid #333;
        }

        /* Luz roja */
        .aviso-foco.rojo {
            background-color: #ff4136;
        }

        /* Luz amarilla */
        .aviso-foco.amarillo {
            background-color: #ffdc00;
        }

        /* Luz verde */
        .aviso-foco.verde {
            background-color: #2ecc40;
        }

        /* Zona del título */
        .aviso-cabecera {
            text-align: center;

            margin-bottom: 20px;
            padding-bottom: 10px;

            border-bottom: 4px solid #ccc;
        }

        /* Texto del título */
        .aviso-titulo {
            margin: 0;

            font-size: 18px;
            letter-spacing: 1px;

            color: #333;

            font-family: Arial, Helvetica, sans-serif;
        }

        /* Zona del mensaje */
        .aviso-cuerpo {
            text-align: center;

            margin-bottom: 25px;

            font-size: 20px;
            line-height: 1.4;
            font-weight: bold;

            color: #000000;
        }

        /* Botón de cerrar */
        .aviso-boton-cerrar {
            width: 100%;

            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;

            padding: 15px;

            border: 4px solid #333;
            border-radius: 30px;

            background: linear-gradient(180deg, #e3350d 50%, #ffffff 50%);

            font-weight: bold;
            text-transform: uppercase;

            cursor: pointer;

            box-shadow: 0 4px 0 #333;

            transition: 0.2s;
        }

        /* Círculo central del botón estilo Pokéball */
        .aviso-bola-centro {
            width: 18px;
            height: 18px;

            position: relative;

            background: white;

            border: 3px solid #333;
            border-radius: 50%;
        }

        /* Punto interior del círculo */
        .aviso-bola-centro::after {
            content: '';

            position: absolute;
            top: 50%;
            left: 50%;

            width: 6px;
            height: 6px;

            transform: translate(-50%, -50%);

            background: #333;

            border-radius: 50%;
        }

        /* Animación de entrada */
        @keyframes avisoBounce {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Efecto hover del botón */
        .aviso-boton-cerrar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #333;
        }

        /* Efecto al pulsar el botón */
        .aviso-boton-cerrar:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 #333;
        }
    </style>

<?php
}
?>