<!DOCTYPE html>
<html lang="en">
  <?php include('templates/head.php') ?>
  <body>
    <?php 
      $categoria = $_GET['categoria'];
      if($categoria == "f1") $paginaAnterior = "temporadasf1.php";
      if($categoria == "f2") $paginaAnterior = "temporadasf2.php";

      $temporada = $_GET['temporada'];
    ?>

    <a href="<?php echo $paginaAnterior; ?>"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <!-- Establezco las temporadas que tendran 22 y 24 pilotos -->
    <?php 
      $temporadaCon22Pilotos = array(2016, 2014, 2013); 
      $temporadaCon24Pilotos = array(2012, 2011, 2010);
    ?>

    <!-- Conecto a la base de datos y cargo los pilotos y escuderias, y ademas la temporada actual -->
    <?php 
      try {
        require('db/conexion.php');

        if($categoria == "f1"){
          $cargarTemporada = " SELECT pilotosF1, escuderiasF1 FROM temporadas WHERE año = $temporada";
          $resultadoTemporada = $con->query($cargarTemporada);

          $temporadaActual = $resultadoTemporada->fetch_assoc();
          $pilotosActuales = $temporadaActual['pilotosF1'];
          $escuderiasActuales = $temporadaActual['escuderiasF1'];  
        }
        else if($categoria == "f2"){
          $cargarTemporada = " SELECT pilotosF2, escuderiasF2 FROM temporadas WHERE año = $temporada";
          $resultadoTemporada = $con->query($cargarTemporada);
            
          $temporadaActual = $resultadoTemporada->fetch_assoc();
          $pilotosActuales = $temporadaActual['pilotosF2'];
          $escuderiasActuales = $temporadaActual['escuderiasF2'];  
        }

        $cargarPilotos = ' SELECT * FROM pilotos ORDER BY apellido ASC';
        $resultadoPilotos = $con->query($cargarPilotos);

        $cargarEscuderias = ' SELECT * FROM escuderias ORDER BY nombre ASC';
        $resultadoEscuderias = $con->query($cargarEscuderias);

        $cargarPistas = ' SELECT * FROM pistas ORDER BY pais';
        $resultadoPistas = $con->query($cargarPistas);
      } catch (\Exception $e) {
        $error = $e->getMessage();
      }
    ?>

    <div class="container" style="margin-top: 50px;">
        <!-- Agregar una escuderia -->
        <form id="agregar_escuderia" action="#">
            <div class="form-group row">
              <label class="col-4 col-form-label" for="nuevo_piloto">Añadir Escuderia</label> 
              <div class="col-8">
                <select id="nueva_escuderia" name="nueva_escuderia" class="custom-select" required="required" multiple="multiple">
                  <?php
                    while ($escuderias = $resultadoEscuderias->fetch_assoc()) {
                      $idEscuderia = $escuderias['id'];
                      $nombreEscuderia = $escuderias['nombre'];
                      if(strpos($escuderiasActuales, $nombreEscuderia) == false){
                  ?>
                        <option value="<?php echo $nombreEscuderia ?>" class="<?php echo $nombreEscuderia ?>"><?php echo $nombreEscuderia ?></option>
                  <?php 
                      }
                    }
                  ?>
                </select>
              </div>
            </div> 
            <div class="form-group row">
              <div class="offset-4 col-8 text-center">
                <input type="hidden" id="escuderias_categoria" value="<?php echo $categoria ?>">
                <input type="hidden" id="escuderias_temporada" value="<?php echo $temporada ?>">
                <input type="hidden" id="escuderias_actuales" value="<?php echo $escuderiasActuales ?>">
                <button name="submit" type="submit" class="btn btn-primary">Añadir</button>
              </div>
            </div>
        </form>

        <!-- Agregar un piloto -->
        <form id="agregar_piloto" action="#">
            <div class="form-group row">
              <label class="col-4 col-form-label" for="nuevo_piloto">Añadir Piloto</label> 
              <div class="col-8">
                <select id="nuevo_piloto" name="nuevo_piloto" class="custom-select" required="required" multiple="multiple">
                  <?php
                    while ($pilotos = $resultadoPilotos->fetch_assoc()) {
                      $idPiloto = $pilotos['id'];
                      $nombrePiloto = $pilotos['nombre'] . ' ' . $pilotos['apellido'];
                      if(strpos($pilotosActuales, $nombrePiloto) == false){
                  ?>
                        <option value="<?php echo $nombrePiloto ?>"><?php echo $nombrePiloto ?></option>
                  <?php 
                      }
                    }
                  ?>
                </select>
              </div>
            </div> 
            <div class="form-group row">
              <div class="offset-4 col-8 text-center">
                <input type="hidden" id="pilotos_categoria" value="<?php echo $categoria ?>">
                <input type="hidden" id="pilotos_temporada" value="<?php echo $temporada ?>">
                <input type="hidden" id="pilotos_actuales" value="<?php echo $pilotosActuales ?>">
                <button name="submit" type="submit" class="btn btn-primary">Añadir</button>
              </div>
            </div>
        </form>

        <!-- Agregar una carrera -->
        <form id="agregar_carrera" action="#">
            <h3 style="margin-top:50px;" class="text-center mb-2 bread">Añadir una carrera</h3>
            <div class="form-group row">
              <label for="carrera" class="col-4 col-form-label">Seleccione la carrera</label> 
              <div class="col-8" style="margin-bottom: 50px;">
                <select id="carrera" name="carrera" class="custom-select" required="required">
                  <option selected disabled>-- Selecciona una Carrera --</option>
                  <?php
                    while ($pistas = $resultadoPistas->fetch_assoc()) {
                      $nombrePista = $pistas['pais'] . ' - ' . $pistas['ciudad'];
                  ?>
                        <option value="<?php echo $nombrePista; ?>"><?php echo $nombrePista; ?></option>
                  <?php 
                    }
                  ?>
                </select>
                <div class="text-center">
                    <div class="form-check form-check-inline">
                  <input class="form-check-input" name="tipo-carrera" type="radio" value="Feature" <?php if($categoria == 'f1'){ ?>checked<?php } ?>>
                      <label class="form-check-label">Feature Race</label>
                    </div>
                    <div class="form-check form-check-inline">
                  <input class="form-check-input" name="tipo-carrera" type="radio" value="Sprint" <?php if($categoria == 'f1'){ ?>disabled<?php } ?>>
                      <label class="form-check-label">Sprint Race</label>
                    </div>
                </div>
              </div>

              <?php
                if(in_array($temporada, $temporadaCon22Pilotos)) $cantidadPilotos = 22;
                else if(in_array($temporada, $temporadaCon24Pilotos)) $cantidadPilotos = 24;
                else $cantidadPilotos = 20;

                for ($i=1; $i <= $cantidadPilotos; $i++){ 
              ?>
                <label for="posicion<?php echo $i?>-Piloto" class="col-4 col-form-label">Posicion <?php echo $i?></label> 
                <div class="col-8 d-flex justify-content-between">
                  <select id="posicion<?php echo $i?>-Piloto" class="custom-select" required="required">
                    <option selected disabled>-- Selecciona un Piloto --</option>
                    <?php
                      $resultadoPilotos = $con->query($cargarPilotos);
                      while ($pilotos = $resultadoPilotos->fetch_assoc()) {
                        $idPiloto = $pilotos['id'];
                        $nombrePiloto = $pilotos['nombre'] . ' ' . $pilotos['apellido'];
                        if(strpos($pilotosActuales, $nombrePiloto) != false){
                    ?>
                          <option value="<?php echo $nombrePiloto ?>"><?php echo $nombrePiloto ?></option>
                    <?php 
                        }
                      }
                      $resultadoPilotos = $con->query($cargarPilotos);
                    ?>
                  </select>

                  <select id="posicion<?php echo $i?>-Escuderia" class="custom-select" required="required">
                    <option selected disabled>-- Selecciona una Escuderia --</option>
                    <?php
                      $resultadoEscuderias = $con->query($cargarEscuderias);
                      while ($escuderias = $resultadoEscuderias->fetch_assoc()) {
                        $idEscuderia = $escuderias['id'];
                        $nombreEscuderia = $escuderias['nombre'];
                        if(strpos($escuderiasActuales, $nombreEscuderia) != false){
                    ?>
                          <option value="<?php echo $nombreEscuderia ?>"><?php echo $nombreEscuderia ?></option>
                    <?php 
                        }
                      }
                      $resultadoEscuderias = $con->query($cargarEscuderias);
                    ?>
                  </select>
                </div>
              <?php 
                }
              ?>

              <label class="col-4 col-form-label" for="abandonos" style="margin-top: 50px;">Abandonos</label> 
              <div class="col-8">
                <select id="abandonos" name="abandonos" class="custom-select" style="margin-top: 50px;" required="required" multiple="multiple">
                  <option value="Nadie">Sin abandonos</option>
                  <option disabled>-------------------------------------------------------------------------------------</option>
                  <?php
                      $resultadoPilotos = $con->query($cargarPilotos);
                      while ($pilotos = $resultadoPilotos->fetch_assoc()) {
                        $idPiloto = $pilotos['id'];
                        $nombrePiloto = $pilotos['nombre'] . ' ' . $pilotos['apellido'];
                        if(strpos($pilotosActuales, $nombrePiloto) != false){
                  ?>
                          <option value="<?php echo $nombrePiloto ?>"><?php echo $nombrePiloto ?></option>
                  <?php 
                        }
                      }
                  ?>
                </select>
                <select id="abandonosEscuderia" name="abandonosEscuderia" class="custom-select" style="margin-top: 50px;" required="required" multiple="multiple">
                  <option value="Nadie">Sin abandonos</option>
                  <option disabled>-------------------------------------------------------------------------------------</option>
                  <?php
                      $resultadoEscuderias = $con->query($cargarEscuderias);
                      while ($escuderias = $resultadoEscuderias->fetch_assoc()) {
                        $idEscuderia = $escuderias['id'];
                        $nombreEscuderia = $escuderias['nombre'];
                        if(strpos($escuderiasActuales, $nombreEscuderia) != false){
                  ?>
                          <option value="<?php echo $nombreEscuderia ?>"><?php echo $nombreEscuderia ?></option>
                  <?php 
                        }
                      }
                  ?>
                  <?php
                      $resultadoEscuderias = $con->query($cargarEscuderias);
                      while ($escuderias = $resultadoEscuderias->fetch_assoc()) {
                        $idEscuderia = $escuderias['id'];
                        $nombreEscuderia = $escuderias['nombre'];
                        if(strpos($escuderiasActuales, $nombreEscuderia) != false){
                  ?>
                          <option value="<?php echo $nombreEscuderia ?>"><?php echo $nombreEscuderia ?></option>
                  <?php 
                        }
                      }
                  ?>
                </select>
              </div>

              <label for="pole" class="col-4 col-form-label" style="margin-top: 50px;">Pole</label> 
              <div class="col-8" style="margin-top: 50px;">
                <select id="pole" name="pole" class="custom-select" required="required">
                  <option selected disabled>-- Selecciona un Piloto --</option>
                  <?php
                        $resultadoPilotos = $con->query($cargarPilotos);
                        while ($pilotos = $resultadoPilotos->fetch_assoc()) {
                          $idPiloto = $pilotos['id'];
                          $nombrePiloto = $pilotos['nombre'] . ' ' . $pilotos['apellido'];
                          if(strpos($pilotosActuales, $nombrePiloto) != false){
                    ?>
                            <option value="<?php echo $nombrePiloto ?>"><?php echo $nombrePiloto ?></option>
                    <?php 
                          }
                        }
                    ?>
                </select>
                <select id="poleEscuderia" name="poleEscuderia" class="custom-select" required="required">
                  <option selected disabled>-- Selecciona una Escuderia --</option>
                  <?php
                        $resultadoEscuderias = $con->query($cargarEscuderias);
                        while ($escuderias = $resultadoEscuderias->fetch_assoc()) {
                          $idEscuderia = $escuderias['id'];
                          $nombreEscuderia = $escuderias['nombre'];
                          if(strpos($escuderiasActuales, $nombreEscuderia) != false){
                    ?>
                            <option value="<?php echo $nombreEscuderia ?>"><?php echo $nombreEscuderia ?></option>
                    <?php 
                          }
                        }
                    ?>
                </select>
              </div>

              <label for="vuelta_rapida" class="col-4 col-form-label">Vuelta Rápida</label> 
              <div class="col-8">
                <select id="vuelta_rapida" name="vuelta_rapida" class="custom-select" required="required">
                  <option selected disabled>-- Selecciona un Piloto --</option>
                  <option value="Nadie">Nadie</option>
                  <?php
                        $resultadoPilotos = $con->query($cargarPilotos);
                        while ($pilotos = $resultadoPilotos->fetch_assoc()) {
                          $idPiloto = $pilotos['id'];
                          $nombrePiloto = $pilotos['nombre'] . ' ' . $pilotos['apellido'];
                          if(strpos($pilotosActuales, $nombrePiloto) != false){
                    ?>
                            <option value="<?php echo $nombrePiloto ?>"><?php echo $nombrePiloto ?></option>
                    <?php 
                          }
                        }
                    ?>
                </select>
                <select id="vuelta_rapida_escuderia" name="vuelta_rapida_escuderia" class="custom-select" required="required">
                  <option selected disabled>-- Selecciona una Escuderia --</option>
                  <option value="Nadie">Nadie</option>
                  <?php
                        $resultadoEscuderias = $con->query($cargarEscuderias);
                        while ($escuderias = $resultadoEscuderias->fetch_assoc()) {
                          $idEscuderia = $escuderias['id'];
                          $nombreEscuderia = $escuderias['nombre'];
                          if(strpos($escuderiasActuales, $nombreEscuderia) != false){
                    ?>
                            <option value="<?php echo $nombreEscuderia ?>"><?php echo $nombreEscuderia ?></option>
                    <?php 
                          }
                        }
                    ?>
                </select>
              </div>

              <label for="piloto_del_dia" class="col-4 col-form-label">Piloto del Día</label> 
              <div class="col-8">
                <select id="piloto_del_dia" name="piloto_del_dia" class="custom-select" required="required">
                  <option selected disabled>-- Selecciona un Piloto --</option>
                  <?php
                        $resultadoPilotos = $con->query($cargarPilotos);
                        while ($pilotos = $resultadoPilotos->fetch_assoc()) {
                          $idPiloto = $pilotos['id'];
                          $nombrePiloto = $pilotos['nombre'] . ' ' . $pilotos['apellido'];
                          if(strpos($pilotosActuales, $nombrePiloto) != false){
                    ?>
                            <option value="<?php echo $nombrePiloto ?>"><?php echo $nombrePiloto ?></option>
                    <?php 
                          }
                        }
                    ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <div class="text-center offset-4 col-8">
                <input type="hidden" id="temporada-carrera" value="<?php echo $_GET['temporada'] ?>">
                <input type="hidden" id="categoria-carrera" value="<?php echo $_GET['categoria'] ?>">
                <button name="submit" type="submit" class="btn btn-primary">Añadir</button>
              </div>
            </div>
        </form>

        <!-- Agregar un campeon -->
        <form id="agregar_campeones" action="#">
            <h3 style="margin-top:50px;" class="text-center mb-2 bread">Añadir Campeones</h3>
            <div class="form-group row">
              <label for="campeonPilotos" class="col-4 col-form-label" style="margin-top: 50px;">Campeon de Pilotos</label> 
              <div class="col-8" style="margin-top: 50px;">
                <select id="campeonPilotos" name="campeonPilotos" class="custom-select" required="required">
                  <option selected disabled>-- Selecciona un Piloto --</option>
                  <?php
                        $resultadoPilotos = $con->query($cargarPilotos);
                        while ($pilotos = $resultadoPilotos->fetch_assoc()) {
                          $idPiloto = $pilotos['id'];
                          $nombrePiloto = $pilotos['nombre'] . ' ' . $pilotos['apellido'];
                          if(strpos($pilotosActuales, $nombrePiloto) != false){
                    ?>
                            <option value="<?php echo $nombrePiloto ?>"><?php echo $nombrePiloto ?></option>
                    <?php 
                          }
                        }
                    ?>
                </select>
              </div>

              <label for="campeonEscuderias" class="col-4 col-form-label">Campeon de Escuderias</label> 
              <div class="col-8">
                <select id="campeonEscuderias" name="campeonEscuderias" class="custom-select" required="required">
                  <option selected disabled>-- Selecciona una Escuderia --</option>
                  <option value="Nadie">Nadie</option>
                  <?php
                        $resultadoEscuderias = $con->query($cargarEscuderias);
                        while ($escuderias = $resultadoEscuderias->fetch_assoc()) {
                          $idEscuderia = $escuderias['id'];
                          $nombreEscuderia = $escuderias['nombre'];
                          if(strpos($escuderiasActuales, $nombreEscuderia) != false){
                    ?>
                            <option value="<?php echo $nombreEscuderia ?>"><?php echo $nombreEscuderia ?></option>
                    <?php 
                          }
                        }
                    ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <div class="text-center offset-4 col-8">
                <input type="hidden" id="temporada-campeon" value="<?php echo $_GET['temporada'] ?>">
                <input type="hidden" id="categoria-campeon" value="<?php echo $_GET['categoria'] ?>">
                <button name="submit" type="submit" class="btn btn-primary">Añadir</button>
              </div>
            </div>
        </form>
    </div>

    <?php include('templates/scripts.php') ?>
  </body>
</html>