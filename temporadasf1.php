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

          <!-- Australia -->
          <table class="table Melbourne" style="display: none">
            <thead class="text-center" style="background-color:rgb(0, 0, 110);">
              <tr>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Melbourne</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">---</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Australia</h3></th>
                <th scope="col" width="25%" class="text-right"><img src="images/Paises/australia.png" alt="Bandera" width="50%"></img></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr style="font-weight: bold; background-color:rgb(0, 0, 110); color:red;">
                <th scope="row">#</th>
                <td>Piloto</td>
                <td>Escuderia</td>
                <td>Puntos</td>
              </tr>
              <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Australia - Melbourne']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Australia - Melbourne']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Australia - Melbourne']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
            </tbody>
            <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Vuelta Rápida</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Australia - Melbourne']['vuelta_rapida']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Pole</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Australia - Melbourne']['pole']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Piloto del Día</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Australia - Melbourne']['piloto_del_dia']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
          </table>

          <!-- Bahrein -->
          <table class="table Sahkir" style="display: none">
            <thead class="text-center" style="background-color:#dc3545;">
              <tr>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Sahkir</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">---</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Bahrein</h3></th>
                <th scope="col" width="25%" class="text-right"><img src="images/Paises/bahrein.png" alt="Bandera" width="50%"></img></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr style="font-weight: bold; background-color:#dc3545; color:white;">
                <th scope="row">#</th>
                <td>Piloto</td>
                <td>Escuderia</td>
                <td>Puntos</td>
              </tr>
              <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Bahrein - Sahkir']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Bahrein - Sahkir']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Bahrein - Sahkir']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
            </tbody>
            <tfoot class="text-center" style="background-color:#dc3545; color:white;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Vuelta Rápida</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Bahrein - Sahkir']['vuelta_rapida']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:#dc3545; color:white;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Pole</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Bahrein - Sahkir']['pole']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:#dc3545; color:white;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Piloto del Día</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Bahrein - Sahkir']['piloto_del_dia']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
          </table>

          <!-- China -->
          <table class="table Shangai" style="display: none">
            <thead class="text-center" style="background-color:red;">
              <tr>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:yellow;">Shangai</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:yellow;">---</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:yellow;">China</h3></th>
                <th scope="col" width="25%" class="text-right"><img src="images/Paises/china.png" alt="Bandera" width="50%"></img></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr style="font-weight: bold; background-color:red; color:yellow;">
                <th scope="row">#</th>
                <td>Piloto</td>
                <td>Escuderia</td>
                <td>Puntos</td>
              </tr>
              <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['China - Shangai']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['China - Shangai']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['China - Shangai']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
            </tbody>
            <tfoot class="text-center" style="background-color:red; color:yellow;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Vuelta Rápida</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['China - Shangai']['vuelta_rapida']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:red; color:yellow;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Pole</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['China - Shangai']['pole']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:red; color:yellow;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Piloto del Día</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['China - Shangai']['piloto_del_dia']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
          </table>

          <!-- Azerbaiyan -->
          <table class="table Baku" style="display: none">
            <thead class="text-center" style="background-color:#67bd52;">
              <tr>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:blue;">Baku</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:blue;">---</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:blue;">Azerbaiyan</h3></th>
                <th scope="col" width="25%" class="text-right"><img src="images/Paises/azerbaiyan.png" alt="Bandera" width="50%"></img></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr style="font-weight: bold; background-color:#67bd52; color:blue;">
                <th scope="row">#</th>
                <td>Piloto</td>
                <td>Escuderia</td>
                <td>Puntos</td>
              </tr>
              <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Azerbaiyan - Baku']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Azerbaiyan - Baku']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Azerbaiyan - Baku']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
            </tbody>
            <tfoot class="text-center" style="background-color:#67bd52; color:blue;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Vuelta Rápida</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Azerbaiyan - Baku']['vuelta_rapida']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:#67bd52; color:blue;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Pole</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Azerbaiyan - Baku']['pole']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:#67bd52; color:blue;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Piloto del Día</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Azerbaiyan - Baku']['piloto_del_dia']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
          </table>

          <!-- España -->
          <table class="table Catalunya" style="display: none">
            <thead class="text-center" style="background-color:yellow;">
              <tr>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Barcelona</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">---</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">España</h3></th>
                <th scope="col" width="25%" class="text-right"><img src="images/Paises/españa.jpg" alt="Bandera" width="50%"></img></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr style="font-weight: bold; background-color:yellow; color:red;">
                <th scope="row">#</th>
                <td>Piloto</td>
                <td>Escuderia</td>
                <td>Puntos</td>
              </tr>
              <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['España - Catalunya']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['España - Catalunya']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['España - Catalunya']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
            </tbody>
            <tfoot class="text-center" style="background-color:yellow; color:red;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Vuelta Rápida</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Catalunya']['vuelta_rapida']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:yellow; color:red;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Pole</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Catalunya']['pole']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:yellow; color:red;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Piloto del Día</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Catalunya']['piloto_del_dia']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
          </table>

          <table class="table Jerez" style="display: none">
            <thead class="text-center" style="background-color:yellow;">
              <tr>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Jerez</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">---</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">España</h3></th>
                <th scope="col" width="25%" class="text-right"><img src="images/Paises/españa.jpg" alt="Bandera" width="50%"></img></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr style="font-weight: bold; background-color:yellow; color:red;">
                <th scope="row">#</th>
                <td>Piloto</td>
                <td>Escuderia</td>
                <td>Puntos</td>
              </tr>
              <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['España - Jerez']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['España - Jerez']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['España - Jerez']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
            </tbody>
            <tfoot class="text-center" style="background-color:yellow; color:red;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Vuelta Rápida</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Jerez']['vuelta_rapida']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:yellow; color:red;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Pole</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Jerez']['pole']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:yellow; color:red;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Piloto del Día</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Jerez']['piloto_del_dia']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
          </table>

          <!-- Monaco -->
          <table class="table Montecarlo" style="display: none">
            <thead class="text-center" style="background-color:red;">
              <tr>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Montecarlo</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">---</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Monaco</h3></th>
                <th scope="col" width="25%" class="text-right"><img src="images/Paises/monaco.JPG" alt="Bandera" width="50%"></img></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr style="font-weight: bold; background-color:red; color:white;">
                <th scope="row">#</th>
                <td>Piloto</td>
                <td>Escuderia</td>
                <td>Puntos</td>
              </tr>
              <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Monaco - Montecarlo']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Monaco - Montecarlo']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Monaco - Montecarlo']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
            </tbody>
            <tfoot class="text-center" style="background-color:red; color:white;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Vuelta Rápida</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Monaco - Montecarlo']['vuelta_rapida']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:red; color:white;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Pole</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Monaco - Montecarlo']['pole']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:red; color:white;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Piloto del Día</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Monaco - Montecarlo']['piloto_del_dia']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
          </table>

          <!-- Canada -->
          <table class="table Montreal" style="display: none">
            <thead class="text-center" style="background-color:red;">
              <tr>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Montreal</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">---</h3></th>
                <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Canada</h3></th>
                <th scope="col" width="25%" class="text-right"><img src="images/Paises/canada.svg" alt="Bandera" width="50%"></img></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr style="font-weight: bold; background-color:red; color:white;">
                <th scope="row">#</th>
                <td>Piloto</td>
                <td>Escuderia</td>
                <td>Puntos</td>
              </tr>
              <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Canada - Montreal']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Canada - Montreal']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Canada - Montreal']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
            </tbody>
            <tfoot class="text-center" style="background-color:red; color:white;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Vuelta Rápida</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Canada - Montreal']['vuelta_rapida']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:red; color:white;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Pole</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Canada - Montreal']['pole']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
            <tfoot class="text-center" style="background-color:red; color:white;">
              <th width="25%" scope="row"></th>
              <th width="25%" scope="row">Piloto del Día</th>
              <th width="25%" scope="row"><?php echo $carrerasTemporada['Canada - Montreal']['piloto_del_dia']; ?></th>
              <th width="25%" scope="row"></th>
            </tfoot>
          </table>

          <!-- Francia -->
          <table class="table LeCastellet" style="display: none">
              <thead class="text-center" style="background-color:blue;">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Paul Ricard</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Francia</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/francia.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:blue; color:white;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Francia - Le Castellet']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Francia - Le Castellet']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Francia - Le Castellet']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:blue; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Francia - Le Castellet']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:blue; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Francia - Le Castellet']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:blue; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Francia - Le Castellet']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Austria -->
          <table class="table Spielberg" style="display: none">
              <thead class="text-center" style="background-color:red;">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Red Bull Ring</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Austria</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/austria.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:red; color:white;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Austria - Spielberg']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Austria - Spielberg']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Austria - Spielberg']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Austria - Spielberg']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Austria - Spielberg']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Austria - Spielberg']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Gran Bretaña -->
          <table class="table Silverstone" style="display: none">
              <thead class="text-center" style="background-color:rgb(0, 0, 110);">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Silverstone</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Gran Bretaña</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/gran_bretaña.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:rgb(0, 0, 110); color:red;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Gran Bretaña - Silverstone']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Gran Bretaña - Silverstone']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Gran Bretaña - Silverstone']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Gran Bretaña - Silverstone']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Gran Bretaña - Silverstone']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Gran Bretaña - Silverstone']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Alemania -->
          <table class="table Hockenheim" style="display: none">
              <thead class="text-center" style="background-color:black;">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Hockenheim</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Alemania</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/alemania.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:black; color:yellow;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Alemania - Hockenheim']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Alemania - Hockenheim']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Alemania - Hockenheim']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:black; color:yellow;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Alemania - Hockenheim']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:black; color:yellow;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Alemania - Hockenheim']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:black; color:yellow;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Alemania - Hockenheim']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Hungria -->
          <table class="table Mogyrod" style="display: none">
              <thead class="text-center" style="background-color:rgb(0, 228, 19);">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Hungaroring</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Hungria</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/hungria.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:rgb(0, 228, 19); color:red;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Hungria - Mogyrod']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Hungria - Mogyrod']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Hungria - Mogyrod']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Hungria - Mogyrod']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Hungria - Mogyrod']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Hungria - Mogyrod']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Belgica -->
          <table class="table Spa" style="display: none">
              <thead class="text-center" style="background-color:red;">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:yellow;">Spa</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:yellow;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:yellow;">Belgica</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/belgica.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:black; color:yellow;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Belgica - Spa']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Belgica - Spa']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Belgica - Spa']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:black; color:yellow;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Belgica - Spa']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:black; color:yellow;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Belgica - Spa']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:black; color:yellow;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Belgica - Spa']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Italia -->
          <table class="table Monza" style="display: none">
              <thead class="text-center" style="background-color:rgb(0, 228, 19);">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Monza</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Italia</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/italia.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:rgb(0, 228, 19); color:red;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Italia - Monza']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Italia - Monza']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Italia - Monza']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Italia - Monza']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Italia - Monza']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Italia - Monza']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Singapur -->
          <table class="table MarinaBay" style="display: none">
              <thead class="text-center" style="background-color:red;">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Marina Bay</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Singapur</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/singapur.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:red; color:white;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Singapur - Marina Bay']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Singapur - Marina Bay']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Singapur - Marina Bay']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Singapur - Marina Bay']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Singapur - Marina Bay']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Singapur - Marina Bay']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Rusia -->
          <table class="table Sochi" style="display: none">
              <thead class="text-center" style="background-color:blue;">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Sochi</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Rusia</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/rusia.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:blue; color:white;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Rusia - Sochi']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Rusia - Sochi']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Rusia - Sochi']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:blue; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Rusia - Sochi']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:blue; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Rusia - Sochi']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:blue; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Rusia - Sochi']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Japon -->
          <table class="table Suzuka" style="display: none">
              <thead class="text-center" style="background-color:red;">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Suzuka</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Japon</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/japon.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:red; color:white;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Japon - Suzuka']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Japon - Suzuka']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Japon - Suzuka']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Japon - Suzuka']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Japon - Suzuka']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Japon - Suzuka']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Malasia -->
          <table class="table KualaLampur" style="display: none">
              <thead class="text-center" style="background-color:red;">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Kuala Lampur</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Malasia</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/malasia.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:red; color:white;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Malasia - Kuala Lampur']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Malasia - Kuala Lampur']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Malasia - Kuala Lampur']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Malasia - Kuala Lampur']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Malasia - Kuala Lampur']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:red; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Malasia - Kuala Lampur']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Mexico -->
          <table class="table MexicoDF" style="display: none">
              <thead class="text-center" style="background-color:rgb(4, 116, 0);">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">D.F.</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Mexico</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/mexico.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:rgb(4, 116, 0); color:red;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Mexico - Mexico DF']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Mexico - Mexico DF']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Mexico - Mexico DF']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:rgb(4, 116, 0); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Mexico - Mexico DF']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(4, 116, 0); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Mexico - Mexico DF']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(4, 116, 0); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Mexico - Mexico DF']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- EEUU -->
          <table class="table Texas" style="display: none">
              <thead class="text-center" style="background-color:red;">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Austin</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">EEUU</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/eeuu.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:blue; color:white;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['EEUU - Texas']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['EEUU - Texas']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['EEUU - Texas']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:blue; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['EEUU - Texas']['vuelta_rapida'] ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:blue; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['EEUU - Texas']['pole'] ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:blue; color:white;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['EEUU - Texas']['piloto_del_dia'] ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Brasil -->
          <table class="table SaoPablo" style="display: none">
              <thead class="text-center" style="background-color:rgb(44, 236, 76);">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:blue;">Interlagos</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:blue;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:blue;">Brasil</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/brasil.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:rgb(44, 236, 76); color:yellow;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Brasil - Sao Pablo']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Brasil - Sao Pablo']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Brasil - Sao Pablo']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:rgb(44, 236, 76); color:yellow;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Brasil - Sao Pablo']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(44, 236, 76); color:yellow;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Brasil - Sao Pablo']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(44, 236, 76); color:yellow;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Brasil - Sao Pablo']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>

          <!-- Emiratos Arabes -->
          <table class="table AbuDhabi" style="display: none">
              <thead class="text-center" style="background-color:rgb(50, 177, 0);">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Abu Dhabi</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">---</h3></th>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Emiratos Arabes</h3></th>
                  <th scope="col" width="25%" class="text-right"><img src="images/Paises/emiratos_arabes.svg" alt="Bandera" width="50%"></img></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr style="font-weight: bold; background-color:rgb(50, 177, 0); color:white;">
                  <th scope="row">#</th>
                  <td>Piloto</td>
                  <td>Escuderia</td>
                  <td>Puntos</td>
                </tr>
                <?php 
                  $posicionesPilotos = json_decode($carrerasTemporada['Emiratos Arabes - Abu Dhabi']['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Emiratos Arabes - Abu Dhabi']['posiciones_escuderias'], true);
                  for($i = 1; $i <= $cantidadPilotos; $i++){
                ?>
                  <tr>
                    <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Emiratos Arabes - Abu Dhabi']['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                    <td><?php echo $posicionesPilotos[$i]; ?></td>
                    <td><?php echo $posicionesEscuderias[$i]; ?></td>
                    <td><?php echo calcularPuntos($i, $_GET['temporada']); ?></td>
                  </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:rgb(50, 177, 0); color:black;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Emiratos Arabes - Abu Dhabi']['vuelta_rapida']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(50, 177, 0); color:black;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Emiratos Arabes - Abu Dhabi']['pole']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(50, 177, 0); color:black;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Emiratos Arabes - Abu Dhabi']['piloto_del_dia']; ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
          </table>
        </div>
    <?php 
      }
    ?>

    <?php include('templates/scripts.php') ?>
  </body>
</html>