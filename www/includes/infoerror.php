<?php
// 1. LÓGICA PARA PROCESAR EL MENSAJE
if (isset($_GET['error']) || isset($_GET['update'])) {
    $mensaje = "";
    $titulo_aviso = "¡¡ERROR!!"; // Título estilo Pokédex

    switch ($_GET['error']) {
        case 'locupado':
            $mensaje = "Ese nombre de usuario ya está en uso. Elige otro.";
            break;
        case 'auth':
            $mensaje = "nombre de usuario o contraceña incorrectos.";
            break;
        case 'empty':
            $mensaje = "Asegúrate de insertar bien los datos.";
            break;
        case 'sql':
            $mensaje = "Hubo un problema con la base de datos. Inténtalo más tarde.";
            break;
        default:
            $mensaje = "Ha ocurrido un error desconocido en la aventura.";
            break;
    }

    switch ($_GET['update']) {
        case 'success':
            $titulo_aviso = "¡AVISO :)!";
            $mensaje = "Cambios realizados exitosamente.";
            break;
    }

    // 2. MOSTRAR EL AVISO SOLO SI HAY UN MENSAJE
    if ($mensaje != "") {
?>
        <!-- Estructura HTML del Aviso -->
        <div id="avisoGlobalOverlay" class="aviso-pantalla">
            <div class="aviso-pokedex">
                <!-- Luces de estado superiores -->
                <div class="aviso-luces">
                    <div class="aviso-foco rojo"></div>
                    <div class="aviso-foco amarillo"></div>
                    <div class="aviso-foco verde"></div>
                </div>

                <div class="aviso-cabecera">
                    <h2 class="aviso-titulo"><?php echo $titulo_aviso; ?></h2>
                </div>

                <div class="aviso-cuerpo">
                    <p><?php echo $mensaje; ?></p>
                </div>

                <button type="button" class="aviso-boton-cerrar" onclick="cerrarAviso()">
                    <div class="aviso-bola-centro"></div>
                    ENTENDIDO
                </button>
            </div>
        </div>

        <!-- Script para cerrar y limpiar URL -->
        <script>
            function cerrarAviso() {
                document.getElementById('avisoGlobalOverlay').style.display = 'none';
                // Limpia los parámetros de la URL (?error=...) para que no se repita al recargar
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        </script>

        <!-- Estilos CSS Únicos -->
        <style>
            .aviso-pantalla {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.75);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 10000;
            }

            .aviso-pokedex {
                background-color: #f0f0f0;
                width: 90%;
                max-width: 380px;
                padding: 30px;
                border: 6px solid #333;
                border-radius: 20px;
                box-shadow: 10px 10px 0px rgba(0, 0, 0, 0.4);
                position: relative;
                animation: avisoBounce 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            }

            .aviso-luces {
                display: flex;
                justify-content: center;
                gap: 12px;
                margin-bottom: 20px;
            }

            .aviso-foco {
                width: 14px;
                height: 14px;
                border-radius: 50%;
                border: 2px solid #333;
            }

            .aviso-foco.rojo {
                background-color: #ff4136;
            }

            .aviso-foco.amarillo {
                background-color: #ffdc00;
            }

            .aviso-foco.verde {
                background-color: #2ecc40;
            }

            .aviso-cabecera {
                text-align: center;
                border-bottom: 4px solid #ccc;
                margin-bottom: 20px;
                padding-bottom: 10px;
            }

            .aviso-titulo {
                font-size: 18px;
                color: #333;
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
                letter-spacing: 1px;
            }

            .aviso-cuerpo {
                text-align: center;
                margin-bottom: 25px;
                font-size: 20px;
                line-height: 1.4;
                color: #000000;
                font-weight: bold;
            }

            .aviso-boton-cerrar {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 10px;
                width: 100%;
                padding: 15px;
                border: 4px solid #333;
                border-radius: 30px;
                background: linear-gradient(180deg, #e3350d 50%, #ffffff 50%);
                font-weight: bold;
                cursor: pointer;
                transition: 0.2s;
                box-shadow: 0 4px 0 #333;
                text-transform: uppercase;
            }

            .aviso-bola-centro {
                width: 18px;
                height: 18px;
                background: white;
                border: 3px solid #333;
                border-radius: 50%;
                position: relative;
            }

            .aviso-bola-centro::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 6px;
                height: 6px;
                background: #333;
                border-radius: 50%;
            }

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

            .aviso-boton-cerrar:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 0 #333;
            }

            .aviso-boton-cerrar:active {
                transform: translateY(2px);
                box-shadow: 0 1px 0 #333;
            }
        </style>
<?php
    }
}
?>