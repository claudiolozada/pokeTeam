<?php
include '../includes/navbar.php';

/* 
    Estas variables normalmente deberían venir de la sesión o de la base de datos.
    Las dejo protegidas por si todavía no las tienes cargadas.
    $avatar = $avatar ?? '../assets/img/avatar.png';
    $apodo = $apodo ?? 'Entrenador';
    $username = $username ?? 'usuario123';
    $edad = $edad ?? '18';
    */
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | PokeTeam</title>

    <link rel="stylesheet" href="../assets/css/perfil.css">

    <?php include '../includes/metas.php'; ?>
</head>

<body>

    <main class="contenedor-perfil">

        <section class="perfil">

            <!-- Zona izquierda: avatar -->
            <div class="tarjeta-avatar-perfil">

                <div class="cabecera-avatar-perfil">
                    <h2>Mi avatar</h2>
                    <p>Este es tu entrenador actual</p>
                </div>

                <div class="zona-imagen-avatar">
                    <img
                        src="<?php echo htmlspecialchars($avatar); ?>"
                        alt="Avatar del usuario"
                        class="imagen-avatar-perfil">
                </div>

                <a href="selec_avatar.php" class="boton-cambiar-avatar">
                    Cambiar avatar
                </a>

            </div>

            <!-- Zona derecha: datos del perfil -->
            <div class="zona-panel-perfil">

                <div class="cabecera-perfil">

                    <div class="foto-perfil">
                        <img
                            src="<?php echo htmlspecialchars($ftavatar); ?>"
                            alt="Foto de perfil">
                    </div>

                    <div>
                        <h1>Mi perfil</h1>
                        <p>Administra tus datos de entrenador</p>
                    </div>

                </div>

                <div class="datos-perfil">

                    <div class="datos-perfil">

                        <!-- USERNAME -->
                        <div class="campo-perfil">
                            <div class="info-campo">
                                <span class="titulo-campo">Username</span>

                                <span class="valor-campo texto">
                                    <?php echo htmlspecialchars($nombre); ?>
                                </span>

                                <form action="../funciones/edit_perfil.php" method="POST" class="form-editar">
                                    <input type="text" class="input-editar" name="username"
                                        value="<?php echo htmlspecialchars($nombre); ?>" hidden>
                            </div>

                                <input type="text" name="add" value="username" hidden>

                                <div class="botones-edicion">
                                    <button type="button" class="btn-editar" title="Editar">✎</button>
                                    <button type="submit" class="btn-guardar" title="Guardar">📩</button>
                                    <button type="button" class="btn-cancelar" title="Cancelar">❌</button>
                                </div>
                                </form>
                        </div>

                        <!-- APODO -->
                        <div class="campo-perfil">
                            <div class="info-campo">
                                <span class="titulo-campo">Apodo</span>

                                <span class="valor-campo texto">
                                    <?php echo htmlspecialchars($apodo); ?>
                                </span>

                                <form action="../funciones/edit_perfil.php" method="POST" class="form-editar">
                                    <input type="text" class="input-editar" name="apodo"
                                        value="<?php echo htmlspecialchars($apodo); ?>" hidden>
                            </div>

                            <input type="text" name="add" value="apodo" hidden>

                            <div class="botones-edicion">
                                <button type="button" class="btn-editar">✎</button>
                                <button type="submit" class="btn-guardar">📩</button>
                                <button type="button" class="btn-cancelar">❌</button>
                            </div>
                            </form>
                        </div>

                        <!-- CONTRASEÑA -->
                        <div class="campo-perfil">
                            <div class="info-campo">
                                <span class="titulo-campo">Contraseña</span>

                                <span class="valor-campo texto">••••••••</span>

                                <form action="../funciones/edit_perfil.php" method="POST" class="form-editar">
                                    <input type="password" name="pws" class="input-editar" hidden>
                            </div>

                            <input type="text" name="add" value="psw" hidden>

                            <div class="botones-edicion">
                                <button type="button" class="btn-editar">✎</button>
                                <button type="submit" class="btn-guardar">📩</button>
                                <button type="button" class="btn-cancelar">❌</button>
                            </div>
                            </form>
                        </div>

                        <!-- EDAD -->
                        <div class="campo-perfil">
                            <div class="info-campo">
                                <span class="titulo-campo">edad</span>

                                <span class="valor-campo texto">
                                    <?php echo htmlspecialchars($edad); ?>
                                </span>

                                <form action="../funciones/edit_perfil.php" method="POST" class="form-editar">
                                    <input type="text" class="input-editar" name="edad"
                                        value="<?php echo htmlspecialchars($edad); ?>" hidden>
                            </div>

                            <input type="text" name="add" value="edad" hidden>

                            <div class="botones-edicion">
                                <button type="button" class="btn-editar">✎</button>
                                <button type="submit" class="btn-guardar">📩</button>
                                <button type="button" class="btn-cancelar">❌</button>
                            </div>
                            </form>
                        </div>

                        <div class="zona-acciones-perfil">

                            <a href="home.php" class="boton-volver">
                                Volver al inicio
                            </a>

                            <a href="../acciones/cerrar-sesion.php" class="boton-cerrar">
                                Cerrar sesión
                            </a>

                        </div>

                    </div>

        </section>

    </main>

</body>
<script>
    document.querySelectorAll('.campo-perfil').forEach(campo => {

        const btnEdit = campo.querySelector('.btn-editar');
        const btnSave = campo.querySelector('.btn-guardar');
        const btnCancel = campo.querySelector('.btn-cancelar');

        const input = campo.querySelector('.input-editar');
        const texto = campo.querySelector('.texto');
        const form = campo.querySelector('.form-editar');

        let originalValue = texto.textContent;

        // ✎ EDITAR
        btnEdit.addEventListener('click', () => {
            campo.classList.add('editando');
            input.hidden = false;
            input.focus();
        });

        // ❌ CANCELAR
        btnCancel.addEventListener('click', () => {
            campo.classList.remove('editando');
            input.hidden = true;
            input.value = originalValue.replace(' años', '');
        });

        
    });
</script>

</html>