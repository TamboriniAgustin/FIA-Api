function mostrarCarrera(Carrera) {
    if(Carrera != "Selecciona una carrera"){
        let carrera = '.' + Carrera;
        $('.Sahkir').hide(); $('.Catalunya').hide(); $('.Montecarlo').hide();
        $('.Baku').hide(); $('.Spielberg').hide(); $('.Silverstone').hide();
        $('.Budapest').hide(); $('.Spa').hide(); $('.Monza').hide();
        $('.Jerez').hide(); $('.AbuDhabi').hide(); $('.LeCastellet').hide();
        $('.Sochi').hide(); $('.Melbourne').hide(); $('.Shangai').hide();
        $('.Montreal').hide(); $('.Hockenheim').hide(); $('.MarinaBay').hide();
        $('.Suzuka').hide(); $('.MexicoDF').hide(); $('.Texas').hide();
        $('.SaoPablo').hide();

        $(carrera).show();
    }
}

$(document).ready(function () {
    if(window.location.search == ""){
        $('.contenido').hide();
    }

    let mundialPilotos = $('.table-posiciones');
    mundialPilotos.tablesorter();

    let mundialEscuderias = $('.table-posicionesE');
    mundialEscuderias.tablesorter();

    let seleccionCarrera = $('.card #mostrarCarrera');
    $(seleccionCarrera).on('click', function () {
        carreraSeleccionada = $(this).attr('data-id');
        mostrarCarrera(carreraSeleccionada);
    });

    let modificarTemporada = $('#configurarTemporada');
    $(modificarTemporada).on('click', function () {
        if(window.location.search != ""){
            window.location = "configuracion.php" + window.location.search;
        } 
    });
});