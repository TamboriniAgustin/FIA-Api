<!-- Errores -->
<?php 
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);
?>
<!-- Cargo la funcionalidad de la página -->
<?php include('funcionesf2.php'); ?>
<!-- Establezco variables de interés -->
<?php 
  $temporadaActual = $_GET['temporada'];   
  $campeonPilotos = "";
  $campeonEscuderias = "";
?>
<!-- Establezco la cantidad de pilotos de la temporada -->
<?php 
  $temporadaCon22Pilotos =  array(
                              
                            ); 
  $temporadaCon24Pilotos = array(
                              
                           );
  $temporadaCon26Pilotos = array(
                              
                           );
  $temporadaCon28Pilotos = array(
                              
                           );
  $temporadaCon30Pilotos = array(
                              
                           );
  $temporadaCon32Pilotos = array(
                              
                           );
  $temporadaCon34Pilotos = array(
                              
                           );
  $temporadaCon36Pilotos = array(
                              
                           );
  $temporadaCon38Pilotos = array(
                                  
                          );
  $temporadaCon40Pilotos = array(
                              
                           );
  
  $cantidadPilotos = 20;
  if(in_array($temporadaActual, $temporadaCon22Pilotos)) $cantidadPilotos = 22;
  else if(in_array($temporadaActual, $temporadaCon24Pilotos)) $cantidadPilotos = 24;
  else if(in_array($temporadaActual, $temporadaCon26Pilotos)) $cantidadPilotos = 26;
  else if(in_array($temporadaActual, $temporadaCon28Pilotos)) $cantidadPilotos = 28;
  else if(in_array($temporadaActual, $temporadaCon30Pilotos)) $cantidadPilotos = 30;
  else if(in_array($temporadaActual, $temporadaCon32Pilotos)) $cantidadPilotos = 32;
  else if(in_array($temporadaActual, $temporadaCon34Pilotos)) $cantidadPilotos = 34;
  else if(in_array($temporadaActual, $temporadaCon36Pilotos)) $cantidadPilotos = 36;
  else if(in_array($temporadaActual, $temporadaCon38Pilotos)) $cantidadPilotos = 38;
  else if(in_array($temporadaActual, $temporadaCon40Pilotos)) $cantidadPilotos = 40;
?>
<!-- Conexiones a la base de datos -->
<?php
  try {
    require('db/conexion.php');
    //TEMPORADAS
    $cargarTemporadas = ' SELECT * FROM temporadas WHERE año >= 2017 ORDER BY año DESC';
    $resultadoTemporadas = $con->query($cargarTemporadas);
    
    if($temporadaActual){
      //CAMPEONES
      $cargarCampeones = " SELECT campeon_pilotos_f2, campeon_escuderias_f2 FROM temporadas WHERE año = $temporadaActual ";
      $campeonesTemporada = $con->query($cargarCampeones);
      $resultadoCampeones = $campeonesTemporada->fetch_assoc();

      $campeonPilotos = $resultadoCampeones['campeon_pilotos_f2'];
      $campeonEscuderias = $resultadoCampeones['campeon_escuderias_f2'];
      //PILOTOS (TEMPORADA ACTUAL)
      $cargarPilotosTemporada = " SELECT * FROM pilotos WHERE (SELECT pilotosF2 FROM temporadas WHERE año = $temporadaActual) LIKE CONCAT('%', nombre, ' ', apellido, '%') ";
      $pilotosTemporada = $con->query($cargarPilotosTemporada);
      //ESCUDERIAS (TEMPORADA ACTUAL)
      $cargarEscuderiasTemporada = " SELECT * FROM escuderias WHERE (SELECT escuderiasF2 FROM temporadas WHERE año = $temporadaActual) LIKE CONCAT('%', nombre, '%') ";
      $escuderiasTemporada = $con->query($cargarEscuderiasTemporada);
      //CARRERAS
      $cargarCarreras = " SELECT * FROM carreras WHERE categoria = 'f2' AND temporada = $temporadaActual ";
      $resultadoCarreras = $con->query($cargarCarreras);
      
      $carrerasF2 = array();
      while($carreras = $resultadoCarreras->fetch_assoc()){
        array_push($carrerasF2, $carreras);
      }
      //PISTAS
      $cargarPistas = " SELECT * FROM pistas WHERE CONCAT(pais, ' - ', ciudad) IN (SELECT nombre FROM carreras WHERE temporada = $temporadaActual) ";
      $resultadoPistas = $con->query($cargarPistas);
      
      $pistasF2 = array();
      while($pistas = $resultadoPistas->fetch_assoc()){
        array_push($pistasF2, $pistas);
      }
    }
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
    <!-- Elegir Temporada -->
    <div id="elegirTemporada" class="text-center">
      <?php
        $contador = 1;
        while ($temporadas = $resultadoTemporadas->fetch_assoc()) {
      ?>
          <a href="temporadasf2.php?categoria=f2&temporada=<?php echo $temporadas['año']; ?>"><span class="badge badge-pill badge-primary"><?php echo $temporadas['año']; ?></span></a>
      <?php
          if($contador % 20 == 0) echo "<br>";
          $contador++; 
        }
      ?>
    </div>
    <!-- Configuración de Temporada -->
    <div id="configurarTemporada">
      <?php 
        if($temporadaActual){
      ?>
          <a id="configurarTemporada" href="configuracion.php?categoria=f2&temporada=<?php echo $temporadaActual; ?>"><h5 class="mb-2 bread text-right" style="padding: 20px;">Configurar Temporada</h5></a>    
      <?php 
        }
      ?>
    </div>
    <!-- Contenido de Temporada -->
    <div id="contenido-temporada">
        <?php 
          if($temporadaActual){
        ?>
            <div class="container contenido">
              <!-- Tabla de Posiciones del Mundial de Pilotos -->
              <div class="mundial-pilotos">
                <!-- Titulo -->
                <h3 class="mb-2 bread text-center" style="color:#007bff; padding: 20px;">Mundial de Pilotos</h3>
                <!-- Tabla -->
                <table class="table table-posiciones">
                  <!-- Header -->
                  <thead class="text-center" style="color:white; background-color:#007bff;">
                    <tr>
                      <th scope="col" data-tablesorter="false">Piloto</th>
                      <th scope="col">Puntos</th>
                      <th scope="col">Victorias</th>
                      <th scope="col">Podios</th>
                      <th scope="col">Vueltas Rápidas</th>
                      <th scope="col">Poles</th>
                      <th scope="col">Abandonos</th>
                    </tr>
                  </thead>
                  <!-- Body -->
                  <tbody class="text-center">
                    <?php
                      while($piloto = $pilotosTemporada->fetch_assoc()) {
                        $nombrePiloto = $piloto['nombre'] . ' ' . $piloto['apellido'];
                        calcularInformacionTemporada($nombrePiloto, $temporadaActual, 'piloto', $carrerasF2, $informacionPiloto);
                    ?>
                        <tr <?php if(($nombrePiloto == $campeonPilotos) || (strpos($nombrePiloto, $campeonPilotos) != false)) echo 'style="color:white; background-color:#bf930d;"' ?>>
                          <!-- Nombre -->
                          <td><?php echo $nombrePiloto; ?></td>
                          <td><?php echo $informacionPiloto['puntos']; ?></td>
                          <td><?php echo $informacionPiloto['victorias']; ?></td>
                          <td><?php echo $informacionPiloto['podios']; ?></td>
                          <td><?php echo $informacionPiloto['vueltasRapidas']; ?></td>
                          <td><?php echo $informacionPiloto['poles']; ?></td>
                          <td><?php echo $informacionPiloto['abandonos']; ?></td>
                        </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              
              <!-- Tabla de Posiciones del Mundial de Escuderias -->
              <div class="mundial-escuderias">
                <!-- Titulo -->
                <h3 class="mb-2 bread text-center" style="color:#007bff; padding: 20px;">Mundial de Escuderias</h3>
                <!-- Tabla -->
                <table class="table table-posicionesE">
                  <!-- Header -->
                  <thead class="text-center" style="color:white; background-color:#007bff;">
                    <tr>
                      <th scope="col" data-tablesorter="false">Escuderia</th>
                      <th scope="col">Puntos</th>
                      <th scope="col">Victorias</th>
                      <th scope="col">Podios</th>
                      <th scope="col">Vueltas Rápidas</th>
                      <th scope="col">Poles</th>
                      <th scope="col">Abandonos</th>
                    </tr>
                  </thead>
                  <!-- Body -->
                  <tbody class="text-center">
                    <?php
                        while($escuderia = $escuderiasTemporada->fetch_assoc()) {
                          $nombreEscuderia = $escuderia['nombre'];
                          calcularInformacionTemporada($nombreEscuderia, $temporadaActual, 'escuderia', $carrerasF2, $informacionEscuderia);
                      ?>
                          <tr <?php if(($nombreEscuderia == $campeonEscuderias) || (strpos($nombreEscuderia, $campeonEscuderias) != false)) echo 'style="color:white; background-color:#bf930d;"' ?>>
                            <td><?php echo $nombreEscuderia ?></td>
                            <td><?php echo $informacionEscuderia['puntos']; ?></td>
                            <td><?php echo $informacionEscuderia['victorias']; ?></td>
                            <td><?php echo $informacionEscuderia['podios']; ?></td>
                            <td><?php echo $informacionEscuderia['vueltasRapidas']; ?></td>
                            <td><?php echo $informacionEscuderia['poles']; ?></td>
                            <td><?php echo $informacionEscuderia['abandonos']; ?></td>
                          </tr>
                      <?php
                        }
                      ?>
                  </tbody>
                </table>
              </div>
              
              <br>
              
              <!-- Carreras -->
              <div class="carreras">
                <div id="seleccionarCarrera" class="text-center" style="margin-top:2rem;">
                  <?php
                    $contador = 0; 
                    foreach ($carrerasF2 as $carrera){
                      $paisCarrera = substr($carrera['nombre'], 0, strpos($carrera['nombre'], ' -'));
                  ?>
                      <!-- Seleccionar Carrera -->
                      <?php if(($contador % 4 == 0)) echo "<div class='row'>"; ?>
                        <div class="col-3 card text-center" style="width: 18rem;">
                          <h5><?php echo $carrera['tipo']; ?></h5>
                          <img style="width:10rem; height:8rem; margin:1rem auto;" src="images/Paises/<?php echo $paisCarrera; ?>.svg" class="card-img-top" alt="foto pais">
                          <div class="card-body">
                            <h5 class="card-title">Gran Premio de <?php echo $carrera['nombre']; ?></h5>
                            <a id="mostrarCarrera" class="btn btn-danger active" data-id="<?php echo $carrera['id']; ?>">Ver</a>
                          </div>
                        </div>
                      <?php if(($contador + 1) % 4 == 0) echo "</div>"; ?>
                      <!-- Carrera -->
                      <div class="carrera pista<?php echo $carrera['id']; ?>" style="width:100%; display: none;">
                        <?php 
                          foreach($pistasF2 as $pista) {
                            $nombrePista = $pista['pais'] . ' - ' . $pista['ciudad'];
                            if($nombrePista == $carrera['nombre']){
                        ?>
                              <table class="table" style="margin-top:2rem;">
                                <!-- Head -->
                                <thead class="text-center" style="background-color:<?php echo $pista['color_principal'] ?>;">
                                  <tr>
                                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:<?php echo $pista['texto_principal'] ?>;"><?php echo $pista['ciudad']; ?></h3></th>
                                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:<?php echo $pista['texto_principal'] ?>;">---</h3></th>
                                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:<?php echo $pista['texto_principal'] ?>;"><?php echo $pista['pais']; ?></h3></th>
                                    <th scope="col" width="25%" class="text-right"><img src="images/Paises/<?php echo $pista['pais']; ?>.svg" alt="Bandera" width="50%"></img></th>
                                  </tr>
                                </thead>
                                <!-- Body -->
                                <tbody class="text-center">
                                  <tr style="font-weight: bold; background-color:<?php echo $pista['color_principal'] ?>; color:<?php echo $pista['texto_secundario'] ?>;">
                                    <th scope="row">#</th>
                                    <td>Piloto</td>
                                    <td>Escuderia</td>
                                    <td>Puntos</td>
                                  </tr>
                                  <?php 
                                      $posicionesPilotos = json_decode($carrera['posiciones_pilotos'], true);
                                      $posicionesEscuderias = json_decode($carrera['posiciones_escuderias'], true);
                                      for($i = 1; $i <= $cantidadPilotos; $i++){
                                    ?>
                                      <tr>
                                        <th scope="row"><?php if(strpos('{' . $carrera['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                                        <td><?php echo $posicionesPilotos[$i]; ?></td>
                                        <td><?php echo $posicionesEscuderias[$i]; ?></td>
                                        <td><?php echo calcularPuntos($_GET['temporada'], $i, $carrera['tipo']); ?></td>
                                      </tr>
                                    <?php 
                                      }
                                    ?>
                                </tbody>
                                <!-- Foots -->
                                <tfoot class="text-center" style="background-color:<?php echo $pista['color_principal'] ?>; color:<?php echo $pista['texto_principal'] ?>;">
                                  <th width="25%" scope="row"></th>
                                  <th width="25%" scope="row">Vuelta Rápida</th>
                                  <th width="25%" scope="row"><?php echo $carrera['vuelta_rapida']; ?></th>
                                  <th width="25%" scope="row"></th>
                                </tfoot>
                                <tfoot class="text-center" style="background-color:<?php echo $pista['color_principal'] ?>; color:<?php echo $pista['texto_principal'] ?>;">
                                  <th width="25%" scope="row"></th>
                                  <th width="25%" scope="row">Pole</th>
                                  <th width="25%" scope="row"><?php echo $carrera['pole']; ?></th>
                                  <th width="25%" scope="row"></th>
                                </tfoot>
                                <tfoot class="text-center" style="background-color:<?php echo $pista['color_principal'] ?>; color:<?php echo $pista['texto_secundario'] ?>;">
                                  <th width="25%" scope="row"></th>
                                  <th width="25%" scope="row">Piloto del Día</th>
                                  <th width="25%" scope="row"><?php echo $carrera['piloto_del_dia']; ?></th>
                                  <th width="25%" scope="row"></th>
                                </tfoot>
                              </table>
                        <?php
                            } 
                          }
                        ?>
                      </div>
                  <?php
                      $contador++; 
                    }
                  ?>
                </div>
              </div>
            </div>
        <?php 
          }
        ?>
    </div>
    <!-- Scripts -->
    <?php include('templates/scripts.php') ?>
  </body>
</html>