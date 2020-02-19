function mostrarCarrera(Carrera) {
    if(Carrera != "Selecciona una carrera"){
        let carrera = '.' + Carrera;
        $('.Melbourne').hide(); $('.Sahkir').hide(); $('.Shangai').hide(); 
        $('.Catalunya').hide(); $('.Montecarlo').hide(); $('.Montreal').hide(); 
        $('.Spielberg').hide(); $('.Silverstone').hide(); $('.Hockenheim').hide(); 
        $('.Spa').hide(); $('.Monza').hide(); $('.MarinaBay').hide(); 
        $('.Suzuka').hide(); $('.MexicoDF').hide(); $('.Texas').hide(); 
        $('.AbuDhabi').hide(); $('.KualaLampur').hide(); $('.Jerez').hide(); 
        $('.Yeongam').hide(); $('.Buddh').hide(); $('.Valencia').hide(); 
        $('.Nevers').hide(); $('.Fuji').hide(); $('.Indianapolis').hide(); 
        $('.BuenosAires').hide(); $('.Dijon').hide(); $('.California').hide();
        $('.Estoril').hide(); $('.Okayama').hide(); $('.Adelaida').hide();
        $('.Kyalami').hide(); $('.Phoenix').hide(); $('.RioDeJaneiro').hide();
        $('.Michigan').hide(); $('.Kent').hide(); $('.Zandvoort').hide();
        $('.Zolder').hide(); $('.Imola').hide(); $('.Estambul').hide();
        $('.Nurburg').hide(); $('.SaoPablo').hide(); $('.Sochi').hide();
        $('.Budapest').hide(); $('.LeCastellet').hide(); $('.Baku').hide();
        $('.LasVegas').hide(); $('.Jarama').hide(); $('.NuevaYork').hide();
        $('.Anderstorp').hide();

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