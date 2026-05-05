
Se quiere crear una base de datos para una aplicación web llamada PokeTeam, donde los usuarios puedan registrarse, elegir un avatar y
crear su propio equipo Pokémon.

Cada usuario debe tener la siguiente información: id, username, psw, apodo, edad y avatar.
Cada usuario podrá tener un equipo Pokémon formado por varios Pokémon. En el equipo se debe guardar también la posición numérica que ocupa cada 
Pokémon dentro del equipo y si el Pokémon tiene un apodo personalizado. También se debe tener en cuenta que un Pokémon puede estar en los equipos 
de muchos usuarios.

De cada Pokémon se necesita guardar: id, pokedex_num y nom. Es importante saber que cada Pokémon puede tener uno o varios tipos. Por ejemplo,
Charmander es de tipo Fuego, pero Bulbasaur es de tipo Planta y Veneno. Además, un tipo puede pertenecer a muchos Pokémon; de cada tipo se necesita guardar: id, tipo y descripción.

Además, se quiere guardar la relación entre los tipos de los Pokémon y su efectividad en combate. Por ejemplo, el tipo Fuego es fuerte contra Planta, pero débil contra Agua. Para eso, se debe crear una tabla donde se guarde el multiplicador de daño entre un tipo atacante y un tipo defensor.

El multiplicador puede tener valores como:

• 2.0 si el ataque es muy eficaz.
• 1.0 si el daño es normal.
• 0.5 si es poco eficaz.
• 0.0 si no tiene efecto.



