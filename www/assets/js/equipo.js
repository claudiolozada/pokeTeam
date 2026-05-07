/**
 * equipo.js - Gestión del Equipo Pokémon y Escenario Visual
 */

// 1. Configuración de rutas y recursos
const rutaImagenes = "../assets/img";
const rutaPokeball = `${rutaImagenes}/pokeball.svg`;

// Mapa de colores basado en el tipo principal para el fondo de las tarjetas
const colores = {
    grass: "#7ED978", bug: "#B5D957", dark: "#74717E", dragon: "#3D8FE0",
    electric: "#ece954", fairy: "#F5A8EE", fighting: "#E0627B", fire: "#f2744a",
    flying: "#B8CCF2", ghost: "#7B86D4", ground: "#c4b769", ice: "#9BE3D8",
    normal: "#BFC1BD", poison: "#CA82DC", psychic: "#FF5CBA", rock: "#7f6e2b",
    steel: "#78AEB9", water: "#75B8F0",
};

// Mapeo de nombres de tipos a archivos de imagen locales
const imagenesTipos = {
    normal: "normal.png", fire: "fuego.png", water: "agua.png", grass: "planta.png",
    electric: "electrico.png", ice: "hielo.png", fighting: "lucha.png", poison: "veneno.png",
    ground: "tierra.png", flying: "volador.png", psychic: "psiquico.png", bug: "bicho.png",
    rock: "roca.png", ghost: "fantasma.png", dragon: "dragon.png", dark: "siniestro.png",
    steel: "acero.png", fairy: "hada.png",
};

const obtenerImagenTipo = (tipo) => `${rutaImagenes}/tipos/${imagenesTipos[tipo]}`;
const tiposPrincipales = Object.keys(colores);

/**
 * FUNCIÓN: actualizarPosicionEscenario
 * Coloca el sprite del Pokémon en el escenario superior (zona-entrenador-equipo).
 */
const actualizarPosicionEscenario = (datos, posicion) => {
    // Buscamos el contenedor por clase (.pokemon-1, .pokemon-2, etc.)
    const contenedorFalso = document.querySelector(`.pokemon-${posicion}`);
    
    if (contenedorFalso) {
        contenedorFalso.innerHTML = ""; // Limpiamos el marcador de posición
        
        const imgPokemon = document.createElement("img");
        // Usamos el sprite frontal oficial de la PokeAPI
        imgPokemon.src = datos.sprites.front_default;
        imgPokemon.alt = datos.name;
        
        // Estilos para asegurar que el pixel-art se vea nítido
        imgPokemon.style.width = "100%";
        imgPokemon.style.height = "100%";
        imgPokemon.style.objectFit = "contain";
        imgPokemon.style.imageRendering = "pixelated";
        imgPokemon.classList.add("img-escenario-pixel");

        contenedorFalso.appendChild(imgPokemon);
        
        // Removemos los bordes de guía (dashed) y el fondo gris inicial
        contenedorFalso.style.border = "none";
        contenedorFalso.style.backgroundColor = "transparent";
    }
};

/**
 * FUNCIÓN: crearTarjetaPokemon
 * Construye el HTML de la tarjeta (frente y reverso) con los datos de la PokeAPI.
 */
const crearTarjetaPokemon = (pokemon, apodo) => {
    const cartaPokemon = document.createElement("div");
    cartaPokemon.classList.add("carta");

    // Lógica de nombre: Prioriza apodo si existe
    const nombreDisplay = apodo ? apodo.toUpperCase() : pokemon.name.toUpperCase();
    const idDisplay = pokemon.id.toString().padStart(3, "0");

    // Determinamos el tipo principal para el color de fondo
    const tiposPokemon = pokemon.types.map((tipo) => tipo.type.name);
    const tipoPrincipal = tiposPrincipales.find((tipo) => tiposPokemon.indexOf(tipo) > -1);
    const color = colores[tipoPrincipal];

    cartaPokemon.style.backgroundColor = color;

    const contenidoCarta = `
        <div class="frente lado">
            <div class="contenedor-imagen">
                <img class="fondo-pokeball" src="${rutaPokeball}" alt="Pokéball">
                <img class="imagen-pokemon" src="${pokemon.sprites.front_default}" alt="${nombreDisplay}">
            </div>
            <span class="numero-pokemon">#${idDisplay}</span>
            <h3 class="nombre-pokemon">${nombreDisplay}</h3>
            <div class="tipos-pokemon">
                ${tiposPokemon.map(tipo => `
                    <div class="fondo-tipo-pokemon">
                        <img src="${obtenerImagenTipo(tipo)}" alt="${tipo}">
                    </div>
                `).join("")}
            </div>
        </div>
        <div class="reverso lado">
            <div class="contenedor-imagen">
                <img class="imagen-pokemon" src="${pokemon.sprites.back_default || pokemon.sprites.front_default}" alt="${nombreDisplay}">
                <img class="fondo-pokeball" src="${rutaPokeball}" alt="Pokéball">
            </div>
            <div class="estadisticas">
                <div>Peso:<br><b>${pokemon.weight / 10}kg</b></div>
                <div>Altura:<br><b>${pokemon.height / 10}m</b></div>
            </div>
        </div>
    `;

    cartaPokemon.innerHTML = contenidoCarta;

    // Navegación al hacer clic en la tarjeta
    cartaPokemon.addEventListener("click", () => {
        window.location.href = `pokeinfo.php?id=${pokemon.id}`;
    });

    return cartaPokemon;
};

/**
 * FUNCIÓN PRINCIPAL: cargarEquipo
 * Recorre el array 'miEquipo' (inyectado por PHP), consulta la API y renderiza todo.
 */
const cargarEquipo = async () => {
    // Validamos que exista el array de datos de la DB
    if (typeof miEquipo === 'undefined' || !Array.isArray(miEquipo)) {
        console.warn("No se encontró el array 'miEquipo' de PHP.");
        return;
    }

    for (const pokemon of miEquipo) {
        try {
            // 1. Consultar datos a PokeAPI
            const url = `https://pokeapi.co/api/v2/pokemon/${pokemon.pokemon_id}`;
            const respuesta = await fetch(url);
            const datos = await respuesta.json();

            // 2. Localizar el slot correspondiente en el grid inferior
            const slot = document.getElementById(pokemon.posicion_num.toString());

            if (slot) {
                slot.innerHTML = ""; // Quitamos el símbolo "+"
                
                // 3. Crear y añadir la tarjeta interactiva
                const tarjeta = crearTarjetaPokemon(datos, pokemon.poke_apodo);
                slot.appendChild(tarjeta);
                
                // 4. NUEVO: Actualizar el escenario visual superior
                actualizarPosicionEscenario(datos, pokemon.posicion_num);
            }
        } catch (error) {
            console.error("Error cargando el Pokémon con ID:", pokemon.pokemon_id, error);
        }
    }
};

// Inicialización cuando el DOM está listo
document.addEventListener("DOMContentLoaded", cargarEquipo);