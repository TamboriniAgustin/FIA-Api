<!DOCTYPE html>
<html lang="en">
  
  <?php include('templates/head.php') ?>

  <body>
    <a href="modificaciones.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <!-- Conecto a la base de datos y cargo el piloto -->
    <?php 
      try {
        $idPiloto = $_GET['id'];

        require('db/conexion.php');

        $cargarPiloto = "SELECT * FROM pilotos WHERE id = $idPiloto";
        $resultadoPiloto = $con->query($cargarPiloto);
      } catch (\Exception $e) {
        $error = $e->getMessage();
      }

      $piloto = $resultadoPiloto->fetch_assoc();
      $nombre = $piloto['nombre'];
      $apellido = $piloto['apellido'];
      $nacionalidad = $piloto['nacionalidad'];
      $edad = $piloto['edad'];
    ?>

    <div class="container" style="margin-top: 50px;">
        <!-- Formulario de Piloto -->
        <form id="modificar_piloto" style="margin-bottom: 50px;">
          <div class="form-group row">
            <label for="nombrePiloto" class="col-4 col-form-label">Nombre</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="nombrePiloto" name="nombrePiloto" value="<?php echo $nombre ?>" type="text" class="form-control" required="required">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="apellidoPiloto" class="col-4 col-form-label">Apellido</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="apellidoPiloto" name="apellidoPiloto" value="<?php echo $apellido ?>" type="text" class="form-control" required="required">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="nacionalidadPiloto" class="col-4 col-form-label">Nacionalidad</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-card-o"></i>
                  </div>
                </div> 
                <input id="nacionalidadPiloto" name="nacionalidadPiloto" value="<?php echo $nacionalidad ?>" type="text" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="edadPiloto" class="col-4 col-form-label">Edad</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="edadPiloto" name="edadPiloto" value="<?php echo $edad ?>" type="text" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="offset-4 col-8 text-center">
              <input type="hidden" id="idPiloto" value="<?php echo $idPiloto ?>">
              <button name="submit" type="submit" class="btn btn-primary">Modificar</button>
            </div>
          </div>
        </form>
    </div>

    <?php include('templates/scripts.php') ?>
    
  </body>
</html>