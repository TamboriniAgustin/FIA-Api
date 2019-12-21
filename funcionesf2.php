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
    function calcularPuntos($posicion, $temporada, $tipoCarrera){
      if($temporada >= 2017){
        if($tipoCarrera == "Feature"){
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
        else if($tipoCarrera == "Sprint"){
          switch ($posicion) {
            case 1: return 15;
            case 2: return 12;
            case 3: return 10;
            case 4: return 8;
            case 5: return 6;
            case 6: return 4;
            case 7: return 2;
            case 8: return 1;
            default: return 0;
          }
        }
      }
    }
    function calcularPuntosPorPole($poles, $temporada){
      if($temporada >= 2017) return $poles * 4;
      return 0;
    }
    function calcularPuntosPorVueltaRapida($vueltasRapidas, $temporada){
      if($temporada >= 2017) return $vueltasRapidas * 2;
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
        if($temporada >= 2017){
          if($carrera['tipo'] == "Feature"){
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
          else if($carrera['tipo'] == "Sprint"){
            if(strpos($nombre, $posicionesCarrera[1]) != false || $nombre == $posicionesCarrera[1]) $puntos = $puntos + 15;
            if(strpos($nombre, $posicionesCarrera[2]) != false || $nombre == $posicionesCarrera[2]) $puntos = $puntos + 12;
            if(strpos($nombre, $posicionesCarrera[3]) != false || $nombre == $posicionesCarrera[3]) $puntos = $puntos + 10;
            if(strpos($nombre, $posicionesCarrera[4]) != false || $nombre == $posicionesCarrera[4]) $puntos = $puntos + 8;
            if(strpos($nombre, $posicionesCarrera[5]) != false || $nombre == $posicionesCarrera[5]) $puntos = $puntos + 6;
            if(strpos($nombre, $posicionesCarrera[6]) != false || $nombre == $posicionesCarrera[6]) $puntos = $puntos + 4;
            if(strpos($nombre, $posicionesCarrera[7]) != false || $nombre == $posicionesCarrera[7]) $puntos = $puntos + 2;
            if(strpos($nombre, $posicionesCarrera[8]) != false || $nombre == $posicionesCarrera[8]) $puntos = $puntos + 1;
          }
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

        if($carrera['tipo'] == "Feature"){
          if(strpos($nombre, $poleCarrera) != false || $nombre == $poleCarrera) $poles++;
        }
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
    function corrioEnF2($nombre, $tipo, $listaCarreras){  
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
          else $posicionesCarrera = $carrera['posiciones_escuderias'];

          $posicionesCarrera = json_decode($posicionesCarrera, true);
          if(in_array($nombre, $posicionesCarrera)) return true;
        }
        return false;
    }
    function carrerasEnF2($nombre, $tipo, $listaCarreras){
        $cantidadCarreras = 0;
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
          else $posicionesCarrera = $carrera['posiciones_escuderias'];

          $posicionesCarrera = json_decode($posicionesCarrera, true);
          if(in_array($nombre, $posicionesCarrera)) $cantidadCarreras++;
        }
        return $cantidadCarreras;
    }
    function polesEnF2($nombre, $tipo, $listaCarreras){      
        $poles = 0;
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $poleCarrera = $carrera['pole'];
          else $poleCarrera = $carrera['pole_escuderia'];

          if(strpos($nombre, $poleCarrera) != false || $nombre == $poleCarrera) $poles++;
        }
        return $poles;
    }
    function podiosEnF2($nombre, $tipo, $listaCarreras){
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
    function vueltasRapidasEnF2($nombre, $tipo, $listaCarreras){
        $vueltasRapidas = 0;
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $vueltaRapidaCarrera = $carrera['vuelta_rapida'];
          else $vueltaRapidaCarrera = $carrera['vuelta_rapida_escuderia'];

          if(strpos($nombre, $vueltaRapidaCarrera) != false || $nombre == $vueltaRapidaCarrera) $vueltasRapidas++;
        }
        return $vueltasRapidas;
    }
    function abandonosEnF2($nombre, $tipo, $listaCarreras){ 
        $abandonos = 0;
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $abandonosCarrera = '{ ' . str_replace(',', ' ', $carrera['abandonos']) . ' }';
          else $abandonosCarrera = '{ ' . str_replace(',', ' ', $carrera['abandonos_escuderias']) . ' }';

          if(strpos($abandonosCarrera, $nombre) != false) $abandonos = $abandonos + substr_count($abandonosCarrera, $nombre);
        }
        return $abandonos;
    }
    function victoriasEnF2($nombre, $tipo, $listaCarreras){
        $victorias = 0;
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
          else $posicionesCarrera = $carrera['posiciones_escuderias'];

          $posicionesCarrera = json_decode($posicionesCarrera, true);
          if(strpos($nombre, $posicionesCarrera[1]) != false || $nombre == $posicionesCarrera[1]) $victorias++;
        }
        return $victorias;
    }
    function mundialesDeF2($nombre, $tipo, $listaTemporadas){      
        $mundiales = 0;
        foreach($listaTemporadas as $temporada){
          if($tipo == 'piloto') $campeon = $temporada['campeon_pilotos_f2'];
          else $campeon = $temporada['campeon_escuderias_f2'];

          if($nombre == $campeon) $mundiales++;
        }
        return $mundiales;
    }
    function ultimaParticipacionEnF2($nombre, $tipo, $listaCarreras){      
        foreach($listaCarreras as $carrera){
          if($tipo == 'piloto') $posicionesCarrera = $carrera['posiciones_pilotos'];
          else $posicionesCarrera = $carrera['posiciones_escuderias'];

          $posicionesCarrera = json_decode($posicionesCarrera, true);
          if(in_array($nombre, $posicionesCarrera)) return $carrera['temporada'];
        }
        return "Error";
    }
?>