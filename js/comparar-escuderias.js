var escuderiasTotales = $('#escuderiasTotales').val();

function mostrarEscuderia(fila, escuderia) {
    for (let idEscuderia = 1; idEscuderia < escuderiasTotales; idEscuderia++) {
        if(idEscuderia == escuderia) $(`#fila${fila}-escuderia${escuderia}`).show();
        else $(`#fila${fila}-escuderia${idEscuderia}`).hide();
    }
}

$(document).ready(function () {
    let fila1 = $('#escuderia1');
    $(fila1).on('change', function () {
        let idEscuderia = fila1.val();
        mostrarEscuderia(1, idEscuderia);
    });

    let fila2 = $('#escuderia2');
    $(fila2).on('change', function () {
        let idEscuderia = fila2.val();
        mostrarEscuderia(2, idEscuderia);
    });

    let fila3 = $('#escuderia3');
    $(fila3).on('change', function () {
        let idEscuderia = fila3.val();
        mostrarEscuderia(3, idEscuderia);
    });
});