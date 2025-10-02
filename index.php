<?php

/***** Inicialización del entorno ******/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/* Zona de declaración de funciones */
//*******Funciones de debugueo****
function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

//*******Función lógica presentación**********+
function getTableroMarkup ($tablero, $posPersonaje){
    $output = '';

    foreach ($tablero as $filaIndex => $datosFila) {
        foreach ($datosFila as $columnaIndex => $tileType) {
            if ($posPersonaje !== null 
                && $filaIndex === $posPersonaje['row'] 
                && $columnaIndex === $posPersonaje['col']) {
                $output .= '<div class="tile ' . $tileType . '"><img class="characters" src="./src/super_musculitos.png"></div>';    
            } else {
                $output .= '<div class="tile ' . $tileType . '"></div>';
            }
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

    return ((isset($col) && is_numeric($col)) && (isset($row) && is_numeric($row))) ? array(
            'row' => $row,
            'col' => $col
        ) : null;    
}

function moveCharacter($direction, $row, $col) {
    switch ($direction) {
        case 'up':    
            $row--; 
            break;
        case 'down':  
            $row++; 
            break;
        case 'left':  
            $col--; 
            break;
        case 'right': 
            $col++; 
            break;
    }
    return "<a href=\"index.php?row={$row}&col={$col}\">" . strtoupper($direction) . "</a>";
}


//*****Lógica de negocio***********
//Extracción de las variables de la petición


$posPersonaje = leerInput();
$tablero = leerArchivoCSV('./data/tablero1.csv');



//*****+++Lógica de presentación*******
$tableroMarkup = getTableroMarkup($tablero, $posPersonaje);
$message = '';

if ($posPersonaje === null) {
    $message = '<pre style="color:red; text-wrap: wrap;">* ERROR: Parámetros "row" y/o "col" no declarados o inválidos</pre>';
} elseif ($posPersonaje['row'] < 0 || $posPersonaje['row'] > 11 
       || $posPersonaje['col'] < 0 || $posPersonaje['col'] > 11) {
    $message = '<pre style="color:red; text-wrap: wrap;">* ERROR: La posición del personaje está fuera de los límites del tablero</pre>';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <title>Document</title>
    <style>
        .contenedorTablero {
            width:600px;
            height:600px;
            border: solid 2px grey;
            box-shadow: grey;
            display:grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(12, 1fr);
        }
        .tile {
            float: left;
            margin: 0;
            padding: 0;
            border-width: 0;
            background-image: url("./src/464.jpg");
            background-size: 209px;
            background-repeat: none;
            overflow: hidden;
        }
        .tile img{
            max-width:100%;
        }
        .fuego {
            background-color: red;
            background-position: -105px -52px;
        }
        .tierra {
            background-color: brown;
            background-position: -157px 0px;
        }
        .agua {
            background-color: blue;
            background-position: -53px 0px;
        }
        .hierba {
            background-color: green;
            background-position: 0px 0px;
        }

        .container-controls {
            margin-top: 20px;
        }
        .container-controls a {
            display: inline-block;
            margin-right: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            width: 120px;
        }
        .container-controls a:hover {
            background-color: #0056b3;
        }
        
        .upper-row {
            text-align: center;
            margin-bottom: 10px;
        }
        .bottom-row {
            text-align: center;
        }

        .characters {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>
<body>
    <h1>Tablero juego super rol DWES</h1>
    <?php echo $message; ?>
    <div class="contenedorTablero">
        <?php echo $tableroMarkup; ?>
    </div>

    <div class="container-controls">
        <div class="upper-row">
            <?= moveCharacter('up', $posPersonaje['row'] ?? 0, $posPersonaje['col'] ?? 0) ?>
        </div>
        <div class="bottom-row">
            <?= moveCharacter('left', $posPersonaje['row'] ?? 0, $posPersonaje['col'] ?? 0) ?>
            <?= moveCharacter('down', $posPersonaje['row'] ?? 0, $posPersonaje['col'] ?? 0) ?>
            <?= moveCharacter('right', $posPersonaje['row'] ?? 0, $posPersonaje['col'] ?? 0) ?>
        </div>
    </div>
</body>
</html>