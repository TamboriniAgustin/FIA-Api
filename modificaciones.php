<!DOCTYPE html>
<html lang="en">
  <?php include('templates/head.php') ?>
  <body>
    <a href="index.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <!-- Conecto a la base de datos y cargo los pilotos, escuderias y temporadas -->
    <?php 
      try {
        require('db/conexion.php');

        $cargarPilotos = ' SELECT * FROM pilotos ORDER BY apellido ASC';
        $resultadoPilotos = $con->query($cargarPilotos);

        $cargarEscuderias = ' SELECT * FROM escuderias ORDER BY nombre ASC';
        $resultadoEscuderias = $con->query($cargarEscuderias);

        $cargarTemporadas = ' SELECT * FROM temporadas ORDER BY año DESC';
        $resultadoTemporadas = $con->query($cargarTemporadas);
      } catch (\Exception $e) {
        $error = $e->getMessage();
      }
    ?>

    <div class="container" style="margin-top: 50px;">
        <!-- Modificar Piloto -->
        <h3 class="text-center">Modificar Piloto</h3>
        <table class="table" id="tablaPilotos">
          <thead class="text-center" style="color:white;">
            <tr>
              <th scope="col" width="50%" style="background-color:#dc3545;">Piloto</th>
              <th scope="col" style="background-color:#007bff;">Acciones</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php 
              while ($pilotos = $resultadoPilotos->fetch_assoc()) {
                $idPiloto = $pilotos['id'];
                $nombrePiloto = $pilotos['nombre'];
                $apellidoPiloto = $pilotos['apellido'];
            ?>
              <tr>
                <th scope="row"><?php echo $nombrePiloto . ' ' . $apellidoPiloto ?></th>
                <td>
                  <a href="modificar-piloto.php?id=<?echo $idPiloto ?>"><button class="btn btn-success">Modificar</button></a>
                  <button data-name="piloto" data-id="<?php echo $idPiloto ?>" class="btn btn-danger">Eliminar</button>
                </td>
              </tr>
            <?php 
              }
            ?>
          </tbody>
        </table>

        <!-- Modificar Escuderia -->
        <h3 class="text-center">Modificar Escuderia</h3>
        <table class="table" id="tablaEscuderias">
            <thead class="text-center" style="color:white;">
              <tr>
                <th scope="col" width="50%" style="background-color:#dc3545;">Escuderia</th>
                <th scope="col" style="background-color:#007bff;">Acciones</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php 
                while ($escuderias = $resultadoEscuderias->fetch_assoc()) {
                  $idEscuderia = $escuderias['id'];
                  $nombreEscuderia = $escuderias['nombre'];
              ?>
                <tr>
                  <th scope="row"><?php echo $nombreEscuderia ?></th>
                  <td>
                    <a href="modificar-escuderia.php?id=<?php echo $idEscuderia ?>"><button class="btn btn-success">Modificar</button></a>
                    <button data-name="escuderia" data-id="<?php echo $idEscuderia ?>" class="btn btn-danger">Eliminar</button>
                  </td>
                </tr>
              <?php 
                }
              ?>
            </tbody>
        </table>

        <!-- Modificar Temporada -->
        <h3 class="text-center">Modificar Temporada</h3>
        <table class="table" id="tablaTemporadas">
            <thead class="text-center" style="color:white;">
              <tr>
                <th scope="col" width="50%" style="background-color:#dc3545;">Temporada</th>
                <th scope="col" style="background-color:#007bff;">Acciones</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php 
                while ($temporadas = $resultadoTemporadas->fetch_assoc()) {
                  $idTemporada = $temporadas['id'];
                  $anioTemporada = $temporadas['año'];
              ?>
                <tr>
                  <th scope="row"><?php echo $anioTemporada ?></th>
                  <td>
                    <button data-name="temporada" data-id="<?php echo $idTemporada ?>" class="btn btn-danger">Eliminar</button>
                  </td>
                </tr>
              <?php 
                }
              ?>
            </tbody>
        </table>
    </div>

    <?php include('templates/scripts.php') ?>
    
  </body>
</html>