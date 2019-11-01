<!DOCTYPE html>
<html lang="en">
  <?php include('templates/head.php') ?>
  <body>
    <a href="index.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <?php include('funcionesf1.php'); ?>

    <!-- Establezco las temporadas que tendran 22 pilotos -->
    <?php $temporadaCon22Pilotos = array(2016, 2014, 2013); ?>    

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

    <form action="#" id="elegirTemporada" method="GET">
        <select class="form-control">
            <option disabled selected>Selecciona una temporada</option>
            <?php 
              while ($temporadas = $resultadoTemporadas->fetch_assoc()) {
                $anioTemporada = $temporadas['año'];
            ?>
            <option value="<?php echo $anioTemporada ?>"><?php echo $anioTemporada ?></option>
            <?php 
              }
            ?>
        </select>
    </form>

    <a id="configurarTemporada" href="#seleccionar_temporada"><h5 class="mb-2 bread text-right" style="padding: 20px;">Configurar Temporada</h5></a>    

    <!-- Obtengo los pilotos que participaron en la temporada -->
    <?php
      $temporadaActual = $_GET['temporada']; 
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
                  <tr>
                    <td><?php echo $piloto ?></td>
                    <?php 
                      if($temporadaActual >= 2019){
                    ?>
                        <td><?php echo calcularPuntosPiloto($piloto, $temporadaActual) + cantidadVueltasRapidasPiloto($piloto, $temporadaActual);?></td>
                    <?php 
                      }
                      else{
                    ?>
                        <td><?php echo calcularPuntosPiloto($piloto, $temporadaActual)?></td>
                    <?php 
                      }
                    ?>
                    <td><?php echo cantidadVictoriasPiloto($piloto, $temporadaActual); ?></td>
                    <td><?php echo cantidadVueltasRapidasPiloto($piloto, $temporadaActual); ?></td>
                    <td><?php echo cantidadPolesPiloto($piloto, $temporadaActual); ?></td>
                    <td><?php echo cantidadAbandonosPiloto($piloto, $temporadaActual); ?></td>
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
                  <tr>
                    <td><?php echo $escuderia ?></td>
                    <?php 
                      if($temporadaActual >= 2019){
                    ?>
                        <td><?php echo calcularPuntosEscuderia($escuderia, $temporadaActual) + cantidadVueltasRapidasEscuderia($escuderia, $temporadaActual);?></td>
                    <?php 
                      }
                      else{
                    ?>
                        <td><?php echo calcularPuntosEscuderia($escuderia, $temporadaActual)?></td>
                    <?php 
                      }
                    ?>
                    <td><?php echo cantidadVictoriasEscuderia($escuderia, $temporadaActual); ?></td>
                    <td><?php echo cantidadVueltasRapidasEscuderia($escuderia, $temporadaActual); ?></td>
                    <td><?php echo cantidadPolesEscuderia($escuderia, $temporadaActual); ?></td>
                    <td><?php echo cantidadAbandonosEscuderia($escuderia, $temporadaActual); ?></td>
                  </tr>
              <?php
                }
              ?>
            </tbody>
          </table>

          <!-- Conecto a la base de datos y cargo las carreras - Generando un array por cada una -->
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

            while($carreras = $resultadoCarreras->fetch_assoc()){
              $carrerasTemporada[$carreras['nombre']] = $carreras;
            }
          ?>

          <!-- Seleccionar Carrera -->
          <form action="#" id="elegirCarrera" method="GET" style="padding: 50px 0 50px 0;">
              <select class="form-control">
                  <option disabled selected>Selecciona una carrera</option>
                  <?php 
                    foreach ($carrerasTemporada as $carrera) {
                  ?>
                      <option value="<?php echo valorCarrera($carrera['nombre']); ?>"><?php echo $carrera['nombre']; ?></option>
                  <?php 
                    }
                  ?>
              </select>
          </form>
          
          <!-- Establezco la cantidad de pilotos que participan por carrera -->
          <?php 
            $cantidadPilotos = 20;
            if(in_array($temporadaActual, $temporadaCon22Pilotos)) $cantidadPilotos = 22;
          ?>

          <!-- Carreras -->
          <?php 
            while($pista = $resultadoPistas->fetch_assoc()){
              $nombrePista = $pista['pais'] . ' - ' . $pista['ciudad'];
          ?>
              <table class="table <?php echo str_replace(' ', '', $pista['ciudad']); ?>" style="display: none">
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