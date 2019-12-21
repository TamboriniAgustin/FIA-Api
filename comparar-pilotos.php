<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  $categoria = $_GET['categoria'];
  $colorPagina;
  if($categoria == 'f1') $colorPagina = "#dc3545";
  else $colorPagina = "#007bff"; 
?>

<!DOCTYPE html>
<html lang="en">
  <?php include('templates/head.php') ?>
  <body>
    <a href="<?php if($categoria == 'f1') echo "historiaf1.php"; else echo "historiaf2.php"; ?>"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

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
         $piloto1 = $_GET['piloto1'];
         $piloto2 = $_GET['piloto2'];

         try {
            require('db/conexion.php');
  
            $cargarPilotosTemporada = " SELECT * FROM pilotos WHERE id = $piloto1 OR id = $piloto2 ORDER BY apellido ";
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
    ?>

    <div style="margin: 50px;">
        <!-- Pilotos -->
        <h3 class="text-center">Pilotos</h3>
            <div class="tabla-pilotos">
                <table class="table">
                    <thead class="text-center" style="color:white; background-color:<?php echo $colorPagina; ?>;">
                        <tr>
                        <th scope="col" width="75%">Piloto</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Nacionalidad</th>
                        <th scope="col">Carreras Corridas</th>
                        <th scope="col">Poles</th>
                        <th scope="col">Podios</th>
                        <th scope="col">Vueltas Rápidas</th>
                        <th scope="col">Abandonos</th>
                        <th scope="col">Victorias</th>
                        <th scope="col">Campeonatos del Mundo</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php 
                            foreach ($pilotosComparacion as $piloto) {
                                $nombrePiloto = $piloto['nombre'] . ' ' . $piloto['apellido'];
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $nombrePiloto; ?></th>
                                    <th scope="row"><?php echo $piloto['edad']; ?></th>
                                    <th scope="row"><?php echo $piloto['nacionalidad']; ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo carrerasEnF1($nombrePiloto, 'piloto', $carreras); else echo carrerasEnF2($nombrePiloto, 'piloto', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo polesEnF1($nombrePiloto, 'piloto', $carreras); else echo polesEnF2($nombrePiloto, 'piloto', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo podiosEnF1($nombrePiloto, 'piloto', $carreras); else echo podiosEnF2($nombrePiloto, 'piloto', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo vueltasRapidasEnF1($nombrePiloto, 'piloto', $carreras); else echo vueltasRapidasEnF2($nombrePiloto, 'piloto', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo abandonosEnF1($nombrePiloto, 'piloto', $carreras); else echo abandonosEnF2($nombrePiloto, 'piloto', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo victoriasEnF1($nombrePiloto, 'piloto', $carreras); else echo victoriasEnF2($nombrePiloto, 'piloto', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo mundialesDeF1($nombrePiloto, 'piloto', $temporadas); else echo mundialesDeF2($nombrePiloto, 'piloto', $temporadas); ?></th>
                                </tr>
                        <?php 
                            }
                        ?>
                    </tbody>
                </table>
            </div>      
    </div>

    <?php include('templates/scripts.php') ?>
  </body>
</html>