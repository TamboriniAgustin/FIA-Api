<!-- Cargo el tipo de historia que quiero cargar -->
<?php 
  $tipo = $_GET['tipo']; 
  $categoria = 'f2';
?>
<!-- Cargo la funcionalidad PHP -->
<?php include('funcionesf2.php'); ?> 
<!-- Realizo la consulta en la base de datos -->
<?php
  if($tipo){
    try {
      require('db/conexion.php');

      if($tipo == "pilotos"){
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
                              "  ) AS campeonatos, " .
                              "  ( " .
                              "    SELECT MAX(temporada) FROM carreras c2 " .
                              "    WHERE (c2.posiciones_pilotos LIKE CONCAT('%', p1.nombre, ' ', p1.apellido, '%')) AND (c2.categoria = '$categoria') " .
                              "  ) AS ultima_participacion " .
                              " FROM pilotos p1 " .
                              " WHERE (SELECT COUNT(*) FROM carreras c2 WHERE (c2.posiciones_pilotos LIKE CONCAT('%', p1.nombre, ' ', p1.apellido, '%')) AND (c2.categoria = '$categoria')) > 0 " .
                              " ORDER BY p1.apellido, p1.nombre " 
                            ;
      }
      else if($tipo == "escuderias"){
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
                              "  ) AS campeonatos, " .
                              "  ( " .
                              "    SELECT MAX(temporada) FROM carreras c2 " .
                              "    WHERE (c2.posiciones_escuderias LIKE CONCAT('%', e1.nombre, '%')) AND (c2.categoria = '$categoria') " .
                              "  ) AS ultima_participacion " .
                              " FROM escuderias e1 " .
                              " WHERE (SELECT COUNT(*) FROM carreras c2 WHERE (c2.posiciones_escuderias LIKE CONCAT('%', e1.nombre, '%')) AND (c2.categoria = '$categoria')) > 0 " .
                              " ORDER BY e1.nombre " 
                            ;
      }
      else if($tipo == "paises"){
        //ESTADÍSTICAS
        $cargarEstadistica =  " SELECT " .
                              "   p1.nacionalidad AS pais, " . 
                              "   ( " .
                              "     SELECT COUNT(*) FROM temporadas t2 " .
                              "     JOIN pilotos p2 ON t2.campeon_pilotos_$categoria = CONCAT(p2.nombre, ' ', p2.apellido) " .
                              "     WHERE p2.nacionalidad = p1.nacionalidad " .
                              "   ) AS campeonatos_piloto, " .
                              "   ( " .
                              "     SELECT COUNT(*) FROM temporadas t2 " .
                              "     JOIN escuderias e2 ON t2.campeon_escuderias_$categoria = e2.nombre " .
                              "     WHERE e2.nacionalidad = p1.nacionalidad " .
                              "   ) AS campeonatos_escuderia, " .
                              "   ( " .
                              "     SELECT COUNT(*) FROM carreras c2 " .
                              "     WHERE (c2.nombre LIKE CONCAT('%', p1.nacionalidad, '%')) AND (c2.categoria = '$categoria') " .
                              "   ) AS sede, " .
                              "   ( " .
                              "     SELECT MAX(c2.temporada) FROM carreras c2 " .
                              "     WHERE (c2.nombre LIKE CONCAT('%', p1.nacionalidad, '%')) AND (c2.categoria = '$categoria') " .
                              "   ) AS ultima_sede " .
                              " FROM pilotos p1 " .
                              " GROUP BY p1.nacionalidad " .
                              " ORDER BY campeonatos_escuderia DESC, campeonatos_piloto DESC, sede DESC, p1.nacionalidad " 
                            ;
      }
      else if($tipo == "pistas"){
        //ESTADÍSTICAS
        $cargarEstadistica =  " SELECT " .
                              "   CONCAT(p1.ciudad, ', ', p1.pais) AS pista, " . 
                              "   ( " .
                              "     SELECT COUNT(*) FROM carreras c2 " .
                              "     WHERE (c2.nombre = CONCAT(p1.pais, ' - ', p1.ciudad)) AND (c2.categoria = '$categoria') " .
                              "   ) AS sede, " .
                              "   ( " .
                              "     SELECT CONCAT(p2.nombre, ' ', p2.apellido) FROM pilotos p2 " .
                              "     JOIN carreras c2 ON (c2.posiciones_pilotos LIKE CONCAT('%', '\"1\":\"', p2.nombre, ' ', p2.apellido, '\"%')) " .
                              "     WHERE (c2.nombre = CONCAT(p1.pais, ' - ', p1.ciudad)) AND (c2.categoria = '$categoria') " .
                              "     GROUP BY p2.id, p2.nombre, p2.apellido " .
                              "     ORDER BY COUNT(c2.id) DESC " .
                              "     LIMIT 1 " .
                              "   ) AS mejor_piloto, " .
                              "   ( " .
                              "     SELECT e2.nombre FROM escuderias e2 " .
                              "     JOIN carreras c2 ON (c2.posiciones_escuderias LIKE CONCAT('%', '\"1\":\"', e2.nombre, '\"%')) " .
                              "     WHERE (c2.nombre = CONCAT(p1.pais, ' - ', p1.ciudad)) AND (c2.categoria = '$categoria') " .
                              "     GROUP BY e2.nombre " .
                              "     ORDER BY COUNT(c2.id) DESC " .
                              "     LIMIT 1 " .
                              "   ) AS mejor_escuderia " .
                              " FROM pistas p1 " .
                              " ORDER BY p1.pais, p1.ciudad " 
                            ;
      }
      $resultadoEstadistica = $con->query($cargarEstadistica);
    } catch (\Exception $e) {
      $error = $e->getMessage();
    }
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
    <!-- Selección de historia -->
    <div class="seleccionar-tipo text-center" style="margin:20px auto;">
      <a href="historiaf2.php?tipo=pilotos" class="btn p-3 px-xl-4 py-xl-3 <?php if($tipo == "pilotos") echo 'btn-primary'; else echo 'btn-outline-primary'; ?>">Pilotos</a>
      <a href="historiaf2.php?tipo=escuderias" class="btn p-3 px-xl-4 py-xl-3 <?php if($tipo == "escuderias") echo 'btn-primary'; else echo 'btn-outline-primary'; ?>">Escuderias</a>
      <a href="historiaf2.php?tipo=paises" class="btn p-3 px-xl-4 py-xl-3 <?php if($tipo == "paises") echo 'btn-primary'; else echo 'btn-outline-primary'; ?>">Países</a>
      <a href="historiaf2.php?tipo=pistas" class="btn p-3 px-xl-4 py-xl-3 <?php if($tipo == "pistas") echo 'btn-primary'; else echo 'btn-outline-primary'; ?>">Pistas</a>
    </div>
    <!-- Tablas de Historia -->
    <div class="tabla-historia">
      <?php 
        if($tipo == "pilotos"){
      ?>
          <table id="tabla-pilotos" class="table">
            <thead class="text-center" style="color:white; background-color:#007bff;">
                <tr>
                  <th scope="col" width="75%">Piloto</th>
                  <th scope="col">Grandes Premios</th>
                  <th scope="col">Victorias</th>
                  <th scope="col">Podios</th>
                  <th scope="col">Poles</th>
                  <th scope="col">Vueltas Rápidas</th>
                  <th scope="col">Abandonos</th>
                  <th scope="col">Campeonatos del Mundo</th>
                  <th scope="col">Última Participación</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                    while($piloto = $resultadoEstadistica->fetch_assoc()) {
                ?>
                      <tr>
                          <th scope="row"><?php echo $piloto['nombre']; ?></th>
                          <th scope="row"><?php echo $piloto['grandes_premios']; ?></th>
                          <th scope="row"><?php echo $piloto['victorias']; ?></th>
                          <th scope="row"><?php echo $piloto['podios']; ?></th>
                          <th scope="row"><?php echo $piloto['poles']; ?></th>
                          <th scope="row"><?php echo $piloto['vueltas_rapidas']; ?></th>
                          <th scope="row"><?php echo $piloto['abandonos']; ?></th>
                          <th scope="row"><?php echo $piloto['campeonatos']; ?></th>
                          <th scope="row"><?php echo $piloto['ultima_participacion']; ?></th>
                      </tr>
                <?php 
                    }
                ?>
            </tbody>
          </table>
      <?php 
        }
        else if($tipo == "escuderias"){
      ?>
          <table id="tabla-escuderias" class="table">
            <thead class="text-center" style="color:white; background-color:#007bff;">
                <tr>
                  <th scope="col" width="75%">Escuderia</th>
                  <th scope="col">Grandes Premios</th>
                  <th scope="col">Victorias</th>
                  <th scope="col">Podios</th>
                  <th scope="col">Poles</th>
                  <th scope="col">Vueltas Rápidas</th>
                  <th scope="col">Abandonos</th>
                  <th scope="col">Campeonatos del Mundo</th>
                  <th scope="col">Última Participación</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                    while($escuderia = $resultadoEstadistica->fetch_assoc()) {
                ?>
                      <tr>
                          <th scope="row"><?php echo $escuderia['nombre']; ?></th>
                          <th scope="row"><?php echo $escuderia['grandes_premios']; ?></th>
                          <th scope="row"><?php echo $escuderia['victorias']; ?></th>
                          <th scope="row"><?php echo $escuderia['podios']; ?></th>
                          <th scope="row"><?php echo $escuderia['poles']; ?></th>
                          <th scope="row"><?php echo $escuderia['vueltas_rapidas']; ?></th>
                          <th scope="row"><?php echo $escuderia['abandonos']; ?></th>
                          <th scope="row"><?php echo $escuderia['campeonatos']; ?></th>
                          <th scope="row"><?php echo $escuderia['ultima_participacion']; ?></th>
                      </tr>
                <?php 
                    }
                ?>
            </tbody>
          </table>
      <?php 
        }
        else if($tipo == "paises"){
      ?>
          <table id="tabla-paises" class="table">
            <thead class="text-center" style="color:white; background-color:#007bff;">
                <tr>
                  <th scope="col" width="20%">País</th>
                  <th scope="col">Campeonatos de Pilotos</th>
                  <th scope="col">Campeonatos de Escuderias</th>
                  <th scope="col">Sede</th>
                  <th scope="col">Último año de Sede</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                    while($pais = $resultadoEstadistica->fetch_assoc()) {
                ?>
                      <tr>
                          <th scope="row"><?php echo $pais['pais']; ?></th>
                          <th scope="row"><?php echo $pais['campeonatos_piloto']; ?></th>
                          <th scope="row"><?php echo $pais['campeonatos_escuderia']; ?></th>
                          <th scope="row"><?php echo $pais['sede']; ?></th>
                          <th scope="row"><?php echo $pais['ultima_sede']; ?></th>
                      </tr>
                <?php 
                    }
                ?>
            </tbody>
          </table>
      <?php 
        }
        else if($tipo == "pistas"){
      ?>
          <table id="tabla-pistas" class="table">
            <thead class="text-center" style="color:white; background-color:#007bff;">
                <tr>
                  <th scope="col" width="20%">Pista</th>
                  <th scope="col">Sede</th>
                  <th scope="col">Piloto más ganador</th>
                  <th scope="col">Escuderia más ganadora</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                    while($pista = $resultadoEstadistica->fetch_assoc()) {
                ?>
                      <tr>
                          <th scope="row"><?php echo $pista['pista']; ?></th>
                          <th scope="row"><?php echo $pista['sede']; ?></th>
                          <th scope="row"><?php echo $pista['mejor_piloto']; ?></th>
                          <th scope="row"><?php echo $pista['mejor_escuderia']; ?></th>
                      </tr>
                <?php 
                    }
                ?>
            </tbody>
          </table>
      <?php 
        }
      ?>
    </div>
    <!-- Contenido no visible -->
    <?php include('templates/scripts.php') ?>
  </body>
</html>