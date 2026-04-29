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

                                <input type="text" class="input-editar"
                                    value="<?php echo htmlspecialchars($nombre); ?>" hidden>
                            </div>

                            <form action="edit_perfil.php" method="POST" class="form-editar">
                                <input type="hidden" name="add" value="username">

                                <div class="botones-edicion">
                                    <button type="button" class="btn-editar" title="Editar">✎</button>
                                    <button type="button" class="btn-guardar" title="Guardar">📩</button>
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

                                <input type="text" class="input-editar"
                                    value="<?php echo htmlspecialchars($apodo); ?>" hidden>
                            </div>

                            <form action="edit_perfil.php" method="POST" class="form-editar">
                                <input type="hidden" name="add" value="apodo">

                                <div class="botones-edicion">
                                    <button type="button" class="btn-editar">✎</button>
                                    <button type="button" class="btn-guardar">📩</button>
                                    <button type="button" class="btn-cancelar">❌</button>
                                </div>
                            </form>
                        </div>

                        <!-- CONTRASEÑA -->
                        <div class="campo-perfil">
                            <div class="info-campo">
                                <span class="titulo-campo">Contraseña</span>

                                <span class="valor-campo texto">••••••••</span>

                                <input type="password" class="input-editar" hidden>
                            </div>

                            <form action="edit_perfil.php" method="POST" class="form-editar">
                                <input type="hidden" name="add" value="psw">

                                <div class="botones-edicion">
                                    <button type="button" class="btn-editar">✎</button>
                                    <button type="button" class="btn-guardar">📩</button>
                                    <button type="button" class="btn-cancelar">❌</button>
                                </div>
                            </form>
                        </div>

                        <!-- EDAD -->
                        <div class="campo-perfil">
                            <div class="info-campo">
                                <span class="titulo-campo">Edad</span>

                                <span class="valor-campo texto">
                                    <?php echo htmlspecialchars($edad); ?> años
                                </span>

                                <input type="number" class="input-editar"
                                    value="<?php echo htmlspecialchars($edad); ?>" hidden>
                            </div>

                            <form action="edit_perfil.php" method="POST" class="form-editar">
                                <input type="hidden" name="add" value="edad">

                                <div class="botones-edicion">
                                    <button type="button" class="btn-editar">✎</button>
                                    <button type="button" class="btn-guardar">📩</button>
                                    <button type="button" class="btn-cancelar">❌</button>
                                </div>
                            </form>
                        </div>

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

        // 📩 GUARDAR
        btnSave.addEventListener('click', async () => {

            const valor = input.value;
            const campoTipo = form.querySelector('input[name="add"]').value;

            const formData = new FormData();
            formData.append('add', campoTipo);
            formData.append('valor', valor);

            try {
                const res = await fetch('edit_perfil.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await res.text();
                console.log("Respuesta PHP:", data);

                if (res.ok) {

                    texto.textContent = valor + (campoTipo === 'edad' ? ' años' : '');

                    originalValue = texto.textContent;

                    campo.classList.remove('editando');
                    input.hidden = true;
                }

            } catch (err) {
                console.error("Error guardando:", err);
            }
        });
    });
</script>

</html>