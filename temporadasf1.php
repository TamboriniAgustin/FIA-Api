<!-- Errores -->
<?php 
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);
?>
<!-- Cargo la funcionalidad de la página -->
<?php include('funcionesf1.php'); ?>
<!-- Establezco variables de interés -->
<?php 
  $temporadaActual = $_GET['temporada'];   
  $campeonPilotos = "";
  $campeonEscuderias = "";
?>
<!-- Establezco la cantidad de pilotos de la temporada -->
<?php 
  $temporadaCon22Pilotos =  array(
                              2016, 2014, 2013, 2008, 2007, 2006, 2002, 2001, 2000,
                              1999, 1998, 1997, 1996, 1957
                            ); 
  $temporadaCon24Pilotos = array(
                              2012, 2011, 2010, 1968, 1966, 1960, 1955
                           );
  $temporadaCon26Pilotos = array(
                              1995, 1993, 1986, 1967, 1964, 1963, 1951
                           );
  $temporadaCon28Pilotos = array(
                              1994, 1987, 1985, 1984, 1980, 1971, 1970, 1965,
                              1956, 1950
                           );
  $temporadaCon30Pilotos = array(
                              1983, 1979, 1976, 1975, 1973, 1962, 1959
                           );
  $temporadaCon32Pilotos = array(
                              1992, 1988, 1982, 1981, 1972, 1958, 1954, 1953
                           );
  $temporadaCon34Pilotos = array(
                              1991, 1978, 1974, 1961
                           );
  $temporadaCon36Pilotos = array(
                              1990, 1977, 1952
                           );
  $temporadaCon38Pilotos = array(
                                  
                          );
  $temporadaCon40Pilotos = array(
                              1989
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
    $cargarTemporadas = ' SELECT * FROM temporadas ORDER BY año DESC';
    $resultadoTemporadas = $con->query($cargarTemporadas);
    
    if($temporadaActual){
      //CAMPEONES
      $cargarCampeones = " SELECT campeon_pilotos_f1, campeon_escuderias_f1 FROM temporadas WHERE año = $temporadaActual ";
      $campeonesTemporada = $con->query($cargarCampeones);
      $resultadoCampeones = $campeonesTemporada->fetch_assoc();

      $campeonPilotos = $resultadoCampeones['campeon_pilotos_f1'];
      $campeonEscuderias = $resultadoCampeones['campeon_escuderias_f1'];
      //PILOTOS (TEMPORADA ACTUAL)
      $cargarPilotosTemporada = " SELECT * FROM pilotos WHERE (SELECT pilotosF1 FROM temporadas WHERE año = $temporadaActual) LIKE CONCAT('%', nombre, ' ', apellido, '%') ";
      $pilotosTemporada = $con->query($cargarPilotosTemporada);
      //ESCUDERIAS (TEMPORADA ACTUAL)
      $cargarEscuderiasTemporada = " SELECT * FROM escuderias WHERE (SELECT escuderiasF1 FROM temporadas WHERE año = $temporadaActual) LIKE CONCAT('%', nombre, '%') ";
      $escuderiasTemporada = $con->query($cargarEscuderiasTemporada);
      //CARRERAS
      $cargarCarreras = " SELECT * FROM carreras WHERE categoria = 'f1' AND temporada = $temporadaActual ";
      $resultadoCarreras = $con->query($cargarCarreras);
      
      $carrerasF1 = array();
      while($carreras = $resultadoCarreras->fetch_assoc()){
        array_push($carrerasF1, $carreras);
      }
      //PISTAS
      $cargarPistas = " SELECT * FROM pistas WHERE CONCAT(pais, ' - ', ciudad) IN (SELECT nombre FROM carreras WHERE temporada = $temporadaActual) ";
      $resultadoPistas = $con->query($cargarPistas);
      
      $pistasF1 = array();
      while($pistas = $resultadoPistas->fetch_assoc()){
        array_push($pistasF1, $pistas);
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
          <a href="temporadasf1.php?categoria=f1&temporada=<?php echo $temporadas['año']; ?>"><span class="badge badge-pill badge-danger"><?php echo $temporadas['año']; ?></span></a>
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
          <a id="configurarTemporada" href="configuracion.php?categoria=f1&temporada=<?php echo $temporadaActual; ?>"><h5 class="mb-2 bread text-right" style="padding: 20px;">Configurar Temporada</h5></a>    
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
                <h3 class="mb-2 bread text-center" style="color:#dc3545; padding: 20px;">Mundial de Pilotos</h3>
                <!-- Tabla -->
                <table class="table table-posiciones">
                  <!-- Header -->
                  <thead class="text-center" style="color:white; background-color:#dc3545;">
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
                        calcularInformacionTemporada($nombrePiloto, $temporadaActual, 'piloto', $carrerasF1, $informacionPiloto);
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
                <h3 class="mb-2 bread text-center" style="color:#dc3545; padding: 20px;">Mundial de Escuderias</h3>
                <!-- Tabla -->
                <table class="table table-posicionesE">
                  <!-- Header -->
                  <thead class="text-center" style="color:white; background-color:#dc3545;">
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
                          calcularInformacionTemporada($nombreEscuderia, $temporadaActual, 'escuderia', $carrerasF1, $informacionEscuderia);
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

              <!-- Aclaraciones de temporadas no habituales -->
              <div class="aclaraciones">
                <?php if($temporadaActual == "2007") echo "* McLaren ha sido descalificado del torneo por espionaje hacia ferrari." ?>
                <?php if($temporadaActual == "1988") echo "* Para la cuenta final del campeonato sólo se contaron los 11 mejores resultados de 16 posibles." ?>
                <?php if($temporadaActual == "1984") echo "* En Mónaco los puntos se han dividido por dos ya que la carrera fue suspendida por mal clima. Tyrrell fue desclasificado del Campeonato Mundial de Pilotos y Campeonato Mundial de Constructores debido a una infracción técnica." ?>
                <?php if($temporadaActual == "1974") echo "* Para la cuenta final del campeonato sólo se contaron los siete mejores resultados de las ocho primeras carreras y los mejores seis de las siete restantes. Para el campeonato de constructores sólo puntuaba un coche por carrera, el mejor clasificado." ?>
                <?php if($temporadaActual == "1973") echo "* Para la cuenta final del campeonato sólo se contaron los siete mejores resultados de las ocho primeras carreras y los mejores seis de las siete restantes. Para el campeonato de constructores sólo puntuaba un coche por carrera, el mejor clasificado." ?>
                <?php if($temporadaActual == "1972") echo "* Para la cuenta final del campeonato sólo se contaron los siete mejores resultados de las ocho primeras carreras y los mejores seis de las siete restantes. Para el campeonato de constructores sólo puntuaba un coche por carrera, el mejor clasificado." ?>
                <?php if($temporadaActual == "1970") echo "* Se toman en cuenta 11 carreras: las 6 mejores de las 7 primeras, y las 5 mejores de las 6 últimas." ?>
                <?php if($temporadaActual == "1965") echo "* Solo contabilizan los 6 mejores resultados." ?>
                <?php if($temporadaActual == "1964") echo "* Solo contabilizan los 6 mejores resultados." ?>
                <?php if($temporadaActual == "1959") echo "* Para el campeonato de constructores, solamente puntuaba el monoplaza mejor clasificado, aunque fuera de una escudería privada." ?>
                <?php if($temporadaActual == "1958") echo "* Para el campeonato de constructores, solamente puntuaba el monoplaza mejor clasificado, aunque fuera de una escudería privada." ?>
                <?php if($temporadaActual == "1956") echo "* Para el campeonato de pilotos solo se contabilizaban los cinco mejores resultados obtenidos por cada competidor. En caso de que varios pilotos, por circunstancias de la carrera, compitieran con un mismo vehículo, los puntos serían divididos equitativamente entre los pilotos." ?>
              </div>
              
              <!-- Carreras -->
              <div class="carreras">
                <div id="seleccionarCarrera" class="text-center" style="margin-top:2rem;">
                  <?php
                    $contador = 0; 
                    foreach ($carrerasF1 as $carrera){
                      $paisCarrera = substr($carrera['nombre'], 0, strpos($carrera['nombre'], ' -'));
                  ?>
                      <!-- Seleccionar Carrera -->
                      <?php if(($contador % 4 == 0)) echo "<div class='row'>"; ?>
                        <div class="col-3 card text-center" style="width: 18rem;">
                          <?php
                            if($paisCarrera == "Hungria") $width = "8rem";
                            else $width = "10rem";
                          ?>
                          <img style="width:<?php echo $width; ?>; height:8rem; margin:1rem auto;" src="images/Paises/<?php echo $paisCarrera; ?>.svg" class="card-img-top" alt="foto pais">
                          <div class="card-body">
                            <h5 class="card-title">Gran Premio de <?php echo $carrera['nombre']; ?></h5>
                            <a id="mostrarCarrera" class="btn btn-danger active" data-id="<?php echo $carrera['id']; ?>">Ver</a>
                          </div>
                        </div>
                      <?php if(($contador + 1) % 4 == 0) echo "</div>"; ?>
                      <!-- Carrera -->
                      <div class="carrera pista<?php echo $carrera['id']; ?>" style="width:100%; display: none;">
                        <?php 
                          foreach($pistasF1 as $pista) {
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
                                        <td><?php echo calcularPuntos($_GET['temporada'], $i); ?></td>
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