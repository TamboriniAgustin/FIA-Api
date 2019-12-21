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
    <!-- Cargo las escuderias que participaron en la temporada -->
    <?php 
         $escuderia1 = $_GET['escuderia1'];
         $escuderia2 = $_GET['escuderia2'];

         try {
            require('db/conexion.php');
  
            $cargarEscuderiasTemporada = " SELECT * FROM escuderias WHERE id = $escuderia1 OR id = $escuderia2 ORDER BY nombre ";
            $resultadoTemporada = $con->query($cargarEscuderiasTemporada);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $escuderiasComparacion = array();
          $contador = 0;
          while ($escuderias = $resultadoTemporada->fetch_assoc()) {
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
    ?>

    <div style="margin: 50px;">
        <!-- Escuderias -->
        <h3 class="text-center">Escuderias</h3>
            <div class="tabla-escuderias">
                <table class="table">
                    <thead class="text-center" style="color:white; background-color:<?php echo $colorPagina; ?>;">
                        <tr>
                        <th scope="col" width="75%">Escuderia</th>
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
                            foreach ($escuderiasComparacion as $escuderia) {
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $escuderia['nombre']; ?></th>
                                    <th scope="row"><?php echo $escuderia['nacionalidad']; ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo carrerasEnF1($escuderia['nombre'], 'escuderia', $carreras); else echo carrerasEnF2($escuderia['nombre'], 'escuderia', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo polesEnF1($escuderia['nombre'], 'escuderia', $carreras); else echo polesEnF2($escuderia['nombre'], 'escuderia', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo podiosEnF1($escuderia['nombre'], 'escuderia', $carreras); else echo podiosEnF2($escuderia['nombre'], 'escuderia', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo vueltasRapidasEnF1($escuderia['nombre'], 'escuderia', $carreras); else echo vueltasRapidasEnF2($escuderia['nombre'], 'escuderia', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo abandonosEnF1($escuderia['nombre'], 'escuderia', $carreras); else echo abandonosEnF2($escuderia['nombre'], 'escuderia', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo victoriasEnF1($escuderia['nombre'], 'escuderia', $carreras); else echo victoriasEnF2($escuderia['nombre'], 'escuderia', $carreras); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo mundialesDeF1($escuderia['nombre'], 'escuderia', $temporadas); else echo mundialesDeF2($escuderia['nombre'], 'escuderia', $temporadas); ?></th>
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