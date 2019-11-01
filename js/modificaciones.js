function leerFormulario(formulario, nombreFormulario){
    if(nombreFormulario == "piloto"){
        //Tomamos los valores insertados en el formulario
        const id = $("#idPiloto").val();
        const nombre = $("#nombrePiloto").val();
        const apellido = $("#apellidoPiloto").val();
        const nacionalidad = $("#nacionalidadPiloto").val();
        const edad = $("#edadPiloto").val();
        //Generamos en objeto con los datos del formulario
        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('apellido', apellido);
        datos.append('nacionalidad', nacionalidad);
        datos.append('edad', edad);
        datos.append('accion', 'editar');
        modificarBD(datos, nombreFormulario);
    }
    if(nombreFormulario == "escuderia"){
        //Tomamos los valores insertados en el formulario
        const id = $("#idEscuderia").val();
        const nombre = $("#nombreEscuderia").val();
        const nacionalidad = $("#nacionalidadEscuderia").val();
        //Generamos en objeto con los datos del formulario
        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('nacionalidad', nacionalidad);
        datos.append('accion', 'editar');
        modificarBD(datos, nombreFormulario);
    }
    if(nombreFormulario == "pista"){
        //Tomamos los valores insertados en el formulario
        const id = $("#idPista").val();
        const pais = $("#pais").val();
        const ciudad = $("#ciudad").val();
        const colorP = $("#colorP").val();
        const textoP = $("#textoP").val();
        const textoS = $("#textoS").val();
        //Generamos en objeto con los datos del formulario
        const datos = new FormData();
        datos.append('id', id);
        datos.append('pais', pais);
        datos.append('ciudad', ciudad);
        datos.append('color_principal', colorP);
        datos.append('texto_principal', textoP);
        datos.append('texto_secundario', textoS);
        datos.append('accion', 'editar');
        modificarBD(datos, nombreFormulario);
    }
}

function modificarBD(datos, nombreFormulario){
    if(nombreFormulario == "piloto"){
        //Llamo a AJAX
        $.ajax({
            url: "db/pilotos.php",
            type: "POST",
            data: datos,
            processData: false,
            contentType: false,
            success: function (respuesta) {
                alert('El piloto fue modificado con éxito');
            },
            error: function (respuesta) {
                alert('El piloto no pudo ser modificado');
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
                alert('La escuderia fue modificada con éxito');
            },
            error: function (respuesta) {
                alert('La escuderia no pudo ser modificada');
            }
        });
    }
    if(nombreFormulario == "pista"){
        //Llamo a AJAX
        $.ajax({
            url: "db/pistas.php",
            type: "POST",
            data: datos,
            processData: false,
            contentType: false,
            success: function (respuesta) {
                alert('La pista fue modificada con éxito');
            },
            error: function (respuesta) {
                alert('La pista no pudo ser modificada');
            }
        });
    }
}

function eliminarBD(e){
    if(e.target.hasAttribute("data-id")){
        const confirmacion = confirm("¿Estás seguro?"),
              clave = e.target.getAttribute("data-id"),
              tipo = e.target.getAttribute("data-name");      
        if(tipo == "piloto" && confirmacion){
            $.ajax({
                url: `db/pilotos.php?id=${clave}&&accion=borrar`,
                type: "GET",
                processData: false,
                contentType: false,
                success: function (respuesta) {
                    e.target.parentElement.parentElement.remove(); //Eliminamos el elemento del DOM
                    alert('El piloto fue borrado con éxito');
                },
                error: function (respuesta) {
                    alert('El piloto no pudo ser borrado');
                }
            });
        }
        if(tipo == "escuderia" && confirmacion){
            $.ajax({
                url: `db/escuderias.php?id=${clave}&&accion=borrar`,
                type: "GET",
                processData: false,
                contentType: false,
                success: function (respuesta) {
                    e.target.parentElement.parentElement.remove(); //Eliminamos el elemento del DOM
                    alert('La escuderia fue borrada con éxito');
                },
                error: function (respuesta) {
                    alert('La escuderia no pudo ser borrada');
                }
            });
        }
        if(tipo == "temporada" && confirmacion){
            $.ajax({
                url: `db/temporadas.php?id=${clave}&&accion=borrar`,
                type: "GET",
                processData: false,
                contentType: false,
                success: function (respuesta) {
                    e.target.parentElement.parentElement.remove(); //Eliminamos el elemento del DOM
                    alert('La temporada fue borrada con éxito');
                },
                error: function (respuesta) {
                    alert('La temporada no pudo ser borrada');
                }
            });
        }
        if(tipo == "pista" && confirmacion){
            $.ajax({
                url: `db/pistas.php?id=${clave}&&accion=borrar`,
                type: "GET",
                processData: false,
                contentType: false,
                success: function (respuesta) {
                    e.target.parentElement.parentElement.remove(); //Eliminamos el elemento del DOM
                    alert('La pista fue borrada con éxito');
                },
                error: function (respuesta) {
                    alert('La pista no pudo ser borrada');
                }
            });
        }
    }
}

$(document).ready(function () {
    /* Eliminar Piloto */
    const tablaPilotos = document.querySelector('#tablaPilotos tbody');
    if(tablaPilotos) tablaPilotos.addEventListener("click", eliminarBD);
    /* Eliminar Escuderia */
    const tablaEscuderias = document.querySelector('#tablaEscuderias tbody');
    if(tablaEscuderias) tablaEscuderias.addEventListener("click", eliminarBD);
    /* Eliminar Temporada */
    const tablaTemporadas = document.querySelector('#tablaTemporadas tbody');
    if(tablaTemporadas) tablaTemporadas.addEventListener("click", eliminarBD);
    /* Eliminar Pista */
    const tablaPistas = document.querySelector('#tablaPistas tbody');
    if(tablaPistas) tablaPistas.addEventListener("click", eliminarBD);
    
    /* Modificar Piloto */
    const formularioPiloto = $('#modificar_piloto');
    if(formularioPiloto){
        $(formularioPiloto).on('submit', function () {
            leerFormulario(formularioPiloto, "piloto");
            return false;
        });
    }
    /* Modificar Escuderia */
    const formularioEscuderia = $('#modificar_escuderia');
    if(formularioEscuderia){
        $(formularioEscuderia).on('submit', function () {
            leerFormulario(formularioEscuderia, "escuderia");
            return false;
        });
    }
    /* Modificar Pista */
    const formularioPista = $('#modificar_pista');
    if(formularioPista){
        $(formularioPista).on('submit', function () {
            leerFormulario(formularioPista, "pista");
            return false;
        });
    }
});