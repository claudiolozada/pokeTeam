#insertare los tipos de pokemon

INSERT INTO tipos (tipo) VALUES 
('Acero'),
('Agua'),
('Bicho'),
('Dragón'),
('Eléctrico'),
('Fantasma'),
('Fuego'),
('Hada'),
('Hielo'),
('Lucha'),
('Normal'),
('Planta'),
('Psíquico'),
('Roca'),
('Siniestro'),
('Tierra'),
('Veneno'),
('Volador');



#efectividad

#2.0 super efectivo

-- Fuego (7) es súper efectivo contra Planta (12), Hielo (9), Bicho (3) y Acero (1)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (7, 12, 2.0), (7, 9, 2.0), (7, 3, 2.0), (7, 1, 2.0);

-- Agua (2) es súper efectivo contra Fuego (7), Tierra (16) y Roca (14)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (2, 7, 2.0), (2, 16, 2.0), (2, 14, 2.0);

-- Eléctrico (5) es súper efectivo contra Agua (2) y Volador (18)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (5, 2, 2.0), (5, 18, 2.0);

-- Planta (12) es súper efectivo contra Agua (2), Tierra (16) y Roca (14)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (12, 2, 2.0), (12, 16, 2.0), (12, 14, 2.0);

-- Lucha (10) es súper efectivo contra Normal (11), Hielo (9), Roca (14), Siniestro (15) y Acero (1)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (10, 11, 2.0), (10, 9, 2.0), (10, 14, 2.0), (10, 15, 2.0), (10, 1, 2.0);

#1.0 daño normal... si no estan en la base de datos asumo q es daño normal

#0.5 poco efectivo

-- El tipo Acero (1) es resistente a casi todo
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (11, 1, 0.5), (12, 1, 0.5), (9, 1, 0.5), (3, 1, 0.5);

-- Fuego (7) es poco efectivo contra Agua (2) y Roca (14)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (7, 2, 0.5), (7, 14, 0.5);



#0 inmunes

-- Normal (11) no afecta a Fantasma (6)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (11, 6, 0.0);

-- Fantasma (6) no afecta a Normal (11)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (6, 11, 0.0);

-- Eléctrico (5) no afecta a Tierra (16)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (5, 16, 0.0);

-- Tierra (16) no afecta a Volador (18)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (16, 18, 0.0);

-- Veneno (17) no afecta a Acero (1)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (17, 1, 0.0);

-- Dragón (4) no afecta a Hada (8)
INSERT INTO efectivo (id_att, id_def, multiplicador) VALUES (4, 8, 0.0);
