// --------------------------------------------------
// 1. LEER EL ID DEL POKÉMON DESDE LA URL
// --------------------------------------------------

// URLSearchParams permite leer los parámetros que vienen en la URL.
// Ejemplo:
// details.html?id=25
// En ese caso, el parámetro "id" vale 25.
const params = new URLSearchParams(window.location.search);

// Sacamos el valor del parámetro "id" y lo convertimos a número.
// Si viene "25", id será 25.
const id = parseInt(params.get("id"));

//la cantidad de pokemons que hay en mi equipo
const cantequipo = miEquipo.length; // es una bariable gloval q saque del div

// --------------------------------------------------
// 2. COLORES SEGÚN EL TIPO DEL POKÉMON
// --------------------------------------------------

// Estos nombres están en inglés porque la PokeAPI devuelve los tipos en inglés.
// Ejemplo: fire, water, grass, electric...
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

// Creamos una lista con todos los tipos disponibles.
// Esto sirve para detectar cuál es el tipo principal del Pokémon.
const main_types = Object.keys(colors);

// --------------------------------------------------
// 2.1 RUTAS DE IMÁGENES
// --------------------------------------------------

// Ruta de la pokéball.
// Ahora la tienes en assets/img/pokeball.svg.
// Se usa como imagen decorativa detrás del Pokémon.
const rutaPokeball = "../assets/img/pokeball.svg";

// La PokeAPI devuelve los tipos en inglés.
// Pero tus imágenes están guardadas en español.
// Por eso hacemos esta "traducción" de nombre de tipo a archivo.
//
// Ejemplo:
// La API dice "fire".
// Tu imagen se llama "fuego.png".
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

// Esta función recibe el tipo en inglés que viene de la PokeAPI
// y devuelve la ruta de la imagen en español.
//
// Ejemplo:
// obtenerImagenTipo("fire")
// devuelve:
// "../assets/img/tipos/fuego.png"
const obtenerImagenTipo = (tipo) => {
  return `../assets/img/tipos/${imagenesTipos[tipo]}`;
};

// --------------------------------------------------
// 3. FUNCIÓN PARA PEDIR DATOS DE UN TIPO
// --------------------------------------------------

// Esta función recibe una URL de tipo.
// Ejemplo:
// https://pokeapi.co/api/v2/type/fire/
//
// Luego devuelve la información de ese tipo en formato JSON.
// Se usa para calcular fortalezas e inmunidades.
const getType_data = async (url) => {
  const res = await fetch(url);
  const data = await res.json();

  return data;
};

// --------------------------------------------------
// 4. FUNCIÓN PRINCIPAL PARA TRAER LOS DETALLES
// --------------------------------------------------

// Esta función hace las peticiones principales a la PokeAPI.
// Trae:
// - Datos normales del Pokémon.
// - Datos de especie.
// - Datos de tipos.
const fetchPokemonDetails = async () => {
  // Si no hay ID en la URL, mandamos al primer Pokémon.
  // Esto evita errores si alguien entra a details.html sin ?id=.
  if (!id) {
    window.location.href = "pokeinfo.php?id=1";
    return;
  }

  // URL con datos principales del Pokémon:
  // nombre, tipos, stats, altura, peso, imágenes, habilidades...
  const url = `https://pokeapi.co/api/v2/pokemon/${id}/`;

  // URL con datos de especie:
  // descripción, género, ratio de captura, cadena evolutiva...
  const url2 = `https://pokeapi.co/api/v2/pokemon-species/${id}/`;

  try {
    // Pedimos los datos principales del Pokémon.
    const res = await fetch(url);

    // Pedimos los datos de especie.
    const res2 = await fetch(url2);

    // Si la API no encuentra el Pokémon, mandamos de vuelta al primero.
    if (!res.ok) {
      window.location.href = "pokevs.php?id=1";
      return;
    }

    // Convertimos la primera respuesta a objeto JavaScript.
    const data = await res.json();

    // Convertimos la segunda respuesta a objeto JavaScript.
    const data2 = await res2.json();

    // Sacamos los nombres de los tipos del Pokémon.
    // Ejemplo: Bulbasaur devuelve ["grass", "poison"].
    const type_names = data.types.map((val) => val.type.name);

    // Por cada tipo, pedimos más información del tipo.
    // Esto sirve para saber sus relaciones de daño.
    const data3 = type_names.map(async (val) => {
      return await getType_data(`https://pokeapi.co/api/v2/type/${val}/`);
    });

    // Guardamos todo junto en un array:
    // arr[0] = datos principales del Pokémon
    // arr[1] = datos de especie
    // arr[2] = datos de tipos
    const arr = [data, data2, data3];

    // Llamamos a la función que pinta todo en pantalla.
    await displayPokemonDetails(arr);
  } catch (error) {
    window.location.href = `pokevs.php?id=${pokedexNum}&error=api`;
  }
};

// --------------------------------------------------
// 5. MOSTRAR LOS DETALLES EN PANTALLA
// --------------------------------------------------

// Esta función recibe toda la información del Pokémon
// y se encarga de crear el HTML dinámico.
const displayPokemonDetails = async (pokemon) => {
  // pokemon[0] = datos principales del Pokémon
  // pokemon[1] = datos de especie
  // pokemon[2] = datos de tipos

  // Nombre con primera letra en mayúscula.
  const name = pokemon[0].name[0].toUpperCase() + pokemon[0].name.slice(1);

  // Nombre japonés.
  const japaneseName = pokemon[1].names[0].name;

  // ID con 3 cifras.
  const idFormateado = pokemon[0].id.toString().padStart(3, "0");

  // ID normal
  const idNormal = pokemon[0].id;

  // Imagen Dream World.
  const imageSrc = pokemon[0].sprites.other.dream_world.front_default;

  // Imagen oficial por si no existe Dream World.
  const imageSrc2 = pokemon[0].sprites.other["official-artwork"].front_default;

  // Tipos del Pokémon.
  const poke_types = pokemon[0].types.map((type) => type.type.name);

  // Sacamos el tipo principal para elegir color.
  const type = main_types.find((type) => poke_types.indexOf(type) > -1);

  // Color del tipo principal.
  const color = colors[type];

  // IMPORTANTE:
  // No usamos document.body.style.backgroundColor,
  // porque eso taparía el fondo con cuadritos del CSS.
  //
  // En su lugar cambiamos una variable CSS:
  // --color-tipo-actual
  document.body.style.setProperty("--color-tipo-actual", color);

  // Stats base del Pokémon.
  const hp = pokemon[0].stats[0].base_stat;
  const attack = pokemon[0].stats[1].base_stat;
  const defense = pokemon[0].stats[2].base_stat;
  const spAttack = pokemon[0].stats[3].base_stat;
  const spDefense = pokemon[0].stats[4].base_stat;
  const speed = pokemon[0].stats[5].base_stat;

  // Total de stats.
  const totalStats = hp + attack + defense + spAttack + spDefense + speed;

  // Habilidades del Pokémon.
  const abilities = pokemon[0].abilities.map((ability) => ability.ability.name);

  // Grupos huevo.
  const eggGroups = pokemon[1].egg_groups.map((group) => group.name);

  // Altura en metros.
  const height = pokemon[0].height / 10 + "m";

  // Peso en kilogramos.
  const weight = pokemon[0].weight / 10 + "kg";

  // --------------------------------------------------
  // 5.1 MOSTRAR PARTE SUPERIOR
  // --------------------------------------------------

  const pokemonDetailsEl = document.getElementById("pokemon-details");

// 1. Definimos qué contenido extra vamos a mostrar según la condición
let contenidoExtra = "";

if (cantequipo < 6) { // Aquí pondrías tu variable cantEquipoPoke
    contenidoExtra = `
        <form action="addpoke.php" method="POST">
        <input type="hidden" name="add" value="${idNormal}">
        <button type="submit" class="addpoke">AGREGAR AL EQUIPO</button>
        </form>`;
} else {
    contenidoExtra = `<div class="japaneseName">${japaneseName}</div>`;
}

// 2. Insertamos todo el HTML junto
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
        ${contenidoExtra}
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

  // --------------------------------------------------
  // 5.2 DESCRIPCIÓN Y CLASIFICACIÓN EN ESPAÑOL
  // --------------------------------------------------

  const desiredLanguage = "es";

  let overview = "No hay descripción disponible.";
  let genus = "Pokémon";

  // Buscamos descripción en español.
  for (const entry of pokemon[1].flavor_text_entries) {
    if (entry.language.name === desiredLanguage) {
      overview = entry.flavor_text.replace(/\f/g, " ");
      break;
    }
  }

  // Buscamos clasificación en español.
  for (const entry of pokemon[1].genera) {
    if (entry.language.name === desiredLanguage) {
      genus = entry.genus;
      break;
    }
  }

  // --------------------------------------------------
  // 5.3 GÉNERO DEL POKÉMON
  // --------------------------------------------------

  const genderRate = pokemon[1].gender_rate;

  let male = "";
  let female = "";

  if (genderRate === -1) {
    male = "Sin género";
    female = "Sin género";
  } else if (genderRate === 0) {
    male = "100%";
    female = "0%";
  } else if (genderRate === 8) {
    male = "0%";
    female = "100%";
  } else {
    female = (genderRate / 8) * 100 + "%";
    male = 100 - (genderRate / 8) * 100 + "%";
  }

  // --------------------------------------------------
  // 5.4 PESTAÑA RESUMEN
  // --------------------------------------------------

  const tab1 = document.getElementById("tab_1");

  tab1.innerHTML = `
        <div class="overview">

            <p>
                <span class="genus">${genus}</span>
                <br>
                ${overview}
            </p>

            <div class="heightWeight">
                <span>Altura:<br><b>${height}</b></span>
                <span>Peso:<br><b>${weight}</b></span>
            </div>

            <div class="types">
                ${poke_types
      .map(
        (type) => `
                            <div class="poke__type__bg">
                                <!-- Imagen del tipo.
                                     La API manda el tipo en inglés.
                                     obtenerImagenTipo() busca tu PNG en español
                                     dentro de assets/img/tipos. -->
                                <img 
                                    src="${obtenerImagenTipo(type)}" 
                                    alt="Tipo ${type}"
                                >
                            </div>
                        `,
      )
      .join("")}
            </div>

        </div>

        <div class="about">

            <div>ID: <b class="id">#${idFormateado}</b></div>

            <div>
                Género:
                <b>
                    <i class="fa-solid fa-mars" style="color: #1f71ff;"></i>
                    ${male}

                    <i class="fa-solid fa-venus" style="color: #ff5c74;"></i>
                    ${female}
                </b>
            </div>

            <span>Habilidades: <b>${abilities.join(", ")}</b></span>

            <span>
                Ratio de captura:
                <b>${pokemon[1].capture_rate} (${((pokemon[1].capture_rate / 255) * 100).toFixed(2)}%)</b>
            </span>

            <span>
                Amistad base:
                <b>
                    ${pokemon[1].base_happiness}
                    (${pokemon[1].base_happiness < 50 ? "baja" : pokemon[1].base_happiness < 100 ? "normal" : "alta"})
                </b>
            </span>

            <span>Experiencia base: <b>${pokemon[0].base_experience}</b></span>

            <span>Tipo de crecimiento: <b>${pokemon[1].growth_rate.name}</b></span>

            <span>Grupos huevo: <b>${eggGroups.join(", ")}</b></span>

        </div>
    `;

  // --------------------------------------------------
  // 5.5 PESTAÑA EVOLUCIÓN
  // --------------------------------------------------

  const evolutionChainUrl = pokemon[1].evolution_chain.url;

  const resEvolutionChain = await fetch(evolutionChainUrl);
  const evolutionChainData = await resEvolutionChain.json();

  const varieties = pokemon[1].varieties
    .map((variety) => {
      if (variety.is_default === true) {
        return null;
      }

      return variety.pokemon;
    })
    .filter((item) => item !== null);

  const resVarieties = await Promise.all(
    varieties.map((variety) => fetch(variety.url)),
  );

  const varietiesData = await Promise.all(
    resVarieties.map((res) => res.json()),
  );

  const tab3 = document.getElementById("tab_3");

  tab3.innerHTML = `
        <div class="evolution"></div>
        <div class="varieties"></div>
    `;

  const displayVarieties = (varietiesData) => {
    const container = document.querySelector(".varieties");

    container.innerHTML = "";

    if (varietiesData.length === 0) {
      container.innerHTML = `<p>Este Pokémon no tiene variedades especiales.</p>`;
      return;
    }

    varietiesData.forEach((variety) => {
      const pokemonName = variety.name;
      const imgUrl = variety.sprites.other["official-artwork"].front_default;

      const pokemonDiv = document.createElement("div");
      pokemonDiv.classList.add("varieties__pokemon");

      const nameElement = document.createElement("h1");
      nameElement.textContent = pokemonName;

      const imageElement = document.createElement("img");
      imageElement.src = imgUrl;
      imageElement.alt = pokemonName;

      pokemonDiv.appendChild(nameElement);
      pokemonDiv.appendChild(imageElement);

      container.appendChild(pokemonDiv);
    });
  };

  displayVarieties(varietiesData);

  const displayEvolutionChain = (evolutionChainData) => {
    const container = document.querySelector(".evolution");

    container.innerHTML = "";

    const chain = evolutionChainData.chain;

    displayEvolutionRecursive(chain, container);
  };

  const displayEvolutionRecursive = (chain, container) => {
    try {
      const pokemonName = chain.species.name;
      const evolutionId = getPokemonIdFromURL(chain.species.url);

      const imgUrl = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/${evolutionId}.png`;

      const pokemonDiv = document.createElement("div");
      pokemonDiv.classList.add("evolution__pokemon");

      const iconDiv = document.createElement("div");

      const nameElement = document.createElement("h1");
      nameElement.textContent = pokemonName;

      const imageElement = document.createElement("img");
      imageElement.src = imgUrl;
      imageElement.alt = pokemonName;

      imageElement.addEventListener("click", () => {
        window.location.href = `pokeinfo.php?id=${evolutionId}`;
      });

      pokemonDiv.appendChild(nameElement);
      pokemonDiv.appendChild(imageElement);

      if (chain.evolves_to.length > 0) {
        const arrowIndicator = document.createElement("i");

        arrowIndicator.classList.add(
          "fa-solid",
          "fa-caret-right",
          "fa-2x",
          "fa-beat",
        );

        iconDiv.appendChild(arrowIndicator);
      }

      container.appendChild(pokemonDiv);
      container.appendChild(iconDiv);

      if (chain.evolves_to.length > 0) {
        const evolutionData = chain.evolves_to[0];
        displayEvolutionRecursive(evolutionData, container);
      }
    } catch (err) {
      console.log("Error mostrando evoluciones:", err);
    }
  };

  function getPokemonIdFromURL(url) {
    const parts = url.split("/");
    return parts[parts.length - 2];
  }

  displayEvolutionChain(evolutionChainData);

  // --------------------------------------------------
  // 5.6 PESTAÑA ESTADÍSTICAS
  // --------------------------------------------------

  if (pokemon[2] != null) {
    const datosTipos = await Promise.all(pokemon[2]);

    let immuneTypesString = "";
    let strongTypesString = "";

    datosTipos.forEach((res) => {
      // INMUNIDADES:
      // no_damage_from significa:
      // tipos que NO le hacen daño a este Pokémon por su tipo.
      res.damage_relations.no_damage_from.forEach((type) => {
        immuneTypesString += `
                    <!-- Imagen de inmunidad.
                         type.name viene en inglés desde la API.
                         obtenerImagenTipo() busca el PNG en español. -->
                    <img 
                        src="${obtenerImagenTipo(type.name)}" 
                        alt="Tipo ${type.name}" 
                        class="imagen-tipo-lista"
                    >
                `;
      });

      // FORTALEZAS:
      // double_damage_to significa:
      // tipos a los que este Pokémon hace doble daño.
      res.damage_relations.double_damage_to.forEach((type) => {
        strongTypesString += `
                    <!-- Imagen del tipo contra el que este Pokémon es fuerte.
                         type.name viene en inglés desde la API.
                         obtenerImagenTipo() busca el PNG en español. -->
                    <img 
                        src="${obtenerImagenTipo(type.name)}" 
                        alt="Tipo ${type.name}" 
                        class="imagen-tipo-lista"
                    >
                `;
      });
    });

    const tab2 = document.getElementById("tab_2");

    tab2.innerHTML = `
            <div class="stats">

                <div class="stat">
                    <div>
                        <span>Vida:</span>
                        <span>${hp}</span>
                    </div>

                    <meter min="0" max="255" low="70" high="120" optimum="150" value="${hp}"></meter>
                </div>

                <div class="stat">
                    <div>
                        <span>Ataque:</span>
                        <span>${attack}</span>
                    </div>

                    <meter min="0" max="255" low="70" high="120" optimum="150" value="${attack}"></meter>
                </div>

                <div class="stat">
                    <div>
                        <span>Defensa:</span>
                        <span>${defense}</span>
                    </div>

                    <meter min="0" max="255" low="70" high="120" optimum="150" value="${defense}"></meter>
                </div>

                <div class="stat">
                    <div>
                        <span>Atq. Esp:</span>
                        <span>${spAttack}</span>
                    </div>

                    <meter min="0" max="255" low="70" high="120" optimum="150" value="${spAttack}"></meter>
                </div>

                <div class="stat">
                    <div>
                        <span>Def. Esp:</span>
                        <span>${spDefense}</span>
                    </div>

                    <meter min="0" max="255" low="70" high="120" optimum="150" value="${spDefense}"></meter>
                </div>

                <div class="stat">
                    <div>
                        <span>Velocidad:</span>
                        <span>${speed}</span>
                    </div>

                    <meter min="0" max="255" low="70" high="120" optimum="150" value="${speed}"></meter>
                </div>

                <div class="stat">
                    <div>
                        <span>Total:</span>
                        <span>${totalStats}</span>
                    </div>

                    <meter min="0" max="1530" low="500" high="720" optimum="1000" value="${totalStats}"></meter>
                </div>

                <div class="statTypes">
                    <div class="statTypeText">
                        Inmune a
                    </div>

                    <div class="statIconHolder">
                        ${immuneTypesString === "" ? "Ninguno" : immuneTypesString}
                    </div>
                </div>

                <div class="statTypes">
                    <div class="statTypeText">
                        Fuerte contra
                    </div>

                    <div class="statIconHolder">
                        ${strongTypesString === "" ? "Ninguno" : strongTypesString}
                    </div>
                </div>

            </div>
        `;
  } else {
    console.log("No hay datos de tipos:", pokemon[2]);
  }
};

// --------------------------------------------------
// 6. SISTEMA DE PESTAÑAS
// --------------------------------------------------

const tabs = document.querySelectorAll("[data-tab-value]");
const tabInfos = document.querySelectorAll("[data-tab-info]");

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    const target = document.querySelector(tab.dataset.tabValue);

    tabInfos.forEach((tabInfo) => {
      tabInfo.classList.remove("active");
    });

    tabs.forEach((tabItem) => {
      tabItem.classList.remove("tab-activa");
    });

    target.classList.add("active");
    tab.classList.add("tab-activa");
  });
});

// --------------------------------------------------
// 7. BOTÓN SIGUIENTE
// --------------------------------------------------

const nextPokemon = () => {
  if (id >= 1010) {
    window.location.href = "pokeinfo.php?id=1";
    return;
  }

  window.location.href = `pokeinfo.php?id=${id + 1}`;
};

// --------------------------------------------------
// 8. BOTÓN VOLVER
// --------------------------------------------------

const backButton = () => {
  window.history.back();
};

// --------------------------------------------------
// 9. CARGA INICIAL
// --------------------------------------------------

fetchPokemonDetails();

// --------------------------------------------------
// 10. PRELOADER
// --------------------------------------------------

window.addEventListener("load", function () {
  document.querySelector("body").classList.add("loaded");
});
