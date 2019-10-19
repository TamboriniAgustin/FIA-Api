<?php 
    if($_POST['accion'] == "nuevo"){
        //Conecto al archivo de conexion a la BD
        require('conexion.php');
        //Filtro variables para evitar codigo malo
        $anio = filter_var($_POST['año'], FILTER_SANITIZE_NUMBER_INT);
        $default = "{}";
        //Inserto en la base de datos
        try {
            $stmt = $con->prepare('INSERT INTO temporadas (año, pilotosF1, escuderiasF1, pilotosF2, escuderiasF2) VALUES (?, ?, ?, ?, ?)');
            $stmt->bind_param('issss', $anio, $default, $default, $default, $default);
            $stmt->execute();
            $respuesta = array(
                'operacion' => 'exitosa',
                'id' => $stmt->insert_id
            );
            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            $respuesta = array(
                "operacion" => "fallida",
                "error" => $e->getMessage()
            );
        }
        //Enviamos la información de la operación hacia JavaScript
        echo json_encode($respuesta);
    }
    if($_GET['accion'] == "borrar"){
        //Limpio las variables para verificar que no se ingrese 'basura'
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        //Llamamos al archivo de conexion
        require('conexion.php');
        //Intento conectar a la base de datos y realizar la operacion de creado, sino, contengo
        try{
            $stmt = $con->prepare("DELETE FROM temporadas WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $respuesta = array('operacion' => 'exitosa');

            $stmt->close();
            $con->close();
        } catch(Exception $e){
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }
    }
    /*****************************************/
    if($_POST['accion'] == "nueva-escuderia"){
        //Conecto al archivo de conexion a la BD
        require('conexion.php');
        //Filtro variables para evitar codigo malo
        $categoria = $_POST['categoria'];
        $temporada = filter_var($_POST['temporada'], FILTER_SANITIZE_STRING);
        $escuderias = filter_var($_POST['escuderias'], FILTER_SANITIZE_STRING);
        //Inserto en la base de datos
        try {
            if($categoria == "f1"){
                $stmt = $con->prepare('UPDATE temporadas SET escuderiasF1 = ? WHERE año = ?');
            }
            else if($categoria == "f2"){
                $stmt = $con->prepare('UPDATE temporadas SET escuderiasF2 = ? WHERE año = ?');
            }
            $stmt->bind_param('ss', $escuderias, $temporada);
            $stmt->execute();
            $respuesta = array(
                'operacion' => 'exitosa',
                'id' => $stmt->insert_id
            );
            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            $respuesta = array(
                "operacion" => "fallida",
                "error" => $e->getMessage()
            );
        }
        //Enviamos la información de la operación hacia JavaScript
        echo json_encode($respuesta);
    }
    if($_POST['accion'] == "nuevo-piloto"){
        //Conecto al archivo de conexion a la BD
        require('conexion.php');
        //Filtro variables para evitar codigo malo
        $categoria = $_POST['categoria'];
        $temporada = filter_var($_POST['temporada'], FILTER_SANITIZE_STRING);
        $pilotos = filter_var($_POST['pilotos'], FILTER_SANITIZE_STRING);
        //Inserto en la base de datos
        try {
            if($categoria == "f1"){
                $stmt = $con->prepare('UPDATE temporadas SET pilotosF1 = ? WHERE año = ?');
            }
            else if($categoria == "f2"){
                $stmt = $con->prepare('UPDATE temporadas SET pilotosF2 = ? WHERE año = ?');
            }
            $stmt->bind_param('ss', $pilotos, $temporada);
            $stmt->execute();
            $respuesta = array(
                'operacion' => 'exitosa',
                'id' => $stmt->insert_id
            );
            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            $respuesta = array(
                "operacion" => "fallida",
                "error" => $e->getMessage()
            );
        }
        //Enviamos la información de la operación hacia JavaScript
        echo json_encode($respuesta);
    }
    if($_POST['accion'] == "nueva-carrera"){
        //Conecto al archivo de conexion a la BD
        require('conexion.php');
        //Filtro variables para evitar codigo malo
        $categoria = $_POST['categoria'];
        $temporada = $_POST['temporada'];
        $posicionPilotos = $_POST['posicionPilotos'];
        $posicionEscuderias = $_POST['posicionEscuderias'];
        $carrera = $_POST['carrera'];
        $tipo = $_POST['tipo'];
        $pole = $_POST['pole'];
        $poleEscuderia = $_POST['pole-escuderia'];
        $vueltaRapida = $_POST['vueltaRapida'];
        $vueltaRapidaEscuderia = $_POST['vueltaRapida-escuderia'];
        $pilotoDelDia = $_POST['pilotoDelDia'];
        $abandonos = $_POST['abandonos'];
        $abandonosEscuderia = $_POST['abandonos-escuderia'];

        //Inserto en la base de datos
        try {
            $stmt = $con->prepare('INSERT INTO carreras (nombre, temporada, categoria, tipo, posiciones_pilotos, posiciones_escuderias, abandonos, abandonos_escuderias, pole, pole_escuderia, vuelta_rapida, vuelta_rapida_escuderia, piloto_del_dia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('sssssssssssss', $carrera, $temporada, $categoria, $tipo, $posicionPilotos, $posicionEscuderias, $abandonos, $abandonosEscuderia, $pole, $poleEscuderia, $vueltaRapida, $vueltaRapidaEscuderia, $pilotoDelDia);
            $stmt->execute();
            $respuesta = array(
                'operacion' => 'exitosa',
                'id' => $stmt->insert_id
            );
            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            $respuesta = array(
                "operacion" => "fallida",
                "error" => $e->getMessage()
            );
        }
        //Enviamos la información de la operación hacia JavaScript
        echo json_encode($respuesta);
    }
    if($_POST['accion'] == "nuevos-campeones"){
        //Conecto al archivo de conexion a la BD
        require('conexion.php');
        //Filtro variables para evitar codigo malo
        $categoria = $_POST['categoria'];
        $temporada = $_POST['temporada'];
        $campeonPilotos = $_POST['campeon-pilotos'];
        $campeonEscuderias = $_POST['campeon-escuderias'];

        //Inserto en la base de datos
        try {
            if($categoria == 'f1') $stmt = $con->prepare('UPDATE temporadas SET campeon_pilotos_f1 = ?, campeon_escuderias_f1 = ? WHERE año = ?');
            else $stmt = $con->prepare('UPDATE temporadas SET campeon_pilotos_f2 = ?, campeon_escuderias_f2 = ? WHERE año = ?');
            $stmt->bind_param('ssi', $campeonPilotos, $campeonEscuderias, $temporada);
            $stmt->execute();
            $respuesta = array(
                'operacion' => 'exitosa',
                'id' => $stmt->insert_id
            );
            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            $respuesta = array(
                "operacion" => "fallida",
                "error" => $e->getMessage()
            );
        }
        //Enviamos la información de la operación hacia JavaScript
        echo json_encode($respuesta);
    }
?>