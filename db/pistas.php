<?php 
    if($_POST['accion'] == "nuevo"){
        //Conecto al archivo de conexion a la BD
        require('conexion.php');
        //Filtro variables para evitar codigo malo
        $pais = filter_var($_POST['pais'], FILTER_SANITIZE_STRING);
        $ciudad = filter_var($_POST['ciudad'], FILTER_SANITIZE_STRING);
        $color_principal = filter_var($_POST['color_principal'], FILTER_SANITIZE_STRING);
        $texto_principal = filter_var($_POST['texto_principal'], FILTER_SANITIZE_STRING);
        $texto_secundario = filter_var($_POST['texto_secundario'], FILTER_SANITIZE_STRING);
        //Inserto en la base de datos
        try {
            $stmt = $con->prepare('INSERT INTO pistas (pais, ciudad, color_principal, texto_principal, texto_secundario) VALUES (?, ?, ?, ?, ?)');
            $stmt->bind_param('sssss', $pais, $ciudad, $color_principal, $texto_principal, $texto_secundario);
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
        $id = $_POST['id'];
        $pais = filter_var($_POST['pais'], FILTER_SANITIZE_STRING);
        $ciudad = filter_var($_POST['ciudad'], FILTER_SANITIZE_STRING);
        $color_principal = filter_var($_POST['color_principal'], FILTER_SANITIZE_STRING);
        $texto_principal = filter_var($_POST['texto_principal'], FILTER_SANITIZE_STRING);
        $texto_secundario = filter_var($_POST['texto_secundario'], FILTER_SANITIZE_STRING);
        //Inserto en la base de datos
        try {
            $stmt = $con->prepare('UPDATE pistas SET pais = ?, ciudad = ?, color_principal = ?, texto_principal = ?, texto_secundario = ? WHERE id = ?');
            $stmt->bind_param('sssssi', $pais, $ciudad, $color_principal, $texto_principal, $texto_secundario, $id);
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
            $stmt = $con->prepare("DELETE FROM pistas WHERE id = ?");
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