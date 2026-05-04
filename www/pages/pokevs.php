<?php

require_once '../db/conn.php';
require_once '../funciones/vs.php';

// Recibimos el número de Pokédex por GET.
// Si no llega ningún id, usamos 1 por defecto.
$pokedex_num = isset($_GET["id"]) ? intval($_GET["id"]) : 1;

// Si el id viene mal o es menor que 1, lo corregimos a 1.
if ($pokedex_num <= 0) {
    $pokedex_num = 1;
}

// Obtenemos todos los datos del análisis VS desde la base de datos.
// Esta función devuelve la información que luego usará JavaScript.
$datosPokeVs = obtenerAnalisisPokeVs($conn, $pokedex_num);

// Cargamos el navbar.
include '../includes/navbar.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poke VS | PokeTeam</title>

    <?php include '../includes/metas.php'; ?>

    <!-- Mismo CSS que pokeinfo para mantener el estilo -->
    <link rel="stylesheet" href="../assets/css/pokeinfo.css" />

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Pasamos los datos de PHP a JavaScript -->
    <script>
        const datosPokeVs = <?php echo json_encode($datosPokeVs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    </script>

    <script src="../assets/js/pokevs.js" defer></script>
</head>

<body>



    <!-- 
        Parte superior igual que pokeinfo.

        Aquí JavaScript mete:
        - botones de volver / siguiente
        - nombre del Pokémon
        - imagen principal
        - pokéball del fondo
    -->
    <div id="pokemon-details"></div>


    <!-- 
        Zona Poke VS.

        Aquí NO usamos descripción, altura, peso, resumen, etc.

        Solo usamos:
        - botones principales
        - botones secundarios
        - frase estilo Pokémon
        - lista de Pokémon como las evoluciones
    -->
    <section class="details">

        <!-- Botones principales: Ataca / Defiende -->
        <div class="tabs" id="botones-modo-vs">
            <span data-modo="ataca" class="tab-activa">Ataca</span>
            <span data-modo="defiende">Defiende</span>
        </div>


        <!-- Botones secundarios: Eficaz / Débil / Inmune -->
        <div class="tabs" id="botones-tipo-vs">
            <span data-tipo="eficaz" class="tab-activa">Eficaz</span>
            <span data-tipo="debil">Débil</span>
            <span data-tipo="inmune">Inmune</span>
        </div>


        <!-- Frase dinámica -->
        <div id="tab-content">

            <div class="tabs__tab active" id="tab_1" data-tab-info>

                <p id="frase-vs"></p>

                <!-- 
                    Aquí se pintan los Pokémon.

                    Usamos la misma clase "evolution",
                    para que se vean como las evoluciones.
                -->
                <div class="evolution" id="resultados-vs"></div>

            </div>

        </div>

    </section>


    <!-- Preloader igual que pokeinfo -->
    <div class="loader-wrapper">
        <div class="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>

</body>

</html>