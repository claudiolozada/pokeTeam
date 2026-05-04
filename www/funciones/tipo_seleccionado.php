<?php

// FUNCIÓN: obtenerIdsPokemonPorTipo
// --------------------------------------------------

// Recibe:
// - $conn: conexión a la base de datos.
// - $nombreTipo: nombre del tipo que queremos buscar.
//   Ejemplo: "Fuego", "Agua", "Planta".
//
// Devuelve:
// - Un array con los números de Pokédex de los Pokémon
//   que pertenecen a ese tipo.
// --------------------------------------------------

function obtenerIdsPokemonPorTipo($conn, $nombreTipo)
{
    // --------------------------------------------------
    // 1. BUSCAR EL ID DEL TIPO
    // --------------------------------------------------

    // Primero buscamos el id del tipo recibido.
    // Si recibimos "Fuego", buscamos su id en la tabla tipos.
    $sqlTipo = "SELECT id  FROM tipos  WHERE tipo = ?";

    // Preparamos la consulta para evitar inyección SQL.
    $stmtTipo = $conn->prepare($sqlTipo);

    // Enlazamos el nombre del tipo.
    // "s" significa string.
    $stmtTipo->bind_param("s", $nombreTipo);

    // Ejecutamos la consulta.
    $stmtTipo->execute();

    // Obtenemos el resultado.
    $resultadoTipo = $stmtTipo->get_result();


    // Si no existe ese tipo en la base de datos,
    // devolvemos un array vacío.
    if ($resultadoTipo->num_rows === 0) {
        return [];
    }


    // Guardamos la fila encontrada.
    $tipo = $resultadoTipo->fetch_assoc();

    // Sacamos solo el id del tipo.
    $idTipo = $tipo['id'];


    // --------------------------------------------------
    // 2. BUSCAR LOS POKÉMON QUE TIENEN ESE TIPO
    // --------------------------------------------------

    // Ahora buscamos todos los Pokémon relacionados con ese tipo.

    // pokemon:
    // contiene los Pokémon.

    // tipo_poke:
    // es la tabla puente que une Pokémon con tipos.

    // Esto permite que un Pokémon pueda tener uno o dos tipos.
    $sqlPokemon = "SELECT p.pokedex_num FROM pokemon p INNER JOIN tipo_poke tp  ON p.id = tp.pokemon_id
        WHERE tp.tipo_id = ? ORDER BY p.pokedex_num ASC ";

    // Preparamos la consulta.
    $stmtPokemon = $conn->prepare($sqlPokemon);

    // Enlazamos el id del tipo.
    // "i" significa integer.
    $stmtPokemon->bind_param("i", $idTipo);

    // Ejecutamos la consulta.
    $stmtPokemon->execute();

    // Obtenemos el resultado.
    $resultadoPokemon = $stmtPokemon->get_result();


    // --------------------------------------------------
    // 3. GUARDAR LOS NÚMEROS DE POKÉDEX
    // --------------------------------------------------

    // Aquí guardaremos los números de Pokédex encontrados.
    $idsPokemon = [];

    // Recorremos los resultados.
    while ($fila = $resultadoPokemon->fetch_assoc()) {

        // Guardamos solo el número de Pokédex.
        $idsPokemon[] = $fila['pokedex_num'];
    }


    // --------------------------------------------------
    // 4. DEVOLVER RESULTADO FINAL
    // --------------------------------------------------

    // Devolvemos un array con los números de Pokédex.
    // Ejemplo:
    // [1, 2, 3, 43, 44, 45]
    return $idsPokemon;
}
