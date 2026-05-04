// --------------------------------------------------
// TABS DE RELACIONES DE TIPOS
// Fortalezas / Debilidades / Inmunidades
// --------------------------------------------------

// Buscamos todos los botones de las tabs.
const botonesRelacion = document.querySelectorAll(".tab-relacion");

// Buscamos todos los paneles de contenido.
const panelesRelacion = document.querySelectorAll(".panel-relacion");


// Recorremos cada botón.
botonesRelacion.forEach(function (boton) {

    // A cada botón le agregamos un evento click.
    boton.addEventListener("click", function () {

        // Sacamos el valor del data-relacion.
        // Ejemplo:
        // data-relacion="fortalezas"
        // data-relacion="debilidades"
        // data-relacion="inmunidades"
        const relacion = boton.dataset.relacion;


        // Quitamos la clase activa de todos los botones.
        botonesRelacion.forEach(function (btn) {
            btn.classList.remove("activa");
        });


        // Quitamos la clase activo de todos los paneles.
        panelesRelacion.forEach(function (panel) {
            panel.classList.remove("activo");
        });


        // Activamos el botón que fue pulsado.
        boton.classList.add("activa");


        // Buscamos el panel que tenga el mismo id que data-relacion.
        // Ejemplo:
        // data-relacion="debilidades"
        // busca:
        // id="debilidades"
        const panelActivo = document.getElementById(relacion);


        // Si existe ese panel, lo activamos.
        if (panelActivo) {
            panelActivo.classList.add("activo");
        }

    });

});