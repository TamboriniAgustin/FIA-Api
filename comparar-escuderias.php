<!-- Errores -->
<?php 
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);
?>
<!-- Configuraciones de Entorno -->
<?php
  //CATEGORÍA ACTUAL
  $categoria = $_GET['categoria'];
  //COLOR DE LOS BOTONES
  $colorPagina;
  if($categoria == 'f1') $colorPagina = "#dc3545";
  else if($categoria == 'f2') $colorPagina = "#007bff";
  else if($categoria == 'f3') $colorPagina = "#6c757d"; 
  //FUNCIONALIDAD DEL SITIO
  if($categoria == 'f1') include('funcionesf1.php'); 
  else if($categoria == 'f2') include('funcionesf2.php');
  else if($categoria == 'f3') include('funcionesf3.php');
  //PILOTOS A COMPARAR
  $escuderia1 = $_GET['escuderia1'];
  $escuderia2 = $_GET['escuderia2'];
  $escuderia3 = $_GET['escuderia3'];
?>
<!-- Conexiones de la base de datos -->
<?php 
  try {
    require('db/conexion.php');

    if(!$escuderia1 || !$escuderia2 || !$escuderia3){
      //ESTADÍSTICAS
      $cargarEstadistica =  " SELECT " .
                            "   e1.id AS id, " . 
                            "   e1.nombre AS nombre , " . 
                            "   e1.nacionalidad AS nacionalidad " .
                            " FROM escuderias e1 " .
                            " WHERE (SELECT COUNT(*) FROM carreras c2 WHERE (c2.posiciones_escuderias LIKE CONCAT('%', e1.nombre, '%')) AND (c2.categoria = '$categoria')) > 0 " .
                            " ORDER BY e1.nombre " 
                          ;
    }
    else {
      //ESTADÍSTICAS
      $cargarEstadistica =  " SELECT " .
                            "   e1.id AS id, " . 
                            "   e1.nombre AS nombre , " . 
                            "   e1.nacionalidad AS nacionalidad, " .
                            "   ( " .
                            "     SELECT COUNT(*) FROM carreras c2 " .
                            "     WHERE (c2.posiciones_escuderias LIKE CONCAT('%', e1.nombre, '%')) AND (c2.categoria = '$categoria') " .
                            "   ) AS grandes_premios, " .
                            "   ( " .
                            "     SELECT COUNT(*) FROM carreras c2 " .
                            "     WHERE (c2.posiciones_escuderias LIKE CONCAT('%', '\"1\":\"', e1.nombre, '\"%')) AND (c2.categoria = '$categoria') " .
                            "   ) AS victorias, " .
                            "   ( " .
                            "     SELECT COUNT(*) FROM carreras c2 " .
                            "     WHERE ((c2.posiciones_escuderias LIKE CONCAT('%', '\"1\":\"', e1.nombre, '\"%')) OR (c2.posiciones_escuderias LIKE CONCAT('%', '\"2\":\"', e1.nombre, '\"%')) OR (c2.posiciones_escuderias LIKE CONCAT('%', '\"3\":\"', e1.nombre, '\"%'))) AND (c2.categoria = '$categoria') " .
                            "   ) AS podios, " .
                            "   ( " .
                            "     SELECT COUNT(*) FROM carreras c2 " .
                            "     WHERE (c2.pole_escuderia = e1.nombre) AND (c2.categoria = '$categoria') " .
                            "   ) AS poles, " .
                            "   ( " .
                            "     SELECT COUNT(*) FROM carreras c2 " .
                            "     WHERE (c2.vuelta_rapida_escuderia = e1.nombre) AND (c2.categoria = '$categoria') " .
                            "   ) AS vueltas_rapidas, " .
                            "  ( " .
                            "    SELECT COUNT(*) FROM carreras c2 " .
                            "    WHERE (c2.abandonos_escuderias LIKE CONCAT('%', e1.nombre, '%')) AND (c2.categoria = '$categoria') " .
                            "  ) AS abandonos, " .
                            "  ( " .
                            "    SELECT COUNT(*) FROM temporadas t2 " .
                            "    WHERE t2.campeon_escuderias_$categoria = e1.nombre " .
                            "  ) AS campeonatos " .
                            " FROM escuderias e1 " .
                            " WHERE e1.id = $escuderia1 OR e1.id = $escuderia2 OR e1.id = $escuderia3 " .
                            " ORDER BY e1.nombre " 
                          ;
    }
    $resultadoEscuderias = $con->query($cargarEstadistica);
  } catch (\Exception $e) {
    $error = $e->getMessage();
  }
?>

<!DOCTYPE html>
<html lang="en">
  <!-- Contenido no visible -->
  <?php include('templates/head.php') ?>
  <!-- Contenido visible -->
  <body>
    <!-- Botón volver -->
    <a href="index.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>
    <!-- Header -->
    <?php include('templates/header.php') ?>
    <!-- Comparación de Pilotos -->
    <div style="margin: 50px;">
        <!-- Titulo -->
        <h3 class="text-center">Pilotos</h3>
        <?php 
          if(!$escuderia1 || !$escuderia2 || !$escuderia3){
        ?>
            <!-- Comparador -->
            <div class="comparadorPilotos container">
              <h5 class="text-center">SELECCIONE 3 ESCUDERIAS PARA REALIZAR UNA COMPARACIÓN</h5>
              <div class="seleccionar-piloto row">
                <?php 
                  while($escuderia = $resultadoEscuderias->fetch_assoc()){
                    if(!$escuderia1) $linkNuevo = $_SERVER["REQUEST_URI"] . '&escuderia1=';
                    else if(!$escuderia2) $linkNuevo = $_SERVER["REQUEST_URI"] . '&escuderia2=';
                    else $linkNuevo = $_SERVER["REQUEST_URI"] . '&escuderia3=';
                ?>
                    <div class="piloto card col-md-3" style="width: 18rem; <?php if($escuderia1 == $escuderia['id'] || $escuderia2 == $escuderia['id'] || $escuderia3 == $escuderia['id']) echo 'background-color:' . $colorPagina . '; color: #ffffff;' ?>">
                      <div class="card-body">
                        <h5 class="card-title"><?php echo $escuderia['nombre']; ?></h5>
                        <hr>
                        <h6 class="card-subtitle mb-2"><?php echo $escuderia['nacionalidad']; ?></h6>
                        <hr>
                        <a href="<?php echo $linkNuevo . $escuderia['id']; ?>" class="card-link" style="color: <?php if($escuderia1 == $escuderia['id'] || $escuderia2 == $escuderia['id'] || $escuderia3 == $escuderia['id']) echo '#ffffff'; else echo $colorPagina; ?>">SELECCIONAR</a>
                      </div>
                    </div>
                <?php 
                  }
                ?>
              </div>
            </div>
        <?php
          }
          else{
        ?>
            <!-- Información de pilotos -->
            <div class="row">
              <?php 
                while($escuderia = $resultadoEscuderias->fetch_assoc()){
              ?>
                  <!-- Información de Escuderias -->
                  <div class="piloto card col-md-4" style="width: 18rem;">
                    <div class="card-body">
                      <div class="informacion-personal text-center">
                        <h4>Información General</h4>
                        <h5 class="card-title"><strong><?php echo $escuderia['nombre']; ?></strong></h5>
                        <h6 class="card-subtitle mb-2"><?php echo $escuderia['nacionalidad']; ?></h6>
                      </div>
                      <hr>
                      <div class="informacion-carrera text-center">
                        <h4>Estadísticas</h4>
                        <h6 class="card-subtitle mb-2">Grandes Premios: <br> <strong><?php echo $escuderia['grandes_premios']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Victorias: <br> <strong><?php echo $escuderia['victorias']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Podios: <br> <strong><?php echo $escuderia['podios']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Poles: <br> <strong><?php echo $escuderia['poles']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Vueltas Rápidas: <br> <strong><?php echo $escuderia['vueltas_rapidas']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Abandonos: <br> <strong><?php echo $escuderia['abandonos']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Campeonatos Obtenidos: <br> <strong><?php echo $escuderia['campeonatos']; ?></strong></h6>
                      </div>
                    </div>
                  </div>
              <?php 
                }
              ?>
            </div>

            <br>

            <!-- Botón de Volver -->
            <div class="text-center">
              <a href="comparar-escuderias.php?categoria=<?php echo $categoria; ?>" class="btn" style="background-color: <?php echo $colorPagina; ?>; color: #ffffff;">COMPARAR OTROS</a>   
            </div>
        <?php 
          }
        ?>
    </div>
    <!-- Contenido no visible -->
    <?php include('templates/scripts.php') ?>
  </body>
</html>