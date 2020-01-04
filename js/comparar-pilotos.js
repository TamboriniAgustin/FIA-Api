var pilotosTotales = $('#pilotosTotales').val();

function mostrarPiloto(fila, piloto) {
    //console.log($(`#fila${fila}-piloto${piloto}`));
    for (let idPiloto = 1; idPiloto < pilotosTotales; idPiloto++) {
        if(idPiloto == piloto) $(`#fila${fila}-piloto${piloto}`).show();
        else $(`#fila${fila}-piloto${idPiloto}`).hide();
    }
}

$(document).ready(function () {
    let fila1 = $('#piloto1');
    $(fila1).on('change', function () {
        let idPiloto = fila1.val();
        mostrarPiloto(1, idPiloto);
    });

    let fila2 = $('#piloto2');
    $(fila2).on('change', function () {
        let idPiloto = fila2.val();
        mostrarPiloto(2, idPiloto);
    });

    let fila3 = $('#piloto3');
    $(fila3).on('change', function () {
        let idPiloto = fila3.val();
        mostrarPiloto(3, idPiloto);
    });
});