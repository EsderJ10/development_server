<?php

/* Zona de declaración de funciones */
//*******Funciones de debugueo****
function dump($var){
    global $miVariable;
    echo $miVariable;
    echo '<pre>'.print_r($var,1).'</pre>';
}

//*******Función lógica presentación**********+
function getTableroMarkup ($tablero, $posPersonaje){
    $output = '';
    foreach ($tablero as $filaIndex => $datosFila) {
        foreach ($datosFila as $columnaIndex => $tileType) {
            if(isset($posPersonaje)&&($filaIndex == $posPersonaje['row'])&&($columnaIndex == $posPersonaje['col'])){
                $output .= '<div class = "tile ' . $tileType . '"><img class="characters" src="./src/super_musculitos.png"></div>';    
            }else{
                $output .= '<div class = "tile ' . $tileType . '"></div>';
            }
        }
    }
    return $output;
}
function getMensajesMarkup($arrayMensajes){
    $output = '';
    foreach ($arrayMensajes as $mensaje){
        $output .= '<p>'.$mensaje.'</p>';
    }
    return $output;
    
}
function getArrowsMarkup($arrows){
    $output = '';
    if(isset($arrows)){
        foreach($arrows as $sentido => $arrayPos){
            $output .= '<a href="./index.php?col='.$arrayPos['col'].'&row='.$arrayPos['row'].'">'.$sentido.'</a> ';
        }
    }
    
    return $output;
    
}

//******+Función Lógica de negocio************
//El tablero es un array bidimensional en el que cada fila contiene 12 palabras cuyos valores pueden ser:
// agua
//fuego
//tierra
// hierba
function leerArchivoCSV($rutaArchivoCSV) {
    $tablero = [];

    if (($puntero = fopen($rutaArchivoCSV, "r")) !== FALSE) {
        while (($datosFila = fgetcsv($puntero)) !== FALSE) {
            $tablero[] = $datosFila;
        }
        fclose($puntero);
    }

    return $tablero;
}
function leerInput(){    
    $col = filter_input(INPUT_GET, 'col', FILTER_VALIDATE_INT);
    $row = filter_input(INPUT_GET, 'row', FILTER_VALIDATE_INT);

    return (isset($col) && is_int($col) && isset($row) && is_int($row))? array(
            'row' => $row,
            'col' => $col
        ) : null;
}

function processRedirect() {
    if (!isset($_GET['row']) && !isset($_GET['col'])) {
        header('HTTP/1.1 308 Permanent Redirect');
        header('Location: ./index.php?row=0&col=0');
    }
}

function getMensajes(&$posPersonaje){
    if(!isset($posPersonaje)){
        return array('La posición del personaje no está bien definida');
    } else if ($posPersonaje['row'] < 0 || $posPersonaje['row'] > 11 || 
               $posPersonaje['col'] < 0 || $posPersonaje['col'] > 11) {
                return array('El valor de la posición del personaje es incorrecto.');
               }
    return array('');
}

function getArrows($posPersonaje){
    if(isset($posPersonaje) && $posPersonaje['row'] >= 0 && $posPersonaje['row'] <= 11 && 
               $posPersonaje['col'] >= 0 && $posPersonaje['col'] <= 11){

        $arrows = array(
            'izquierda' => array(
                'row' => $posPersonaje['row'],
                'col' => $posPersonaje['col'] -1 < 0 ? 11 : $posPersonaje['col'] -1 ,
            ),
            'arriba' => array(
                'row' => $posPersonaje['row'] -1 < 0 ? 11 : $posPersonaje['row'] -1,
                'col' => $posPersonaje['col'] ,
            ),
            'derecha' => array(
                'row' => $posPersonaje['row'],
                'col' => $posPersonaje['col'] +1 > 11 ? 0 : $posPersonaje['col'] +1,
            ),
            'abajo' => array(
                'row' => $posPersonaje['row'] +1 > 11 ? 0 : $posPersonaje['row'] +1,
                'col' => $posPersonaje['col'],
            ),
        );
        return $arrows;
    }
    return null;

}