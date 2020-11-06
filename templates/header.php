<?php 
    if(strpos($nombrePagina, 'creaciones') != false){
        $imagen = 'images/creaciones.jpg';
        $encabezado = 'Creaciones';
    }
    if(strpos($nombrePagina, 'modificaciones') != false){
        $imagen = 'images/modificaciones.jpg';
        $encabezado = 'Modificaciones';
    }
    if(strpos($nombrePagina, 'modificar-escuderia') != false){
        $imagen = 'images/escuderias.jpg';
        $encabezado = 'Modificar Escuderia';
    }
    if(strpos($nombrePagina, 'modificar-piloto') != false){
        $imagen = 'images/pilotos.jpg';
        $encabezado = 'Modificar Piloto';
    }
    if(strpos($nombrePagina, 'modificar-pista') != false){
        $imagen = 'images/pistas.jpg';
        $encabezado = 'Modificar Pista';
    }
    if(strpos($nombrePagina, 'historiaf1') != false){
        $imagen = 'images/campeones/f1/campeones.jpg';
        $encabezado = 'Historia de la Fórmula 1';
    }
    if(strpos($nombrePagina, 'historiaf2') != false){
        $imagen = 'images/campeones/f2/campeones.jpg';
        $encabezado = 'Historia de la Fórmula 2';
    }
    if(strpos($nombrePagina, 'historiaf3') != false){
        $imagen = 'images/campeones/f3/campeones.jpg';
        $encabezado = 'Historia de la Fórmula 3';
    }
    if(strpos($nombrePagina, 'temporadasf1') != false){
        if($campeonPilotos == "" || $campeonEscuderias == "") $imagen = 'images/Campeones/f1/campeones.jpg';
        else $imagen = 'images/Campeones/f1/campeones' . $temporadaActual . '.jpg';
        $encabezado = 'Fórmula 1 - Temporadas';
    }
    if(strpos($nombrePagina, 'temporadasf2') != false){
        if($campeonPilotos == "" || $campeonEscuderias == "") $imagen = 'images/Campeones/f2/campeones.jpg';
        else $imagen = 'images/Campeones/f2/campeones' . $temporadaActual . '.jpg';
        $encabezado = 'Fórmula 2 - Temporadas';
    }
    if(strpos($nombrePagina, 'temporadasf3') != false){
        if($campeonPilotos == "" || $campeonEscuderias == "") $imagen = 'images/Campeones/f3/campeones.jpg';
        else $imagen = 'images/Campeones/f3/campeones' . $temporadaActual . '.jpg';
        $encabezado = 'Fórmula 3 - Temporadas';
    }
    if(strpos($nombrePagina, 'configuracion') != false){
        if($_GET['categoria'] == 'f1') $imagen = 'images/Campeones/f1/campeones.jpg';
        if($_GET['categoria'] == 'f2') $imagen = 'images/Campeones/f2/campeones.jpg';
        if($_GET['categoria'] == 'f3') $imagen = 'images/Campeones/f3/campeones.jpg';
        $encabezado = 'Configuracion';
    }
    if(strpos($nombrePagina, 'comparar-pilotos') != false){
        if($_GET['categoria'] == 'f1') $imagen = 'images/Campeones/f1/campeones.jpg';
        if($_GET['categoria'] == 'f2') $imagen = 'images/Campeones/f2/campeones.jpg';
        if($_GET['categoria'] == 'f3') $imagen = 'images/Campeones/f3/campeones.jpg';
        $encabezado = 'Comparacion de Pilotos';
    }
    if(strpos($nombrePagina, 'comparar-escuderias') != false){
        if($_GET['categoria'] == 'f1') $imagen = 'images/Campeones/f1/campeones.jpg';
        if($_GET['categoria'] == 'f2') $imagen = 'images/Campeones/f2/campeones.jpg';
        if($_GET['categoria'] == 'f3') $imagen = 'images/Campeones/f3/campeones.jpg';
        $encabezado = 'Comparacion de Escuderias';
    }
?>

<section class="hero-wrap hero-wrap-2" style="background-image: url('<?php echo $imagen ?>');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-2 bread"><?php echo $encabezado ?></h1>;
          </div>
        </div>
    </div>
</section>