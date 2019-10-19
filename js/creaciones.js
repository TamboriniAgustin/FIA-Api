function leerFormulario(formulario, nombreFormulario){
    if(nombreFormulario == "piloto"){
        //Tomamos los valores insertados en el formulario
        const nombre = $("#nombre").val();
        const apellido = $("#apellido").val();
        const nacionalidad = $("#nacionalidad").val();
        const edad = $("#edad").val();
        //Generamos en objeto con los datos del formulario
        const datos = new FormData();
        datos.append('nombre', nombre);
        datos.append('apellido', apellido);
        datos.append('nacionalidad', nacionalidad);
        datos.append('edad', edad);
        datos.append('accion', 'nuevo');
        insertarEnBD(datos, nombreFormulario);
    }
    if(nombreFormulario == "escuderia"){
        //Tomamos los valores insertados en el formulario
        const nombre = $("#nombreEscuderia").val();
        const nacionalidad = $("#nacionalidadEscuderia").val();
        //Generamos en objeto con los datos del formulario
        const datos = new FormData();
        datos.append('nombre', nombre);
        datos.append('nacionalidad', nacionalidad);
        datos.append('accion', 'nuevo');
        insertarEnBD(datos, nombreFormulario);
    }
    if(nombreFormulario == "temporada"){
        //Tomamos los valores insertados en el formulario
        const anio = $("#año").val();
        //Generamos en objeto con los datos del formulario
        const datos = new FormData();
        datos.append('año', anio);
        datos.append('accion', 'nuevo');
        insertarEnBD(datos, nombreFormulario);
    }
}

function insertarEnBD(datos, nombreFormulario){
    if(nombreFormulario == "piloto"){
        //Llamo a AJAX
        $.ajax({
            url: "db/pilotos.php",
            type: "POST",
            data: datos,
            processData: false,
            contentType: false,
            success: function (respuesta) {
                alert('El piloto fue creado con éxito');
            },
            error: function (respuesta) {
                alert('El piloto no pudo ser creado');
            }
        });
    }
    if(nombreFormulario == "escuderia"){
        //Llamo a AJAX
        $.ajax({
            url: "db/escuderias.php",
            type: "POST",
            data: datos,
            processData: false,
            contentType: false,
            success: function (respuesta) {
                alert('La escuderia fue creada con éxito');
            },
            error: function (respuesta) {
                alert('La escuderia no pudo ser creada');
            }
        });
    }
    if(nombreFormulario == "temporada"){
        //Llamo a AJAX
        $.ajax({
            url: "db/temporadas.php",
            type: "POST",
            data: datos,
            processData: false,
            contentType: false,
            success: function (respuesta) {
                alert('La temporada fue creada con éxito');
            },
            error: function (respuesta) {
                alert('La temporada no pudo ser creada');
            }
        });
    }
}

$(document).ready(function () {
    /* Crear Piloto */
    const formularioPiloto = $('.crear-piloto');
    $(formularioPiloto).on('submit', function () {
        leerFormulario(formularioPiloto, "piloto");
        return false;
    });
    /* Crear Escuderia */
    const formularioEscuderia = $('.crear-escuderia');
    $(formularioEscuderia).on('submit', function () {
        leerFormulario(formularioEscuderia, "escuderia");
        return false;
    });
    /* Crear Temporada */
    const formularioTemporada = $('.crear-temporada');
    $(formularioTemporada).on('submit', function () {
        leerFormulario(formularioTemporada, "temporada");
        return false;
    });
});