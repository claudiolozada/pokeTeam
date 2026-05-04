// --------------------------------------------------
// VARIABLES GENERALES
// --------------------------------------------------

// Contenedor donde se van a pintar las cartas de Pokémon.
const contenedorPokemon = document.getElementById("contenedorPokemon");

// Loader/cargador visual.
// Sirve para mostrar que la página está cargando datos.
const cargador = document.querySelector(".cargador");

// Aquí guardaremos todos los Pokémon de la PokéAPI.
// Esta lista sirve para buscar Pokémon por nombre mientras escribes.
let listaPokemon = [];

// Temporizador para controlar la búsqueda.
// Evita hacer demasiadas peticiones mientras el usuario escribe.
let temporizadorBusqueda = null;

// --------------------------------------------------
// COLORES DE TIPOS
// --------------------------------------------------

// Colores asociados a cada tipo.
// Están en inglés porque la PokéAPI devuelve los tipos en inglés.
const colores = {
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

// Sacamos los nombres de los tipos.
// Esto sirve para detectar el tipo principal de cada Pokémon.
const tiposPrincipales = Object.keys(colores);

// --------------------------------------------------
// RUTAS DE IMÁGENES
// --------------------------------------------------

// Ruta base donde están tus imágenes del proyecto.
const rutaImagenes = "../assets/img";

// Ruta de la pokéball decorativa.
const rutaPokeball = `${rutaImagenes}/pokeball.svg`;

// Traducción de los tipos de la PokéAPI a los nombres de tus imágenes.
// Ejemplo:
// La PokéAPI devuelve "fire", pero tu imagen se llama "fuego.png".
const imagenesTipos = {
  normal: "normal.png",
  fire: "fuego.png",
  water: "agua.png",
  grass: "planta.png",
  electric: "electrico.png",
  ice: "hielo.png",
  fighting: "lucha.png",
  poison: "veneno.png",
  ground: "tierra.png",
  flying: "volador.png",
  psychic: "psiquico.png",
  bug: "bicho.png",
  rock: "roca.png",
  ghost: "fantasma.png",
  dragon: "dragon.png",
  dark: "siniestro.png",
  steel: "acero.png",
  fairy: "hada.png",
};

// --------------------------------------------------
// FUNCIÓN: OBTENER IMAGEN DEL TIPO
// --------------------------------------------------

// Recibe un tipo en inglés y devuelve la ruta de su imagen.
// Ejemplo:
// obtenerImagenTipo("fire")
// devuelve:
// ../assets/img/tipos/fuego.png
function obtenerImagenTipo(tipo) {
  return `${rutaImagenes}/tipos/${imagenesTipos[tipo]}`;
}

// --------------------------------------------------
// FUNCIÓN: CARGAR LISTA DE POKÉMON
// --------------------------------------------------

// Esta función pide a la PokéAPI una lista general de Pokémon.
// No trae todos los datos completos, solo nombres y URLs.
// Esa lista se usa para poder buscar mientras se escribe.
async function cargarListaPokemon() {
  const url = "https://pokeapi.co/api/v2/pokemon?limit=1025";

  try {
    const respuesta = await fetch(url);
    const datos = await respuesta.json();

    // Guardamos la lista en la variable global.
    listaPokemon = datos.results;
  } catch (error) {
    // Si falla la PokéAPI, mandamos a la misma página con un aviso.
    window.location.href = `${window.location.pathname}?error=api`;
  }
}

// --------------------------------------------------
// FUNCIÓN: CARGAR POKÉMON POR TIPO
// --------------------------------------------------

// Esta función usa los IDs que llegan desde PHP.
// Ejemplo:
// idsPokemonPorTipo = [4, 5, 6, 37, 38]
//
// Luego pide cada Pokémon a la PokéAPI y crea sus cartas.
async function cargarPokemonPorTipo() {
  // Limpiamos las cartas anteriores.
  contenedorPokemon.innerHTML = "";

  // Activamos el cargador si existe.
  if (cargador) {
    cargador.classList.add("cargador-activo");
  }

  try {
    // Recorremos los IDs recibidos desde PHP.
    for (let i = 0; i < idsPokemonPorTipo.length; i++) {
      const idPokemon = idsPokemonPorTipo[i];

      // Pedimos los datos completos de ese Pokémon.
      const url = `https://pokeapi.co/api/v2/pokemon/${idPokemon}`;

      const respuesta = await fetch(url);
      const datos = await respuesta.json();

      // Creamos la carta del Pokémon.
      crearTarjetaPokemon(datos);
    }
  } catch (error) {
    // Si falla la PokéAPI, añadimos error=api a la URL actual.
    const urlActual = new URL(window.location.href);

    urlActual.searchParams.set("error", "api");

    window.location.href = urlActual.toString();
  }

  // Quitamos el cargador cuando termina.
  if (cargador) {
    cargador.classList.remove("cargador-activo");
  }
}

// --------------------------------------------------
// FUNCIÓN: BUSCAR POKÉMON EN LA API
// --------------------------------------------------

// Esta función se ejecuta cada vez que escribes en el buscador.
//
// Ejemplos:
// "s"    -> muestra Pokémon que empiezan por s.
// "pi"   -> muestra Pokémon que empiezan por pi.
// "pika" -> muestra Pikachu.
//
// Si el input queda vacío, vuelve a cargar los Pokémon del tipo seleccionado.
function buscarPokemonEnApi() {
  const input = document.getElementById("buscador");

  // Si no existe el input, detenemos la función.
  if (!input) {
    return;
  }

  // Leemos el texto escrito y lo pasamos a minúsculas.
  const texto = input.value.toLowerCase().trim();

  // Cancelamos el temporizador anterior.
  // Esto evita lanzar una búsqueda por cada tecla inmediatamente.
  clearTimeout(temporizadorBusqueda);

  // Esperamos 300ms antes de buscar.
  // Si el usuario sigue escribiendo, el temporizador se reinicia.
  temporizadorBusqueda = setTimeout(async function () {
    // Si el usuario borró el texto, volvemos a mostrar el tipo seleccionado.
    if (texto === "") {
      cargarPokemonPorTipo();
      return;
    }

    // Buscamos coincidencias en la lista general.
    // startsWith significa "empieza por".
    //
    // Ejemplo:
    // pikachu.startsWith("pika") -> true
    // charizard.startsWith("pika") -> false
    const coincidencias = listaPokemon
      .filter(function (pokemon) {
        return pokemon.name.startsWith(texto);
      })
      .slice(0, 30);

    // Limpiamos el contenedor.
    contenedorPokemon.innerHTML = "";

    // Si no hay coincidencias, mostramos mensaje.
    if (coincidencias.length === 0) {
      contenedorPokemon.innerHTML = `
        <p class="mensaje-error-pokemon">
          No se encontró ningún Pokémon que empiece por "${texto}".
        </p>
      `;
      return;
    }

    // Activamos el cargador.
    if (cargador) {
      cargador.classList.add("cargador-activo");
    }

    try {
      // Pedimos los datos completos de cada coincidencia.
      for (let i = 0; i < coincidencias.length; i++) {
        const nombrePokemon = coincidencias[i].name;

        const url = `https://pokeapi.co/api/v2/pokemon/${nombrePokemon}`;

        const respuesta = await fetch(url);
        const datos = await respuesta.json();

        crearTarjetaPokemon(datos);
      }
    } catch (error) {
      // Si falla la búsqueda, mostramos mensaje.
      console.error("Error buscando Pokémon:", error);

      contenedorPokemon.innerHTML = `
        <p class="mensaje-error-pokemon">
          Hubo un error buscando Pokémon.
        </p>
      `;
    }

    // Quitamos el cargador.
    if (cargador) {
      cargador.classList.remove("cargador-activo");
    }
  }, 300);
}

// --------------------------------------------------
// FUNCIÓN: CREAR TARJETA POKÉMON
// --------------------------------------------------

// Esta función recibe un Pokémon completo desde la PokéAPI
// y crea una carta HTML con sus datos principales.
function crearTarjetaPokemon(pokemon) {
  // Creamos la carta principal.
  const cartaPokemon = document.createElement("div");

  // Le damos la clase carta para aplicar CSS.
  cartaPokemon.classList.add("carta");

  // Guardamos el id del Pokémon en el elemento.
  cartaPokemon.id = pokemon.id;

  // Nombre con primera letra en mayúscula.
  let nombre = pokemon.name[0].toUpperCase() + pokemon.name.slice(1);

  // Si el nombre es muy largo, nos quedamos con la primera parte.
  // Ejemplo:
  // "charizard-mega-x" -> "charizard"
  if (nombre.length > 9) {
    nombre = nombre.split("-")[0];
  }

  // ID con 3 cifras.
  // Ejemplo:
  // 1 -> 001
  // 25 -> 025
  const id = pokemon.id.toString().padStart(3, "0");

  // Peso en kg.
  const peso = pokemon.weight / 10 + "kg";

  // Altura en metros.
  const altura = pokemon.height / 10 + "m";

  // Sacamos los tipos del Pokémon.
  // Ejemplo:
  // Bulbasaur -> ["grass", "poison"]
  const tiposPokemon = pokemon.types.map(function (tipo) {
    return tipo.type.name;
  });

  // Buscamos el tipo principal para elegir el color de la carta.
  const tipoPrincipal = tiposPrincipales.find(function (tipo) {
    return tiposPokemon.indexOf(tipo) > -1;
  });

  // Sacamos el color del tipo principal.
  const color = colores[tipoPrincipal];

  // Variables para las imágenes del Pokémon.
  let imagenFrente;
  let imagenEspalda;

  try {
    // Imagen frontal del Pokémon.
    imagenFrente = pokemon.sprites.front_default;

    // Imagen trasera del Pokémon.
    imagenEspalda = pokemon.sprites.back_default;
  } catch (error) {
    // Si no existen las imágenes, dejamos un valor vacío.
    imagenFrente = "#";
    imagenEspalda = "#";
  }

  // Aplicamos el color principal al fondo de la carta.
  cartaPokemon.style.backgroundColor = color;

  // Creamos el HTML interno de la carta.
  const contenidoCarta = `
    <div class="frente lado">

      <div class="contenedor-imagen">
        <img 
          class="fondo-pokeball" 
          src="${rutaPokeball}" 
          alt="Pokéball"
        >

        <img 
          class="imagen-pokemon" 
          src="${imagenFrente}" 
          alt="${nombre}"
        >
      </div>

      <span class="numero-pokemon">#${id}</span>

      <h3 class="nombre-pokemon">${nombre}</h3>

      <div class="tipos-pokemon">
        ${tiposPokemon
          .map(function (tipo) {
            return `
              <div class="fondo-tipo-pokemon">
                <img 
                  src="${obtenerImagenTipo(tipo)}" 
                  alt="Tipo ${tipo}"
                >
              </div>
            `;
          })
          .join("")}
      </div>

    </div>

    <div class="reverso lado">

      <div class="contenedor-imagen">
        <img 
          class="imagen-pokemon" 
          src="${imagenEspalda == null ? imagenFrente : imagenEspalda}" 
          alt="${nombre}"
        >

        <img 
          class="fondo-pokeball" 
          src="${rutaPokeball}" 
          alt="Pokéball"
        >
      </div>

      <span class="numero-pokemon">#${id}</span>

      <div class="estadisticas">
        <div>
          Peso:<br>
          <b>${peso}</b>
        </div>

        <div>
          Altura:<br>
          <b>${altura}</b>
        </div>
      </div>

    </div>
  `;

  // Insertamos el HTML dentro de la carta.
  cartaPokemon.innerHTML = contenidoCarta;

  // Al hacer click en la carta,
  // vamos a la página Poke VS de ese Pokémon.
  cartaPokemon.addEventListener("click", function () {
    window.open(`pokevs.php?id=${id}`, "_self");
  });

  // Creamos un contenedor externo para la carta.
  // Esto ayuda con el diseño y la animación CSS.
  const contenedorCarta = document.createElement("div");

  contenedorCarta.classList.add("contenedor-carta");

  // Metemos la carta dentro del contenedor.
  contenedorCarta.appendChild(cartaPokemon);

  // Pintamos la carta en pantalla.
  contenedorPokemon.appendChild(contenedorCarta);
}

// --------------------------------------------------
// BOTÓN SUBIR
// --------------------------------------------------

// Al hacer scroll, mostramos u ocultamos el botón de subir.
window.addEventListener("scroll", function () {
  const botonSubir = document.getElementById("botonSubir");

  // Si el botón no existe en esta página, no hacemos nada.
  if (!botonSubir) {
    return;
  }

  // Si hemos bajado más de 100px, mostramos el botón.
  if (window.scrollY > 100) {
    botonSubir.style.display = "block";
  } else {
    botonSubir.style.display = "none";
  }
});

// Buscamos el botón de subir.
const botonSubir = document.getElementById("botonSubir");

// Si existe, le añadimos el click.
if (botonSubir) {
  botonSubir.addEventListener("click", function () {
    // Subimos suavemente al inicio de la página.
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
}

// --------------------------------------------------
// BOTÓN BAJAR
// --------------------------------------------------

// Al hacer scroll, mostramos u ocultamos el botón de bajar.
window.addEventListener("scroll", function () {
  const botonBajar = document.getElementById("botonBajar");

  // Si el botón no existe en esta página, no hacemos nada.
  if (!botonBajar) {
    return;
  }

  // Si hemos bajado más de 100px, mostramos el botón.
  if (window.scrollY > 100) {
    botonBajar.style.display = "block";
  } else {
    botonBajar.style.display = "none";
  }
});

// Buscamos el botón de bajar.
const botonBajar = document.getElementById("botonBajar");

// Si existe, le añadimos el click.
if (botonBajar) {
  botonBajar.addEventListener("click", function () {
    // Bajamos suavemente hasta el final de la página.
    window.scrollTo({
      top: 999999,
      behavior: "smooth",
    });
  });
}

// --------------------------------------------------
// MODO OSCURO
// --------------------------------------------------

// Botón/icono para activar o desactivar el modo oscuro.
const botonModoOscuro = document.getElementById("botonModoOscuro");

// Revisamos si el usuario ya tenía activado el modo oscuro.
// localStorage guarda datos en el navegador aunque se recargue la página.
const modoOscuroGuardado = localStorage.getItem("modoOscuro");

// Si estaba guardado como "activado", activamos el modo oscuro.
if (modoOscuroGuardado === "activado") {
  document.body.classList.add("modo-oscuro");

  // Cambiamos el icono si existe.
  if (botonModoOscuro) {
    botonModoOscuro.classList.remove("fa-toggle-off");
    botonModoOscuro.classList.add("fa-toggle-on");
  }
}

// Si el botón existe, le añadimos el evento click.
if (botonModoOscuro) {
  botonModoOscuro.addEventListener("click", function () {
    // Activamos o quitamos la clase modo-oscuro del body.
    document.body.classList.toggle("modo-oscuro");

    // Cambiamos el icono del botón.
    botonModoOscuro.classList.toggle("fa-toggle-off");
    botonModoOscuro.classList.toggle("fa-toggle-on");

    // Guardamos en el navegador si el modo oscuro quedó activado o no.
    if (document.body.classList.contains("modo-oscuro")) {
      localStorage.setItem("modoOscuro", "activado");
      s;
    } else {
      localStorage.setItem("modoOscuro", "desactivado");
    }
  });
}

// --------------------------------------------------
// INICIO DE LA PÁGINA
// --------------------------------------------------

// 1. Cargamos la lista general de Pokémon.
//    Esto permite buscar por nombre.
cargarListaPokemon();

// 2. Cargamos los Pokémon del tipo seleccionado.
//    Los IDs vienen desde PHP.
cargarPokemonPorTipo();
s;
