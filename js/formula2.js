function mostrarTemporada(Temporada){
    if(Temporada != "Selecciona una temporada"){
        window.location = 'temporadasf2.php?categoria=f2&temporada=' + Temporada;
    }
}

function mostrarCarrera(Carrera) {
    if(Carrera != "Selecciona una carrera"){
        let carrera = '.' + Carrera;
        console.log(carrera);
        $('.Melbourne').hide(); $('.Sahkir').hide(); $('.Shangai').hide(); $('.Baku').hide();
        $('.Catalunya').hide(); $('.Montecarlo').hide(); $('.Montreal').hide(); $('.LeCastellet').hide();
        $('.Spielberg').hide(); $('.Silverstone').hide(); $('.Hockenheim').hide(); $('.Mogyrod').hide();
        $('.Spa').hide(); $('.Monza').hide(); $('.MarinaBay').hide(); $('.Sochi').hide();
        $('.Suzuka').hide(); $('.MexicoDF').hide(); $('.Texas').hide(); $('.SaoPablo').hide();
        $('.AbuDhabi').hide(); $('.KualaLampur').hide(); $('.Jerez').hide();

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

    let seleccionTemporada = $('#elegirTemporada');
    $(seleccionTemporada).on('click', function () {
        temporadaSeleccionada = seleccionTemporada[0][0].value;
        mostrarTemporada(temporadaSeleccionada);
    });

    let seleccionCarrera = $('#elegirCarrera');
    $(seleccionCarrera).on('click', function () {
        carreraSeleccionada = seleccionCarrera[0][0].value;
        mostrarCarrera(carreraSeleccionada);
    });

    let modificarTemporada = $('#configurarTemporada');
    $(modificarTemporada).on('click', function () {
        if(window.location.search != ""){
            window.location = "configuracion.php" + window.location.search;
        } 
    });
});