
//por defecto
let genero = "chico";
let totalAvatares = 11;
let avatarActual = 1;
let animando = false;


// Avatares del carrusel
const avatarOcultoIzquierda = document.getElementById("avatarOcultoIzquierda");
const avatarIzquierda = document.getElementById("avatarIzquierda");
const avatarCentro = document.getElementById("avatarCentro");
const avatarDerecha = document.getElementById("avatarDerecha");
const avatarOcultoDerecha = document.getElementById("avatarOcultoDerecha");


// Botones
const botonMasculino = document.getElementById("botonMasculino");
const botonFemenino = document.getElementById("botonFemenino");

const botonSeleccionar = document.getElementById("botonSeleccionar");

const flechaIzquierda = document.getElementById("flechaIzquierda");
const flechaDerecha = document.getElementById("flechaDerecha");


// funcion para que el carrusel sea infinito
function numeroCorrecto(numero) {
  if (numero < 1) {
    return totalAvatares;
  }

  if (numero > totalAvatares) {
    return 1;
  }

  return numero;
}


//función para automátizar la ruta de la imagen
function rutaAvatar(numero) {
  return `../assets/img/personajes/avatar/${genero}${numeroCorrecto(numero)}.png`;
}


// función para carga las posiciones de los avatares
function cargarAvatares() {
  
    // cambio las claces para ajustar los avatares
  avatarOcultoIzquierda.className = "avatar oculto-izquierda sin-transicion";
  avatarIzquierda.className = "avatar izquierda sin-transicion";
  avatarCentro.className = "avatar centro sin-transicion";
  avatarDerecha.className = "avatar derecha sin-transicion";
  avatarOcultoDerecha.className = "avatar oculto-derecha sin-transicion";

  // roto las imagenes
  avatarOcultoIzquierda.src = rutaAvatar(avatarActual - 2);
  avatarIzquierda.src = rutaAvatar(avatarActual - 1);
  avatarCentro.src = rutaAvatar(avatarActual);
  avatarDerecha.src = rutaAvatar(avatarActual + 1);
  avatarOcultoDerecha.src = rutaAvatar(avatarActual + 2);

  // Esta línea obliga al navegador a aplicar los cambios bien
  // tenia problemas al rotar y la ia me dio este comando 
  void avatarCentro.offsetWidth;

  // quitamos la clase sin-transicion para que funcionen las animaciones
  avatarOcultoIzquierda.className = "avatar oculto-izquierda";
  avatarIzquierda.className = "avatar izquierda";
  avatarCentro.className = "avatar centro";
  avatarDerecha.className = "avatar derecha";
  avatarOcultoDerecha.className = "avatar oculto-derecha";
}



flechaDerecha.addEventListener("click", () => {
  // Si estan rotando los personajes, se sale de la funcion
  if (animando) {
    return;
  }
  
  animando = true; // desactivo las flechas mientras tanto

  const nuevoAvatar = numeroCorrecto(avatarActual + 1);

  avatarIzquierda.src = rutaAvatar(avatarActual - 1);
  avatarCentro.src = rutaAvatar(avatarActual);
  avatarDerecha.src = rutaAvatar(nuevoAvatar);
  avatarOcultoDerecha.src = rutaAvatar(nuevoAvatar + 1);

  // transicion
  avatarIzquierda.className = "avatar oculto-izquierda";
  avatarCentro.className = "avatar izquierda";
  avatarDerecha.className = "avatar centro";
  avatarOcultoDerecha.className = "avatar derecha";

  // me lo dio la ia para q el js espere a q termine el cambio de posiciones
  setTimeout(() => {
    avatarActual = nuevoAvatar;

    cargarAvatares();

    // activo de nuevo las flechas.
    animando = false;
  }, 450);
});


// lo mismo pero con la otra flecha
flechaIzquierda.addEventListener("click", () => {

  if (animando) {
    return;
  }

  animando = true;

  const nuevoAvatar = numeroCorrecto(avatarActual - 1);

  avatarOcultoIzquierda.src = rutaAvatar(nuevoAvatar - 1);
  avatarIzquierda.src = rutaAvatar(nuevoAvatar);
  avatarCentro.src = rutaAvatar(avatarActual);
  avatarDerecha.src = rutaAvatar(avatarActual + 1);

  avatarOcultoIzquierda.className = "avatar izquierda";
  avatarIzquierda.className = "avatar centro";
  avatarCentro.className = "avatar derecha";
  avatarDerecha.className = "avatar oculto-derecha";

  setTimeout(() => {
    avatarActual = nuevoAvatar;

    cargarAvatares();
    animando = false;
  }, 450);
});


// botones para el genero

botonMasculino.addEventListener("click", () => {
  
  genero = "chico";
  totalAvatares = 11;
  avatarActual = 1;

  // css
  botonMasculino.classList.add("btnchico");
  botonFemenino.classList.remove("btnchica");

  // actualizo los personajes
  cargarAvatares();
});


// lo mismo pero con las chicas
botonFemenino.addEventListener("click", () => {
  
  genero = "chica";
  totalAvatares = 7;
  avatarActual = 1;

  botonFemenino.classList.add("btnchica");
  botonMasculino.classList.remove("btnchico");

  cargarAvatares();
});


// era mara mostrar la posicion del avatar
botonSeleccionar.addEventListener("click", (e) => {
    // 1. Obtenemos la ruta completa usando tu función actual
    const rutaCompleta = rutaAvatar(avatarActual);
    
    // 2. Extraemos solo el nombre del archivo (ej: "chica2.png")
    const nombreImagen = rutaCompleta.split("/").pop();

    // 3. Buscamos el input invisible que creamos en el HTML
    const inputInvisible = document.getElementById("inputAvatarInvisible");

    if (inputInvisible) {
        // Metemos el nombre del archivo en el input
        inputInvisible.value = nombreImagen;
        
        // Opcional: un log para que veas en la consola que funciona
        console.log("Avatar listo para enviar a AWS: " + nombreImagen);
    } else {
        // Si olvidas poner el ID en el HTML, esto te avisará
        console.error("No se encontró el input 'inputAvatarInvisible'");
        e.preventDefault(); // Evita que el formulario se envíe vacío
    }
});

// muestro a los chicos que son los q estan por defecto cuando recargo la pagina
cargarAvatares();