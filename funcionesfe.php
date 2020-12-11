<?php
    //***** Funciones para el calculo de puntos en el campeonato *****\\
    function calcularInformacionTemporada($nombre, $temporada, $tipo, $listaCarreras, &$informacion){
      //Inicializo los valores
      $informacion['puntos'] = 0;
      $informacion['victorias'] = 0;
      $informacion['podios'] = 0;
      $informacion['vueltasRapidas'] = 0;
      $informacion['poles'] = 0;
      $informacion['abandonos'] = 0;
      foreach($listaCarreras as $carrera){
        //Selecciono el tipo que estoy ingresando
        if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
        else $posicionesCarrera = $carrera['posiciones_escuderias'];
        //Convierto las posiciones de carrera a mi conveniencia
        $posicionesCarrera = json_decode($posicionesCarrera, true);
        //Obtengo la posicion del piloto
        $posicion = 0;
        for($i = 1; $i <= count($posicionesCarrera); $i++){
          if(strpos($nombre, $posicionesCarrera[$i]) != false || $nombre == $posicionesCarrera[$i]){
            if($tipo == 'piloto'){
              $posicion = $i;
              $informacion['puntos'] = $informacion['puntos'] + calcularPuntos($temporada, $posicion);
              $i = 1000;
            }
            else{
              $posicion = $i;
              $informacion['puntos'] = $informacion['puntos'] + calcularPuntos($temporada, $posicion);
            }
            if($posicion == 1) $informacion['victorias']++;
            if($posicion >= 1 && $posicion <= 3) $informacion['podios']++;
          }
        }
        //Calculo la información
        if(hizoLaPole($nombre, $carrera, $tipo)) $informacion['poles']++;
        if(hizoLaVueltaRapida($nombre, $carrera, $tipo)) $informacion['vueltasRapidas']++;
        $informacion['abandonos'] = $informacion['abandonos'] + abandonosCarrera($nombre, $carrera, $tipo);
      }
      $informacion['puntos'] = $informacion['puntos'] + calcularPuntosPorPole($informacion['poles'], $temporada);
      $informacion['puntos'] = $informacion['puntos'] + calcularPuntosPorVueltaRapida($informacion['vueltasRapidas'], $temporada);
    }
    function calcularPuntos($temporada, $posicion){
      if($temporada >= 2015){
        if($posicion == 1) return 25;
        if($posicion == 2) return 18;
        if($posicion == 3) return 15;
        if($posicion == 4) return 12;
        if($posicion == 5) return 10;
        if($posicion == 6) return 8;
        if($posicion == 7) return 6;
        if($posicion == 8) return 4;
        if($posicion == 9) return 2;
        if($posicion == 10) return 1;
      } 
      return 0;
    }
    function hizoLaVueltaRapida($nombre, $carrera, $tipo){
      if($tipo == 'piloto') $vueltaRapidaCarrera = $carrera['vuelta_rapida'];
      else $vueltaRapidaCarrera = $carrera['vuelta_rapida_escuderia'];

      return (strpos($nombre, $vueltaRapidaCarrera) != false || $nombre == $vueltaRapidaCarrera);
    }
    function hizoLaPole($nombre, $carrera, $tipo){
      if($tipo == 'piloto') $poleCarrera = $carrera['pole'];
      else $poleCarrera = $carrera['pole_escuderia'];
      
      return (strpos($nombre, $poleCarrera) != false || $nombre == $poleCarrera);
    }
    function abandonosCarrera($nombre, $carrera, $tipo){
      if($tipo == 'piloto') $abandonosCarrera = '{ ' . str_replace(',', ' ', $carrera['abandonos']) . ' }';
      else $abandonosCarrera = '{ ' . str_replace(',', ' ', $carrera['abandonos_escuderias']) . ' }';

      if(strpos($abandonosCarrera, $nombre) != false) return substr_count($abandonosCarrera, $nombre);
      else return 0;
    }
    function calcularPuntosPorPole($poles, $temporada){
      if($temporada >= 2015) return $poles * 3;
      return 0;
    }
    function calcularPuntosPorVueltaRapida($vueltasRapidas, $temporada){
      if($temporada >= 2017) return $vueltasRapidas * 1;
      if($temporada >= 2015) return $vueltasRapidas * 2;
      return 0;
    }
    
    //***** Funciones para calcular las estadisticas generales *****\\
    function escuderiasDePiloto($nombre, $categoria){
      require('db/conexion.php');
      $cargarCarreras = " SELECT * FROM carreras WHERE categoria = '$categoria' ";
      $resultadoCarreras = $con->query($cargarCarreras);

      $escuderias = array();
      while($carrera = $resultadoCarreras->fetch_assoc()){
        $posicionesPilotos = json_decode($carrera['posiciones_pilotos'], true);
        $posicionesEscuderias = json_decode($carrera['posiciones_escuderias'], true);
        //Si el piloto participó de la carrera obtengo la escuderia en la que estuvo
        if(in_array($nombre, $posicionesPilotos)){
          //Obtengo la posición del piloto
          $posicionPiloto = 0;
          for($i=1;$i<count($posicionesPilotos);$i++){
            if($posicionesPilotos[$i] == $nombre) $posicionPiloto = $i; 
          }
          //Verifico que la escuderia no este ya incluida en el array
          if($posicionPiloto > 0){
            array_push($escuderias, $posicionesEscuderias[$posicionPiloto]);
          }
        }
      }
      $escuderias = array_unique($escuderias);
      $escuderias = array_reverse($escuderias);
      //Convierto las escuderias en un string
      $escuderias = implode(', ', $escuderias);
      return $escuderias;
    }
?>