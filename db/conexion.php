<?php 
    $con = new mysqli('localhost', 'root', 'root', 'fia');

    if($con->connect_error){
        echo $con->connect_error;
    }

    $con->set_charset('utf8');
?>