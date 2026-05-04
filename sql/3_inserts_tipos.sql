#insertare los tipos de pokemon

INSERT INTO tipos (tipo, descripcion) VALUES 
('Acero', 'Tipo resistente y defensivo, relacionado con metal, armaduras y ataques de gran dureza.'),
('Agua', 'Tipo asociado al agua, mares y ríos. Suele destacar por ataques fluidos y buen equilibrio.'),
('Bicho', 'Tipo relacionado con insectos. Suele ser rápido, molesto y útil contra ciertos tipos concretos.'),
('Dragon', 'Tipo poderoso y raro, relacionado con criaturas legendarias, fuerza y ataques muy potentes.'),
('Electrico', 'Tipo basado en electricidad y velocidad. Destaca por ataques rápidos y paralizantes.'),
('Fantasma', 'Tipo misterioso relacionado con espíritus, sombras e inmunidades especiales.'),
('Fuego', 'Tipo ofensivo relacionado con llamas y calor. Es fuerte contra planta, bicho, hielo y acero.'),
('Hada', 'Tipo mágico y elegante. Destaca por ser muy útil contra dragón, lucha y siniestro.'),
('Hielo', 'Tipo relacionado con frío y hielo. Puede ser muy fuerte contra dragón, planta, tierra y volador.'),
('Lucha', 'Tipo físico y directo, basado en golpes, fuerza y combate cuerpo a cuerpo.'),
('Normal', 'Tipo básico y equilibrado. No tiene muchas ventajas, pero suele ser simple y versátil.'),
('Planta', 'Tipo relacionado con plantas y naturaleza. Suele usar ataques de drenaje, esporas y curación.'),
('Psiquico', 'Tipo mental y especial, relacionado con poderes psíquicos, control y ataques de energía.'),
('Roca', 'Tipo duro y defensivo, relacionado con piedras, montañas y ataques de gran impacto.'),
('Siniestro', 'Tipo oscuro y estratégico, relacionado con trucos, sombras y ataques inesperados.'),
('Tierra', 'Tipo relacionado con arena, suelo y terremotos. Muy fuerte contra eléctrico, fuego, roca, acero y veneno.'),
('Veneno', 'Tipo relacionado con toxinas y veneno. Puede envenenar y es fuerte contra planta y hada.'),
('Volador', 'Tipo relacionado con el aire y el vuelo. Suele ser rápido y fuerte contra planta, lucha y bicho.');

#efectividad

/* ============================================================
   TABLA DE EFECTIVIDAD POKÉMON
   id_att = tipo atacante
   id_def = tipo defensor
   multiplicador:
   2.0 = súper efectivo
   0.5 = poco efectivo
   0.0 = no afecta / inmune

   Si una combinación NO está aquí, se asume daño normal x1.0
   ============================================================ */


/* ============================================================
   2.0 - SÚPER EFECTIVO
   ============================================================ */

INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES

-- Acero
(1, 8, 2.0),  -- Acero -> Hada
(1, 9, 2.0),  -- Acero -> Hielo
(1, 14, 2.0), -- Acero -> Roca

-- Agua
(2, 7, 2.0),  -- Agua -> Fuego
(2, 16, 2.0), -- Agua -> Tierra
(2, 14, 2.0), -- Agua -> Roca

-- Bicho
(3, 12, 2.0), -- Bicho -> Planta
(3, 13, 2.0), -- Bicho -> Psíquico
(3, 15, 2.0), -- Bicho -> Siniestro

-- Dragón
(4, 4, 2.0),  -- Dragón -> Dragón

-- Eléctrico
(5, 2, 2.0),  -- Eléctrico -> Agua
(5, 18, 2.0), -- Eléctrico -> Volador

-- Fantasma
(6, 6, 2.0),  -- Fantasma -> Fantasma
(6, 13, 2.0), -- Fantasma -> Psíquico

-- Fuego
(7, 12, 2.0), -- Fuego -> Planta
(7, 9, 2.0),  -- Fuego -> Hielo
(7, 3, 2.0),  -- Fuego -> Bicho
(7, 1, 2.0),  -- Fuego -> Acero

-- Hada
(8, 10, 2.0), -- Hada -> Lucha
(8, 4, 2.0),  -- Hada -> Dragón
(8, 15, 2.0), -- Hada -> Siniestro

-- Hielo
(9, 12, 2.0), -- Hielo -> Planta
(9, 16, 2.0), -- Hielo -> Tierra
(9, 18, 2.0), -- Hielo -> Volador
(9, 4, 2.0),  -- Hielo -> Dragón

-- Lucha
(10, 11, 2.0), -- Lucha -> Normal
(10, 9, 2.0),  -- Lucha -> Hielo
(10, 14, 2.0), -- Lucha -> Roca
(10, 15, 2.0), -- Lucha -> Siniestro
(10, 1, 2.0),  -- Lucha -> Acero

-- Planta
(12, 2, 2.0),  -- Planta -> Agua
(12, 16, 2.0), -- Planta -> Tierra
(12, 14, 2.0), -- Planta -> Roca

-- Psíquico
(13, 10, 2.0), -- Psíquico -> Lucha
(13, 17, 2.0), -- Psíquico -> Veneno

-- Roca
(14, 7, 2.0),  -- Roca -> Fuego
(14, 9, 2.0),  -- Roca -> Hielo
(14, 18, 2.0), -- Roca -> Volador
(14, 3, 2.0),  -- Roca -> Bicho

-- Siniestro
(15, 6, 2.0),  -- Siniestro -> Fantasma
(15, 13, 2.0), -- Siniestro -> Psíquico

-- Tierra
(16, 7, 2.0),  -- Tierra -> Fuego
(16, 5, 2.0),  -- Tierra -> Eléctrico
(16, 17, 2.0), -- Tierra -> Veneno
(16, 14, 2.0), -- Tierra -> Roca
(16, 1, 2.0),  -- Tierra -> Acero

-- Veneno
(17, 12, 2.0), -- Veneno -> Planta
(17, 8, 2.0),  -- Veneno -> Hada

-- Volador
(18, 12, 2.0), -- Volador -> Planta
(18, 10, 2.0), -- Volador -> Lucha
(18, 3, 2.0);  -- Volador -> Bicho

/* ============================================================
   0.5 - POCO EFECTIVO
   ============================================================ */

INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES

-- Acero
(1, 7, 0.5),  -- Acero -> Fuego
(1, 2, 0.5),  -- Acero -> Agua
(1, 5, 0.5),  -- Acero -> Eléctrico
(1, 1, 0.5),  -- Acero -> Acero

-- Agua
(2, 2, 0.5),  -- Agua -> Agua
(2, 12, 0.5), -- Agua -> Planta
(2, 4, 0.5),  -- Agua -> Dragón

-- Bicho
(3, 7, 0.5),  -- Bicho -> Fuego
(3, 10, 0.5), -- Bicho -> Lucha
(3, 17, 0.5), -- Bicho -> Veneno
(3, 18, 0.5), -- Bicho -> Volador
(3, 6, 0.5),  -- Bicho -> Fantasma
(3, 1, 0.5),  -- Bicho -> Acero
(3, 8, 0.5),  -- Bicho -> Hada

-- Dragón
(4, 1, 0.5),  -- Dragón -> Acero

-- Eléctrico
(5, 5, 0.5),  -- Eléctrico -> Eléctrico
(5, 12, 0.5), -- Eléctrico -> Planta
(5, 4, 0.5),  -- Eléctrico -> Dragón

-- Fantasma
(6, 15, 0.5), -- Fantasma -> Siniestro

-- Fuego
(7, 7, 0.5),  -- Fuego -> Fuego
(7, 2, 0.5),  -- Fuego -> Agua
(7, 14, 0.5), -- Fuego -> Roca
(7, 4, 0.5),  -- Fuego -> Dragón

-- Hada
(8, 7, 0.5),  -- Hada -> Fuego
(8, 17, 0.5), -- Hada -> Veneno
(8, 1, 0.5),  -- Hada -> Acero

-- Hielo
(9, 7, 0.5),  -- Hielo -> Fuego
(9, 2, 0.5),  -- Hielo -> Agua
(9, 9, 0.5),  -- Hielo -> Hielo
(9, 1, 0.5),  -- Hielo -> Acero

-- Lucha
(10, 17, 0.5), -- Lucha -> Veneno
(10, 18, 0.5), -- Lucha -> Volador
(10, 13, 0.5), -- Lucha -> Psíquico
(10, 3, 0.5),  -- Lucha -> Bicho
(10, 8, 0.5),  -- Lucha -> Hada

-- Normal
(11, 14, 0.5), -- Normal -> Roca
(11, 1, 0.5),  -- Normal -> Acero

-- Planta
(12, 7, 0.5),  -- Planta -> Fuego
(12, 12, 0.5), -- Planta -> Planta
(12, 17, 0.5), -- Planta -> Veneno
(12, 18, 0.5), -- Planta -> Volador
(12, 3, 0.5),  -- Planta -> Bicho
(12, 4, 0.5),  -- Planta -> Dragón
(12, 1, 0.5),  -- Planta -> Acero

-- Psíquico
(13, 13, 0.5), -- Psíquico -> Psíquico
(13, 1, 0.5),  -- Psíquico -> Acero

-- Roca
(14, 10, 0.5), -- Roca -> Lucha
(14, 16, 0.5), -- Roca -> Tierra
(14, 1, 0.5),  -- Roca -> Acero

-- Siniestro
(15, 10, 0.5), -- Siniestro -> Lucha
(15, 15, 0.5), -- Siniestro -> Siniestro
(15, 8, 0.5),  -- Siniestro -> Hada

-- Tierra
(16, 12, 0.5), -- Tierra -> Planta
(16, 3, 0.5),  -- Tierra -> Bicho

-- Veneno
(17, 17, 0.5), -- Veneno -> Veneno
(17, 16, 0.5), -- Veneno -> Tierra
(17, 14, 0.5), -- Veneno -> Roca
(17, 6, 0.5),  -- Veneno -> Fantasma

-- Volador
(18, 5, 0.5),  -- Volador -> Eléctrico
(18, 14, 0.5), -- Volador -> Roca
(18, 1, 0.5);  -- Volador -> Acero


/* ============================================================
   0.0 - INMUNIDADES
   ============================================================ */

INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES

(11, 6, 0.0),  -- Normal -> Fantasma
(10, 6, 0.0),  -- Lucha -> Fantasma
(17, 1, 0.0),  -- Veneno -> Acero
(16, 18, 0.0), -- Tierra -> Volador
(6, 11, 0.0),  -- Fantasma -> Normal
(5, 16, 0.0),  -- Eléctrico -> Tierra
(13, 15, 0.0), -- Psíquico -> Siniestro
(4, 8, 0.0);   -- Dragón -> Hada