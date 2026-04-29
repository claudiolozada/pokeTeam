<?php
include '../includes/navbar.php';

$tipos = [
    ['nombre' => 'Normal',    'archivo' => 'normal.png',    'clase' => 'normal'],
    ['nombre' => 'Fuego',     'archivo' => 'fuego.png',     'clase' => 'fuego'],
    ['nombre' => 'Agua',      'archivo' => 'agua.png',      'clase' => 'agua'],
    ['nombre' => 'Planta',    'archivo' => 'planta.png',    'clase' => 'planta'],
    ['nombre' => 'Eléctrico', 'archivo' => 'electrico.png', 'clase' => 'electrico'],
    ['nombre' => 'Hielo',     'archivo' => 'hielo.png',     'clase' => 'hielo'],
    ['nombre' => 'Lucha',     'archivo' => 'lucha.png',     'clase' => 'lucha'],
    ['nombre' => 'Veneno',    'archivo' => 'veneno.png',    'clase' => 'veneno'],
    ['nombre' => 'Tierra',    'archivo' => 'tierra.png',    'clase' => 'tierra'],
    ['nombre' => 'Volador',   'archivo' => 'volador.png',   'clase' => 'volador'],
    ['nombre' => 'Psíquico',  'archivo' => 'psiquico.png',  'clase' => 'psiquico'],
    ['nombre' => 'Bicho',     'archivo' => 'bicho.png',     'clase' => 'bicho'],
    ['nombre' => 'Roca',      'archivo' => 'roca.png',      'clase' => 'roca'],
    ['nombre' => 'Fantasma',  'archivo' => 'fantasma.png',  'clase' => 'fantasma'],
    ['nombre' => 'Dragón',    'archivo' => 'dragon.png',    'clase' => 'dragon'],
    ['nombre' => 'Siniestro', 'archivo' => 'siniestro.png', 'clase' => 'siniestro'],
    ['nombre' => 'Acero',     'archivo' => 'acero.png',     'clase' => 'acero'],
    ['nombre' => 'Hada',      'archivo' => 'hada.png',      'clase' => 'hada']
];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de tipos | PokeTeam</title>

    <link rel="stylesheet" href="../assets/css/tipos.css">

    <?php include '../includes/metas.php'; ?>
</head>

<body>

    <main class="contenedor-tabla-tipos">

        <section class="panel-tabla-tipos">

            <div class="cabecera-tabla-tipos">
                <h1>Tabla de tipos</h1>
                <p>Elige un tipo Pokémon para ver sus fortalezas y debilidades</p>
            </div>

            <div class="cuadricula-tipos">

                <?php foreach ($tipos as $tipo): ?>

                    <a 
                        href="detalle-tipo.php?tipo=<?php echo urlencode($tipo['clase']); ?>" 
                        class="tarjeta-tipo tipo-<?php echo htmlspecialchars($tipo['clase']); ?>"
                    >

                        <div class="circulo-tipo">
                            <img 
                                src="../assets/img/tipos/<?php echo htmlspecialchars($tipo['archivo']); ?>" 
                                alt="Tipo <?php echo htmlspecialchars($tipo['nombre']); ?>"
                            >
                        </div>

                        <span class="nombre-tipo">
                            <?php echo htmlspecialchars($tipo['nombre']); ?>
                        </span>

                    </a>

                <?php endforeach; ?>

            </div>

        </section>

    </main>

</body>
</html>