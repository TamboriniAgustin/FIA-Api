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
  else $colorPagina = "#007bff"; 
  //FUNCIONALIDAD DEL SITIO
  if($categoria == 'f1') include('funcionesf1.php'); 
  else include('funcionesf2.php');
  //PILOTOS A COMPARAR
  $piloto1 = $_GET['piloto1'];
  $piloto2 = $_GET['piloto2'];
  $piloto3 = $_GET['piloto3'];
?>
<!-- Conexiones de la base de datos -->
<?php 
  try {
    require('db/conexion.php');

    if(!$piloto1 || !$piloto2 || !$piloto3){
      //ESTADÍSTICAS
      $cargarEstadistica =  " SELECT " .
                            "   p1.id AS id, " . 
                            "   CONCAT(p1.nombre, ' ', p1.apellido) AS nombre , " . 
                            "   p1.nacionalidad AS nacionalidad " .
                            " FROM pilotos p1 " .
                            " WHERE (SELECT COUNT(*) FROM carreras c2 WHERE (c2.posiciones_pilotos LIKE CONCAT('%', p1.nombre, ' ', p1.apellido, '%')) AND (c2.categoria = '$categoria')) > 0 " .
                            " ORDER BY p1.apellido, p1.nombre " 
                          ;
    }
    else {
      //ESTADÍSTICAS
      $cargarEstadistica =  " SELECT " .
                            "   p1.id AS id, " . 
                            "   CONCAT(p1.nombre, ' ', p1.apellido) AS nombre , " . 
                            "   p1.nacionalidad AS nacionalidad, " .
                            "   p1.edad AS edad, " .
                            "   ( " .
                            "     SELECT COUNT(*) FROM carreras c2 " .
                            "     WHERE (c2.posiciones_pilotos LIKE CONCAT('%', p1.nombre, ' ', p1.apellido, '%')) AND (c2.categoria = '$categoria') " .
                            "   ) AS grandes_premios, " .
                            "   ( " .
                            "     SELECT COUNT(*) FROM carreras c2 " .
                            "     WHERE (c2.posiciones_pilotos LIKE CONCAT('%', '\"1\":\"', p1.nombre, ' ', p1.apellido, '\"%')) AND (c2.categoria = '$categoria') " .
                            "  ) AS victorias, " .
                            "  ( " .
                            "    SELECT COUNT(*) FROM carreras c2 " .
                            "    WHERE ((c2.posiciones_pilotos LIKE CONCAT('%', '\"1\":\"', p1.nombre, ' ', p1.apellido, '\"%')) OR (c2.posiciones_pilotos LIKE CONCAT('%', '\"2\":\"', p1.nombre, ' ', p1.apellido, '\"%')) OR (c2.posiciones_pilotos LIKE CONCAT('%', '\"3\":\"', p1.nombre, ' ', p1.apellido, '\"%'))) AND (c2.categoria = '$categoria') " .
                            "  ) AS podios, " .
                            "  ( " .
                            "    SELECT COUNT(*) FROM carreras c2 " .
                            "    WHERE (c2.pole = CONCAT(p1.nombre, ' ', p1.apellido)) AND (c2.categoria = '$categoria') " .
                            "  ) AS poles, " .
                            "  ( " .
                            "    SELECT COUNT(*) FROM carreras c2 " .
                            "    WHERE (c2.vuelta_rapida = CONCAT(p1.nombre, ' ', p1.apellido)) AND (c2.categoria = '$categoria') " .
                            "  ) AS vueltas_rapidas, " .
                            "  ( " .
                            "    SELECT COUNT(*) FROM carreras c2 " .
                            "    WHERE (c2.abandonos LIKE CONCAT('%', p1.nombre, ' ', p1.apellido, '%')) AND (c2.categoria = '$categoria') " .
                            "  ) AS abandonos, " .
                            "  ( " .
                            "    SELECT COUNT(*) FROM temporadas t2 " .
                            "    WHERE t2.campeon_pilotos_$categoria = CONCAT(p1.nombre, ' ', p1.apellido) " .
                            "  ) AS campeonatos " .
                            " FROM pilotos p1 " .
                            " WHERE p1.id = $piloto1 OR p1.id = $piloto2 OR p1.id = $piloto3 " .
                            " ORDER BY p1.apellido, p1.nombre " 
                          ;
    }
    $resultadoPilotos = $con->query($cargarEstadistica);
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
          if(!$piloto1 || !$piloto2 || !$piloto3){
        ?>
            <!-- Comparador -->
            <div class="comparadorPilotos container">
              <h5 class="text-center">SELECCIONE 3 PILOTOS PARA REALIZAR UNA COMPARACIÓN</h5>
              <div class="seleccionar-piloto row">
                <?php 
                  while($piloto = $resultadoPilotos->fetch_assoc()){
                    if(!$piloto1) $linkNuevo = $_SERVER["REQUEST_URI"] . '&piloto1=';
                    else if(!$piloto2) $linkNuevo = $_SERVER["REQUEST_URI"] . '&piloto2=';
                    else $linkNuevo = $_SERVER["REQUEST_URI"] . '&piloto3=';
                ?>
                    <div class="piloto card col-md-3" style="width: 18rem; <?php if($piloto1 == $piloto['id'] || $piloto2 == $piloto['id'] || $piloto3 == $piloto['id']) echo 'background-color:' . $colorPagina . '; color: #ffffff;' ?>">
                      <div class="card-body">
                        <h5 class="card-title"><?php echo $piloto['nombre']; ?></h5>
                        <hr>
                        <h6 class="card-subtitle mb-2"><?php echo $piloto['nacionalidad']; ?></h6>
                        <hr>
                        <a href="<?php echo $linkNuevo . $piloto['id']; ?>" class="card-link" style="color: <?php if($piloto1 == $piloto['id'] || $piloto2 == $piloto['id'] || $piloto3 == $piloto['id']) echo '#ffffff'; else echo $colorPagina; ?>">SELECCIONAR</a>
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
                while($piloto = $resultadoPilotos->fetch_assoc()){
              ?>
                  <!-- Información de Pilotos -->
                  <div class="piloto card col-md-4" style="width: 18rem;">
                    <div class="card-body">
                      <div class="informacion-personal text-center">
                        <h4>Información personal</h4>
                        <h5 class="card-title"><strong><?php echo $piloto['nombre']; ?></strong></h5>
                        <h6 class="card-subtitle mb-2"><?php echo $piloto['nacionalidad']; ?></h6>
                        <h6 class="card-subtitle mb-2"><?php echo $piloto['edad']; ?> años en su útilma temporada</h6>
                      </div>
                      <hr>
                      <div class="informacion-carrera text-center">
                        <h4>Estadísticas</h4>
                        <h6 class="card-subtitle mb-2">Grandes Premios: <br> <strong><?php echo $piloto['grandes_premios']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Victorias: <br> <strong><?php echo $piloto['victorias']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Podios: <br> <strong><?php echo $piloto['podios']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Poles: <br> <strong><?php echo $piloto['poles']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Vueltas Rápidas: <br> <strong><?php echo $piloto['vueltas_rapidas']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Abandonos: <br> <strong><?php echo $piloto['abandonos']; ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Escuderias: <br> <strong><?php echo escuderiasDePiloto($piloto['nombre'], $categoria); ?></strong></h6>
                        <br>
                        <h6 class="card-subtitle mb-2">Campeonatos Obtenidos: <br> <strong><?php echo $piloto['campeonatos']; ?></strong></h6>
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
              <a href="comparar-pilotos.php?categoria=<?php echo $categoria; ?>" class="btn" style="background-color: <?php echo $colorPagina; ?>; color: #ffffff;">COMPARAR OTROS</a>   
            </div>
        <?php 
          }
        ?>
    </div>
    <!-- Contenido no visible -->
    <?php include('templates/scripts.php') ?>
  </body>
</html>