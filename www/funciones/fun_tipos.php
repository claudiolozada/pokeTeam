<?php

// Primero comprobamos si llegó el tipo por GET
if (!isset($_GET['tipo']) || empty($_GET['tipo'])) {
    header("Location: ../tipos.php?error=notipo");
    exit;
}

$tipo = $_GET['tipo'];

try {

    // Buscamos el id del tipo según el nombre recibido
    $infotipo = $conn->prepare("SELECT id FROM tipos WHERE tipo = ?");
    $infotipo->bind_param("s", $tipo);
    $infotipo->execute();

    $resultadoTipo = $infotipo->get_result();

    // Si NO existe ese tipo, mandamos error
    if ($resultadoTipo->num_rows === 0) {
        header("Location: ../tipos.php?error=noinfo");
        exit;
    }

    // Sacamos la fila
    $filaTipo = $resultadoTipo->fetch_assoc();

    // Guardamos SOLO el id
    $idtipo = (int) $filaTipo["id"];

    // Arrays donde guardaremos los resultados
    $datosTipo = null;
    $fortalezas = [];
    $debilidades = [];
    $inmunidades = [];


    //Llamamos al procedimiento almacenado.
     //Como CALL analizar_tipo devuelve varios SELECT,
     //usamos multi_query y vamos leyendo resultado por resultado.

    $sql = "CALL analizar_tipo($idtipo)";

    if ($conn->multi_query($sql)) {

        // -----------------------------
        // RESULTADO 1: datos del tipo
        // -----------------------------
        if ($resultado = $conn->store_result()) {
            $datosTipo = $resultado->fetch_assoc();
            $resultado->free();
        }

        $conn->next_result();

        // -----------------------------
        // RESULTADO 2: fortalezas
        // -----------------------------
        if ($resultado = $conn->store_result()) {
            while ($fila = $resultado->fetch_assoc()) {
                $fortalezas[] = '../assets/img/tipos/' . $fila["tipo"] . '.png';
            }
            $resultado->free();
        }

        $conn->next_result();

        // -----------------------------
        // RESULTADO 3: debilidades
        // -----------------------------
        if ($resultado = $conn->store_result()) {
            while ($fila = $resultado->fetch_assoc()) {
                $debilidades[] = '../assets/img/tipos/' . $fila["tipo"] . '.png';
            }
            $resultado->free();
        }

        $conn->next_result();

        // -----------------------------
        // RESULTADO 4: inmunidades
        // -----------------------------
        if ($resultado = $conn->store_result()) {
            while ($fila = $resultado->fetch_assoc()) {
                $inmunidades[] = '../assets/img/tipos/' . $fila["tipo"] . '.png';
            }
            $resultado->free();
        }
    }

} catch (mysqli_sql_exception $e) {

    log::error("Error analizando tipo: " . $e->getMessage());

    header("Location: ../tipos.php?error=bd");
    exit;
}