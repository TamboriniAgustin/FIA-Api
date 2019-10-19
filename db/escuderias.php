<?php 
    if($_POST['accion'] == "nuevo"){
        //Conecto al archivo de conexion a la BD
        require('conexion.php');
        //Filtro variables para evitar codigo malo
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        $nacionalidad = filter_var($_POST['nacionalidad'], FILTER_SANITIZE_STRING);
        //Inserto en la base de datos
        try {
            $stmt = $con->prepare('INSERT INTO escuderias (nombre, nacionalidad) VALUES (?, ?)');
            $stmt->bind_param('ss', $nombre, $nacionalidad);
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
    if($_POST['accion'] == "editar"){
        //Conecto al archivo de conexion a la BD
        require('conexion.php');
        //Filtro variables para evitar codigo malo
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        $nacionalidad = filter_var($_POST['nacionalidad'], FILTER_SANITIZE_STRING);
        //Inserto en la base de datos
        try {
            $stmt = $con->prepare('UPDATE escuderias SET nombre = ?, nacionalidad = ? WHERE id = ?');
            $stmt->bind_param('ssi', $nombre, $nacionalidad, $id);
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
            $stmt = $con->prepare("DELETE FROM escuderias WHERE id = ?");
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
?>