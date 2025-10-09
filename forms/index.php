<?php

/***** Inicialización del entorno ******/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('./lib/funciones.php');

processRedirect();
$posPersonaje = leerInput();
$arrows = getArrows($posPersonaje);
$tablero = leerArchivoCSV('./data/tablero1.csv');
$mensajes =  getMensajes($posPersonaje);


//*****+++Lógica de presentación*******
$tableroMarkup = getTableroMarkup($tablero, $posPersonaje);
$mensajesUsuarioMarkup = getMensajesMarkup($mensajes);
$arrowsMarkup = getArrowsMarkup($arrows);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <title>Tablero</title>
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

        .arrowsContainer {
            display: flex;
            flex-direction: row;
            margin: 20px;
            justify-content: center;
        }
        .arrowsContainer button {
            display: inline-block;
            margin-right: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            width: 120px;
            text-align: center;
        }
        .arrowsContainer button:hover {
            background-color: #0056b3;
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
    <div class="arrowsContainer">
        <?php echo $arrowsMarkup; ?>
    </div>
    <div class="mensajesContainer"><?php echo $mensajesUsuarioMarkup; ?></div>
    <div class="contenedorTablero">
        <?php echo $tableroMarkup; ?>
    </div>
    
</body>
</html>