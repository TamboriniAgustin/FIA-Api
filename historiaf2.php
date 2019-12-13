<!DOCTYPE html>
<html lang="en">
  <?php include('templates/head.php') ?>
  <body>
    <a href="index.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <?php include('funcionesf2.php'); ?> 

    <!-- Cargo las temporadas que hayan formado parte de la historia de la F2 -->
    <?php 
         try {
            require('db/conexion.php');
  
            $cargarTemporadas = " SELECT * FROM temporadas ";
            $resultadoTemporada = $con->query($cargarTemporadas);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $temporadasF2 = array();
          while ($temporadas = $resultadoTemporada->fetch_assoc()) {
            array_push($temporadasF2, $temporadas);
          }
    ?>
    <!-- Cargo las carreras que hayan formado parte de la historia de la F2 -->
    <?php 
         try {
            require('db/conexion.php');
  
            $cargarCarreras = " SELECT * FROM carreras WHERE categoria = 'f2' ORDER BY temporada DESC ";
            $resultadoCarrera = $con->query($cargarCarreras);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $carrerasF2 = array();
          while ($carreras = $resultadoCarrera->fetch_assoc()) {
            array_push($carrerasF2, $carreras);
          }
    ?>
    <!-- Cargo los pilotos que participaron en alguna temporada de F2 -->
    <?php 
         try {
            require('db/conexion.php');
  
            $cargarPilotosTemporada = " SELECT * FROM pilotos ORDER BY apellido";
            $resultadoTemporada = $con->query($cargarPilotosTemporada);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $pilotosF2 = array();
          while ($pilotos = $resultadoTemporada->fetch_assoc()) {
            $esPilotoDeF2 = corrioEnF2($pilotos['nombre'] . ' ' . $pilotos['apellido'], 'piloto', $carrerasF2);
            if($esPilotoDeF2){
                array_push($pilotosF2, $pilotos);
            }
          }
    ?>
    <!-- Cargo las escuderias que participaron en alguna temporada de F2 -->
    <?php 
         try {
            require('db/conexion.php');
  
            $cargarEscuderiasTemporada = " SELECT * FROM escuderias ORDER BY nombre";
            $resultadoTemporada = $con->query($cargarEscuderiasTemporada);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $escuderiasF2 = array();
          while ($escuderias = $resultadoTemporada->fetch_assoc()) {
            $esEscuderiaDeF2 = corrioEnF2($escuderias['nombre'], 'escuderia', $carrerasF2);
            if($esEscuderiaDeF2){
                array_push($escuderiasF2, $escuderias);
            }
          }
    ?>

    <div style="margin-top: 50px;">
        <!-- Pilotos -->
        <h3 class="text-center">Pilotos</h3>
            <div class="tabla-pilotos">
                <table id="tabla-pilotos" class="table">
                    <thead class="text-center" style="color:white; background-color:#007bff;">
                        <tr>
                        <th scope="col" width="75%">Piloto</th>
                        <th scope="col">Carreras Corridas</th>
                        <th scope="col">Poles</th>
                        <th scope="col">Podios</th>
                        <th scope="col">Vueltas Rápidas</th>
                        <th scope="col">Abandonos</th>
                        <th scope="col">Puntos Totales</th>
                        <th scope="col">Victorias</th>
                        <th scope="col">Campeonatos del Mundo</th>
                        <th scope="col">Última Participación</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php 
                            foreach ($pilotosF2 as $piloto) {
                                $nombrePiloto = $piloto['nombre'] . ' ' . $piloto['apellido'];
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $nombrePiloto; ?></th>
                                    <th scope="row"><?php echo carrerasEnF2($nombrePiloto, 'piloto', $carrerasF2); ?></th>
                                    <th scope="row"><?php echo polesEnF2($nombrePiloto, 'piloto', $carrerasF2); ?></th>
                                    <th scope="row"><?php echo podiosEnF2($nombrePiloto, 'piloto', $carrerasF2); ?></th>
                                    <th scope="row"><?php echo vueltasRapidasEnF2($nombrePiloto, 'piloto', $carrerasF2); ?></th>
                                    <th scope="row"><?php echo abandonosEnF2($nombrePiloto, 'piloto', $carrerasF2); ?></th>
                                    <th scope="row"><?php echo puntosTotalesDeF2($nombrePiloto, 'piloto', $temporadasF2); ?></th>
                                    <th scope="row"><?php echo victoriasEnF2($nombrePiloto, 'piloto', $carrerasF2); ?></th>
                                    <th scope="row"><?php echo mundialesDeF2($nombrePiloto, 'piloto', $temporadasF2); ?></th>
                                    <th scope="row"><?php echo ultimaParticipacionEnF2($nombrePiloto, 'piloto', $carrerasF2); ?></th>
                                </tr>
                        <?php 
                            }
                        ?>
                    </tbody>
                </table>
            </div>

        <div class="d-flex justify-content-between" style="margin-bottom:30px; margin-top:30px;">
            <div class="piloto1">
                <select id="piloto1" class="browser-default custom-select">
                    <option value="nada" disabled selected>Selecciona un piloto</option>
                    <?php 
                        foreach ($pilotosF2 as $piloto) {
                        $nombrePiloto = $piloto['nombre'] . ' ' . $piloto['apellido'];
                    ?>
                            <option value="<?php echo $piloto['id']; ?>"><?php echo $nombrePiloto; ?></option>
                    <?php 
                        }
                    ?>
                </select>
            </div>
            <div class="enviar">
                <button type="button" id="boton_pilotos" class="btn btn-primary" disabled>Enviar</button>
            </div>
            <div class="piloto2">
                <select id="piloto2" class="browser-default custom-select">
                    <option value="nada" disabled selected>Selecciona un piloto</option>
                    <?php 
                    foreach ($pilotosF2 as $piloto) {
                        $nombrePiloto = $piloto['nombre'] . ' ' . $piloto['apellido'];
                    ?>
                        <option value="<?php echo $piloto['id']; ?>"><?php echo $nombrePiloto; ?></option>
                    <?php 
                        }
                    ?>
                </select>
            </div>
        </div>

        <!-- Escuderias -->
        <h3 class="text-center">Escuderias</h3>
            <div class="tabla-escuderias">
                <table id="tabla-escuderias" class="table">
                    <thead class="text-center" style="color:white; background-color:#007bff;">
                        <tr>
                        <th scope="col" width="75%">Escuderia</th>
                        <th scope="col">Carreras Corridas</th>
                        <th scope="col">Poles</th>
                        <th scope="col">Podios</th>
                        <th scope="col">Vueltas Rápidas</th>
                        <th scope="col">Abandonos</th>
                        <th scope="col">Puntos Totales</th>
                        <th scope="col">Victorias</th>
                        <th scope="col">Campeonatos del Mundo</th>
                        <th scope="col">Última Participación</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php 
                        foreach ($escuderiasF2 as $escuderia) {
                    ?>
                            <tr>
                            <th scope="row"><?php echo $escuderia['nombre']; ?></th>
                                <th scope="row"><?php echo carrerasEnF2($escuderia['nombre'], 'escuderia', $carrerasF2); ?></th>
                                <th scope="row"><?php echo polesEnF2($escuderia['nombre'], 'escuderia', $carrerasF2); ?></th>
                                <th scope="row"><?php echo podiosEnF2($escuderia['nombre'], 'escuderia', $carrerasF2); ?></th>
                                <th scope="row"><?php echo vueltasRapidasEnF2($escuderia['nombre'], 'escuderia', $carrerasF2); ?></th>
                                <th scope="row"><?php echo abandonosEnF2($escuderia['nombre'], 'escuderia', $carrerasF2); ?></th>
                                <th scope="row"><?php echo puntosTotalesDeF2($escuderia['nombre'], 'escuderia', $temporadasF2); ?></th>
                                <th scope="row"><?php echo victoriasEnF2($escuderia['nombre'], 'escuderia', $carrerasF2); ?></th>
                                <th scope="row"><?php echo mundialesDeF2($escuderia['nombre'], 'escuderia', $temporadasF2); ?></th>
                                <th scope="row"><?php echo ultimaParticipacionEnF2($escuderia['nombre'], 'escuderia', $carrerasF2); ?></th>
                            </tr>
                    <?php 
                        }
                    ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between" style="margin-bottom:30px; margin-top:30px;">
                <div class="escuderia1">
                    <select id="escuderia1" class="browser-default custom-select">
                        <option value="" disabled selected>Selecciona una escuderia</option>
                        <?php 
                            foreach ($escuderiasF2 as $escuderia) {
                        ?>
                                <option value="<?php echo $escuderia['id'] ?>"><?php echo $escuderia['nombre']; ?></option>
                        <?php 
                            }
                        ?>
                    </select>
                </div>
                <div class="enviar">
                    <button id="boton_escuderias" type="button" class="btn btn-primary" disabled>Enviar</button>
                </div>
                <div class="escuderia2">
                    <select id="escuderia2" class="browser-default custom-select">
                        <option value="" disabled selected>Selecciona una escuderia</option>
                        <?php 
                            foreach ($escuderiasF2 as $escuderia) {
                        ?>
                                <option value="<?php echo $escuderia['id'] ?>"><?php echo $escuderia['nombre']; ?></option>
                        <?php 
                            }
                        ?>
                    </select>
                </div>
            </div>
        
    </div>

    <?php include('templates/scripts.php') ?>
  </body>
</html>