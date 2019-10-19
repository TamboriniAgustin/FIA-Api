<!DOCTYPE html>
<html lang="en">

  <?php include('templates/head.php') ?>
  
  <body>
    <a href="index.php"><h3 class="mb-2 bread" style="padding: 20px;">Volver</h3></a>

    <?php include('templates/header.php') ?>

    <div class="container" style="margin-top: 50px;">
        <!-- Crear un Piloto -->
        <h3 class="text-center">Crear un Piloto</h3>
        <form class="crear-piloto" style="margin-bottom: 50px;" method="POST" action="#">
          <div class="form-group row">
            <label for="nombre" class="col-4 col-form-label">Nombre</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="nombre" name="nombre" placeholder="Ingresa el nombre del piloto..." type="text" class="form-control" required="required">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="apellido" class="col-4 col-form-label">Apellido</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="apellido" name="apellido" placeholder="Ingresa el apellido del piloto..." type="text" class="form-control" required="required">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="nacionalidad" class="col-4 col-form-label">Nacionalidad</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-card-o"></i>
                  </div>
                </div> 
                <input id="nacionalidad" name="nacionalidad" placeholder="Ingrese la nacionalidad del piloto..." type="text" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="edad" class="col-4 col-form-label">Edad</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="edad" name="edad" placeholder="Ingresa la edad del piloto..." type="text" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="offset-4 col-8 text-center">
              <input class="btn btn-primary" type="submit" value="Crear">
            </div>
          </div>
        </form>

        <!-- Crear una Escuderia -->
        <h3 class="text-center">Crear una Escuderia</h3>
        <form class="crear-escuderia" style="margin-bottom: 50px;" method="POST" action="#">
          <div class="form-group row">
            <label for="nombreEscuderia" class="col-4 col-form-label">Nombre</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="nombreEscuderia" name="nombreEscuderia" placeholder="Ingresa el nombre de la escuderia..." type="text" class="form-control" required="required">
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
                <input id="nacionalidadEscuderia" name="nacionalidadEscuderia" placeholder="Ingrese la nacionalidad de la escuderia..." type="text" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="offset-4 col-8 text-center">
              <button name="submit" type="submit" class="btn btn-primary">Crear</button>
            </div>
          </div>
        </form>

        <!-- Agregar una carrera -->
        <h3 class="text-center">Crear una Temporada</h3>
        <form class="crear-temporada" method="POST" action="#">
          <div class="form-group row">
            <label for="año" class="col-4 col-form-label">Año</label> 
            <div class="col-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-book-o"></i>
                  </div>
                </div> 
                <input id="año" name="año" placeholder="Ingrese el año de la temporada a agregar..." type="text" required="required" class="form-control">
              </div>
            </div>
          </div> 
          <div class="form-group row">
            <div class="offset-4 col-8 text-center">
              <button name="submit" type="submit" class="btn btn-primary">Crear</button>
            </div>
          </div>
        </form>
    </div>

  <?php include('templates/scripts.php') ?>
    
  </body>
</html>