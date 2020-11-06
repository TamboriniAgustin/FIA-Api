<!DOCTYPE html>
<html lang="en">
  <?php include('templates/head.php') ?>

  <body>
    <!-- Navegacion -->
	  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
            <a href="index.php"><img src="images/fia.png" alt="Imagen FIA" width="50%"></a>
            <a href="creaciones.php" style="color: white;">Creaciones</a>
            <a href="modificaciones.php" style="color: white;">Modificaciones</a>
      </div>
	  </nav>
    <!-- Fin de navegacion -->
    
    <!-- Slides -->
    <section class="home-slider owl-carousel js-fullheight">
      <!-- Formula 1 -->
      <div class="slider-item js-fullheight" style="background-image: url(images/f1.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text js-fullheight justify-content-center align-items-center" data-scrollax-parent="true">
            <div class="col-md-12 col-sm-12 text-center ftco-animate">
              <h1 class="mb-4 mt-5">Formula 1</h1>
              <p>
                  <a href="historiaf1.php" class="btn btn-danger p-3 px-xl-4 py-xl-3">Historia</a>
                  <a href="temporadasf1.php" class="btn btn-outline-danger p-3 px-xl-4 py-xl-3">Temporadas</a>
                  <a href="comparar-pilotos.php?categoria=f1" class="btn btn-outline-danger p-3 px-xl-4 py-xl-3">Comparar Pilotos</a>
                  <a href="comparar-escuderias.php?categoria=f1" class="btn btn-outline-danger p-3 px-xl-4 py-xl-3">Comparar Escuderias</a>  
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Formula 2 -->
      <div class="slider-item js-fullheight" style="background-image: url(images/f2.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text js-fullheight justify-content-center align-items-center" data-scrollax-parent="true">
            <div class="col-md-12 col-sm-12 text-center ftco-animate">
              <h1 class="mb-4 mt-5">Formula 2</h1>
              <p>
                  <a href="historiaf2.php" class="btn btn-primary p-3 px-xl-4 py-xl-3">Historia</a>
                  <a href="temporadasf2.php" class="btn btn-outline-primary p-3 px-xl-4 py-xl-3">Temporadas</a>
                  <a href="comparar-pilotos.php?categoria=f2" class="btn btn-outline-primary p-3 px-xl-4 py-xl-3">Comparar Pilotos</a>
                  <a href="comparar-escuderias.php?categoria=f2" class="btn btn-outline-primary p-3 px-xl-4 py-xl-3">Comparar Escuderias</a>    
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Formula 3 -->
      <div class="slider-item js-fullheight" style="background-image: url(images/f3.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text js-fullheight justify-content-center align-items-center" data-scrollax-parent="true">
            <div class="col-md-12 col-sm-12 text-center ftco-animate">
              <h1 class="mb-4 mt-5">Formula 3</h1>
              <p>
                  <a href="historiaf3.php" class="btn btn-secondary p-3 px-xl-4 py-xl-3">Historia</a>
                  <a href="temporadasf3.php" class="btn btn-outline-secondary p-3 px-xl-4 py-xl-3">Temporadas</a>
                  <a href="comparar-pilotos.php?categoria=f3" class="btn btn-outline-secondary p-3 px-xl-4 py-xl-3">Comparar Pilotos</a>
                  <a href="comparar-escuderias.php?categoria=f3" class="btn btn-outline-secondary p-3 px-xl-4 py-xl-3">Comparar Escuderias</a>    
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Fin Slides -->

    <!-- Audio -->
    <div style="display: none"><audio autoplay controls>
    <source src="audio/f1.mp3" type="audio/mpeg">
    Tu navegador no acepta el sistema de audio.
    </audio></div>
    <!-- Fin Audio -->

    <?php include('templates/scripts.php') ?>
    
  </body>
</html>