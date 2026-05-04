<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar avatar</title>

    <?php include '../includes/metas.php'; ?>
    <script src="../assets/js/avatar.js" defer></script>
    <link rel="stylesheet" href="../assets/css/avatar.css">

</head>

<body>

    <main class="contenedor">

        <h1 class="titulo">Selecciona tu nuevo avatar</h1>

        <div class="botones-genero">
            <button class="boton-genero boton-activo" id="botonMasculino">Masculino</button>
            <button class="boton-genero" id="botonFemenino">Femenino</button>
        </div>

        <section class="carrusel">

            <button class="flecha flecha-izquierda" id="flechaIzquierda">‹</button>

            <img class="avatar oculto-izquierda" id="avatarOcultoIzquierda" src="" alt="Avatar oculto izquierda">
            <img class="avatar izquierda" id="avatarIzquierda" src="" alt="Avatar izquierda">
            <img class="avatar centro" id="avatarCentro" src="" alt="Avatar seleccionado">
            <img class="avatar derecha" id="avatarDerecha" src="" alt="Avatar derecha">
            <img class="avatar oculto-derecha" id="avatarOcultoDerecha" src="" alt="Avatar oculto derecha">

            <button class="flecha flecha-derecha" id="flechaDerecha">›</button>

        </section>

        <form action="../funciones/edit_perfil.php" method="POST">
            <input type="text" name="add" value="avatar" hidden>
            <input type="hidden" name="avatar_nombre" id="inputAvatarInvisible">

            <button class="boton-seleccionar" id="botonSeleccionar">
                Seleccionar avatar
            </button>
        </form>

    </main>

</body>
<?php include '../includes/infoerror.php'; ?>
</html>