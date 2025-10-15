<?php

/***** Inicialización del entorno ******/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('./lib/funciones.php');

//processRedirect();
$posPersonaje = leerInput();
$arrows = getArrows($posPersonaje);
$tablero = leerArchivoCSV('./data/tablero1.csv');
$mensajes =  getMensajes($posPersonaje);


//*****+++Lógica de presentación*******
$tableroMarkup = getTableroMarkup($tablero, $posPersonaje);
$mensajesUsuarioMarkup = getMensajesMarkup($mensajes);
$formMarkup = getFormMarkup($arrows);

include_once('./templates/index.tpl.php')
?>
