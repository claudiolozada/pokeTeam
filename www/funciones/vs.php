<?php

// FUNCIÓN: obtenerAnalisisPokeVs
// --------------------------------------------------

// Este archivo contiene la lógica PHP del apartado Poke VS.
// Llama al procedimiento almacenado:
// CALL analizar_efectividad_pokemon(pokedex_num)
// Ese procedimiento devuelve varios SELECT.
// Esta función los recoge y los organiza en un array para JavaScript.
// --------------------------------------------------

function obtenerAnalisisPokeVs($conn, $pokedex_num)
{
    // --------------------------------------------------
    // 1. VALIDAR EL NÚMERO DE POKÉDEX
    // --------------------------------------------------

    // Si no llega un número válido, usamos el Pokémon 1 por defecto.
    if (!$pokedex_num || !is_numeric($pokedex_num)) {
        $pokedex_num = 1;
    }

    // Convertimos a entero para evitar valores raros.
    $pokedex_num = intval($pokedex_num);


    // --------------------------------------------------
    // 2. LLAMAR AL PROCEDIMIENTO DE MYSQL
    // --------------------------------------------------

    // Como $pokedex_num ya es entero, podemos usarlo de forma segura.
    $sql = "CALL analizar_efectividad_pokemon($pokedex_num)";

    // Aquí guardaremos todos los SELECT que devuelve el procedimiento.
    $resultados = [];


    // --------------------------------------------------
    // 3. LEER LOS RESULTADOS DEL PROCEDIMIENTO
    // --------------------------------------------------

    // multi_query() se usa porque el procedimiento devuelve varios SELECT.
    if ($conn->multi_query($sql)) {

        // Este índice indica qué SELECT estamos guardando.
        $indice = 0;

        do {
            // store_result() obtiene el resultado actual del procedimiento.
            if ($resultado = $conn->store_result()) {

                // Aquí guardaremos las filas del SELECT actual.
                $filas = [];

                // Recorremos todas las filas del resultado actual.
                while ($fila = $resultado->fetch_assoc()) {
                    $filas[] = $fila;
                }

                // Guardamos el SELECT actual dentro del array principal.
                // Ejemplo:
                // $resultados[0] = primer SELECT
                // $resultados[1] = segundo SELECT
                // $resultados[2] = tercer SELECT
                $resultados[$indice] = $filas;

                // Liberamos memoria del resultado actual.
                $resultado->free();

                // Pasamos al siguiente índice.
                $indice++;
            }

            // next_result() pasa al siguiente SELECT del procedimiento.
        } while ($conn->next_result());
    } else {
        // Si el procedimiento falla, detenemos la ejecución mostrando el error.
        die("Error al ejecutar el procedimiento: " . $conn->error);
    }


    // --------------------------------------------------
    // 4. ORGANIZAR LOS RESULTADOS
    // --------------------------------------------------

    // $resultados[0] = info del Pokémon elegido

    // DEFENSA:
    // $resultados[1] = Pokémon que le pegan fuerte
    // $resultados[2] = Pokémon que le pegan poco
    // $resultados[3] = Pokémon que no le hacen daño

    // ATAQUE:
    // $resultados[4] = Pokémon a los que él pega fuerte
    // $resultados[5] = Pokémon a los que él pega poco
    // $resultados[6] = Pokémon inmunes contra él

    $infoPokemon = $resultados[0] ?? [];

    // Cuando el Pokémon elegido está defendiendo.
    $lePeganFuerte = $resultados[1] ?? [];
    $lePeganPoco = $resultados[2] ?? [];
    $noLeHacenDano = $resultados[3] ?? [];

    // Cuando el Pokémon elegido está atacando.
    $elPegaFuerte = $resultados[4] ?? [];
    $elPegaPoco = $resultados[5] ?? [];
    $inmunesContraEl = $resultados[6] ?? [];


    // --------------------------------------------------
    // 5. DEVOLVER DATOS ORGANIZADOS
    // --------------------------------------------------

    // "ataca":
    // qué pasa cuando el Pokémon elegido ataca.
    //
    // "defiende":
    // qué pasa cuando el Pokémon elegido recibe ataques.
    return [
        "pokedex_num" => $pokedex_num,

        "infoPokemon" => $infoPokemon,

        "ataca" => [
            "eficaz" => $elPegaFuerte,
            "debil" => $elPegaPoco,
            "inmune" => $inmunesContraEl
        ],

        "defiende" => [
            "eficaz" => $lePeganFuerte,
            "debil" => $lePeganPoco,
            "inmune" => $noLeHacenDano
        ]
    ];
}
