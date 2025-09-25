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

function generateTileBoard($boardData) {
    if (empty($boardData)) {
        return '<p>No board data found.</p>';
    }

    $tileBoard = '<table class="tileboard">';

    foreach ($boardData as $row) {
        $tileBoard .= '<tr>';
        foreach ($row as $tileName) {
            $tileBoard .= '<td><div class=' . $tileName . '></td>';
        }
        $tileBoard .= '</tr>';
    }

    $tileBoard .= '</table>';
    return $tileBoard;
}

function getBoardData() {
    $boardData = [];
    
    if (($handle = fopen("data/board.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $boardData[] = $data;
        }
        fclose($handle);
    }
    
    return $boardData ?: null;
}

// Data
$boardData = getBoardData();
$outputBoard = generateTileBoard($boardData);

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
