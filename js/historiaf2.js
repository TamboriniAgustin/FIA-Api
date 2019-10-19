$(document).ready(function () {
    // Pilotos
    let pilotos = $('.tabla-pilotos-sorter');
    pilotos.tablesorter();

    const botonPilotos = $('#boton_pilotos');
    const piloto1 = $('#piloto1');
    const piloto2 = $('#piloto2');

    $(piloto1).on('blur', function () {
        if(piloto1.val() != null && piloto2.val() != null) $(botonPilotos).removeAttr('disabled');
    });

    $(piloto2).on('blur', function () {
        if(piloto1.val() != null && piloto2.val() != null) $(botonPilotos).removeAttr('disabled');
    });

    $(botonPilotos).on('click', function () {
        if(!$(botonPilotos).attr('disabled')){
            window.location = 'comparar-pilotos.php?categoria=f2&piloto1=' + piloto1.val() + '&piloto2=' + piloto2.val();
        }
    });
    // Escuderias
    let escuderias = $('.tabla-escuderias-sorter');
    escuderias.tablesorter();

    const botonEscuderias = $('#boton_escuderias');
    const escuderia1 = $('#escuderia1');
    const escuderia2 = $('#escuderia2');

    $(escuderia1).on('blur', function () {
        if(escuderia1.val() != null && escuderia2.val() != null) $(botonEscuderias).removeAttr('disabled');
    });

    $(escuderia2).on('blur', function () {
        if(escuderia1.val() != null && escuderia2.val() != null) $(botonEscuderias).removeAttr('disabled');
    });

    $(botonEscuderias).on('click', function () {
        if(!$(botonEscuderias).attr('disabled')){
            window.location = 'comparar-escuderias.php?categoria=f2&escuderia1=' + escuderia1.val() + '&escuderia2=' + escuderia2.val();
        }
    });
});