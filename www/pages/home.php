<?php

 include '../includes/navbar.php'; 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | PokeTeam</title> 
    <?php include '../includes/metas.php'; ?>
    <link rel="stylesheet" href="../assets/css/home.css">
</head>

<body>


    <main class="contenedor-home">

        <section class="inicio">

            <div class="zona-avatar">

                <div class="tarjeta-avatar">

                    <!-- Avatar -->
                    <img 
                        src=<?php echo htmlspecialchars($avatar); ?>
                        alt="Avatar del usuario" 
                        class="imagen-avatar"
                    >

                    <h1>
                        Bienvenido, 
                        <span><?php echo htmlspecialchars($apodo); ?></span>
                    </h1>

                    <p>
                        Prepara tu equipo, revisa tus Pokémon favoritos y explora la Pokédex.
                    </p>

                </div>

            </div>

            <div class="zona-menu">

                <h2>Panel de entrenador</h2>

                <div class="botones-menu">

                    <a href="buscar.php" class="boton-menu">
                        <span>Buscar</span>
                        <img src="../assets/img/pokeball.png" alt="Pokéball buscar" class="pokeball-menu">
                    </a>

                    <a href="perfil.php" class="boton-menu">
                        <span>Perfil</span>
                        <img src="../assets/img/superball.png" alt="Pokéball perfil" class="pokeball-menu">
                    </a>

                    <a href="equipo.php" class="boton-menu">
                        <span>Equipo</span>
                        <img src="../assets/img/honorball.png" alt="Pokéball equipo" class="pokeball-menu">
                    </a>

                    <a href="pokedex.php" class="boton-menu">
                        <span>Pokedex</span>
                        <img src="../assets/img/ultraball.png" alt="Pokéball Pokédex" class="pokeball-menu">
                    </a>

                    <a href="tipos.php" class="boton-menu">
                        <span>Tabla de tipos</span>
                        <img src="../assets/img/masterball.png" alt="Pokéball tipos" class="pokeball-menu">
                    </a>

                </div>

            </div>

        </section>

    </main>
</body>
</html>
