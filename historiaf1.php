<!DOCTYPE html>
<html lang="en">
  <?php include('templates/head.php') ?>
  <body>
    <a href="index.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <?php include('funcionesf1.php'); ?> 

    <!-- Cargo las temporadas que hayan formado parte de la historia de la F1 -->
    <?php 
         try {
            require('db/conexion.php');
  
            $cargarTemporadas = " SELECT * FROM temporadas ";
            $resultadoTemporada = $con->query($cargarTemporadas);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $temporadasF1 = array();
          while ($temporadas = $resultadoTemporada->fetch_assoc()) {
            array_push($temporadasF1, $temporadas);
          }
    ?>
    <!-- Cargo las carreras que hayan formado parte de la historia de la F1 -->
    <?php 
         try {
            require('db/conexion.php');
  
            $cargarCarreras = " SELECT * FROM carreras WHERE categoria = 'f1' ORDER BY temporada DESC ";
            $resultadoCarrera = $con->query($cargarCarreras);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $carrerasF1 = array();
          while ($carreras = $resultadoCarrera->fetch_assoc()) {
            array_push($carrerasF1, $carreras);
          }
    ?>
    <!-- Cargo los pilotos que participaron en alguna temporada de F1 -->
    <?php 
         try {
            require('db/conexion.php');
  
            $cargarPilotosTemporada = " SELECT * FROM pilotos ORDER BY apellido";
            $resultadoTemporada = $con->query($cargarPilotosTemporada);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $pilotosF1 = array();
          while ($pilotos = $resultadoTemporada->fetch_assoc()) {
            $esPilotoDeF1 = corrioEnF1($pilotos['nombre'] . ' ' . $pilotos['apellido'], 'piloto', $carrerasF1);
            if($esPilotoDeF1){
                array_push($pilotosF1, $pilotos);
            }
          }
    ?>
    <!-- Cargo las escuderias que participaron en alguna temporada de F1 -->
    <?php 
         try {
            require('db/conexion.php');
  
            $cargarEscuderiasTemporada = " SELECT * FROM escuderias ORDER BY nombre";
            $resultadoTemporada = $con->query($cargarEscuderiasTemporada);
  
          } catch (\Exception $e) {
            $error = $e->getMessage();
          }

          $escuderiasF1 = array();
          while ($escuderias = $resultadoTemporada->fetch_assoc()) {
            $esEscuderiaDeF1 = corrioEnF1($escuderias['nombre'], 'escuderia', $carrerasF1);
            if($esEscuderiaDeF1){
                array_push($escuderiasF1, $escuderias);
            }
          }
    ?>

    <div style="margin-top: 50px;">
        <!-- Pilotos -->
        <h3 class="text-center">Pilotos</h3>
            <div class="tabla-pilotos">
                <table id="tabla-pilotos" class="table">
                    <thead class="text-center" style="color:white; background-color:#dc3545;">
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
                            foreach ($pilotosF1 as $piloto) {
                                $nombrePiloto = $piloto['nombre'] . ' ' . $piloto['apellido'];
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $nombrePiloto; ?></th>
                                    <th scope="row"><?php echo carrerasEnF1($nombrePiloto, 'piloto', $carrerasF1); ?></th>
                                    <th scope="row"><?php echo polesEnF1($nombrePiloto, 'piloto', $carrerasF1); ?></th>
                                    <th scope="row"><?php echo podiosEnF1($nombrePiloto, 'piloto', $carrerasF1); ?></th>
                                    <th scope="row"><?php echo vueltasRapidasEnF1($nombrePiloto, 'piloto', $carrerasF1); ?></th>
                                    <th scope="row"><?php echo abandonosEnF1($nombrePiloto, 'piloto', $carrerasF1); ?></th>
                                    <th scope="row"><?php echo puntosTotalesDeF1($nombrePiloto, 'piloto', $temporadasF1); ?></th>
                                    <th scope="row"><?php echo victoriasEnF1($nombrePiloto, 'piloto', $carrerasF1); ?></th>
                                    <th scope="row"><?php echo mundialesDeF1($nombrePiloto, 'piloto', $temporadasF1); ?></th>
                                    <th scope="row"><?php echo ultimaParticipacionEnF1($nombrePiloto, 'piloto', $carrerasF1); ?></th>
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
                            foreach ($pilotosF1 as $piloto) {
                            $nombrePiloto = $piloto['nombre'] . ' ' . $piloto['apellido'];
                        ?>
                                <option value="<?php echo $piloto['id']; ?>"><?php echo $nombrePiloto; ?></option>
                        <?php 
                            }
                        ?>
                    </select>
                </div>
                <div class="enviar">
                    <button type="button" id="boton_pilotos" class="btn btn-danger" disabled>Enviar</button>
                </div>
                <div class="piloto2">
                    <select id="piloto2" class="browser-default custom-select">
                        <option value="nada" disabled selected>Selecciona un piloto</option>
                        <?php 
                        foreach ($pilotosF1 as $piloto) {
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
                    <thead class="text-center" style="color:white; background-color:#dc3545;">
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
                        foreach ($escuderiasF1 as $escuderia) {
                    ?>
                            <tr>
                                <th scope="row"><?php echo $escuderia['nombre']; ?></th>
                                <th scope="row"><?php echo carrerasEnF1($escuderia['nombre'], 'escuderia', $carrerasF1); ?></th>
                                <th scope="row"><?php echo polesEnF1($escuderia['nombre'], 'escuderia', $carrerasF1); ?></th>
                                <th scope="row"><?php echo podiosEnF1($escuderia['nombre'], 'escuderia', $carrerasF1); ?></th>
                                <th scope="row"><?php echo vueltasRapidasEnF1($escuderia['nombre'], 'escuderia', $carrerasF1); ?></th>
                                <th scope="row"><?php echo abandonosEnF1($escuderia['nombre'], 'escuderia', $carrerasF1); ?></th>
                                <th scope="row"><?php echo puntosTotalesDeF1($escuderia['nombre'], 'escuderia', $temporadasF1); ?></th>
                                <th scope="row"><?php echo victoriasEnF1($escuderia['nombre'], 'escuderia', $carrerasF1); ?></th>
                                <th scope="row"><?php echo mundialesDeF1($escuderia['nombre'], 'escuderia', $temporadasF1); ?></th>
                                <th scope="row"><?php echo ultimaParticipacionEnF1($escuderia['nombre'], 'escuderia', $carrerasF1); ?></th>
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
                            foreach ($escuderiasF1 as $escuderia) {
                        ?>
                                <option value="<?php echo $escuderia['id'] ?>"><?php echo $escuderia['nombre']; ?></option>
                        <?php 
                            }
                        ?>
                    </select>
                </div>
                <div class="enviar">
                    <button id="boton_escuderias" type="button" class="btn btn-danger" disabled>Enviar</button>
                </div>
                <div class="escuderia2">
                    <select id="escuderia2" class="browser-default custom-select">
                        <option value="" disabled selected>Selecciona una escuderia</option>
                        <?php 
                            foreach ($escuderiasF1 as $escuderia) {
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