<?php
    //***** Funciones extra *****\\
    function valorCarrera($carrera){
      $contador = 0;
      for ($i=0; $i<strlen($carrera); $i++) { 
        if($carrera[$i] == '-'){
          $valorCarrera = substr($carrera, $i+2);
          $i = 1000;
        }
      }
      $valorCarrera = str_replace(' ', '', $valorCarrera);
      return $valorCarrera;
    }
    function calcularPuntos($posicion, $temporada){
      if($temporada >= 2010){
        switch ($posicion) {
          case 1: return 25;
          case 2: return 18;
          case 3: return 15;
          case 4: return 12;
          case 5: return 10;
          case 6: return 8;
          case 7: return 6;
          case 8: return 4;
          case 9: return 2;
          case 10: return 1;
          default: return 0;
        }
      }
      else if($temporada >= 2003){
        switch ($posicion) {
          case 1: return 10;
          case 2: return 8;
          case 3: return 6;
          case 4: return 5;
          case 5: return 4;
          case 6: return 3;
          case 7: return 2;
          case 8: return 1;
          default: return 0;
        }
      }
      else if($temporada >= 1991){
        switch ($posicion) {
          case 1: return 10;
          case 2: return 6;
          case 3: return 4;
          case 4: return 3;
          case 5: return 2;
          case 6: return 1;
          default: return 0;
        }
      }
      else{
        switch ($posicion) {
          case 1: return 9;
          case 2: return 6;
          case 3: return 4;
          case 4: return 3;
          case 5: return 2;
          case 6: return 1;
          default: return 0;
        }
      }
    }
    function calcularPuntosPorPole($poles, $temporada){
      return 0;
    }
    function calcularPuntosPorVueltaRapida($vueltasRapidas, $temporada){
      if($temporada >= 2018) return $vueltasRapidas * 1;
      else return 0;
    }

    //***** Funciones para el calculo de puntos en el campeonato *****\\
    function calcularPuntosTemporada($nombre, $temporada, $tipo, $listaCarreras){      
      $puntos = 0;
      $puntosPorPoles = 0;
      $puntosPorVueltasRapidas = 0;
      foreach($listaCarreras as $carrera){
        if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
        else $posicionesCarrera = $carrera['posiciones_escuderias'];
        $posicionesCarrera = json_decode($posicionesCarrera, true);

        //Calculo los puntos en base a la temporada
        if($temporada >= 2010){
          if(strpos($nombre, $posicionesCarrera[1]) != false || $nombre == $posicionesCarrera[1]) $puntos = $puntos + 25;
          if(strpos($nombre, $posicionesCarrera[2]) != false || $nombre == $posicionesCarrera[2]) $puntos = $puntos + 18;
          if(strpos($nombre, $posicionesCarrera[3]) != false || $nombre == $posicionesCarrera[3]) $puntos = $puntos + 15;
          if(strpos($nombre, $posicionesCarrera[4]) != false || $nombre == $posicionesCarrera[4]) $puntos = $puntos + 12;
          if(strpos($nombre, $posicionesCarrera[5]) != false || $nombre == $posicionesCarrera[5]) $puntos = $puntos + 10;
          if(strpos($nombre, $posicionesCarrera[6]) != false || $nombre == $posicionesCarrera[6]) $puntos = $puntos + 8;
          if(strpos($nombre, $posicionesCarrera[7]) != false || $nombre == $posicionesCarrera[7]) $puntos = $puntos + 6;
          if(strpos($nombre, $posicionesCarrera[8]) != false || $nombre == $posicionesCarrera[8]) $puntos = $puntos + 4;
          if(strpos($nombre, $posicionesCarrera[9]) != false || $nombre == $posicionesCarrera[9]) $puntos = $puntos + 2;
          if(strpos($nombre, $posicionesCarrera[10]) != false || $nombre == $posicionesCarrera[10]) $puntos = $puntos + 1;
        }
        else if($temporada >= 2003){
          if(strpos($nombre, $posicionesCarrera[1]) != false || $nombre == $posicionesCarrera[1]) $puntos = $puntos + 10;
          if(strpos($nombre, $posicionesCarrera[2]) != false || $nombre == $posicionesCarrera[2]) $puntos = $puntos + 8;
          if(strpos($nombre, $posicionesCarrera[3]) != false || $nombre == $posicionesCarrera[3]) $puntos = $puntos + 6;
          if(strpos($nombre, $posicionesCarrera[4]) != false || $nombre == $posicionesCarrera[4]) $puntos = $puntos + 5;
          if(strpos($nombre, $posicionesCarrera[5]) != false || $nombre == $posicionesCarrera[5]) $puntos = $puntos + 4;
          if(strpos($nombre, $posicionesCarrera[6]) != false || $nombre == $posicionesCarrera[6]) $puntos = $puntos + 3;
          if(strpos($nombre, $posicionesCarrera[7]) != false || $nombre == $posicionesCarrera[7]) $puntos = $puntos + 2;
          if(strpos($nombre, $posicionesCarrera[8]) != false || $nombre == $posicionesCarrera[8]) $puntos = $puntos + 1;
        }
        else if($temporada >= 1991){
          if(strpos($nombre, $posicionesCarrera[1]) != false || $nombre == $posicionesCarrera[1]) $puntos = $puntos + 10;
          if(strpos($nombre, $posicionesCarrera[2]) != false || $nombre == $posicionesCarrera[2]) $puntos = $puntos + 6;
          if(strpos($nombre, $posicionesCarrera[3]) != false || $nombre == $posicionesCarrera[3]) $puntos = $puntos + 4;
          if(strpos($nombre, $posicionesCarrera[4]) != false || $nombre == $posicionesCarrera[4]) $puntos = $puntos + 3;
          if(strpos($nombre, $posicionesCarrera[5]) != false || $nombre == $posicionesCarrera[5]) $puntos = $puntos + 2;
          if(strpos($nombre, $posicionesCarrera[6]) != false || $nombre == $posicionesCarrera[6]) $puntos = $puntos + 1;
        }
        else{
          if(strpos($nombre, $posicionesCarrera[1]) != false || $nombre == $posicionesCarrera[1]) $puntos = $puntos + 9;
          if(strpos($nombre, $posicionesCarrera[2]) != false || $nombre == $posicionesCarrera[2]) $puntos = $puntos + 6;
          if(strpos($nombre, $posicionesCarrera[3]) != false || $nombre == $posicionesCarrera[3]) $puntos = $puntos + 4;
          if(strpos($nombre, $posicionesCarrera[4]) != false || $nombre == $posicionesCarrera[4]) $puntos = $puntos + 3;
          if(strpos($nombre, $posicionesCarrera[5]) != false || $nombre == $posicionesCarrera[5]) $puntos = $puntos + 2;
          if(strpos($nombre, $posicionesCarrera[6]) != false || $nombre == $posicionesCarrera[6]) $puntos = $puntos + 1;
        }
        //Calculo los puntos en base a las poles
        $cantidadPoles = cantidadPolesTemporada($nombre, $temporada, $tipo, $listaCarreras);
        $puntosPorPoles = calcularPuntosPorPole($cantidadPoles, $temporada);
        //Calculo los puntos en base a las vueltas rápidas
        $cantidadVueltasRapidas = cantidadVueltasRapidasTemporada($nombre, $temporada, $tipo, $listaCarreras);
        $puntosPorVueltasRapidas = calcularPuntosPorVueltaRapida($cantidadVueltasRapidas, $temporada);
      }
      return $puntos + $puntosPorPoles + $puntosPorVueltasRapidas;
    }
    function cantidadVictoriasTemporada($nombre, $temporada, $tipo, $listaCarreras){
      $victorias = 0;
      foreach($listaCarreras as $carrera){
        if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
        else $posicionesCarrera = $carrera['posiciones_escuderias'];
        $posicionesCarrera = json_decode($posicionesCarrera, true);

        if(strpos($nombre, $posicionesCarrera[1]) != false || $nombre == $posicionesCarrera[1]) $victorias++;
      }
      return $victorias;
    }
    function cantidadVueltasRapidasTemporada($nombre, $temporada, $tipo, $listaCarreras){
      $vueltasRapidas = 0;
      foreach($listaCarreras as $carrera){
        if($tipo == 'piloto') $vueltaRapidaCarrera = $carrera['vuelta_rapida'];
        else $vueltaRapidaCarrera = $carrera['vuelta_rapida_escuderia'];

        if(strpos($nombre, $vueltaRapidaCarrera) != false || $nombre == $vueltaRapidaCarrera) $vueltasRapidas++;
      }
      return $vueltasRapidas;
    }
    function cantidadPolesTemporada($nombre, $temporada, $tipo, $listaCarreras){
      $poles = 0;
      foreach($listaCarreras as $carrera){
        if($tipo == 'piloto') $poleCarrera = $carrera['pole'];
        else $poleCarrera = $carrera['pole_escuderia'];

        if(strpos($nombre, $poleCarrera) != false || $nombre == $poleCarrera) $poles++;
      }
      return $poles;
    }
    function cantidadAbandonosTemporada($nombre, $temporada, $tipo, $listaCarreras){
      $abandonos = 0;
      foreach($listaCarreras as $carrera){
        if($tipo == 'piloto') $abandonosCarrera = '{ ' . str_replace(',', ' ', $carrera['abandonos']) . ' }';
        else $abandonosCarrera = '{ ' . str_replace(',', ' ', $carrera['abandonos_escuderias']) . ' }';
        
        if(strpos($abandonosCarrera, $nombre) != false) $abandonos = $abandonos + substr_count($abandonosCarrera, $nombre);
      }
      return $abandonos;
    }
    
    //***** Funciones para calcular las estadisticas generales *****\\
    function corrioEnF1($nombre, $tipo, $listaCarreras){
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
          else $posicionesCarrera = $carrera['posiciones_escuderias'];

          $posicionesCarrera = json_decode($posicionesCarrera, true);
          if(in_array($nombre, $posicionesCarrera)) return true;
        }
        return false;
    }
    function carrerasEnF1($nombre, $tipo, $listaCarreras){      
        $cantidadCarreras = 0;
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
          else $posicionesCarrera = $carrera['posiciones_escuderias'];

          $posicionesCarrera = json_decode($posicionesCarrera, true);
          if(in_array($nombre, $posicionesCarrera)) $cantidadCarreras++;
        }
        return $cantidadCarreras;
    }
    function polesEnF1($nombre, $tipo, $listaCarreras){
        $poles = 0;
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $poleCarrera = $carrera['pole'];
          else $poleCarrera = $carrera['pole_escuderia'];

          if(strpos($nombre, $poleCarrera) != false || $nombre == $poleCarrera) $poles++;
        }
        return $poles;
    }
    function podiosEnF1($nombre, $tipo, $listaCarreras){ 
        $podios = 0;
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
          else $posicionesCarrera = $carrera['posiciones_escuderias'];

          $posicionesCarrera = json_decode($posicionesCarrera, true);

          if(strpos($nombre, $posicionesCarrera[1]) != false || $nombre == $posicionesCarrera[1]) $podios++;
          else if(strpos($nombre, $posicionesCarrera[2]) != false || $nombre == $posicionesCarrera[2]) $podios++;
          else if(strpos($nombre, $posicionesCarrera[3]) != false || $nombre == $posicionesCarrera[3]) $podios++;
        }
        return $podios;
    }
    function vueltasRapidasEnF1($nombre, $tipo, $listaCarreras){
        $vueltasRapidas = 0;
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $vueltaRapidaCarrera = $carrera['vuelta_rapida'];
          else $vueltaRapidaCarrera = $carrera['vuelta_rapida_escuderia'];

          if(strpos($nombre, $vueltaRapidaCarrera) != false || $nombre == $vueltaRapidaCarrera) $vueltasRapidas++;
        }
        return $vueltasRapidas;
    }
    function abandonosEnF1($nombre, $tipo, $listaCarreras){    
        $abandonos = 0;
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $abandonosCarrera = '{ ' . str_replace(',', ' ', $carrera['abandonos']) . ' }';
          else $abandonosCarrera = '{ ' . str_replace(',', ' ', $carrera['abandonos_escuderias']) . ' }';
          
          if(strpos($abandonosCarrera, $nombre) != false) $abandonos = $abandonos + substr_count($abandonosCarrera, $nombre);
        }
        return $abandonos;
    }
    function victoriasEnF1($nombre, $tipo, $listaCarreras){ 
        $victorias = 0;
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
          else $posicionesCarrera = $carrera['posiciones_escuderias'];

          $posicionesCarrera = json_decode($posicionesCarrera, true);
          if(strpos($nombre, $posicionesCarrera[1]) != false || $nombre == $posicionesCarrera[1]) $victorias++;
        }
        return $victorias;
    }
    function mundialesDeF1($nombre, $tipo, $listaTemporadas){
        $mundiales = 0;
        foreach($listaTemporadas as $temporada){
          if($tipo == 'piloto') $campeon = $temporada['campeon_pilotos_f1'];
          else $campeon = $temporada['campeon_escuderias_f1'];

          if($nombre == $campeon) $mundiales++;
        }
        return $mundiales;
    }
    function ultimaParticipacionEnF1($nombre, $tipo, $listaCarreras){ 
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
          else $posicionesCarrera = $carrera['posiciones_escuderias'];

          $posicionesCarrera = json_decode($posicionesCarrera, true);
          if(in_array($nombre, $posicionesCarrera)) return $carrera['temporada'];
        }
        return "Error";
    }
    function escuderiasDePiloto($nombre, $listaCarreras){
      $escuderias = array();
      foreach($listaCarreras as $carrera){
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