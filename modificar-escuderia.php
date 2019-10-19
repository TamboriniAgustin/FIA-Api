<!DOCTYPE html>
<html lang="en">
  
  <?php include('templates/head.php') ?>

  <body>
    <a href="modificaciones.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <!-- Conecto a la base de datos y cargo la escuderia -->
    <?php 
      try {
        $idEscuderia = $_GET['id'];

        require('db/conexion.php');

        $cargarEscuderia = "SELECT * FROM escuderias WHERE id = $idEscuderia";
        $resultadoEscuderia = $con->query($cargarEscuderia);
      } catch (\Exception $e) {
        $error = $e->getMessage();
      }

      $escuderia = $resultadoEscuderia->fetch_assoc();
      $nombre = $escuderia['nombre'];
      $nacionalidad = $escuderia['nacionalidad'];
    ?>

    <div class="container" style="margin-top: 50px;">
        <!-- Formulario de Escuderia -->
        <form id="modificar_escuderia" style="margin-bottom: 50px;">
          <div class="form-group row">
            <label for="nombreEscuderia" class="col-4 col-form-label">Nombre</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="nombreEscuderia" name="nombreEscuderia" value="<?php echo $nombre ?>" type="text" class="form-control" required="required">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="nacionalidadEscuderia" class="col-4 col-form-label">Nacionalidad</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-card-o"></i>
                  </div>
                </div> 
                <input id="nacionalidadEscuderia" name="nacionalidadEscuderia" value="<?php echo $nacionalidad ?>" type="text" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="offset-4 col-8 text-center">
              <input type="hidden" id="idEscuderia" value="<?php echo $idEscuderia ?>">
              <button name="submit" type="submit" class="btn btn-primary">Modificar</button>
            </div>
          </div>
        </form>
    </div>

    <?php include('templates/scripts.php') ?>
    
  </body>
</html>