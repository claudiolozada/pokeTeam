// --------------------------------------------------
// 1. DATOS GENERALES
// --------------------------------------------------

// Recibimos desde PHP el número de Pokédex del Pokémon actual.
// datosPokeVs viene desde el <script> de pokevs.php.
const pokedexNum = parseInt(datosPokeVs.pokedex_num);

// Ruta de la pokéball decorativa.
// Se usa como imagen de fondo detrás del Pokémon principal
// y también como imagen de reserva si alguna imagen falla.
const rutaPokeball = "../assets/img/pokeball.svg";


// --------------------------------------------------
// 2. COLORES SEGÚN TIPO
// --------------------------------------------------

// Estos nombres están en inglés porque la PokéAPI devuelve los tipos en inglés.
const colors = {
  grass: "#7ED978",
  bug: "#B5D957",
  dark: "#74717E",
  dragon: "#3D8FE0",
  electric: "#ece954",
  fairy: "#F5A8EE",
  fighting: "#E0627B",
  fire: "#f2744a",
  flying: "#B8CCF2",
  ghost: "#7B86D4",
  ground: "#c4b769",
  ice: "#9BE3D8",
  normal: "#BFC1BD",
  poison: "#CA82DC",
  psychic: "#FF5CBA",
  rock: "#7f6e2b",
  steel: "#78AEB9",
  water: "#75B8F0",
};

// Creamos una lista con los nombres de todos los tipos.
// Esto sirve para detectar cuál es el tipo principal del Pokémon.
const mainTypes = Object.keys(colors);


// --------------------------------------------------
// 3. ESTADO ACTUAL DE LOS BOTONES
// --------------------------------------------------

// Estas dos variables guardan qué opciones están seleccionadas.
//
// modoActual puede ser: "ataca" "defiende"
//
// tipoActual puede ser: "eficaz" "debil" "inmune"
//
// Por defecto, la página empieza mostrando: Ataca + Eficaz.
let modoActual = "ataca";
let tipoActual = "eficaz";


// --------------------------------------------------
// 4. CARGAR DATOS DEL POKÉMON PRINCIPAL
// --------------------------------------------------

// Esta función carga los datos visuales del Pokémon desde la PokéAPI.
//
// La base de datos se encarga de la lógica de efectividad.
// La PokéAPI se usa aquí para traer: nombre imagen tipos color principal
async function cargarPokemonPrincipal() {
  try {
    // Creamos la URL de la PokéAPI usando el número de Pokédex.
    const url = `https://pokeapi.co/api/v2/pokemon/${pokedexNum}/`;

    // Hacemos la petición a la API.
    const res = await fetch(url);

    // Si la API no encuentra el Pokémon, volvemos al Pokémon 1.
    if (!res.ok) {
      window.location.href = "pokevs.php?id=1";
      return;
    }

    // Convertimos la respuesta a objeto JavaScript.
    const data = await res.json();

    // Pintamos la parte superior de la página.
    pintarParteSuperior(data);

  } catch (error) {
    // Si ocurre algún error de conexión o API, lo mostramos en consola.
    console.log("Error cargando el Pokémon principal:", error);
  }
}


// --------------------------------------------------
// 5. PINTAR PARTE SUPERIOR
// --------------------------------------------------

// Esta función recibe los datos del Pokémon principal
// y pinta la zona superior de la página.
function pintarParteSuperior(pokemon) {
  // Contenedor donde se insertará el HTML dinámico.
  const pokemonDetailsEl = document.getElementById("pokemon-details");

  // Convertimos el nombre para que empiece con mayúscula.
  const name = pokemon.name[0].toUpperCase() + pokemon.name.slice(1);

  // Imagen Dream World.
  // Algunos Pokémon pueden no tener esta imagen.
  const imageSrc = pokemon.sprites.other.dream_world.front_default;

  // Imagen oficial alternativa.
  // Se usa si Dream World viene vacío.
  const imageSrc2 = pokemon.sprites.other["official-artwork"].front_default;

  // Sacamos los tipos del Pokémon.
  // Ejemplo:
  // Charizard -> ["fire", "flying"]
  const pokeTypes = pokemon.types.map(function (type) {
    return type.type.name;
  });

  // Buscamos el primer tipo que coincida con nuestra lista de colores.
  // Ese será el tipo principal para pintar el fondo.
  const type = mainTypes.find(function (type) {
    return pokeTypes.includes(type);
  });

  // Sacamos el color del tipo principal.
  const color = colors[type];

  // Cambiamos la variable CSS del color actual.
  // En el CSS usas var(--color-tipo-actual).
  document.body.style.setProperty("--color-tipo-actual", color);

  // Pintamos la cabecera del Pokémon.
  pokemonDetailsEl.innerHTML = `
    <div class="btn">
      <button class="previousBtn" onclick="backButton()">
        <i class="fas fa-chevron-left"></i>
      </button>

      <button class="nextBtn" onclick="nextPokemon()">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

    <div class="names">
      <div class="japaneseName">Poke VS</div>
      <div class="name">${name}</div>
    </div>

    <div class="top">
      <div class="image">
        <img 
          class="imgFront" 
          src="${imageSrc == null ? imageSrc2 : imageSrc}" 
          alt="${name}"
        >

        <img 
          class="imgBack" 
          src="${rutaPokeball}" 
          alt="Pokéball"
        >
      </div>
    </div>
  `;
}


// --------------------------------------------------
// 6. FRASES ESTILO POKÉMON
// --------------------------------------------------

// Esta función devuelve la frase que se muestra encima de los resultados.
// La frase cambia dependiendo de:
// - modoActual
// - tipoActual
function obtenerFraseVs() {
  // Cuando el Pokémon actual está atacando
  // y buscamos Pokémon a los que pega fuerte.
  if (modoActual === "ataca" && tipoActual === "eficaz") {
    return "¡Es supereficaz! Estos Pokémon reciben mucho daño de tus ataques:";
  }

  // Cuando el Pokémon actual está atacando
  // y buscamos Pokémon que resisten sus ataques.
  if (modoActual === "ataca" && tipoActual === "debil") {
    return "No es muy eficaz... Estos Pokémon resisten bastante bien tus ataques:";
  }

  // Cuando el Pokémon actual está atacando
  // y buscamos Pokémon inmunes a sus ataques.
  if (modoActual === "ataca" && tipoActual === "inmune") {
    return "¡No afecta al rival! Estos Pokémon son inmunes contra tus ataques:";
  }

  // Cuando el Pokémon actual está defendiendo
  // y buscamos Pokémon que le pegan fuerte.
  if (modoActual === "defiende" && tipoActual === "eficaz") {
    return "¡Cuidado, entrenador! Estos Pokémon pueden hacerte mucho daño:";
  }

  // Cuando el Pokémon actual está defendiendo
  // y buscamos Pokémon que le hacen poco daño.
  if (modoActual === "defiende" && tipoActual === "debil") {
    return "No es muy eficaz contra ti. Estos Pokémon te hacen poco daño:";
  }

  // Cuando el Pokémon actual está defendiendo
  // y buscamos Pokémon que no le hacen daño.
  if (modoActual === "defiende" && tipoActual === "inmune") {
    return "¡No te afecta! Estos Pokémon no logran hacerte daño:";
  }

  // Frase por defecto.
  return "Selecciona una opción para analizar el combate.";
}


// --------------------------------------------------
// 7. OBTENER LISTA ACTUAL
// --------------------------------------------------

// Esta función devuelve la lista que corresponde
// a los botones seleccionados actualmente.
//
// Ejemplo:
// modoActual = "ataca"
// tipoActual = "eficaz"
//
// Entonces devuelve:
// datosPokeVs["ataca"]["eficaz"]
function obtenerListaActual() {
  return datosPokeVs[modoActual][tipoActual] ?? [];
}


// --------------------------------------------------
// 8. NORMALIZAR NOMBRE DEL POKÉMON
// --------------------------------------------------

// La PokéAPI trabaja mejor con nombres en minúscula
// y usando guiones en vez de espacios.
//
// Ejemplo:
// "Mr Mime" -> "mr-mime"
function normalizarNombrePokemon(nombre) {
  return nombre.toLowerCase().trim().replaceAll(" ", "-");
}


// --------------------------------------------------
// 9. OBTENER ID DEL POKÉMON RESULTADO
// --------------------------------------------------

// Esta función intenta conseguir el id del Pokémon resultado.
//
// Puede venir de tres formas:
// 1. Como pokedex_num desde la base de datos.
// 2. Como id.
// 3. Solo como nombre, y entonces se busca en PokéAPI.
async function obtenerIdPokemonResultado(pokemonResultado) {
  // Si el procedimiento SQL devuelve pokedex_num,
  // usamos ese número directamente.
  if (pokemonResultado.pokedex_num) {
    return pokemonResultado.pokedex_num;
  }

  // Si devuelve id, también lo usamos.
  if (pokemonResultado.id) {
    return pokemonResultado.id;
  }

  // Si solo tenemos el nombre, lo normalizamos
  // para poder buscarlo en PokéAPI.
  const nombreApi = normalizarNombrePokemon(pokemonResultado.pokemon);

  // Buscamos el Pokémon por nombre en la PokéAPI.
  const res = await fetch(`https://pokeapi.co/api/v2/pokemon/${nombreApi}`);

  // Si no se encuentra, lanzamos un error.
  if (!res.ok) {
    throw new Error("No se encontró el Pokémon en PokeAPI");
  }

  // Convertimos la respuesta a JSON.
  const data = await res.json();

  // Devolvemos el id real de la PokéAPI.
  return data.id;
}


// --------------------------------------------------
// 10. CREAR TARJETA DE POKÉMON
// --------------------------------------------------

// Esta función crea una tarjeta HTML para cada Pokémon resultado.
//
// Usamos la clase "evolution__pokemon"
// para reutilizar el mismo estilo que ya tenías en evoluciones.
async function crearTarjetaPokemon(pokemonResultado) {
  // Creamos el contenedor principal de la tarjeta.
  const pokemonDiv = document.createElement("div");
  pokemonDiv.classList.add("evolution__pokemon");

  // Creamos los elementos internos.
  const nombreElement = document.createElement("h1");
  const imagenElement = document.createElement("img");
  const multiplicadorElement = document.createElement("p");

  // Sacamos los datos del Pokémon resultado.
  const nombrePokemon = pokemonResultado.pokemon;
  const multiplicador = pokemonResultado.multiplicador;

  // Pintamos el nombre.
  nombreElement.textContent = nombrePokemon;

  // Pintamos el multiplicador.
  multiplicadorElement.textContent = `Daño x${multiplicador}`;

  try {
    // Conseguimos el id del Pokémon.
    const idPokemon = await obtenerIdPokemonResultado(pokemonResultado);

    // Creamos la URL de la imagen oficial.
    const imgUrl = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/${idPokemon}.png`;

    // Asignamos la imagen y el texto alternativo.
    imagenElement.src = imgUrl;
    imagenElement.alt = nombrePokemon;

    // Al hacer click en la imagen,
    // vamos a la página de información del Pokémon.
    imagenElement.addEventListener("click", function () {
      window.location.href = `pokeinfo.php?id=${idPokemon}`;
    });

  } catch (error) {
    // Si no se pudo cargar la imagen,
    // usamos la pokéball como imagen de reserva.
    console.log("No se pudo cargar la imagen de:", nombrePokemon, error);

    imagenElement.src = rutaPokeball;
    imagenElement.alt = nombrePokemon;
  }

  // Agregamos los elementos a la tarjeta.
  pokemonDiv.appendChild(nombreElement);
  pokemonDiv.appendChild(imagenElement);
  pokemonDiv.appendChild(multiplicadorElement);

  // Devolvemos la tarjeta ya creada.
  return pokemonDiv;
}


// --------------------------------------------------
// 11. PINTAR RESULTADOS
// --------------------------------------------------

// Esta función limpia los resultados anteriores
// y pinta los Pokémon de la lista actual.
async function pintarResultadosVs() {
  // Elemento donde va la frase.
  const fraseVs = document.getElementById("frase-vs");

  // Contenedor donde van las tarjetas.
  const resultadosVs = document.getElementById("resultados-vs");

  // Obtenemos la lista según los botones activos.
  const lista = obtenerListaActual();

  // Pintamos la frase correspondiente.
  fraseVs.textContent = obtenerFraseVs();

  // Limpiamos resultados anteriores.
  resultadosVs.innerHTML = "";

  // Si la lista viene vacía, mostramos cuadro de no resultados.
  if (lista.length === 0) {
    fraseVs.textContent = "No hay resultados";

    resultadosVs.innerHTML = `
      <div class="cuadro-sin-resultados">
        <h1>No hay resultados</h1>
      </div>
    `;

    return;
  }

  // Recorremos la lista y creamos una tarjeta por cada Pokémon.
  for (const pokemonResultado of lista) {
    const tarjeta = await crearTarjetaPokemon(pokemonResultado);
    resultadosVs.appendChild(tarjeta);
  }
}


// --------------------------------------------------
// 12. BOTONES ATACA / DEFIENDE
// --------------------------------------------------

// Buscamos los botones principales.
const botonesModoVs = document.querySelectorAll("#botones-modo-vs span");

// A cada botón le añadimos un evento click.
botonesModoVs.forEach(function (boton) {
  boton.addEventListener("click", function () {
    // Guardamos el modo elegido.
    modoActual = boton.dataset.modo;

    // Quitamos la clase activa de todos los botones de modo.
    botonesModoVs.forEach(function (btn) {
      btn.classList.remove("tab-activa");
    });

    // Activamos el botón pulsado.
    boton.classList.add("tab-activa");

    // Repintamos los resultados.
    pintarResultadosVs();
  });
});


// --------------------------------------------------
// 13. BOTONES EFICAZ / DÉBIL / INMUNE
// --------------------------------------------------

// Buscamos los botones secundarios.
const botonesTipoVs = document.querySelectorAll("#botones-tipo-vs span");

// A cada botón le añadimos un evento click.
botonesTipoVs.forEach(function (boton) {
  boton.addEventListener("click", function () {
    // Guardamos el tipo de resultado elegido.
    tipoActual = boton.dataset.tipo;

    // Quitamos la clase activa de todos los botones secundarios.
    botonesTipoVs.forEach(function (btn) {
      btn.classList.remove("tab-activa");
    });

    // Activamos el botón pulsado.
    boton.classList.add("tab-activa");

    // Repintamos los resultados.
    pintarResultadosVs();
  });
});


// --------------------------------------------------
// 14. BOTÓN SIGUIENTE
// --------------------------------------------------

// Esta función se llama desde el botón de siguiente.
function nextPokemon() {
  // Si llegamos al límite, volvemos al Pokémon 1.
  if (pokedexNum >= 1010) {
    window.location.href = "pokevs.php?id=1";
    return;
  }

  // Si no, avanzamos al siguiente Pokémon.
  window.location.href = `pokevs.php?id=${pokedexNum + 1}`;
}


// --------------------------------------------------
// 15. BOTÓN VOLVER
// --------------------------------------------------

// Esta función vuelve a la página anterior del navegador.
function backButton() {
  window.history.back();
}


// --------------------------------------------------
// 16. CARGA INICIAL
// --------------------------------------------------

// Cargamos la parte visual del Pokémon principal.
cargarPokemonPrincipal();

// Pintamos los resultados iniciales:
// Ataca + Eficaz.
pintarResultadosVs();


// --------------------------------------------------
// 17. PRELOADER
// --------------------------------------------------

// Cuando la página termina de cargar,
// agregamos la clase loaded al body.
// Esa clase sirve para ocultar el preloader desde CSS.
window.addEventListener("load", function () {
  document.querySelector("body").classList.add("loaded");
});