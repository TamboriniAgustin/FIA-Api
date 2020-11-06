function mostrarCarrera(Carrera) {
    const pista = $(`.carreras .pista${Carrera}`).hide();
    $(pista).show();
}

function ocultarCarrera(Carrera) {
    const pista = $(`.carreras .pista${Carrera}`).hide();
    $(pista).hide();
}

$(document).ready(function () {
    let mundialPilotos = $('.table-posiciones');
    $(mundialPilotos).tablesorter({
        headers: { 
            0: { sorter: false}
        },
        sortList: [[1,1]]
    });

    let mundialEscuderias = $('.table-posicionesE');
    $(mundialEscuderias).tablesorter({
        headers: { 
            0: { sorter: false}
        },
        sortList: [[1,1]]
    });

    let seleccionCarrera = $('.card #mostrarCarrera');
    $(seleccionCarrera).on('click', function () {
        $('#seleccionarCarrera .card').removeClass('col-12');
        $('#seleccionarCarrera .card').addClass('col-3');

        carreraSeleccionada = $(this).attr('data-id');

        if($(this).html() == "Ver"){
            $(this).html('Ocultar');
            $(this).closest('.card').removeClass('col-3');
            $(this).closest('.card').addClass('col-12');
            mostrarCarrera(carreraSeleccionada);
        }
        else{
            $(this).html('Ver');
            $(this).closest('.card').removeClass('col-12');
            $(this).closest('.card').addClass('col-3');
            ocultarCarrera(carreraSeleccionada);
        }
        
    });
});