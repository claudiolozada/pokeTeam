<?php
include '../includes/navbar.php';
include '../funciones/fun_tipos.php';


$nomtipo = $datosTipo["tipo"];
$desctipo = $datosTipo["descripcion"];

$imagenTipo = '../assets/img/tipos/' . $nomtipo . '.png';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipo <?php echo htmlspecialchars($nomtipo); ?> | PokeTeam</title>

    <?php include '../includes/metas.php'; ?>
    <script src="../assets/js/tipos.js" defer></script>
    <link rel="stylesheet" href="../assets/css/tiposinfo.css">
</head>

<body class="tipo-<?php echo htmlspecialchars($nomtipo); ?>">

    <main class="contenedor-tipo-info">

        <!-- Parte superior estilo pokeinfo -->
        <section class="zona-superior-tipo">

            <div class="botones-tipo">
                <a href="tipos.php" class="boton-volver-tipo">
                    <
                        </a>
            </div>

            <div class="nombres-tipo">
                <span class="subtitulo-tipo">Tipo Pokémon</span>
                <h1><?php echo htmlspecialchars($nomtipo); ?></h1>
            </div>

            <div class="imagen-principal-tipo">

                <img
                    src="../assets/img/pokeball.svg"
                    alt="Pokéball decorativa"
                    class="pokeball-fondo-tipo">

                <img
                    src="<?php echo htmlspecialchars($imagenTipo); ?>"
                    alt="Tipo <?php echo htmlspecialchars($nomtipo); ?>"
                    class="icono-tipo-grande">

            </div>

        </section>

        <!-- Panel inferior -->
        <section class="panel-info-tipo">

            <div class="barra-color-tipo"></div>

            <article class="descripcion-tipo">

                <h2>Descripción</h2>

                <p>
                    <?php echo htmlspecialchars($desctipo); ?>
                </p>

            </article>

            <div class="relaciones-tipo">

                <div class="tabs-relaciones">
                    <button class="tab-relacion activa" type="button" data-relacion="fortalezas">
                        Fortalezas
                    </button>

                    <button class="tab-relacion" type="button" data-relacion="debilidades">
                        Debilidades
                    </button>

                    <button class="tab-relacion" type="button" data-relacion="inmunidades">
                        Inmunidades
                    </button>
                </div>

                <div class="contenido-relaciones">

                    <!-- Fortalezas -->
                    <article class="panel-relacion activo" id="fortalezas">

                        <h2>Fortalezas</h2>

                        <p>
                            Este tipo es fuerte contra:
                        </p>

                        <div class="lista-iconos-tipo">

                            <?php if (!empty($fortalezas)): ?>

                                <?php foreach ($fortalezas as $tipo): ?>
                                    <div class="caja-icono-tipo">
                                        <img
                                            src="<?php echo htmlspecialchars($tipo); ?>"
                                            alt="Tipo fuerte">
                                    </div>
                                <?php endforeach; ?>

                            <?php else: ?>

                                <div class="sin-resultados-tipo">
                                    No hay resultados
                                </div>

                            <?php endif; ?>

                        </div>

                    </article>

                    <!-- Debilidades -->
                    <article class="panel-relacion" id="debilidades">

                        <h2>Debilidades</h2>

                        <p>
                            Este tipo es débil contra:
                        </p>

                        <div class="lista-iconos-tipo">

                            <?php if (!empty($debilidades)): ?>

                                <?php foreach ($debilidades as $tipo): ?>
                                    <div class="caja-icono-tipo">
                                        <img
                                            src="<?php echo htmlspecialchars($tipo); ?>"
                                            alt="Tipo débil">
                                    </div>
                                <?php endforeach; ?>

                            <?php else: ?>

                                <div class="sin-resultados-tipo">
                                    No hay resultados
                                </div>

                            <?php endif; ?>

                        </div>

                    </article>

                    <!-- Inmunidades -->
                    <article class="panel-relacion" id="inmunidades">

                        <h2>Inmunidades</h2>

                        <p>
                            Este tipo no recibe daño de:
                        </p>

                        <div class="lista-iconos-tipo">

                            <?php if (!empty($inmunidades)): ?>

                                <?php foreach ($inmunidades as $tipo): ?>
                                    <div class="caja-icono-tipo">
                                        <img
                                            src="<?php echo htmlspecialchars($tipo); ?>"
                                            alt="Tipo inmune">
                                    </div>
                                <?php endforeach; ?>

                            <?php else: ?>

                                <div class="sin-resultados-tipo">
                                    No hay resultados
                                </div>

                            <?php endif; ?>

                        </div>

                    </article>

                </div>

            </div>

        </section>

    </main>

</body>

</html>