<?php

include '../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex | PokeTeam</title>
    <?php include '../includes/metas.php'; ?>
    <link rel="stylesheet" href="../assets/css/pokedex.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="../assets/js/pokedex.js" defer></script>

</head>

<body>
    <div class="espacionv">
        <section class="zona-controles-pokedex">
            <div class="caja-buscador">
                <input
                    id="buscador"
                    onkeyup="buscarPokemon()"
                    type="text"
                    placeholder="Buscar Pokémon" />
            </div>

            <div class="contenedor-modo-oscuro">
                <div class="contenido-modo-oscuro">
                    <span class="texto-modo-oscuro">Modo oscuro</span>
                    <i class="fa-solid fa-toggle-off" id="botonModoOscuro"></i>
                </div>
            </div>
        </section>

    </div>

    </section>
    <div class="selector-regiones">
        <div class="regiones" id="selectorRegion">
            <span data-value="kanto" class="activo valor-region">Kanto</span>
            <span data-value="johto" class="valor-region">Johto</span>
            <span data-value="hoenn" class="valor-region">Hoenn</span>
            <span data-value="sinnoh" class="valor-region">Sinnoh</span>
            <span data-value="unova" class="valor-region">Unova</span>
            <span data-value="kalos" class="valor-region">Kalos</span>
            <span data-value="alola" class="valor-region">Alola</span>
            <span data-value="galar" class="valor-region">Galar</span>
            <span data-value="hisui" class="valor-region">Hisui</span>
            <span data-value="paldea" class="valor-region">Paldea</span>
            <span data-value="kitakami" class="valor-region">Kitakami</span>
            <span data-value="indigo" class="valor-region">Indigo</span>
        </div>

    </div>

    <main class="contenedor-pokemon" id="contenedorPokemon"></main>

    <div class="cargador">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <button id="botonSubir">
        <i class="fas fa-chevron-up"></i>
    </button>

    <button id="botonBajar">
        <i class="fas fa-chevron-down"></i>
    </button>
    </div>

    <script
        src="https://kit.fontawesome.com/919bc986f5.js"
        crossorigin="anonymous"></script>
</body>

</html>