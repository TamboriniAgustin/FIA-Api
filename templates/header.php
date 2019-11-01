<?php 
    if(strpos($nombrePagina, 'creaciones') != false){
        $imagen = 'images/f1.jpg';
        $encabezado = 'Creaciones';
    }
    if(strpos($nombrePagina, 'modificaciones') != false){
        $imagen = 'images/f1.jpg';
        $encabezado = 'Modificaciones';
    }
    if(strpos($nombrePagina, 'modificar-escuderia') != false){
        $imagen = 'images/f1.jpg';
        $encabezado = 'Modificar Escuderia';
    }
    if(strpos($nombrePagina, 'modificar-piloto') != false){
        $imagen = 'images/pilotos.jpg';
        $encabezado = 'Modificar Piloto';
    }
    if(strpos($nombrePagina, 'modificar-pista') != false){
        $imagen = 'images/pilotos.jpg';
        $encabezado = 'Modificar Pista';
    }
    if(strpos($nombrePagina, 'historiaf1') != false){
        $imagen = 'images/pilotos.jpg';
        $encabezado = 'Historia de la Fórmula 1';
    }
    if(strpos($nombrePagina, 'historiaf2') != false){
        $imagen = 'images/pilotosf2.jpg';
        $encabezado = 'Historia de la Fórmula 2';
    }
    if(strpos($nombrePagina, 'temporadasf1') != false){
        $imagen = 'images/f1.jpg';
        $encabezado = 'Fórmula 1 - Temporadas';
    }
    if(strpos($nombrePagina, 'temporadasf2') != false){
        $imagen = 'images/f2.jpg';
        $encabezado = 'Fórmula 2 - Temporadas';
    }
    if(strpos($nombrePagina, 'configuracion') != false){
        $imagen = 'images/f1.jpg';
        $encabezado = 'Configuracion';
    }
    if(strpos($nombrePagina, 'comparar-pilotos') != false){
        $imagen = 'images/pilotos.jpg';
        $encabezado = 'Comparacion de Pilotos';
    }
    if(strpos($nombrePagina, 'comparar-escuderias') != false){
        $imagen = 'images/pilotos.jpg';
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