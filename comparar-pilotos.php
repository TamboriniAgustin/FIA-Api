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
    <!-- Cargo los pilotos que participaron en la temporada -->
    <?php
         try {
            require('db/conexion.php');
  
            $cargarPilotosTemporada = " SELECT * FROM pilotos ORDER BY apellido ";
            $resultadoTemporada = $con->query($cargarPilotosTemporada);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $pilotosComparacion = array();
          $contador = 0;
            while ($pilotos = $resultadoTemporada->fetch_assoc()) {
              if($categoria == 'f1'){
                $esPilotoDeF1 = corrioEnF1($pilotos['nombre'] . ' ' . $pilotos['apellido'], 'piloto', $carreras);
                if($esPilotoDeF1) array_push($pilotosComparacion, $pilotos);
              }
              else{
                $esPilotoDeF2 = corrioEnF2($pilotos['nombre'] . ' ' . $pilotos['apellido'], 'piloto', $carreras);
                if($esPilotoDeF2) array_push($pilotosComparacion, $pilotos);
              }
              $contador++;
            }
          //Hago un array con las IDS de los pilotos que se compararan
          $idPilotos = array();
          foreach($pilotosComparacion as $piloto){
            array_push($idPilotos, $piloto['id']);
          }
    ?>
    <!-- Obtengo la informacion extra de los pilotos -->
    <?php
      $pilotos = array(); 
      foreach($pilotosComparacion as $piloto){
          if($categoria == 'f1'){
            $piloto['grandes_premios'] =  carrerasEnF1($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['victorias'] =  victoriasEnF1($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['poles'] =  polesEnF1($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['podios'] =  podiosEnF1($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['vueltas_rapidas'] =  vueltasRapidasEnF1($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['abandonos'] =  abandonosEnF1($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['mundiales'] =  mundialesDeF1($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $temporadas);
            $piloto['escuderias'] =  escuderiasDePiloto($piloto['nombre'] . ' ' . $piloto['apellido'], $carreras); 
          }
          else{
            $piloto['grandes_premios'] =  carrerasEnF2($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['victorias'] =  victoriasEnF2($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['poles'] =  polesEnF2($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['podios'] =  podiosEnF2($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['vueltas_rapidas'] =  vueltasRapidasEnF2($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['abandonos'] =  abandonosEnF2($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $carreras);
            $piloto['mundiales'] =  mundialesDeF2($piloto['nombre'] . ' ' . $piloto['apellido'], 'piloto', $temporadas);
            $piloto['escuderias'] =  escuderiasDePiloto($piloto['nombre'] . ' ' . $piloto['apellido'], $carreras);
          }
          array_push($pilotos, $piloto);
        }
    ?>
    <!-- Envio la cantidad de pilotos registrados a js -->
    <input type="hidden" value="<?php echo max($idPilotos); ?>" id="pilotosTotales">

    <div style="margin: 50px;">
        <!-- Pilotos -->
        <h3 class="text-center">Pilotos</h3>
        <div class="comparadorPilotos container">
          <div class="row">
            <div class="col-sm" style="border: solid .2rem <?php echo $colorPagina; ?>">
              <div class="seleccionarPiloto form-group">
                <label for="piloto1">Seleccione un piloto</label>
                <select class="form-control" id="piloto1">
                  <?php 
                    foreach($pilotosComparacion as $piloto){
                  ?>
                      <option value="<?php echo $piloto['id'] ?>"><?php echo $piloto['apellido'] . ' ' . $piloto['nombre']; ?></option>
                  <?php 
                    }
                  ?>
                </select>
              </div>
              <?php 
                foreach($pilotos as $piloto){
              ?>
                  <div class="formularioPiloto" id="fila1-piloto<?php echo $piloto['id']; ?>" style="display:none;">
                        <p>Nacionalidad: <?php echo $piloto['nacionalidad']; ?></p>
                        <p>Edad (última participación): <?php echo $piloto['edad']; ?></p>
                        <p>Grandes Premios: <?php echo $piloto['grandes_premios']; ?></p>
                        <p>Victorias: <?php echo $piloto['victorias']; ?></p>
                        <p>Poles: <?php echo $piloto['poles'] ?></p>
                        <p>Podios: <?php echo $piloto['podios']; ?></p>
                        <p>Vueltas Rápidas: <?php echo $piloto['vueltas_rapidas']; ?></p>
                        <p>Abandonos: <?php echo $piloto['abandonos']; ?></p>
                        <p>Campeonatos del mundo: <?php echo $piloto['mundiales']; ?></p>
                        <p>Escuderias: <?php echo $piloto['escuderias']; ?></p>
                  </div>
              <?php 
                }
              ?>
            </div>
            <div class="col-sm" style="border: solid .2rem <?php echo $colorPagina; ?>">
              <div class="seleccionarPiloto form-group">
                <label for="piloto2">Seleccione un piloto</label>
                <select class="form-control" id="piloto2">
                  <?php 
                    foreach($pilotosComparacion as $piloto){
                  ?>
                      <option value="<?php echo $piloto['id'] ?>"><?php echo $piloto['apellido'] . ' ' . $piloto['nombre']; ?></option>
                  <?php 
                    }
                  ?>
                </select>
              </div>
              <?php 
                foreach($pilotos as $piloto){
              ?>
                  <div class="formularioPiloto" id="fila2-piloto<?php echo $piloto['id']; ?>" style="display:none;">
                        <p>Nacionalidad: <?php echo $piloto['nacionalidad']; ?></p>
                        <p>Edad (última participación): <?php echo $piloto['edad']; ?></p>
                        <p>Grandes Premios: <?php echo $piloto['grandes_premios']; ?></p>
                        <p>Victorias: <?php echo $piloto['victorias']; ?></p>
                        <p>Poles: <?php echo $piloto['poles'] ?></p>
                        <p>Podios: <?php echo $piloto['podios']; ?></p>
                        <p>Vueltas Rápidas: <?php echo $piloto['vueltas_rapidas']; ?></p>
                        <p>Abandonos: <?php echo $piloto['abandonos']; ?></p>
                        <p>Campeonatos del mundo: <?php echo $piloto['mundiales']; ?></p>
                        <p>Escuderias: <?php echo $piloto['escuderias']; ?></p>
                  </div>
              <?php 
                }
              ?>
            </div>
            <div class="col-sm" style="border: solid .2rem <?php echo $colorPagina; ?>">
              <div class="seleccionarPiloto form-group">
                <label for="piloto3">Seleccione un piloto</label>
                <select class="form-control" id="piloto3">
                  <?php 
                    foreach($pilotosComparacion as $piloto){
                  ?>
                      <option value="<?php echo $piloto['id'] ?>"><?php echo $piloto['apellido'] . ' ' . $piloto['nombre']; ?></option>
                  <?php 
                    }
                  ?>
                </select>
              </div>
              <?php 
                foreach($pilotos as $piloto){
              ?>
                  <div class="formularioPiloto" id="fila3-piloto<?php echo $piloto['id']; ?>" style="display:none;">
                        <p>Nacionalidad: <?php echo $piloto['nacionalidad']; ?></p>
                        <p>Edad (última participación): <?php echo $piloto['edad']; ?></p>
                        <p>Grandes Premios: <?php echo $piloto['grandes_premios']; ?></p>
                        <p>Victorias: <?php echo $piloto['victorias']; ?></p>
                        <p>Poles: <?php echo $piloto['poles'] ?></p>
                        <p>Podios: <?php echo $piloto['podios']; ?></p>
                        <p>Vueltas Rápidas: <?php echo $piloto['vueltas_rapidas']; ?></p>
                        <p>Abandonos: <?php echo $piloto['abandonos']; ?></p>
                        <p>Campeonatos del mundo: <?php echo $piloto['mundiales']; ?></p>
                        <p>Escuderias: <?php echo $piloto['escuderias']; ?></p>
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