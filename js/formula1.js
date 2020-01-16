function mostrarCarrera(Carrera) {
    if(Carrera != "Selecciona una carrera"){
        let carrera = '.' + Carrera;
        $('.Melbourne').hide(); $('.Sahkir').hide(); $('.Shangai').hide(); $('.Baku').hide();
        $('.Catalunya').hide(); $('.Montecarlo').hide(); $('.Montreal').hide(); $('.LeCastellet').hide();
        $('.Spielberg').hide(); $('.Silverstone').hide(); $('.Hockenheim').hide(); $('.Budapest').hide();
        $('.Spa').hide(); $('.Monza').hide(); $('.MarinaBay').hide(); $('.Sochi').hide();
        $('.Suzuka').hide(); $('.MexicoDF').hide(); $('.Texas').hide(); $('.SaoPablo').hide();
        $('.AbuDhabi').hide(); $('.KualaLampur').hide(); $('.Jerez').hide(); $('.Nurburg').hide();
        $('.Yeongam').hide(); $('.Buddh').hide(); $('.Valencia').hide(); $('.Estambul').hide();
        $('.Nevers').hide(); $('.Fuji').hide(); $('.Indianapolis').hide(); $('.Imola').hide();
        $('.BuenosAires').hide(); $('.SuzukaCorto').hide(); $('.TexasCorto').hide();
        $('.Estoril').hide(); $('.Okayama').hide(); $('.Adelaida').hide();
        $('.Kyalami').hide(); $('.Phoenix').hide(); $('.RioDeJaneiro').hide();
        $('.Michigan').hide(); $('.Kent').hide();

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