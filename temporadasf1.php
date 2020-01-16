<!DOCTYPE html>
<html lang="en">
  <?php include('templates/head.php') ?>
  <body>
    <a href="index.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <?php include('funcionesf1.php'); ?>

    <!-- Establezco las temporadas que tendran 22 y 24 pilotos -->
    <?php 
      $temporadaCon22Pilotos =  array(
                                  2016, 2014, 2013, 2008, 2007, 2006, 2002, 2001, 2000,
                                  1999, 1998, 1996
                                ); 
      $temporadaCon24Pilotos = array(
                                  2012, 2011, 2010, 1997
                               );
      $temporadaCon26Pilotos = array(
                                  1995, 1993
                               );
      $temporadaCon28Pilotos = array(
                                  1994, 1986
                               );
      $temporadaCon32Pilotos = array(
                                  1992, 1987
                               );
      $temporadaCon36Pilotos = array(
                                  1991, 1988
                               );
      $temporadaCon38Pilotos = array(
                                  1990
                               );
      $temporadaCon40Pilotos = array(
                                  1989
                               );                                 
    ?>    

    <!-- Conecto a la base de datos y cargo las temporadas -->
    <?php 
      try {
        require('db/conexion.php');

        $cargarTemporadas = ' SELECT * FROM temporadas ORDER BY año DESC';
        $resultadoTemporadas = $con->query($cargarTemporadas);
      } catch (\Exception $e) {
        $error = $e->getMessage();
      }
    ?>
    
    <div id="elegirTemporada" class="text-center">
      <?php
        $contador = 1;
        $temporadaActual = $_GET['temporada']; 
        $campeonPilotos = "";
        $campeonEscuderias = "";
        while ($temporadas = $resultadoTemporadas->fetch_assoc()) {
          if($temporadas['año'] == $temporadaActual){
            $campeonPilotos = $temporadas['campeon_pilotos_f1'];
            $campeonEscuderias = $temporadas['campeon_escuderias_f1'];
          }
      ?>
          <a href="temporadasf1.php?categoria=f1&temporada=<?php echo $temporadas['año']; ?>"><span class="badge badge-pill badge-danger"><?php echo $temporadas['año']; ?></span></a>
      <?php
          if($contador % 20 == 0) echo "<br>";
          $contador++; 
        }
      ?>
    </div>

    <a id="configurarTemporada" href="#seleccionar_temporada"><h5 class="mb-2 bread text-right" style="padding: 20px;">Configurar Temporada</h5></a>    

    <!-- Obtengo los pilotos que participaron en la temporada -->
    <?php 
      if($temporadaActual){
        try {
          require('db/conexion.php');

          $cargarPilotosTemporada = " SELECT pilotosF1 FROM temporadas WHERE año = $temporadaActual ";
          $resultadoTemporada = $con->query($cargarPilotosTemporada);

          $pilotosTemporada = $resultadoTemporada->fetch_assoc()['pilotosF1'];
          $pilotosTemporada = str_replace('{', '', $pilotosTemporada);
          $pilotosTemporada = str_replace('}', '', $pilotosTemporada);
          $pilotosTemporada = explode(',', $pilotosTemporada);

          $cargarEscuderiasTemporada = " SELECT escuderiasF1 FROM temporadas WHERE año = $temporadaActual ";
          $resultadoTemporada = $con->query($cargarEscuderiasTemporada);

          $escuderiasTemporada = $resultadoTemporada->fetch_assoc()['escuderiasF1'];
          $escuderiasTemporada = str_replace('{', '', $escuderiasTemporada);
          $escuderiasTemporada = str_replace('}', '', $escuderiasTemporada);
          $escuderiasTemporada = explode(',', $escuderiasTemporada);
        } catch (\Exception $e) {
          $error = $e->getMessage();
        }
    ?>
    <!-- Cargo las carreras que hayan formado parte de la temporada -->
    <?php 
      try {
        require('db/conexion.php');

        $cargarCarreras = "SELECT * FROM carreras WHERE categoria = 'f1' AND temporada = $temporadaActual";
        $resultadoCarreras = $con->query($cargarCarreras);

        $cargarPistas = "SELECT * FROM pistas";
        $resultadoPistas = $con->query($cargarPistas);
      } catch (\Exception $e) {
        $error = $e->getMessage();
      }

      $carrerasF1 = array();
      while($carreras = $resultadoCarreras->fetch_assoc()){
        $carrerasTemporada[$carreras['nombre']] = $carreras;
        array_push($carrerasF1, $carreras);
      }
    ?>

        <div class="container contenido">
          <!-- Tabla de Posiciones del Mundial -->
          <h3 class="mb-2 bread text-center" style="color:#dc3545; padding: 20px;">Mundial de Pilotos</h3>
          <table class="table table-posiciones">
            <thead class="text-center" style="color:white; background-color:#dc3545;">
              <tr>
                <th scope="col" data-tablesorter="false">Piloto</th>
                <th scope="col">Puntos</th>
                <th scope="col">Victorias</th>
                <th scope="col">Vueltas Rápidas</th>
                <th scope="col">Poles</th>
                <th scope="col">Abandonos</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php
                foreach ($pilotosTemporada as $piloto) {
              ?>
                  <tr <?php if(($piloto == $campeonPilotos) || (strpos($piloto, $campeonPilotos) != false)) echo 'style="color:white; background-color:#bf930d;"' ?>>
                    <td><?php echo $piloto ?></td>
                    <td><?php echo calcularPuntosTemporada($piloto, $temporadaActual, 'piloto', $carrerasF1);?></td>
                    <td><?php echo cantidadVictoriasTemporada($piloto, $temporadaActual, 'piloto', $carrerasF1);?></td>
                    <td><?php echo cantidadVueltasRapidasTemporada($piloto, $temporadaActual, 'piloto', $carrerasF1);?></td>
                    <td><?php echo cantidadPolesTemporada($piloto, $temporadaActual, 'piloto', $carrerasF1);?></td>
                    <td><?php echo cantidadAbandonosTemporada($piloto, $temporadaActual, 'piloto', $carrerasF1);?></td>
                  </tr>
              <?php
                }
              ?>
            </tbody>
          </table>

          <h3 class="mb-2 bread text-center" style="color:#dc3545; padding: 20px;">Mundial de Escuderias</h3>
          <table class="table table-posicionesE">
            <thead class="text-center" style="color:white; background-color:#dc3545;">
              <tr>
                <th scope="col" data-tablesorter="false">Escudería</th>
                <th scope="col">Puntos</th>
                <th scope="col">Victorias</th>
                <th scope="col">Vueltas Rápidas</th>
                <th scope="col">Poles</th>
                <th scope="col">Abandonos</th>
              </tr>
            </thead>
            <tbody class="text-center">
            <?php
                foreach ($escuderiasTemporada as $escuderia) {
              ?>
                  <tr <?php if(($escuderia == $campeonEscuderias) || (strpos($escuderia, $campeonEscuderias) != false)) echo 'style="color:white; background-color:#bf930d;"' ?>>
                    <td><?php echo $escuderia ?></td>
                    <td><?php echo calcularPuntosTemporada($escuderia, $temporadaActual, 'escuderia', $carrerasF1);?></td>
                    <td><?php echo cantidadVictoriasTemporada($escuderia, $temporadaActual, 'escuderia', $carrerasF1);?></td>
                    <td><?php echo cantidadVueltasRapidasTemporada($escuderia, $temporadaActual, 'escuderia', $carrerasF1);?></td>
                    <td><?php echo cantidadPolesTemporada($escuderia, $temporadaActual, 'escuderia', $carrerasF1);?></td>
                    <td><?php echo cantidadAbandonosTemporada($escuderia, $temporadaActual, 'escuderia', $carrerasF1);?></td>
                  </tr>
              <?php
                }
              ?>
            </tbody>
          </table>
          <br>
          <?php if($temporadaActual == "2007") echo "* McLaren ha sido descalificado del torneo por espionaje hacia ferrari." ?>
          <?php if($temporadaActual == "1988") echo "* Para la cuenta final del campeonato sólo se contaron los 11 mejores resultados de 16 posibles." ?>
          <!-- Seleccionar Carrera -->
          <div id="seleccionarCarrera" class="text-center" style="margin-top:2rem;">
            <?php
              $contador = 0; 
              foreach ($carrerasTemporada as $carrera){
                $paisCarrera = substr($carrera['nombre'], 0, strpos($carrera['nombre'], ' -'));
                if(($contador % 6 == 0)) echo "<div class='row'>";
            ?>
                <div class="col-2 card text-center" style="width: 18rem;">
                  <img style="border:solid .1rem grey; width:10rem;" src="images/Paises/<?php echo $paisCarrera; ?>.svg" class="card-img-top" alt="foto pais">
                  <div class="card-body">
                    <h5 class="card-title">Gran Premio de <?php echo $carrera['nombre']; ?></h5>
                    <a id="mostrarCarrera" class="btn btn-danger active" data-id="<?php echo valorCarrera($carrera['nombre']); ?>">Ver</a>
                  </div>
                </div>
            <?php
                $contador++;
                if(($contador % 6 == 0)) echo "</div>"; 
              }
            ?>
          </div>
          
          <!-- Establezco la cantidad de pilotos que participan por carrera -->
          <?php 
            $cantidadPilotos = 20;
            if(in_array($temporadaActual, $temporadaCon22Pilotos)) $cantidadPilotos = 22;
            else if(in_array($temporadaActual, $temporadaCon24Pilotos)) $cantidadPilotos = 24;
            else if(in_array($temporadaActual, $temporadaCon26Pilotos)) $cantidadPilotos = 26;
            else if(in_array($temporadaActual, $temporadaCon28Pilotos)) $cantidadPilotos = 28;
            else if(in_array($temporadaActual, $temporadaCon32Pilotos)) $cantidadPilotos = 32;
            else if(in_array($temporadaActual, $temporadaCon36Pilotos)) $cantidadPilotos = 36;
            else if(in_array($temporadaActual, $temporadaCon38Pilotos)) $cantidadPilotos = 38;
            else if(in_array($temporadaActual, $temporadaCon40Pilotos)) $cantidadPilotos = 40;
          ?>

          <!-- Carreras -->
          <?php 
            while($pista = $resultadoPistas->fetch_assoc()){
              $nombrePista = $pista['pais'] . ' - ' . $pista['ciudad'];
          ?>
              <table class="table <?php echo str_replace(' ', '', $pista['ciudad']); ?>" style="display: none; margin-top:2rem;">
                <thead class="text-center" style="background-color:<?php echo $pista['color_principal'] ?>;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:<?php echo $pista['texto_principal'] ?>;"><?php echo $pista['ciudad']; ?></h3></th>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:<?php echo $pista['texto_principal'] ?>;">---</h3></th>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:<?php echo $pista['texto_principal'] ?>;"><?php echo $pista['pais']; ?></h3></th>
                    <th scope="col" width="25%" class="text-right"><img src="images/Paises/<?php echo $pista['pais']; ?>.svg" alt="Bandera" width="50%"></img></th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <tr style="font-weight: bold; background-color:<?php echo $pista['color_principal'] ?>; color:<?php echo $pista['texto_secundario'] ?>;">
                    <th scope="row">#</th>
                    <td>Piloto</td>
                    <td>Escuderia</td>
                    <td>Puntos</td>
                  </tr>
                  <?php 
                      $posicionesPilotos = json_decode($carrerasTemporada[$nombrePista]['posiciones_pilotos'], true);
                      $posicionesEscuderias = json_decode($carrerasTemporada[$nombrePista]['posiciones_escuderias'], true);
                      for($i = 1; $i <= $cantidadPilotos; $i++){
                    ?>
                      <tr>
                        <th scope="row"><?php if(strpos('{' . $carrerasTemporada[$nombrePista]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                        <td><?php echo $posicionesPilotos[$i]; ?></td>
                        <td><?php echo $posicionesEscuderias[$i]; ?></td>
                        <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                      </tr>
                    <?php 
                      }
                    ?>
                </tbody>
                <tfoot class="text-center" style="background-color:<?php echo $pista['color_principal'] ?>; color:<?php echo $pista['texto_principal'] ?>;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada[$nombrePista]['vuelta_rapida']; ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:<?php echo $pista['color_principal'] ?>; color:<?php echo $pista['texto_principal'] ?>;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada[$nombrePista]['pole']; ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:<?php echo $pista['color_principal'] ?>; color:<?php echo $pista['texto_secundario'] ?>;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada[$nombrePista]['piloto_del_dia']; ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
          <?php 
            }
          ?>
        </div>
    <?php 
      }
    ?>

    <?php include('templates/scripts.php') ?>
  </body>
</html>