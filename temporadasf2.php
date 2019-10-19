<!DOCTYPE html>
<html lang="en">
  <?php include('templates/head.php') ?>
  <body>
    <a href="index.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <?php include('funcionesf2.php'); ?>

    <!-- Conecto a la base de datos y cargo las temporadas -->
    <?php 
      try {
        require('db/conexion.php');

        $cargarTemporadas = ' SELECT * FROM temporadas WHERE año >= "2017" ORDER BY año DESC';
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

          $cargarPilotosTemporada = " SELECT pilotosF2 FROM temporadas WHERE año = $temporadaActual ";
          $resultadoTemporada = $con->query($cargarPilotosTemporada);

          $pilotosTemporada = $resultadoTemporada->fetch_assoc()['pilotosF2'];
          $pilotosTemporada = str_replace('{', '', $pilotosTemporada);
          $pilotosTemporada = str_replace('}', '', $pilotosTemporada);
          $pilotosTemporada = explode(',', $pilotosTemporada);

          $cargarEscuderiasTemporada = " SELECT escuderiasF2 FROM temporadas WHERE año = $temporadaActual ";
          $resultadoTemporada = $con->query($cargarEscuderiasTemporada);

          $escuderiasTemporada = $resultadoTemporada->fetch_assoc()['escuderiasF2'];
          $escuderiasTemporada = str_replace('{', '', $escuderiasTemporada);
          $escuderiasTemporada = str_replace('}', '', $escuderiasTemporada);
          $escuderiasTemporada = explode(',', $escuderiasTemporada);
        } catch (\Exception $e) {
          $error = $e->getMessage();
        }
    ?>

        <div class="container contenido">
          <!-- Tabla de Posiciones del Mundial -->
          <h3 class="mb-2 bread text-center" style="color:#007bff; padding: 20px;">Mundial de Pilotos</h3>
          <table class="table table-posiciones">
            <thead class="text-center" style="color:white; background-color:#007bff;">
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
                      if($temporadaActual >= 2017){
                    ?>
                        <td><?php echo calcularPuntosPiloto($piloto, $temporadaActual) + (2 * cantidadVueltasRapidasPiloto($piloto, $temporadaActual)) + (4 * cantidadPolesPiloto($piloto, $temporadaActual)); ?></td>
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

          <h3 class="mb-2 bread text-center" style="color:#007bff; padding: 20px;">Mundial de Escuderias</h3>
          <table class="table table-posicionesE">
            <thead class="text-center" style="color:white; background-color:#007bff;">
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
              foreach ($escuderiasTemporada as $escuderia){
            ?>
                <tr>
                  <td><?php echo $escuderia; ?></td>
                  <?php 
                    if($temporadaActual >= 2017){
                  ?>
                      <td><?php echo calcularPuntosEscuderia($escuderia, $temporadaActual) + (2 * cantidadVueltasRapidasEscuderia($escuderia, $temporadaActual)) + (4 * cantidadPolesEscuderia($escuderia, $temporadaActual)); ?></td>
                  <?php 
                    }
                  ?>
                  <td><?php echo cantidadVictoriasEscuderia($escuderia, $temporadaActual) ?></td>
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

              $cargarCarreras = "SELECT * FROM carreras WHERE categoria = 'f2' AND temporada = $temporadaActual";
              $resultadoCarreras = $con->query($cargarCarreras);
            } catch (\Exception $e) {
              $error = $e->getMessage();
            }

            while($carreras = $resultadoCarreras->fetch_assoc()){
              //var_dump ($carreras);
              if($carrerasTemporada[$carreras['nombre']]){
                $carrerasTemporada[$carreras['nombre']][2] = $carreras;
              }
              else{
                $carrerasTemporada[$carreras['nombre']][1] = $carreras;
              }
            }
          ?>

          <!-- Seleccionar Carrera -->
          <form action="#" id="elegirCarrera" method="GET" style="padding: 50px 0 50px 0;">
            <select class="form-control">
                <option disabled selected>Selecciona una carrera</option>
                <?php 
                  foreach ($carrerasTemporada as $carrera) {
                ?>
                    <option value="<?php echo valorCarrera($carrera[1]['nombre']); ?>"><?php echo $carrera[1]['nombre']; ?></option>
                <?php 
                  }
                ?>
            </select>
          </form>

          <!-- Australia -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="Melbourne table" style="display: none; border-right: 3px solid red;">
              <thead class="text-center" style="background-color:rgb(0, 0, 110);">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Feature Race</h3></th>
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
                  $posicionesPilotos = json_decode($carrerasTemporada['Australia - Melbourne'][1]['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Australia - Melbourne'][1]['posiciones_escuderias'], true);
                  for($i = 1; $i <= 20; $i++){
                ?>
                    <tr>
                      <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Australia - Melbourne'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                      <td><?php echo $posicionesPilotos[$i]; ?></td>
                      <td><?php echo $posicionesEscuderias[$i]; ?></td>
                      <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Australia - Melbourne'][1]['tipo']); ?></td>
                    </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Australia - Melbourne'][1]['vuelta_rapida'] ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Australia - Melbourne'][1]['pole'] ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Australia - Melbourne'][1]['piloto_del_dia'] ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              </table>
            </div>
            <div>
              <table class="Melbourne table" style="display: none">
              <thead class="text-center" style="background-color:rgb(0, 0, 110);">
                <tr>
                  <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Sprint Race</h3></th>
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
                  $posicionesPilotos = json_decode($carrerasTemporada['Australia - Melbourne'][2]['posiciones_pilotos'], true);
                  $posicionesEscuderias = json_decode($carrerasTemporada['Australia - Melbourne'][2]['posiciones_escuderias'], true);
                  for($i = 1; $i <= 20; $i++){
                ?>
                    <tr>
                      <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Australia - Melbourne'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                      <td><?php echo $posicionesPilotos[$i]; ?></td>
                      <td><?php echo $posicionesEscuderias[$i]; ?></td>
                      <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Australia - Melbourne'][2]['tipo']); ?></td>
                    </tr>
                <?php 
                  }
                ?>
              </tbody>
              <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Vuelta Rápida</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Australia - Melbourne'][2]['vuelta_rapida'] ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Pole</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Australia - Melbourne'][2]['pole'] ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                <th width="25%" scope="row"></th>
                <th width="25%" scope="row">Piloto del Día</th>
                <th width="25%" scope="row"><?php echo $carrerasTemporada['Australia - Melbourne'][2]['piloto_del_dia'] ?></th>
                <th width="25%" scope="row"></th>
              </tfoot>
              </table>
            </div>
          </div>

          <!-- Bahrein -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Sahkir" style="display: none; border-right: 3px solid white;">
                    <thead class="text-center" style="background-color:#dc3545;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Bahrein - Sahkir'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Bahrein - Sahkir'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Bahrein - Sahkir'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Bahrein - Sahkir'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:#dc3545; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Bahrein - Sahkir'][1]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:#dc3545; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Bahrein - Sahkir'][1]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:#dc3545; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Bahrein - Sahkir'][1]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
            <div>
              <table class="table Sahkir" style="display: none">
              <thead class="text-center" style="background-color:#dc3545;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Bahrein - Sahkir'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Bahrein - Sahkir'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Bahrein - Sahkir'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Bahrein - Sahkir'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:#dc3545; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Bahrein - Sahkir'][2]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:#dc3545; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Bahrein - Sahkir'][2]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:#dc3545; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Bahrein - Sahkir'][2]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
          </div>

          <!-- China -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Shangai" style="display: none; border-right: 3px solid yellow;">
                    <thead class="text-center" style="background-color:red;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:yellow;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['China - Shangai'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['China - Shangai'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['China - Shangai'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['China - Shangai'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:red; color:yellow;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['China - Shangai'][1]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:yellow;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['China - Shangai'][1]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:yellow;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['China - Shangai'][1]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
            <div>
              <table class="table Shangai" style="display: none; border-right: 3px solid yellow;">
                    <thead class="text-center" style="background-color:red;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:yellow;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['China - Shangai'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['China - Shangai'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['China - Shangai'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['China - Shangai'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:red; color:yellow;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['China - Shangai'][2]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:yellow;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['China - Shangai'][2]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:yellow;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['China - Shangai'][2]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
          </div>

          <!-- Azerbaiyan -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Baku" style="display: none; border-right: 3px solid blue;">
                    <thead class="text-center" style="background-color:#67bd52;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:blue;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Azerbaiyan - Baku'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Azerbaiyan - Baku'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Azerbaiyan - Baku'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Azerbaiyan - Baku'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:#67bd52; color:blue;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Azerbaiyan - Baku'][1]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:#67bd52; color:blue;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Azerbaiyan - Baku'][1]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:#67bd52; color:blue;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Azerbaiyan - Baku'][1]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
            <div>
              <table class="table Baku" style="display: none">
                    <thead class="text-center" style="background-color:#67bd52;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:blue;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Azerbaiyan - Baku'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Azerbaiyan - Baku'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Azerbaiyan - Baku'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Azerbaiyan - Baku'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:#67bd52; color:blue;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Azerbaiyan - Baku'][2]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:#67bd52; color:blue;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Azerbaiyan - Baku'][2]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:#67bd52; color:blue;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Azerbaiyan - Baku'][2]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
          </div>

          <!-- España -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Catalunya" style="display: none; border-right: 3px solid red">
                    <thead class="text-center" style="background-color:yellow;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['España - Catalunya'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['España - Catalunya'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['España - Catalunya'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['España - Catalunya'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Catalunya'][1]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Catalunya'][1]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Catalunya'][1]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
            <div>
              <table class="table Catalunya" style="display: none;">
                    <thead class="text-center" style="background-color:yellow;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['España - Catalunya'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['España - Catalunya'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['España - Catalunya'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['España - Catalunya'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Catalunya'][2]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Catalunya'][2]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Catalunya'][2]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
          </div>

          <div class="d-flex justify-content-around">
            <div>
              <table class="table Jerez" style="display: none; border-right: 3px solid red">
                    <thead class="text-center" style="background-color:yellow;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['España - Jerez'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['España - Jerez'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['España - Jerez'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['España - Jerez'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Jerez'][1]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Jerez'][1]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Jerez'][1]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
            <div>
              <table class="table Jerez" style="display: none;">
                    <thead class="text-center" style="background-color:yellow;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['España - Jerez'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['España - Jerez'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['España - Jerez'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['España - Jerez'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Jerez'][2]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Jerez'][2]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:yellow; color:red;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['España - Jerez'][2]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
          </div>

          <!-- Monaco -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Montecarlo" style="display: none; border-right: 3px solid white;">
                    <thead class="text-center" style="background-color:red;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Monaco - Montecarlo'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Monaco - Montecarlo'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Monaco - Montecarlo'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Monaco - Montecarlo'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Monaco - Montecarlo'][1]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Monaco - Montecarlo'][1]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Monaco - Montecarlo'][1]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
            <div>
              <table class="table Montecarlo" style="display: none">
                    <thead class="text-center" style="background-color:red;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Sprint</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Monaco - Montecarlo'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Monaco - Montecarlo'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Monaco - Montecarlo'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Monaco - Montecarlo'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Monaco - Montecarlo'][2]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Monaco - Montecarlo'][2]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Monaco - Montecarlo'][2]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
          </div>

          <!-- Canada -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Montreal" style="display: none; border-right: 3px solid white;">
                    <thead class="text-center" style="background-color:red;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Canada - Montreal'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Canada - Montreal'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Canada - Montreal'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Canada - Montreal'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Canada - Montreal'][1]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Canada - Montreal'][1]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Canada - Montreal'][1]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
            <div>
              <table class="table Montreal" style="display: none">
                    <thead class="text-center" style="background-color:red;">
                      <tr>
                        <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Canada - Montreal'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Canada - Montreal'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Canada - Montreal'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Canada - Montreal'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                    </tbody>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Vuelta Rápida</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Canada - Montreal'][2]['vuelta_rapida'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Pole</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Canada - Montreal'][2]['pole'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
                    <tfoot class="text-center" style="background-color:red; color:white;">
                      <th width="25%" scope="row"></th>
                      <th width="25%" scope="row">Piloto del Día</th>
                      <th width="25%" scope="row"><?php echo $carrerasTemporada['Canada - Montreal'][2]['piloto_del_dia'] ?></th>
                      <th width="25%" scope="row"></th>
                    </tfoot>
              </table>
            </div>
          </div>

          <!-- Francia -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table LeCastellet" style="display: none; border-right: 3px solid red;">
                <thead class="text-center" style="background-color:blue;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Francia - Le Castellet'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Francia - Le Castellet'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Francia - Le Castellet'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Francia - Le Castellet'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Francia - Le Castellet'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Francia - Le Castellet'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Francia - Le Castellet'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table LeCastellet" style="display: none">
                <thead class="text-center" style="background-color:blue;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Francia - Le Castellet'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Francia - Le Castellet'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Francia - Le Castellet'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Francia - Le Castellet'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Francia - Le Castellet'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Francia - Le Castellet'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Francia - Le Castellet'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Austria -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Spielberg" style="display: none; border-right: 3px solid white;">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Austria - Spielberg'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Austria - Spielberg'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Austria - Spielberg'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Austria - Spielberg'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Austria - Spielberg'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Austria - Spielberg'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Austria - Spielberg'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table Spielberg" style="display: none">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Austria - Spielberg'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Austria - Spielberg'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Austria - Spielberg'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Austria - Spielberg'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Austria - Spielberg'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Austria - Spielberg'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Austria - Spielberg'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Gran Bretaña -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Silverstone" style="display: none; border-right: 3px solid red;">
                <thead class="text-center" style="background-color:rgb(0, 0, 110);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Gran Bretaña - Silverstone'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Gran Bretaña - Silverstone'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Gran Bretaña - Silverstone'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Gran Bretaña - Silverstone'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Gran Bretaña - Silverstone'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Gran Bretaña - Silverstone'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Gran Bretaña - Silverstone'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table Silverstone" style="display: none">
                <thead class="text-center" style="background-color:rgb(0, 0, 110);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Gran Bretaña - Silverstone'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Gran Bretaña - Silverstone'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Gran Bretaña - Silverstone'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Gran Bretaña - Silverstone'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Gran Bretaña - Silverstone'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Gran Bretaña - Silverstone'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 0, 110); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Gran Bretaña - Silverstone'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Alemania -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Hockenheim" style="display: none; border-right: 3px solid yellow;">
                <thead class="text-center" style="background-color:black;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Alemania - Hockenheim'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Alemania - Hockenheim'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Alemania - Hockenheim'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Alemania - Hockenheim'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Alemania - Hockenheim'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Alemania - Hockenheim'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Alemania - Hockenheim'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table Hockenheim" style="display: none">
                <thead class="text-center" style="background-color:black;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Alemania - Hockenheim'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Alemania - Hockenheim'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Alemania - Hockenheim'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Alemania - Hockenheim'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Alemania - Hockenheim'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Alemania - Hockenheim'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Alemania - Hockenheim'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Hungria -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Mogyrod" style="display: none; border-right: 3px solid red;">
                <thead class="text-center" style="background-color:rgb(0, 228, 19);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Hungria - Mogyrod'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Hungria - Mogyrod'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Hungria - Mogyrod'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Hungria - Mogyrod'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Hungria - Mogyrod'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Hungria - Mogyrod'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Hungria - Mogyrod'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table Mogyrod" style="display: none">
                <thead class="text-center" style="background-color:rgb(0, 228, 19);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Hungria - Mogyrod'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Hungria - Mogyrod'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Hungria - Mogyrod'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Hungria - Mogyrod'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Hungria - Mogyrod'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Hungria - Mogyrod'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Hungria - Mogyrod'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Belgica -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Spa" style="display: none; border-right: 3px solid yellow;">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:yellow;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Belgica - Spa'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Belgica - Spa'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Belgica - Spa'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Belgica - Spa'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Belgica - Spa'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Belgica - Spa'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Belgica - Spa'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table Spa" style="display: none">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:yellow;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Belgica - Spa'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Belgica - Spa'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Belgica - Spa'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Belgica - Spa'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Belgica - Spa'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Belgica - Spa'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:black; color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Belgica - Spa'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Italia -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Monza" style="display: none; border-right: 3px solid red;">
                <thead class="text-center" style="background-color:rgb(0, 228, 19);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Italia - Monza'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Italia - Monza'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Italia - Monza'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Italia - Monza'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Italia - Monza'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Italia - Monza'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Italia - Monza'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table Monza" style="display: none">
                <thead class="text-center" style="background-color:rgb(0, 228, 19);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Italia - Monza'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Italia - Monza'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Italia - Monza'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Italia - Monza'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Italia - Monza'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Italia - Monza'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(0, 228, 19); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Italia - Monza'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Singapur -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table MarinaBay" style="display: none; border-right: 3px solid white;">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Singapur - Marina Bay'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Singapur - Marina Bay'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Singapur - Marina Bay'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Singapur - Marina Bay'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Singapur - Marina Bay'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Singapur - Marina Bay'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Singapur - Marina Bay'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table MarinaBay" style="display: none">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Singapur - Marina Bay'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Singapur - Marina Bay'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Singapur - Marina Bay'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Singapur - Marina Bay'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Singapur - Marina Bay'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Singapur - Marina Bay'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Singapur - Marina Bay'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Rusia -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Sochi" style="display: none; border-right: 3px solid red;">
                <thead class="text-center" style="background-color:blue;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Rusia - Sochi'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Rusia - Sochi'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Rusia - Sochi'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Rusia - Sochi'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Rusia - Sochi'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Rusia - Sochi'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Rusia - Sochi'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table Sochi" style="display: none">
                <thead class="text-center" style="background-color:blue;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Rusia - Sochi'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Rusia - Sochi'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Rusia - Sochi'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Rusia - Sochi'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Rusia - Sochi'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Rusia - Sochi'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Rusia - Sochi'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Japon -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Suzuka" style="display: none; border-right: 3px solid white;">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Japon - Suzuka'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Japon - Suzuka'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Japon - Suzuka'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Japon - Suzuka'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Japon - Suzuka'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Japon - Suzuka'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Japon - Suzuka'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table Suzuka" style="display: none">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Japon - Suzuka'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Japon - Suzuka'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Japon - Suzuka'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Japon - Suzuka'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Japon - Suzuka'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Japon - Suzuka'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Japon - Suzuka'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Malasia -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table KualaLampur" style="display: none; border-right: 3px solid white;">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Malasia - Kuala Lampur'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Malasia - Kuala Lampur'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Malasia - Kuala Lampur'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Malasia - Kuala Lampur'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Malasia - Kuala Lampur'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Malasia - Kuala Lampur'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Malasia - Kuala Lampur'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table KualaLampur" style="display: none">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Malasia - Kuala Lampur'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Malasia - Kuala Lampur'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Malasia - Kuala Lampur'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Malasia - Kuala Lampur'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Malasia - Kuala Lampur'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Malasia - Kuala Lampur'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:red; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Malasia - Kuala Lampur'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Mexico -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table MexicoDF" style="display: none; border-right: 3px solid red;">
                <thead class="text-center" style="background-color:rgb(4, 116, 0);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Mexico - Mexico DF'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Mexico - Mexico DF'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Mexico - Mexico DF'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Mexico - Mexico DF'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(4, 116, 0); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Mexico - Mexico DF'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(4, 116, 0); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Mexico - Mexico DF'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(4, 116, 0); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Mexico - Mexico DF'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table MexicoDF" style="display: none">
                <thead class="text-center" style="background-color:rgb(4, 116, 0);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Mexico - Mexico DF'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Mexico - Mexico DF'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Mexico - Mexico DF'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Mexico - Mexico DF'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(4, 116, 0); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Mexico - Mexico DF'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(4, 116, 0); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Mexico - Mexico DF'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(4, 116, 0); color:red;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Mexico - Mexico DF'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- EEUU -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table Texas" style="display: none; border-right: 3px solid white;">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['EEUU - Texas'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['EEUU - Texas'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['EEUU - Texas'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['EEUU - Texas'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['EEUU - Texas'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['EEUU - Texas'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['EEUU - Texas'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table Texas" style="display: none">
                <thead class="text-center" style="background-color:red;">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:white;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['EEUU - Texas'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['EEUU - Texas'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['EEUU - Texas'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['EEUU - Texas'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['EEUU - Texas'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['EEUU - Texas'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:blue; color:white;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['EEUU - Texas'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Brasil -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table SaoPablo" style="display: none; border-right: 3px solid yellow;">
                <thead class="text-center" style="background-color:rgb(44, 236, 76);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:blue;">Feature Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Brasil - Sao Pablo'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Brasil - Sao Pablo'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Brasil - Sao Pablo'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Brasil - Sao Pablo'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(44, 236, 76); color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Brasil - Sao Pablo'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(44, 236, 76); color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Brasil - Sao Pablo'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(44, 236, 76); color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Brasil - Sao Pablo'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table SaoPablo" style="display: none">
                <thead class="text-center" style="background-color:rgb(44, 236, 76);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:blue;">Sprint Race</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Brasil - Sao Pablo'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Brasil - Sao Pablo'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Brasil - Sao Pablo'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Brasil - Sao Pablo'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(44, 236, 76); color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Brasil - Sao Pablo'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(44, 236, 76); color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Brasil - Sao Pablo'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(44, 236, 76); color:yellow;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Brasil - Sao Pablo'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Emiratos Arabes -->
          <div class="d-flex justify-content-around">
            <div>
              <table class="table AbuDhabi" style="display: none; border-right: 3px solid red;">
                <thead class="text-center" style="background-color:rgb(50, 177, 0);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Feature Race</h3></th>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">---</h3></th>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Abu Dhabi</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Emiratos Arabes - Abu Dhabi'][1]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Emiratos Arabes - Abu Dhabi'][1]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Emiratos Arabes - Abu Dhabi'][1]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Emiratos Arabes - Abu Dhabi'][1]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(50, 177, 0); color:black;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Emiratos Arabes - Abu Dhabi'][1]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(50, 177, 0); color:black;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Emiratos Arabes - Abu Dhabi'][1]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(50, 177, 0); color:black;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Emiratos Arabes - Abu Dhabi'][1]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
            <div>
              <table class="table AbuDhabi" style="display: none">
                <thead class="text-center" style="background-color:rgb(50, 177, 0);">
                  <tr>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Sprint Race</h3></th>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">---</h3></th>
                    <th scope="col" width="25%"><h3 style="font-weight: bold; color:red;">Abu Dhabi</h3></th>
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
                        $posicionesPilotos = json_decode($carrerasTemporada['Emiratos Arabes - Abu Dhabi'][2]['posiciones_pilotos'], true);
                        $posicionesEscuderias = json_decode($carrerasTemporada['Emiratos Arabes - Abu Dhabi'][2]['posiciones_escuderias'], true);
                        for($i = 1; $i <= 20; $i++){
                      ?>
                        <tr>
                          <th scope="row"><?php if(strpos('{' . $carrerasTemporada['Emiratos Arabes - Abu Dhabi'][2]['abandonos'] . '}', $posicionesPilotos[$i]) == false) echo $i; else echo "DNF"; ?></th>
                          <td><?php echo $posicionesPilotos[$i]; ?></td>
                          <td><?php echo $posicionesEscuderias[$i]; ?></td>
                          <td><?php echo calcularPuntos($i, $_GET['temporada'], $carrerasTemporada['Emiratos Arabes - Abu Dhabi'][2]['tipo']); ?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                </tbody>
                <tfoot class="text-center" style="background-color:rgb(50, 177, 0); color:black;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Vuelta Rápida</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Emiratos Arabes - Abu Dhabi'][2]['vuelta_rapida'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(50, 177, 0); color:black;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Pole</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Emiratos Arabes - Abu Dhabi'][2]['pole'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
                <tfoot class="text-center" style="background-color:rgb(50, 177, 0); color:black;">
                  <th width="25%" scope="row"></th>
                  <th width="25%" scope="row">Piloto del Día</th>
                  <th width="25%" scope="row"><?php echo $carrerasTemporada['Emiratos Arabes - Abu Dhabi'][2]['piloto_del_dia'] ?></th>
                  <th width="25%" scope="row"></th>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

    <?php 
      }
    ?>

    <?php include('templates/scripts.php') ?>
  </body>
</html>