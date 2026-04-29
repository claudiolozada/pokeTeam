USE poketeam;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) NOT NULL UNIQUE,
psw VARCHAR(255) NOT NULL,
apodo VARCHAR(50),
edad INT,
avatar VARCHAR(20)
);

CREATE TABLE tipos (
id INT AUTO_INCREMENT PRIMARY KEY,
tipo VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE pokemon (
id INT AUTO_INCREMENT PRIMARY KEY,
pokedex_num INT NOT NULL UNIQUE,
nom VARCHAR(50) NOT NULL
);

CREATE TABLE tipo_poke (
pokemon_id INT NOT NULL,
tipo_id INT NOT NULL,
PRIMARY KEY (pokemon_id,tipo_id),
FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE,
FOREIGN KEY (tipo_id) REFERENCES tipos (id) ON DELETE CASCADE
);

CREATE TABLE efectivo (
id_att INT NOT NULL,
id_def INT NOT NULL,
multiplicador DECIMAL(3,1) NOT NULL,
PRIMARY KEY (id_att,id_def),
FOREIGN KEY (id_att) REFERENCES tipos (id) ON DELETE CASCADE,
FOREIGN KEY (id_def) REFERENCES tipos (id) ON DELETE CASCADE
);

CREATE TABLE equipo_pokemon (
user_id INT NOT NULL,
pokemon_id INT NOT NULL,
posicion_num INT NOT NULL,
poke_apodo VARCHAR(15),
PRIMARY KEY (user_id, posicion_num), 
FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE,
CHECK (posicion_num BETWEEN 1 AND 6) 
);

CREATE TABLE pokemon_fav (
user_id INT NOT NULL,
pokemon_id INT NOT NULL,
PRIMARY KEY (user_id,pokemon_id),
FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE
);