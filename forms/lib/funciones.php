<?php

/* Zona de declaración de funciones */

//*******Funciones de debugueo********
function dump($var) {
    echo '<pre>' . print_r($var, true) . '</pre>';
}

//*******Funciones de presentación********
function getTableroMarkup($tablero, $posPersonaje) {
    $output = '';
    foreach ($tablero as $filaIndex => $datosFila) {
        foreach ($datosFila as $columnaIndex => $tileType) {
            if (isset($posPersonaje) && ($filaIndex == $posPersonaje['row']) && ($columnaIndex == $posPersonaje['col'])) {
                $output .= '<div class="tile ' . htmlspecialchars($tileType) . '"><img class="characters" src="./src/super_musculitos.png"></div>';    
            } else {
                $output .= '<div class="tile ' . htmlspecialchars($tileType) . '"></div>';
            }
        }
    }
    return $output;
}

function getMensajesMarkup($arrayMensajes) {
    $output = '';
    foreach ($arrayMensajes as $mensaje) {
        $output .= '<p>' . htmlspecialchars($mensaje) . '</p>';
    }
    return $output;
}

function getFormMarkup($arrows) {
    if (empty($arrows)) return '';

    $output = '';
    foreach ($arrows as $sentido => $arrayPos) {
        // Serialize position into a single hidden field
        $posSerialized = serialize(['row' => intval($arrayPos['row']), 'col' => intval($arrayPos['col'])]);
        $output .= '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">
            <input type="hidden" name="pos" value="' . htmlspecialchars($posSerialized) . '">
            <button type="submit">' . htmlspecialchars($sentido) . '</button>
            </form>';
    }
    
    return $output;
}

//*******Funciones de lógica de negocio********
function leerArchivoCSV($rutaArchivoCSV) {
    $tablero = [];
    if (($puntero = fopen($rutaArchivoCSV, "r")) !== false) {
        while (($datosFila = fgetcsv($puntero)) !== false) {
            $tablero[] = $datosFila;
        }
        fclose($puntero);
    }
    return $tablero;
}

function leerInput() {
    $posRaw = filter_input(INPUT_POST, 'pos', FILTER_UNSAFE_RAW);
    if ($posRaw === null || $posRaw === false || $posRaw === '') {
        return ['row' => 0, 'col' => 0];
    }

    // Unserialize safely
    $data = unserialize($posRaw, ['allowed_classes' => false]);
    if (!is_array($data) || !isset($data['row']) || !isset($data['col'])) {
        return ['row' => 0, 'col' => 0];
    }

    $row = filter_var($data['row'], FILTER_VALIDATE_INT);
    $col = filter_var($data['col'], FILTER_VALIDATE_INT);

    if ($row === false || $col === false) {
        return ['row' => 0, 'col' => 0];
    }

    // Clamp to board limits (0-11)
    $row = max(0, min(11, $row));
    $col = max(0, min(11, $col));

    return ['row' => $row, 'col' => $col];
}

/*function processRedirect() {
    if (!isset($_GET['row']) || !isset($_GET['col'])) {
        header('HTTP/1.1 308 Permanent Redirect');
        header('Location: ./index.php?row=0&col=0');
        exit();
    }
}*/

function getMensajes(&$posPersonaje) {
    if (!isset($posPersonaje)) {
        return ['La posición del personaje no está bien definida'];
    }

    if (
        $posPersonaje['row'] < 0 || $posPersonaje['row'] > 11 ||
        $posPersonaje['col'] < 0 || $posPersonaje['col'] > 11
    ) {
        return ['El valor de la posición del personaje es incorrecto.'];
    }

    return []; // Return empty array instead of array with empty string
}

function getArrows($posPersonaje) {
    if (!isset($posPersonaje)) return [];
    
    $arrows = [];

    if ($posPersonaje['row'] > 0) {
        $arrows['Arriba'] = ['row' => $posPersonaje['row'] - 1, 'col' => $posPersonaje['col']];
    }
    if ($posPersonaje['row'] < 11) {
        $arrows['Abajo'] = ['row' => $posPersonaje['row'] + 1, 'col' => $posPersonaje['col']];
    }
    if ($posPersonaje['col'] > 0) {
        $arrows['Izquierda'] = ['row' => $posPersonaje['row'], 'col' => $posPersonaje['col'] - 1];
    }
    if ($posPersonaje['col'] < 11) {
        $arrows['Derecha'] = ['row' => $posPersonaje['row'], 'col' => $posPersonaje['col'] + 1];
    }

    return $arrows;
}
