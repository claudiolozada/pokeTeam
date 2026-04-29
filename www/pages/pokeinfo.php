<?php

include '../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles Pokémon | PokeTeam</title>
    <?php include '../includes/metas.php'; ?>
    <link rel="stylesheet" href="../assets/css/pokeinfo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="../assets/js/pokeinfo.js" defer></script>

</head>


<body>
    
        <!-- Aquí JavaScript mete la parte superior del Pokémon:
         botones, nombre, imagen principal y pokéball del fondo -->
        <div id="pokemon-details"></div>

        <!-- Panel inferior con pestañas -->
        <section class="details">

            <div class="tabs">
                <span data-tab-value="#tab_1" class="tab-activa">Resumen</span>
                <span data-tab-value="#tab_2">Estadísticas</span>
                <span data-tab-value="#tab_3">Evolución</span>
            </div>

            <div id="tab-content">

                <div class="tabs__tab active" id="tab_1" data-tab-info></div>

                <div class="tabs__tab" id="tab_2" data-tab-info></div>

                <div class="tabs__tab" id="tab_3" data-tab-info></div>

            </div>

        </section>

        <!-- Preloader -->
        <div class="loader-wrapper">
            <div class="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
    
</body>

</html>