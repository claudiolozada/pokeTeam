// --------------------------------------------------
// MENÚ LATERAL DEL USUARIO
// --------------------------------------------------

// zona del navbar donde aparece el usuario.
// Al hacer click aquí, se abre el menú lateral.
const openUserMenu = document.getElementById("openUserMenu");

// Botón X para cerrar el menú lateral.
const closeUserMenu = document.getElementById("closeUserMenu");

// Menú lateral que contiene las opciones del usuario.
const userSideMenu = document.getElementById("userSideMenu");

// Fondo oscuro que aparece detrás del menú.
// También sirve para cerrar el menú al hacer click fuera.
const overlayMenu = document.getElementById("overlayMenu");


// --------------------------------------------------
// ABRIR MENÚ
// --------------------------------------------------

// Cuando el usuario hace click en su nombre/avatar,
// añadimos la clase active al menú y al fondo oscuro.
openUserMenu.addEventListener("click", function () {
    userSideMenu.classList.add("active");
    overlayMenu.classList.add("active");
});


// --------------------------------------------------
// CERRAR MENÚ CON EL BOTÓN X
// --------------------------------------------------

// Cuando el usuario pulsa la X,
// quitamos la clase active para ocultar el menú y el fondo.
closeUserMenu.addEventListener("click", function () {
    userSideMenu.classList.remove("active");
    overlayMenu.classList.remove("active");
});


// --------------------------------------------------
// CERRAR MENÚ AL TOCAR FUERA
// --------------------------------------------------

// Si el usuario hace click en el fondo oscuro,
// también cerramos el menú lateral.
overlayMenu.addEventListener("click", function () {
    userSideMenu.classList.remove("active");
    overlayMenu.classList.remove("active");
});