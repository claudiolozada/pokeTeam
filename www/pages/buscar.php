<?php

require_once __DIR__ . '/../db/conn.php';
include '../funciones/tipo_seleccionado.php';

$tipoSeleccionado = $_GET['tipo'] ?? 'normal';

$idsPokemon = obtenerIdsPokemonPorTipo($conn, $tipoSeleccionado);

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
    <script src="../assets/js/busqueda_tipo.js" defer></script>

</head>
<?php $tipoSeleccionado = $_GET['tipo'] ?? 'normal'; ?>

<body>
    <div id="pagina">
        <section class="zona-controles-pokedex">
            <div class="caja-buscador">
                <input
                    id="buscador"
                    oninput="buscarPokemonEnApi()"
                    type="text"
                    placeholder="Buscar Pokémon"
                    autocomplete="off" />
            </div>

            <div class="contenedor-modo-oscuro">
                <div class="contenido-modo-oscuro">
                    <span class="texto-modo-oscuro">Modo oscuro</span>
                    <i class="fa-solid fa-toggle-off" id="botonModoOscuro"></i>
                </div>
            </div>
        </section>

        <form class="selector-tipos" action="" method="GET">

            <div class="tipos" id="selectorTipo">

                <button type="submit" name="tipo" value="normal" class="valor-tipo <?php echo $tipoSeleccionado === 'normal' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/normal.png" alt="Normal">
                </button>

                <button type="submit" name="tipo" value="Fuego" class="valor-tipo <?php echo $tipoSeleccionado === 'Fuego' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/fuego.png" alt="Fuego">
                </button>

                <button type="submit" name="tipo" value="Agua" class="valor-tipo <?php echo $tipoSeleccionado === 'Agua' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/agua.png" alt="Agua">
                </button>

                <button type="submit" name="tipo" value="Planta" class="valor-tipo <?php echo $tipoSeleccionado === 'Planta' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/planta.png" alt="Planta">
                </button>

                <button type="submit" name="tipo" value="Eléctrico" class="valor-tipo <?php echo $tipoSeleccionado === 'Eléctrico' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/electrico.png" alt="Eléctrico">
                </button>

                <button type="submit" name="tipo" value="Hielo" class="valor-tipo <?php echo $tipoSeleccionado === 'Hielo' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/hielo.png" alt="Hielo">
                </button>

                <button type="submit" name="tipo" value="Lucha" class="valor-tipo <?php echo $tipoSeleccionado === 'Lucha' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/lucha.png" alt="Lucha">
                </button>

                <button type="submit" name="tipo" value="Veneno" class="valor-tipo <?php echo $tipoSeleccionado === 'Veneno' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/veneno.png" alt="Veneno">
                </button>

                <button type="submit" name="tipo" value="Tierra" class="valor-tipo <?php echo $tipoSeleccionado === 'Tierra' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/tierra.png" alt="Tierra">
                </button>

                <button type="submit" name="tipo" value="Volador" class="valor-tipo <?php echo $tipoSeleccionado === 'Volador' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/volador.png" alt="Volador">
                </button>

                <button type="submit" name="tipo" value="Psíquico" class="valor-tipo <?php echo $tipoSeleccionado === 'Psíquico' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/psiquico.png" alt="Psíquico">
                </button>

                <button type="submit" name="tipo" value="Bicho" class="valor-tipo <?php echo $tipoSeleccionado === 'Bicho' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/bicho.png" alt="Bicho">
                </button>

                <button type="submit" name="tipo" value="Roca" class="valor-tipo <?php echo $tipoSeleccionado === 'Roca' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/roca.png" alt="Roca">
                </button>

                <button type="submit" name="tipo" value="Fantasma" class="valor-tipo <?php echo $tipoSeleccionado === 'Fantasma' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/fantasma.png" alt="Fantasma">
                </button>

                <button type="submit" name="tipo" value="Dragón" class="valor-tipo <?php echo $tipoSeleccionado === 'Dragón' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/dragon.png" alt="Dragón">
                </button>

                <button type="submit" name="tipo" value="Siniestro" class="valor-tipo <?php echo $tipoSeleccionado === 'Siniestro' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/siniestro.png" alt="Siniestro">
                </button>

                <button type="submit" name="tipo" value="Acero" class="valor-tipo <?php echo $tipoSeleccionado === 'Acero' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/acero.png" alt="Acero">
                </button>

                <button type="submit" name="tipo" value="Hada" class="valor-tipo <?php echo $tipoSeleccionado === 'Hada' ? 'activo' : ''; ?>">
                    <img src="../assets/img/tipos/hada.png" alt="Hada">
                </button>

            </div>

        </form>

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

        <script>
            const idsPokemonPorTipo = <?php echo json_encode($idsPokemon); ?>;
        </script>

        <script
            src="https://kit.fontawesome.com/919bc986f5.js"
            crossorigin="anonymous"></script>
</body>

</html>