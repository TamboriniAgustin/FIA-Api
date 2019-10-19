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
              $esEscuderiaDeF1 = corrioEnF1($escuderias['nombre'], 'escuderia');
              if($esEscuderiaDeF1) array_push($escuderiasComparacion, $escuderias);
            }
            else{
              $esEscuderiaDeF2 = corrioEnF2($escuderias['nombre'], 'escuderia');
              if($esEscuderiaDeF2) array_push($escuderiasComparacion, $escuderias);
            }
            $contador++;
          }
    ?>

    <div style="margin: 50px;">
        <!-- Escuderias -->
        <h3 class="text-center">Escuderias</h3>
            <div class="tabla-escuderias">
                <table class="table tabla-escuderias-sorter">
                    <thead class="text-center" style="color:white; background-color:<?php echo $colorPagina; ?>;">
                        <tr>
                        <th scope="col" width="75%">Escuderia</th>
                        <th scope="col">Nacionalidad</th>
                        <th scope="col">Carreras Corridas</th>
                        <th scope="col">Poles</th>
                        <th scope="col">Podios</th>
                        <th scope="col">Vueltas Rápidas</th>
                        <th scope="col">Abandonos</th>
                        <th scope="col">Mayor Cantidad de Puntos en Temporada</th>
                        <th scope="col">Puntos Totales</th>
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
                                    <th scope="row"><?php if($categoria == 'f1') echo carrerasEnF1($escuderia['nombre'], 'escuderia'); else echo carrerasEnF2($escuderia['nombre'], 'escuderia'); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo polesEnF1($escuderia['nombre'], 'escuderia'); else echo polesEnF2($escuderia['nombre'], 'escuderia'); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo podiosEnF1($escuderia['nombre'], 'escuderia'); else echo podiosEnF2($escuderia['nombre'], 'escuderia'); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo vueltasRapidasEnF1($escuderia['nombre'], 'escuderia'); else echo vueltasRapidasEnF2($escuderia['nombre'], 'escuderia'); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo abandonosEnF1($escuderia['nombre'], 'escuderia'); else echo abandonosEnF2($escuderia['nombre'], 'escuderia'); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo maximaCantidadDePuntosDeF1($escuderia['nombre'], 'escuderia'); else echo maximaCantidadDePuntosDeF2($escuderia['nombre'], 'escuderia'); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo puntosTotalesDeF1($escuderia['nombre'], 'escuderia'); else echo puntosTotalesDeF2($escuderia['nombre'], 'escuderia'); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo victoriasEnF1($escuderia['nombre'], 'escuderia'); else echo victoriasEnF2($escuderia['nombre'], 'escuderia'); ?></th>
                                    <th scope="row"><?php if($categoria == 'f1') echo mundialesDeF1($escuderia['nombre'], 'escuderia'); else echo mundialesDeF2($escuderia['nombre'], 'escuderia'); ?></th>
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