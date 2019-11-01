<!DOCTYPE html>
<html lang="en">
  
  <?php include('templates/head.php') ?>

  <body>
    <a href="modificaciones.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <!-- Conecto a la base de datos y cargo la pista -->
    <?php 
      try {
        $idPista = $_GET['id'];

        require('db/conexion.php');

        $cargarPista = "SELECT * FROM pistas WHERE id = $idPista";
        $resultadoPista = $con->query($cargarPista);
      } catch (\Exception $e) {
        $error = $e->getMessage();
      }

      $pista = $resultadoPista->fetch_assoc();
      $pais = $pista['pais'];
      $ciudad = $pista['ciudad'];
      $color_principal = $pista['color_principal'];
      $texto_principal = $pista['texto_principal'];
      $texto_secundario = $pista['texto_secundario'];
    ?>

    <div class="container" style="margin-top: 50px;">
        <!-- Formulario de Pista -->
        <form id="modificar_pista" method="POST" action="#">
          <div class="form-group row">
            <label for="pais" class="col-4 col-form-label">País</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="pais" name="pais" value="<?php echo $pais ?>" type="text" required="required" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="ciudad" class="col-4 col-form-label">Ciudad</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="ciudad" name="ciudad" value="<?php echo $ciudad ?>" type="text" required="required" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="colorP" class="col-4 col-form-label">Color Principal</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="colorP" name="colorP" type="color" required="required" class="form-control" value="<?php echo $color_principal; ?>">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="textoP" class="col-4 col-form-label">Texto Principal</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="textoP" name="textoP" type="color" required="required" class="form-control" value="<?php echo $texto_principal ?>">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="textoS" class="col-4 col-form-label">Texto Secundario</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="textoS" name="textoS" type="color" required="required" class="form-control" value="<?php echo $texto_secundario ?>">
              </div>
            </div>
          </div>  
          <div class="form-group row">
            <div class="offset-4 col-8 text-center">
              <input id="idPista" type="hidden" value="<?php echo $idPista ?>">
              <button name="submit" type="submit" class="btn btn-primary">Modificar</button>
            </div>
          </div>
        </form>
    </div>

    <?php include('templates/scripts.php') ?>
    
  </body>
</html>