<?php $nombrePagina = $_SERVER['PHP_SELF']; ?>
<head>
    <?php 
        if(strpos($nombrePagina, 'index') != false) echo '<title>Campeonatos de la FIA</title>';
        if(strpos($nombrePagina, 'creaciones') != false) echo '<title>FIA - Creaciones</title>';
        if(strpos($nombrePagina, 'modificaciones') != false) echo '<title>FIA - Modificaciones</title>';
        if(strpos($nombrePagina, 'modificar-escuderia') != false) echo '<title>Modificaciones - Escuderia</title>';
        if(strpos($nombrePagina, 'modificar-piloto') != false) echo '<title>Modificaciones - Piloto</title>';
        if(strpos($nombrePagina, 'historiaf1') != false) echo '<title>F1 - Historia</title>';
        if(strpos($nombrePagina, 'historiaf2') != false) echo '<title>F2 - Historia</title>';
        if(strpos($nombrePagina, 'temporadasf1') != false) echo '<title>F1 - Temporadas</title>';
        if(strpos($nombrePagina, 'temporadasf2') != false) echo '<title>F2 - Temporadas</title>';
        if(strpos($nombrePagina, 'configuracion') != false) echo '<title>Temporada - Configuracion</title>';
        if(strpos($nombrePagina, 'comparar-pilotos') != false) echo '<title>Historia - Comparar Pilotos</title>';
        if(strpos($nombrePagina, 'comparar-escuderias') != false) echo '<title>Historia - Comparar Escuderias</title>';
    ?>
    <title>FIA - Formula</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Monoton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Miss+Fajardose&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
	<link href="css/sorter.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
  </head>