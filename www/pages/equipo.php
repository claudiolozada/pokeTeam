<?php
require_once '../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipo Pokémon | PokeTeam</title>

    <link rel="stylesheet" href="../assets/css/equipo.css">
    <script src="../assets/js/equipo.js" defer></script>
    <?php include '../includes/metas.php'; ?>
</head>

<body>

    <main class="contenedor-equipo">

        <!-- Zona visual del entrenador con los Pokémon alrededor -->
        <section class="zona-entrenador-equipo">

            <div class="escenario-equipo">

                <!-- De momento este div sirve para visualizar el tamaño -->
                <div class="vista-entrenador-pokemon">

                    <img
                        src="<?php echo htmlspecialchars($ftavatar); ?>"
                        alt="Avatar del entrenador"
                        class="entrenador-equipo">

                    <!-- Espacios falsos para imaginar dónde irán los Pokémon -->
                    <div class="pokemon-alrededor pokemon-1"></div>
                    <div class="pokemon-alrededor pokemon-2"></div>
                    <div class="pokemon-alrededor pokemon-3"></div>
                    <div class="pokemon-alrededor pokemon-4"></div>
                    <div class="pokemon-alrededor pokemon-5"></div>
                    <div class="pokemon-alrededor pokemon-6"></div>

                </div>

            </div>

        </section>

        <!-- Línea separadora -->
        <div class="linea-separadora"></div>

        <!-- Zona de tarjetas del equipo -->
        <section id="zona-lista-equipo">

            <h1>Equipo Pokemon</h1>

            <div class="grid-equipo">

                <div id="1" class="slot-pokemon">
                    <span>+</span>
                </div>

                <div id="2" class="slot-pokemon">
                    <span>+</span>
                </div>

                <div id="3" class="slot-pokemon">
                    <span>+</span>
                </div>

                <div id="4" class="slot-pokemon">
                    <span>+</span>
                </div>

                <div id="5" class="slot-pokemon">
                    <span>+</span>
                </div>

                <div id="6" class="slot-pokemon">
                    <span>+</span>
                </div>

            </div>

        </section>

    </main>

</body>

</html>