# PokeTeam

PokeTeam es una web que sirve como una guía completa de Pokémon. Permite a los usuarios buscar información sobre diferentes especies de Pokémon, incluyendo sus características, habilidades, tipos y evoluciones, además de incorporar otras funcionalidades como tener tu equipo Pokémon, información de la tabla de tipos, ver qué Pokémon tienen más oportunidades de derrotar a tu rival, etc.

El sitio web está construido utilizando HTML básico, CSS, JavaScript Vanilla y PHP, y utiliza la PokéAPI para obtener datos sobre los Pokémon.

---

# Índice

1. Tecnologías Utilizadas  
2. Funcionalidades Clave  
3. Sobre el Proyecto  
4. Detalles Técnicos y Lógica  
5. Instalación y Configuración  
6. Estructura de Archivos  
7. Contacto  

---

# Tecnologías Utilizadas

- **Frontend:** HTML5, CSS3, JavaScript (Vanilla).
- **Backend:** PHP.
- **Base de Datos:** MySQL.
- **API Externa:** PokéAPI.
- **Herramientas:** Docker, Git.

---

# Funcionalidades Clave

- Pokédex completa con información detallada de tipos, estadísticas base y líneas evolutivas.
- Tabla de tipos interactiva que muestra fortalezas, debilidades e inmunidades.
- Buscador (por tipos o nombre del Pokémon) que recomienda los mejores Pokémon para enfrentarte a un rival específico.
- Gestión de equipos personalizados guardados en la cuenta del usuario.
- Sistema de login seguro, gestión de perfiles y selección de avatares.

---

# Sobre el Proyecto

PokeTeam es una Pokédex interactiva desarrollada como proyecto académico, donde el usuario puede personalizar su perfil, explorar Pokémon de todas las regiones y analizar ventajas y desventajas entre Pokémon mediante un sistema estratégico basado en sus tipos.

---

# Página Principal

La web cuenta con una interfaz inspirada en los videojuegos clásicos de Pokémon, con un diseño dinámico e interactivo.

<p align="center">
  <img src="scripts/home.png" width="40%" alt="Página principal">
  <img src="scripts/home2.png" width="40%" alt="Panel lateral">
</p>

---

# Sistema de Avatares

El usuario puede elegir entre diferentes avatares masculinos y femeninos para personalizar su experiencia dentro de la plataforma.

<p align="center">
  <img src="scripts/seleccionavatar.png" width="45%" alt="Selección de avatares masculinos">
  <img src="scripts/seleccionavatar2.png" width="45%" alt="Selección de avatares femeninos">
</p>

---

# Perfil del Entrenador

Cada usuario dispone de un perfil personalizado donde puede visualizar su información y su avatar seleccionado.

<p align="center">
  <img src="scripts/perfil.png" width="50%" alt="Perfil del entrenador">
</p>

---

# Equipos Pokémon

PokeTeam permite crear y administrar equipos Pokémon personalizados.

<p align="center">
  <img src="scripts/equipo.png" width="30%" alt="Equipo Pokémon 1">
  <img src="scripts/equipo2.png" width="30%" alt="Equipo Pokémon 2">
  <img src="scripts/equipo3.png" width="30%" alt="Equipo Pokémon 3">
</p>

---

# Pokédex Dinámica

La Pokédex obtiene información en tiempo real desde la PokéAPI y permite visualizar Pokémon de todas las regiones.

<p align="center">
  <img src="scripts/pokedex.png" width="55%" alt="Pokédex">
</p>

<p align="center">
  <img src="scripts/pokedex2.png" width="30%" alt="Información del Pokémon">
  <img src="scripts/estadisticas.png" width="30%" alt="Estadísticas del Pokémon">
  <img src="scripts/evoluciones.png" width="30%" alt="Evoluciones Pokémon">
</p>

---

# Sistema de Tipos

La aplicación incluye un panel interactivo con la tabla de tipos Pokémon y sus relaciones.

<p align="center">
  <img src="scripts/tabladetipos.png" width="55%" alt="Tabla de tipos">
</p>

<p align="center">
  <img src="scripts/infotipos1.png" width="30%" alt="Información de tipos Pokémon">
  <img src="scripts/infotipos2.png" width="30%" alt="Información de tipos Pokémon">
  <img src="scripts/infotipos3.png" width="30%" alt="Información de tipos Pokémon">
</p>

---

# Sistema de Estrategia

El punto fuerte de PokeTeam es su sistema estratégico.  
La aplicación permite buscar Pokémon por tipos y analizar rivalidades automáticamente.

Al seleccionar un Pokémon, el sistema calcula contra qué oponentes tiene ventaja y contra cuáles está en desventaja, basándose en la lógica oficial de tipos Pokémon.

<p align="center">
  <img src="scripts/vs.png" width="55%" alt="Búsqueda por tipos">
</p>

<p align="center">
  <img src="scripts/vs1.png" width="30%" alt="Ventajas del Pokémon">
  <img src="scripts/vs3.png" width="30%" alt="Panel de búsqueda por tipos">
  <img src="scripts/vs2.png" width="30%" alt="Desventajas del Pokémon">
</p>

---

# Detalles Técnicos y Lógica

## Gestión de PokéAPI

- **Pedidos automáticos:** La web conecta con PokéAPI para obtener nombres, imágenes y estadísticas en tiempo real, evitando la carga manual de datos.
- **Segmentación por regiones:** El código gestiona los rangos de ID (desde el 1 hasta el 1025) para cargar únicamente la región solicitada por el usuario, optimizando el rendimiento.
- **Traductor de tipos:** Debido a que la API entrega los datos en inglés, se implementó una lógica para traducir los datos y mostrar los iconos en español (.png locales).
- **Normalización de datos:** Se procesan los valores de peso y altura que entrega la API (originalmente en hectogramos y decímetros) para mostrarlos en formatos estándar (kg y metros).
- **Control de flujo:** El código detecta cambios rápidos de región para cancelar peticiones anteriores y evitar que la información de diferentes generaciones se mezcle en pantalla.

---

## Lógica y Funciones

- **Algoritmo de rivales:** Se diseñó una función que consulta los tipos del Pokémon en la base de datos (multiplicadores de daño 2.0, 1.0, 0.5, 0.0). Al elegir un oponente, el sistema calcula la combinación de tipos más efectiva y muestra los Pokémon ideales para derrotarlo.
- **Tabla de tipos:** Función dedicada a extraer la descripción y efectividades de cada tipo Pokémon para mostrarlas de forma visual.
- **Sistema de avisos y errores:** Se implementó un procesador centralizado mediante un switch que recibe códigos por GET. Esto permite mostrar alertas personalizadas al usuario (como errores de aventura o ediciones exitosas) mediante una interfaz dinámica de JS y CSS, evitando que el código se rompa ante un fallo.
- **Conexión PDO:** Se utiliza PHP Data Objects para todas las consultas a la base de datos, lo que garantiza una capa de seguridad esencial contra ataques de inyección SQL.
- **Sesiones y persistencia:** PHP gestiona las sesiones de usuario para que cada entrenador pueda guardar su equipo (IDs, posiciones y apodos) y recuperarlo en cualquier momento cruzando los datos con la PokéAPI.

---

# Instalación y Configuración

El proyecto se diseñó originalmente usando una base de datos en AWS, así que para instalarlo localmente tendrás que realizar más pasos de lo habitual.

## 1. Clonar el repositorio

```bash
git clone https://github.com/claudiolozada/pokeTeam.git
```

---

## 2. Configurar el archivo docker-compose.yml

Debes asegurar que el archivo incluya un servicio para MySQL que cargue los datos iniciales.

Ejemplo de configuración funcional :

(añade estos datos al .yml sin eliminar lo que ya trae) 
```yml
depends_on:
  - db

db:
  image: mysql:8.0
  container_name: poketeam_db

  environment:
    MYSQL_DATABASE: poketeam_db
    MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}

  volumes:
    - ./sql:/docker-entrypoint-initdb.d/
    - db_data:/var/lib/mysql

volumes:
  db_data:
```

---

## 3. Crear el archivo `.env`

Define las credenciales en la raíz del proyecto para la conexión:

```env
DB_HOST=db
DB_NAME=poketeam_db
DB_USER=root
DB_PASSWORD=tu_clave_aqui
```

---

## 4. Levantar el entorno

Desde la terminal, ejecuta:

```bash
docker-compose up -d
```

---

## 5. Acceso

Navega en tu navegador a:

```txt
localhost:8080
```

---

# Estructura de Archivos

- `www/`: Contiene la lógica de la aplicación (PHP, estilos CSS y scripts JS).
- `sql/`: Scripts necesarios para la estructura y datos de la base de datos.
- `Dockerfile`: Configuración de la imagen del servidor.
- `docker-compose.yml`: Orquestador para levantar el servidor y la base de datos en conjunto.

---

# Uso

Una vez que hayas instalado PokeTeam, puedes usarlo abriéndolo en tu navegador web con `localhost:8080`.

Puedes buscar Pokémon utilizando la barra de búsqueda o navegar a través de la lista de todos los Pokémon.

Al hacer clic en un Pokémon, se mostrará su información detallada, incluyendo sus tipos, habilidades, estadísticas y evoluciones.

También, en el apartado de enfrentamientos, puedes buscar Pokémon filtrando por tipos y, al hacer clic en un Pokémon, se mostrarán los Pokémon rivales contra los que está con mayor ventaja o desventaja.

Además, tienes un apartado para ver tu equipo Pokémon y sus datos, además de una tabla de tipos con la que podrás entender mejor las debilidades y ventajas de los Pokémon.

---

# Créditos

PokeTeam utiliza las siguientes APIs y partes de código abierto:

- PokéAPI: https://pokeapi.co/
- Código de la Pokédex: https://github.com/lazyjinchuriki/pokedex

---

# Contacto

- **Nombre:** Claudio Lozada
- **Email:** claudiolozada02@gmail.com
- **GitHub:** @claudiolozada