$(document).ready(function () {
    // Pilotos
    $("#tabla-pilotos").fancyTable({
      pagination: true,
      paginationClass: "btn btn-primary active",
	  paginationClassActive: "active",
      perPage:10
    });
    $("#tabla-pilotos").tablesorter();

    // Escuderias
    $("#tabla-escuderias").fancyTable({
        pagination: true,
        paginationClass: "btn btn-primary active",
	    paginationClassActive: "active",
		perPage:10
    });
    $("#tabla-escuderias").tablesorter();
});