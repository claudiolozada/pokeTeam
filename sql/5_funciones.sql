DELIMITER //

CREATE PROCEDURE analizar_efectividad_pokemon(IN p_pokedex_num INT)
BEGIN

    /*
        ============================================================
        PROCEDIMIENTO: analizar_efectividad_pokemon
        ============================================================

        Este procedimiento recibe el número de Pokédex de un Pokémon.

        Ejemplo:
        CALL analizar_efectividad_pokemon(6);

        Devuelve varios SELECT:

        1. Datos del Pokémon elegido.
        2. Pokémon que le pegan fuerte.
        3. Pokémon que le pegan poco.
        4. Pokémon que no le hacen daño.
        5. Pokémon a los que el elegido les pega fuerte.
        6. Pokémon a los que el elegido les pega poco.
        7. Pokémon inmunes contra el elegido.

        Mejora añadida:
        - Cada lista devuelve máximo 12 Pokémon.
        - También devuelve pokedex_num para poder cargar imágenes.
    */


    /* ============================================================
       1. Guardamos el Pokémon elegido
       ============================================================ */

    DROP TEMPORARY TABLE IF EXISTS pokemon_objetivo;

    CREATE TEMPORARY TABLE pokemon_objetivo AS
    SELECT 
        p.id,
        p.pokedex_num,
        p.nom
    FROM pokemon p
    WHERE p.pokedex_num = p_pokedex_num;


    /* ============================================================
       2. Guardamos los tipos del Pokémon elegido
       ============================================================ */

    DROP TEMPORARY TABLE IF EXISTS tipos_objetivo;

    CREATE TEMPORARY TABLE tipos_objetivo AS
    SELECT 
        tp.tipo_id
    FROM tipo_poke tp
    INNER JOIN pokemon_objetivo po
        ON po.id = tp.pokemon_id;


    /* ============================================================
       3. Datos básicos del Pokémon elegido
       ============================================================ */

    SELECT 
        po.id,
        po.pokedex_num,
        po.nom,
        GROUP_CONCAT(t.tipo ORDER BY t.tipo SEPARATOR ', ') AS tipos
    FROM pokemon_objetivo po
    INNER JOIN tipo_poke tp
        ON po.id = tp.pokemon_id
    INNER JOIN tipos t
        ON t.id = tp.tipo_id
    GROUP BY 
        po.id,
        po.pokedex_num,
        po.nom;


    /* ============================================================
       4. Calculamos cómo atacan otros Pokémon al elegido
       ============================================================ */

    DROP TEMPORARY TABLE IF EXISTS ataques_contra_objetivo;

    CREATE TEMPORARY TABLE ataques_contra_objetivo AS
    SELECT
        atacante.id AS pokemon_id,
        atacante.pokedex_num,
        atacante.nom AS pokemon,

        tipo_ataque.id AS tipo_ataque_id,
        tipo_ataque.tipo AS tipo_ataque,

        CASE
            WHEN SUM(
                CASE 
                    WHEN COALESCE(e.multiplicador, 1.0) = 0 THEN 1 
                    ELSE 0 
                END
            ) > 0
            THEN 0

            ELSE ROUND(
                EXP(
                    SUM(
                        LN(COALESCE(e.multiplicador, 1.0))
                    )
                ),
                2
            )
        END AS multiplicador

    FROM pokemon atacante

    INNER JOIN tipo_poke tp_atacante
        ON atacante.id = tp_atacante.pokemon_id

    INNER JOIN tipos tipo_ataque
        ON tipo_ataque.id = tp_atacante.tipo_id

    CROSS JOIN tipos_objetivo objetivo_tipo

    LEFT JOIN efectivo e
        ON e.id_att = tp_atacante.tipo_id
       AND e.id_def = objetivo_tipo.tipo_id

    WHERE atacante.id NOT IN (
        SELECT id FROM pokemon_objetivo
    )

    GROUP BY 
        atacante.id,
        atacante.pokedex_num,
        atacante.nom,
        tipo_ataque.id,
        tipo_ataque.tipo;


    /* ============================================================
       5. Elegimos el mejor ataque de cada Pokémon atacante
       ============================================================ */

    DROP TEMPORARY TABLE IF EXISTS mejor_ataque_contra_objetivo;

    CREATE TEMPORARY TABLE mejor_ataque_contra_objetivo AS
    SELECT
        aco.pokemon_id,
        aco.pokedex_num,
        aco.pokemon,
        MAX(aco.multiplicador) AS multiplicador
    FROM ataques_contra_objetivo aco
    GROUP BY 
        aco.pokemon_id,
        aco.pokedex_num,
        aco.pokemon;


    /* ============================================================
       6. Pokémon que le pegan fuerte al elegido
       ============================================================ */

    SELECT
        'LE PEGAN FUERTE AL POKÉMON ELEGIDO' AS categoria,
        ma.pokedex_num,
        ma.pokemon,
        ma.multiplicador
    FROM mejor_ataque_contra_objetivo ma
    WHERE ma.multiplicador > 1
    ORDER BY 
        ma.multiplicador DESC,
        ma.pokemon ASC
    LIMIT 12;


    /* ============================================================
       7. Pokémon que le pegan poco al elegido
       ============================================================ */

    SELECT
        'LE PEGAN POCO AL POKÉMON ELEGIDO' AS categoria,
        ma.pokedex_num,
        ma.pokemon,
        ma.multiplicador
    FROM mejor_ataque_contra_objetivo ma
    WHERE ma.multiplicador > 0
      AND ma.multiplicador < 1
    ORDER BY 
        ma.multiplicador ASC,
        ma.pokemon ASC
    LIMIT 12;


    /* ============================================================
       8. Pokémon que no le hacen daño al elegido
       ============================================================ */

    SELECT
        'NO LE HACEN DAÑO AL POKÉMON ELEGIDO' AS categoria,
        ma.pokedex_num,
        ma.pokemon,
        ma.multiplicador
    FROM mejor_ataque_contra_objetivo ma
    WHERE ma.multiplicador = 0
    ORDER BY 
        ma.pokemon ASC
    LIMIT 12;


    /* ============================================================
       9. Calculamos al revés:
          a qué Pokémon les pega el Pokémon elegido
       ============================================================ */

    DROP TEMPORARY TABLE IF EXISTS ataques_del_objetivo;

    CREATE TEMPORARY TABLE ataques_del_objetivo AS
    SELECT
        defensor.id AS pokemon_id,
        defensor.pokedex_num,
        defensor.nom AS pokemon,

        tipo_ataque.id AS tipo_ataque_id,
        tipo_ataque.tipo AS tipo_ataque,

        CASE
            WHEN SUM(
                CASE 
                    WHEN COALESCE(e.multiplicador, 1.0) = 0 THEN 1 
                    ELSE 0 
                END
            ) > 0
            THEN 0

            ELSE ROUND(
                EXP(
                    SUM(
                        LN(COALESCE(e.multiplicador, 1.0))
                    )
                ),
                2
            )
        END AS multiplicador

    FROM pokemon defensor

    INNER JOIN tipo_poke tp_defensor
        ON defensor.id = tp_defensor.pokemon_id

    CROSS JOIN tipos_objetivo tipo_objetivo

    INNER JOIN tipos tipo_ataque
        ON tipo_ataque.id = tipo_objetivo.tipo_id

    LEFT JOIN efectivo e
        ON e.id_att = tipo_objetivo.tipo_id
       AND e.id_def = tp_defensor.tipo_id

    WHERE defensor.id NOT IN (
        SELECT id FROM pokemon_objetivo
    )

    GROUP BY 
        defensor.id,
        defensor.pokedex_num,
        defensor.nom,
        tipo_ataque.id,
        tipo_ataque.tipo;


    /* ============================================================
       10. Elegimos el mejor ataque del Pokémon elegido
       ============================================================ */

    DROP TEMPORARY TABLE IF EXISTS mejor_ataque_del_objetivo;

    CREATE TEMPORARY TABLE mejor_ataque_del_objetivo AS
    SELECT
        ado.pokemon_id,
        ado.pokedex_num,
        ado.pokemon,
        MAX(ado.multiplicador) AS multiplicador
    FROM ataques_del_objetivo ado
    GROUP BY 
        ado.pokemon_id,
        ado.pokedex_num,
        ado.pokemon;


    /* ============================================================
       11. Pokémon a los que el elegido les pega fuerte
       ============================================================ */

    SELECT
        'EL POKÉMON ELEGIDO LES PEGA FUERTE' AS categoria,
        ma.pokedex_num,
        ma.pokemon,
        ma.multiplicador
    FROM mejor_ataque_del_objetivo ma
    WHERE ma.multiplicador > 1
    ORDER BY 
        ma.multiplicador DESC,
        ma.pokemon ASC
    LIMIT 12;


    /* ============================================================
       12. Pokémon a los que el elegido les pega poco
       ============================================================ */

    SELECT
        'EL POKÉMON ELEGIDO LES PEGA POCO' AS categoria,
        ma.pokedex_num,
        ma.pokemon,
        ma.multiplicador
    FROM mejor_ataque_del_objetivo ma
    WHERE ma.multiplicador > 0
      AND ma.multiplicador < 1
    ORDER BY 
        ma.multiplicador ASC,
        ma.pokemon ASC
    LIMIT 12;


    /* ============================================================
       13. Pokémon que son inmunes contra el elegido
       ============================================================ */

    SELECT
        'SON INMUNES CONTRA EL POKÉMON ELEGIDO' AS categoria,
        ma.pokedex_num,
        ma.pokemon,
        ma.multiplicador
    FROM mejor_ataque_del_objetivo ma
    WHERE ma.multiplicador = 0
    ORDER BY 
        ma.pokemon ASC
    LIMIT 12;


END //

DELIMITER ;




#
# procedimiento 2
#



DELIMITER //

CREATE PROCEDURE analizar_tipo(IN p_tipo_id INT)
BEGIN

    /*
        ============================================================
        PROCEDIMIENTO: analizar_tipo
        ============================================================

        Recibe el ID de un tipo Pokémon.

        Ejemplo:
        CALL analizar_tipo(7); -- Fuego

        Devuelve:

        1. Datos del tipo elegido.

        2. Fortalezas:
           Tipos a los que MI TIPO les pega fuerte.
           Ejemplo: Fuego pega fuerte a Planta.

        3. Debilidades:
           Tipos que le pegan fuerte a MI TIPO.
           Ejemplo: Agua pega fuerte a Fuego.

        4. Inmunidades:
           Tipos que NO le hacen daño a MI TIPO.
           Ejemplo: Normal no afecta a Fantasma.
    */


    -- 1. Datos del tipo elegido
    SELECT 
        id,
        tipo,
        descripcion
    FROM tipos
    WHERE id = p_tipo_id;


    -- 2. FORTALEZAS
    -- Mi tipo como atacante.
    -- Buscamos contra qué tipos hace daño x2.
    SELECT 
        t_def.id AS id_tipo,
        t_def.tipo AS tipo,
        e.multiplicador,
        'Fortaleza' AS categoria
    FROM efectivo e
    INNER JOIN tipos t_def 
        ON e.id_def = t_def.id
    WHERE e.id_att = p_tipo_id
      AND e.multiplicador = 2.0
    ORDER BY t_def.tipo;


    -- 3. DEBILIDADES
    -- Mi tipo como defensor.
    -- Buscamos qué tipos atacantes le hacen daño x2.
    SELECT 
        t_att.id AS id_tipo,
        t_att.tipo AS tipo,
        e.multiplicador,
        'Debilidad' AS categoria
    FROM efectivo e
    INNER JOIN tipos t_att 
        ON e.id_att = t_att.id
    WHERE e.id_def = p_tipo_id
      AND e.multiplicador = 2.0
    ORDER BY t_att.tipo;


    -- 4. INMUNIDADES
    -- Mi tipo como defensor.
    -- Buscamos qué tipos atacantes no le hacen daño x0.
    SELECT 
        t_att.id AS id_tipo,
        t_att.tipo AS tipo,
        e.multiplicador,
        'Inmunidad' AS categoria
    FROM efectivo e
    INNER JOIN tipos t_att 
        ON e.id_att = t_att.id
    WHERE e.id_def = p_tipo_id
      AND e.multiplicador = 0.0
    ORDER BY t_att.tipo;

END //

DELIMITER ;