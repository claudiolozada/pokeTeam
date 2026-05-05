<?php
session_start();
require_once __DIR__ . '/../db/conn.php';

// nos haceguramos de tener el id del pokemon
if (isset($_POST["id"]) && $_POST["id"] != null) {

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../index.php?error=sinsesion");
        exit;
    }

    $idpoke = intval($_POST["id"]);
    $userId = $_SESSION['user_id'];
    // Limpiamos el apodo: si está vacío o solo son espacios, lo tratamos como null
    $apodo = (isset($_POST["apodo"]) && !empty(trim($_POST["apodo"]))) ? trim($_POST["apodo"]) : null;

    try {
        // 1. Buscar la primera posición disponible (1 al 6)
        $sqlPos = "SELECT posicion_num FROM equipo_pokemon WHERE user_id = ? ORDER BY posicion_num ASC";
        $stmtPos = $conn->prepare($sqlPos);
        $stmtPos->bind_param("i", $userId);
        $stmtPos->execute();
        $resPos = $stmtPos->get_result();

        $posicionesOcupadas = [];
        while ($fila = $resPos->fetch_assoc()) {
            $posicionesOcupadas[] = $fila['posicion_num'];
        }

        $nuevaPosicion = 0;
        for ($i = 1; $i <= 6; $i++) {
            if (!in_array($i, $posicionesOcupadas)) {
                $nuevaPosicion = $i;
                break;
            }
        }

        if ($nuevaPosicion === 0) {
            header("Location: ../pages/home.php?error=equipo_lleno");
            exit;
        }

        // 2. Preparamos la consulta dependiendo si tenemos apodo o no
        if ($apodo === null) {
            //  sin no hay apodo, lo omitimos
            $sqlInsert = "INSERT INTO equipo_pokemon (user_id, pokemon_id, posicion_num) VALUES (?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("iii", $userId, $idpoke, $nuevaPosicion);
        } else {
            // si hay, lo agregamos
            $sqlInsert = "INSERT INTO equipo_pokemon (user_id, pokemon_id, posicion_num, poke_apodo) VALUES (?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            // "iiis" -> 3 enteros y 1 string
            $stmtInsert->bind_param("iiis", $userId, $idpoke, $nuevaPosicion, $apodo);
        }

        if ($stmtInsert->execute()) {
            header("Location: ../pages/equipo.php?success=agregado");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        error_log("Error en equipo_poke: " . $e->getMessage());
        header("Location: ../pages/home.php?error=sql");
        exit;
    }
} else {
    // Si se accede sin enviar el ID del pokemon
    header("Location: ../pages/home.php?error=..");
    exit;
}
