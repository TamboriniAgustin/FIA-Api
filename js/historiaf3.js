$(document).ready(function () {
  // Pilotos
  $('#tabla-pilotos').tablesorter({
    headers: { 
        0: { sorter: false }
    },
    sortList: [[7,1]]
  });
  // Escuderias
  $('#tabla-escuderias').tablesorter({
    headers: { 
        0: { sorter: false }
    },
    sortList: [[7,1]]
  });
  // Paises
  $('#tabla-paises').tablesorter({
    headers: { 
        0: { sorter: false }
    },
    sortList: [[1,1]]
  });
  // Pistas
  $('#tabla-pistas').tablesorter({
    headers: { 
        0: { sorter: false }
    },
    sortList: [[1,1]]
  });
});