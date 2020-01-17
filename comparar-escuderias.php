<?php
  $categoria = $_GET['categoria'];
  $colorPagina;
  if($categoria == 'f1') $colorPagina = "#dc3545";
  else $colorPagina = "#007bff"; 
?>

<!DOCTYPE html>
<html lang="en">
  <?php include('templates/head.php') ?>
  <body>
    <a href="index.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <?php if($categoria == 'f1') include('funcionesf1.php'); else include('funcionesf2.php'); ?>

    <!-- Cargo las temporadas que hayan formado parte de la historia -->
    <?php 
         try {
            require('db/conexion.php');
  
            $cargarTemporadas = " SELECT * FROM temporadas ";
            $resultadoTemporada = $con->query($cargarTemporadas);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $temporadas = array();
          while ($temporada = $resultadoTemporada->fetch_assoc()) {
            array_push($temporadas, $temporada);
          }
    ?>
    <!-- Cargo las carreras que hayan formado parte de la historia -->
    <?php 
         try {
            require('db/conexion.php');
  
            $cargarCarreras = " SELECT * FROM carreras WHERE categoria = '$categoria' ORDER BY temporada DESC ";
            $resultadoCarrera = $con->query($cargarCarreras);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $carreras = array();
          while ($carrera = $resultadoCarrera->fetch_assoc()) {
            array_push($carreras, $carrera);
          }
    ?>
    <!-- Cargo las escuderias que participaron en la temporada -->
    <?php
         try {
            require('db/conexion.php');
  
            $cargarEscuderiasTemporada = " SELECT * FROM escuderias ORDER BY nombre ";
            $resultadoEscuderias = $con->query($cargarEscuderiasTemporada);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $escuderiasComparacion = array();
          $contador = 0;
            while ($escuderias = $resultadoEscuderias->fetch_assoc()) {
              if($categoria == 'f1'){
                $esEscuderiaDeF1 = corrioEnF1($escuderias['nombre'], 'escuderia', $carreras);
                if($esEscuderiaDeF1) array_push($escuderiasComparacion, $escuderias);
              }
              else{
                $esEscuderiaDeF2 = corrioEnF2($escuderias['nombre'], 'escuderia', $carreras);
                if($esEscuderiaDeF2) array_push($escuderiasComparacion, $escuderias);
              }
              $contador++;
            }
          //Hago un array con las IDS de las escuderias que se compararan
          $idEscuderias = array();
          foreach($escuderiasComparacion as $escuderia){
            array_push($idEscuderias, $escuderia['id']);
          }
    ?>
    <!-- Obtengo la informacion extra de las escuderias -->
    <?php
      $escuderias = array(); 
      foreach($escuderiasComparacion as $escuderia){
          if($categoria == 'f1'){
            $escuderia['grandes_premios'] =  carrerasEnF1($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['victorias'] =  victoriasEnF1($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['poles'] =  polesEnF1($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['podios'] =  podiosEnF1($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['vueltas_rapidas'] =  vueltasRapidasEnF1($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['abandonos'] =  abandonosEnF1($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['mundiales'] =  mundialesDeF1($escuderia['nombre'], 'escuderia', $temporadas);
          }
          else{
            $escuderia['grandes_premios'] =  carrerasEnF2($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['victorias'] =  victoriasEnF2($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['poles'] =  polesEnF2($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['podios'] =  podiosEnF2($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['vueltas_rapidas'] =  vueltasRapidasEnF2($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['abandonos'] =  abandonosEnF2($escuderia['nombre'], 'escuderia', $carreras);
            $escuderia['mundiales'] =  mundialesDeF2($escuderia['nombre'], 'escuderia', $temporadas);
          }
          array_push($escuderias, $escuderia);
        }
    ?>
    <!-- Envio la cantidad de escuderias registradss a js -->
    <input type="hidden" value="<?php echo max($idEscuderias); ?>" id="escuderiasTotales">

    <div style="margin: 50px;">
        <!-- Escuderias -->
        <h3 class="text-center">Escuderias</h3>
        <div class="comparadorEscuderias container">
          <div class="row">
            <div class="col-sm" style="border: solid .2rem <?php echo $colorPagina; ?>">
              <div class="seleccionarEscuderia form-group">
                <label for="escuderia1">Seleccione una escuderia</label>
                <select class="form-control" id="escuderia1">
                  <?php 
                    foreach($escuderiasComparacion as $escuderia){
                  ?>
                      <option value="<?php echo $escuderia['id'] ?>"><?php echo $escuderia['nombre']; ?></option>
                  <?php 
                    }
                  ?>
                </select>
              </div>
              <?php 
                foreach($escuderias as $escuderia){
              ?>
                  <div class="formularioEscuderia" id="fila1-escuderia<?php echo $escuderia['id']; ?>" style="display:none;">
                        <p>Nacionalidad: <?php echo $escuderia['nacionalidad']; ?></p>
                        <p>Grandes Premios: <?php echo $escuderia['grandes_premios']; ?></p>
                        <p>Victorias: <?php echo $escuderia['victorias']; ?></p>
                        <p>Poles: <?php echo $escuderia['poles'] ?></p>
                        <p>Podios: <?php echo $escuderia['podios']; ?></p>
                        <p>Vueltas Rápidas: <?php echo $escuderia['vueltas_rapidas']; ?></p>
                        <p>Abandonos: <?php echo $escuderia['abandonos']; ?></p>
                        <p>Campeonatos del mundo: <?php echo $escuderia['mundiales']; ?></p>
                  </div>
              <?php 
                }
              ?>
            </div>
            <div class="col-sm" style="border: solid .2rem <?php echo $colorPagina; ?>">
              <div class="seleccionarEscuderia form-group">
                <label for="escuderia2">Seleccione una escuderia</label>
                <select class="form-control" id="escuderia2">
                  <?php 
                    foreach($escuderiasComparacion as $escuderia){
                  ?>
                      <option value="<?php echo $escuderia['id'] ?>"><?php echo $escuderia['nombre']; ?></option>
                  <?php 
                    }
                  ?>
                </select>
              </div>
              <?php 
                foreach($escuderias as $escuderia){
              ?>
                  <div class="formularioEscuderia" id="fila2-escuderia<?php echo $escuderia['id']; ?>" style="display:none;">
                        <p>Nacionalidad: <?php echo $escuderia['nacionalidad']; ?></p>
                        <p>Grandes Premios: <?php echo $escuderia['grandes_premios']; ?></p>
                        <p>Victorias: <?php echo $escuderia['victorias']; ?></p>
                        <p>Poles: <?php echo $escuderia['poles'] ?></p>
                        <p>Podios: <?php echo $escuderia['podios']; ?></p>
                        <p>Vueltas Rápidas: <?php echo $escuderia['vueltas_rapidas']; ?></p>
                        <p>Abandonos: <?php echo $escuderia['abandonos']; ?></p>
                        <p>Campeonatos del mundo: <?php echo $escuderia['mundiales']; ?></p>
                  </div>
              <?php 
                }
              ?>
            </div>
            <div class="col-sm" style="border: solid .2rem <?php echo $colorPagina; ?>">
              <div class="seleccionarEscuderia form-group">
                <label for="escuderia3">Seleccione una escuderia</label>
                <select class="form-control" id="escuderia3">
                  <?php 
                    foreach($escuderiasComparacion as $escuderia){
                  ?>
                      <option value="<?php echo $escuderia['id'] ?>"><?php echo $escuderia['nombre']; ?></option>
                  <?php 
                    }
                  ?>
                </select>
              </div>
              <?php 
                foreach($escuderias as $escuderia){
              ?>
                  <div class="formularioEscuderia" id="fila3-escuderia<?php echo $escuderia['id']; ?>" style="display:none;">
                        <p>Nacionalidad: <?php echo $escuderia['nacionalidad']; ?></p>
                        <p>Grandes Premios: <?php echo $escuderia['grandes_premios']; ?></p>
                        <p>Victorias: <?php echo $escuderia['victorias']; ?></p>
                        <p>Poles: <?php echo $escuderia['poles'] ?></p>
                        <p>Podios: <?php echo $escuderia['podios']; ?></p>
                        <p>Vueltas Rápidas: <?php echo $escuderia['vueltas_rapidas']; ?></p>
                        <p>Abandonos: <?php echo $escuderia['abandonos']; ?></p>
                        <p>Campeonatos del mundo: <?php echo $escuderia['mundiales']; ?></p>
                  </div>
              <?php 
                }
              ?>
            </div>
          </div>
        </div>   
    </div>

    <?php include('templates/scripts.php') ?>
  </body>
</html>