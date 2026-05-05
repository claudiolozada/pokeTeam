// Guardamos en una variable el contenedor donde se van a pintar las cartas de Pokémon.
// Este contenedor viene del HTML:
// <main class="contenedor-pokemon" id="contenedorPokemon"></main>
const contenedorPokemon = document.getElementById("contenedorPokemon");


// Cantidad total de Pokémon que vamos a tener en cuenta.
// Ahora mismo llega hasta Paldea.
const cantidadPokemon = 1025;

// Objeto con los colores principales de cada tipo Pokémon.
// Ojo: los nombres están en inglés porque la PokeAPI devuelve los tipos en inglés.
// Ejemplo: fire, water, grass, electric...
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

// Objeto con las regiones Pokémon.
// Cada región tiene un inicio y un fin.
// Eso sirve para saber qué Pokémon cargar de la API.
const regiones = {
  kanto: {
    inicio: 1,
    fin: 151,
  },
  johto: {
    inicio: 152,
    fin: 251,
  },
  hoenn: {
    inicio: 252,
    fin: 386,
  },
  sinnoh: {
    inicio: 387,
    fin: 493,
  },
  unova: {
    inicio: 494,
    fin: 649,
  },
  kalos: {
    inicio: 650,
    fin: 721,
  },
  alola: {
    inicio: 722,
    fin: 809,
  },
  galar: {
    inicio: 810,
    fin: 898,
  },
  hisui: {
    inicio: 899,
    fin: 905,
  },
  paldea: {
    inicio: 906,
    fin: 1010,
  },
  kitakami: {
    inicio: 1011,
    fin: 1017,
  },
  indigo: {
    inicio: 1018,
    fin: 1025,
  },
};

// Seleccionamos el loader/cargador del HTML.
// Este es el circulito que aparece mientras se están cargando los Pokémon.
const cargador = document.querySelector(".cargador");

// Esta variable guarda cuál región se está cargando ahora mismo.
// La usamos para evitar errores cuando el usuario cambia rápido de región.
let regionActual = "";

// Sacamos todos los nombres de los tipos que están dentro del objeto colores.
// Esto nos sirve para saber cuál es el tipo principal del Pokémon.
const tiposPrincipales = Object.keys(colores);

// --------------------------------------------------
// RUTAS DE IMÁGENES
// --------------------------------------------------

// Ruta base donde están tus imágenes.
const rutaImagenes = "../assets/img";

// Pokéball decorativa que aparece detrás del Pokémon en la carta.
const rutaPokeball = `${rutaImagenes}/pokeball.svg`;

// La PokeAPI devuelve los tipos en inglés.
// Pero las imágenes están guardadas en español.
// Por eso traducimos el tipo de la API al nombre real del archivo.
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

// Esta función recibe un tipo en inglés.
// Ejemplo: "fire"
// Y devuelve la ruta real de la imagen:
// "../assets/img/tipos/fuego.png"
const obtenerImagenTipo = (tipo) => {
  return `${rutaImagenes}/tipos/${imagenesTipos[tipo]}`;
};

/*
    FUNCIÓN: cargarPokemonPorRegion(region)

    Esta función recibe una región.
    Ejemplo:
    cargarPokemonPorRegion("kanto");

    Lo que hace:
    1. Guarda la región actual.
    2. Busca el inicio y fin de esa región.
    3. Limpia el contenedor de Pokémon.
    4. Activa el loader.
    5. Recorre todos los Pokémon de esa región.
    6. Pide los datos a la PokeAPI.
    7. Crea una carta por cada Pokémon.
    8. Quita el loader cuando termina.
*/
const cargarPokemonPorRegion = async (region) => {
  // Guardamos la región que el usuario quiere ver.
  regionActual = region;

  // Sacamos el número inicial y final de la región.
  // Por ejemplo, si region = "kanto", inicio = 1 y fin = 151.
  const { inicio, fin } = regiones[region];

  // Limpiamos el contenedor para que no se mezclen Pokémon de otra región.
  contenedorPokemon.innerHTML = "";

  // Mostramos el loader mientras cargan los Pokémon.
  cargador.classList.add("cargador-activo");

  // Recorremos todos los Pokémon desde el inicio hasta el fin de la región.
  for (let i = inicio; i <= fin; i++) {
    /*
            Esto evita un bug:
            Si el usuario pulsa otra región mientras todavía se está cargando la anterior,
            la carga anterior se detiene y no sigue pintando Pokémon.
        */
    if (regionActual !== region) {
      return;
    }

    // Convertimos el número del Pokémon en texto.
    // Ejemplo: 25 pasa a "25".
    const idPokemon = i.toString();

    // Creamos la URL de la PokeAPI para pedir los datos de ese Pokémon.
    const url = `https://pokeapi.co/api/v2/pokemon/${idPokemon}`;

    // Hacemos la petición a la API.
    const respuesta = await fetch(url);

    // Convertimos la respuesta en datos JavaScript.
    const datos = await respuesta.json();

    /*
            Volvemos a revisar si la región cambió.
            Esto es por si justo cambió mientras se hacía el fetch.
        */
    if (regionActual !== region) {
      return;
    }

    // Creamos la carta del Pokémon usando los datos recibidos.
    crearTarjetaPokemon(datos);
  }

  // Cuando termina de cargar la misma región, quitamos el loader.
  if (regionActual === region) {
    cargador.classList.remove("cargador-activo");
  }
};

/*
    FUNCIÓN: crearTarjetaPokemon(pokemon)

    Recibe un objeto completo de un Pokémon desde la PokeAPI.

    Lo que hace:
    1. Crea un div para la carta.
    2. Saca el nombre, id, peso, altura, tipos e imágenes.
    3. Le pone un color de fondo según su tipo principal.
    4. Crea el HTML interno de la carta.
    5. Le agrega un click para ir a la página de detalles.
    6. Mete la carta dentro del contenedor general.
*/
const crearTarjetaPokemon = (pokemon) => {
  // Creamos el div principal de la carta.
  const cartaPokemon = document.createElement("div");

  // Le agregamos la clase "carta".
  cartaPokemon.classList.add("carta");

  // Le ponemos como id el número real del Pokémon.
  cartaPokemon.id = pokemon.id;

  // Sacamos el nombre del Pokémon.
  // pokemon.name viene en minúsculas desde la API.
  let nombre = pokemon.name[0].toUpperCase() + pokemon.name.slice(1);

  // Si el nombre es muy largo o tiene guiones, usamos solo la primera parte.
  // Ejemplo: "charizard-mega-x" queda como "Charizard".
  if (nombre.length > 9) {
    nombre = nombre.split("-")[0];
  }

  // Formateamos el id con 3 cifras.
  // Ejemplo:
  // 1 -> 001
  // 25 -> 025
  // 150 -> 150
  const id = pokemon.id.toString().padStart(3, "0");

  // La API da el peso en hectogramos.
  // Dividimos entre 10 para pasarlo a kg.
  const peso = pokemon.weight / 10 + "kg";

  // La API da la altura en decímetros.
  // Dividimos entre 10 para pasarlo a metros.
  const altura = pokemon.height / 10 + "m";

  // Sacamos todos los tipos del Pokémon.
  // Ejemplo: Bulbasaur tiene grass y poison.
  const tiposPokemon = pokemon.types.map((tipo) => tipo.type.name);

  // Buscamos cuál de sus tipos está dentro del objeto colores.
  // Ese será el tipo principal para pintar el fondo de la carta.
  const tipoPrincipal = tiposPrincipales.find(
    (tipo) => tiposPokemon.indexOf(tipo) > -1,
  );

  // Sacamos el color correspondiente a ese tipo principal.
  const color = colores[tipoPrincipal];

  // Variables para guardar las imágenes del Pokémon.
  let imagenFrente;
  let imagenEspalda;

  // Intentamos sacar la imagen de frente y de espalda.
  try {
    imagenFrente = pokemon.sprites.front_default;
    imagenEspalda = pokemon.sprites.back_default;
  } catch (error) {
    // Si algo falla, usamos "#".
    imagenFrente = "#";
    imagenEspalda = "#";
  }

  // Le ponemos a la carta el color del tipo principal.
  cartaPokemon.style.backgroundColor = color;

  /*
        Aquí creamos todo el HTML interno de la carta.

        La carta tiene dos lados:
        - frente: imagen delantera, número, nombre y tipos.
        - reverso: imagen trasera, número, peso y altura.

        Luego el CSS hace que la carta gire.
    */
  const contenidoCarta = `
        <div class="frente lado">

            <div class="contenedor-imagen">
                <!-- Pokéball decorativa.
                     Ahora viene desde assets/img/pokeball.svg -->
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
                  .map(
                    (tipo) => `
                            <div class="fondo-tipo-pokemon">
                                <!-- Imagen del tipo.
                                     La API manda el tipo en inglés.
                                     obtenerImagenTipo() busca el PNG en español
                                     dentro de assets/img/tipos. -->
                                <img 
                                    src="${obtenerImagenTipo(tipo)}" 
                                    alt="Tipo ${tipo}"
                                >
                            </div>
                        `,
                  )
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

                <!-- Pokéball decorativa del reverso.
                     Usa la misma ruta nueva de assets/img. -->
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

  // Metemos el HTML dentro de la carta.
  cartaPokemon.innerHTML = contenidoCarta;

  /*
        Cuando el usuario haga click en una carta,
        abrimos la página de detalles y le pasamos el id por la URL.

        Ejemplo:
        details.html?id=025
    */
  cartaPokemon.addEventListener("click", () => {
    window.open(`pokeinfo.php?id=${id}`, "_self");
  });

  // Creamos un contenedor para la carta.
  // Esto ayuda con márgenes y con el efecto hover.
  const contenedorCarta = document.createElement("div");

  // Le agregamos su clase CSS.
  contenedorCarta.classList.add("contenedor-carta");

  // Metemos la carta dentro de su contenedor.
  contenedorCarta.appendChild(cartaPokemon);

  // Finalmente metemos todo en el contenedor principal.
  contenedorPokemon.appendChild(contenedorCarta);
};

/*
    FUNCIÓN: activarCambioDeRegion()

    Esta función activa los botones de regiones.
    Cuando el usuario hace click en Kanto, Johto, Hoenn, etc.,
    se cargan los Pokémon correspondientes a esa región.
*/
const activarCambioDeRegion = () => {
  // Seleccionamos el contenedor donde están todos los botones de región.
  const selectorRegion = document.getElementById("selectorRegion");

  // Escuchamos clicks dentro del selector de regiones.
  selectorRegion.addEventListener("click", (event) => {
    // Sacamos el valor de data-value del botón pulsado.
    // Ejemplo: "kanto", "johto", "hoenn".
    const regionSeleccionada = event.target.getAttribute("data-value");

    // Buscamos cuál región está activa ahora mismo.
    const regionActiva = document.querySelector(".activo");

    // Si el usuario pulsa la misma región que ya está activa, no hacemos nada.
    if (event.target.classList.contains("activo")) {
      return;
    }

    // Si realmente se pulsó una región válida...
    if (regionSeleccionada) {
      // Limpiamos los Pokémon actuales.
      contenedorPokemon.innerHTML = "";

      // Cargamos los Pokémon de la nueva región.
      cargarPokemonPorRegion(regionSeleccionada);

      // Quitamos la clase activo de la región anterior.
      if (regionActiva) {
        regionActiva.classList.remove("activo");
      }

      // Ponemos la clase activo en la nueva región seleccionada.
      event.target.classList.add("activo");
    }
  });
};

/*
    FUNCIÓN: buscarPokemon()

    Esta función se ejecuta cada vez que escribes en el buscador.

    Lo que hace:
    1. Lee lo que escribió el usuario.
    2. Lo pasa a minúsculas.
    3. Quita espacios.
    4. Recorre las cartas visibles.
    5. Oculta las que no coinciden.
    6. Muestra las que sí coinciden.
*/
function buscarPokemon() {
  // Sacamos el texto del input buscador.
  let textoBuscado = document.getElementById("buscador").value;

  // Convertimos todo a minúsculas.
  textoBuscado = textoBuscado.toLowerCase();

  // Quitamos todos los espacios.
  textoBuscado = textoBuscado.replace(/\s+/g, "");

  // Guardamos todas las cartas.
  const cartas = document.getElementsByClassName("contenedor-carta");

  // Recorremos todas las cartas.
  for (let i = 0; i < cartas.length; i++) {
    // Si la carta NO contiene lo que se escribió, se oculta.
    if (!cartas[i].innerHTML.toLowerCase().includes(textoBuscado)) {
      cartas[i].style.display = "none";
    }

    // Si la carta SÍ contiene lo que se escribió, se muestra.
    else {
      cartas[i].style.display = "block";
    }
  }
}

/*
    BOTÓN SUBIR

    Este bloque hace que aparezca un botón para subir al inicio de la página
    cuando el usuario baja un poco haciendo scroll.
*/
window.addEventListener("scroll", function () {
  // Seleccionamos el botón subir.
  const botonSubir = document.getElementById("botonSubir");

  // Si el botón no existe, evitamos errores.
  if (!botonSubir) {
    return;
  }

  // Si el usuario bajó más de 100px, mostramos el botón.
  if (window.scrollY > 100) {
    botonSubir.style.display = "block";
  }

  // Si está arriba del todo, lo ocultamos.
  else {
    botonSubir.style.display = "none";
  }
});

// Cuando se hace click en el botón subir, vuelve arriba con animación suave.
const botonSubir = document.getElementById("botonSubir");

if (botonSubir) {
  botonSubir.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
}

/*
    BOTÓN BAJAR

    Este bloque hace que aparezca un botón para bajar al final de la página.
    Ahora mismo aparece también cuando el usuario baja más de 100px.
*/
window.addEventListener("scroll", function () {
  // Seleccionamos el botón bajar.
  const botonBajar = document.getElementById("botonBajar");

  // Si el botón no existe, evitamos errores.
  if (!botonBajar) {
    return;
  }

  // Si el usuario bajó más de 100px, mostramos el botón.
  if (window.scrollY > 100) {
    botonBajar.style.display = "block";
  }

  // Si está arriba del todo, lo ocultamos.
  else {
    botonBajar.style.display = "none";
  }
});

// Cuando se hace click en el botón bajar, baja hasta el final de la página.
const botonBajar = document.getElementById("botonBajar");

if (botonBajar) {
  botonBajar.addEventListener("click", function () {
    window.scrollTo({
      top: 999999,
      behavior: "smooth",
    });
  });
}

/*
    MODO OSCURO

    Este bloque activa o desactiva el modo oscuro.
    Lo único que hace JavaScript es poner o quitar la clase "modo-oscuro" al body.

    Luego el CSS hace el diseño oscuro con:
    body.modo-oscuro { ... }
*/
const botonModoOscuro = document.getElementById("botonModoOscuro");

if (botonModoOscuro) {
  botonModoOscuro.addEventListener("click", () => {
    // Activa o desactiva la clase modo-oscuro en el body.
    document.body.classList.toggle("modo-oscuro");

    // Cambia el icono del switch.
    botonModoOscuro.classList.toggle("fa-toggle-off");
    botonModoOscuro.classList.toggle("fa-toggle-on");
  });
}

/*
    INICIO DE LA PÁGINA

    Cuando la página carga:
    1. Cargamos por defecto la región de Kanto.
    2. Activamos los botones de cambio de región.
*/
cargarPokemonPorRegion("kanto");
activarCambioDeRegion();
