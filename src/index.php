<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Logic Functions
function dump($var) {
    echo '<pre>' . print_r($var, 1) . '</pre>';
}

/* DONE IN CSS
function getTileImage($tile) {
    $tileTypes = [
        "brick" => "./images/brick.jpg",
        "dirt" => "./images/dirt.jpg",
        "ice" => "./images/ice.jpg",
        "sand" => "./images/sand.jpg",
        "stone" => "./images/stone.jpg"
    ];

    return $tileTypes[$tile] ?? null;
}
    */

function generateTileBoard($boardData, $characterPosition, $characterName) {
    if (empty($boardData)) {
        return '<p>No board data found.</p>';
    }

    $tileBoard = '<table class="tileboard">';
    $tileBoard .= '<tr>';
    $counter = 0;
    
    foreach ($boardData as $row) {
        foreach ($row as $tileName) {
            $counter++;
            if ($counter == $characterPosition) {
                $tileBoard .= '<td><div class=' . $tileName . '> <div class='. $characterName . '></td>';
            } else {
                $tileBoard .= '<td><div class=' . $tileName . '></td>';
            }
        }
        $tileBoard .= '</tr>';
    }

    $tileBoard .= '</table>';
    return $tileBoard;
}

function getBoardData($filePath) {
    $boardData = [];
    
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $boardData[] = $data;
        }
        fclose($handle);
    }
    
    return $boardData ?: null;
}

function setCharacterPosition() {
    return rand(0, 143);
}

// Data
$characterPosition = setCharacterPosition();
$boardData = getBoardData("data/board.csv");
$outputBoard = generateTileBoard($boardData, $characterPosition, "frog");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tileboard</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <h1>Tile Board</h1>
    <?php echo $outputBoard; ?>
</body>
</html>
