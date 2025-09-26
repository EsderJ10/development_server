<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./app/logic.php";
require_once "./app/render.php";

// Main execution
$tileboard = initializeTileboard("data/board.csv");

if ($tileboard) {
    $errorMessage = '';
    $frog = createCharacter("Frog", "frog", $_GET['characterPosition'] ,$tileboard['board_size']);
    if ($frog['position'] == null) {
        $errorMessage .= '<p> ERROR: Character position is not valid </p>';
    } else {
        addCharacterToBoard($tileboard, $frog);
    }
    $outputBoard = renderBoard($tileboard);
} else {
    $outputBoard = '<p>Error loading tileboard.</p>';
}
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
    <?php 
    echo $errorMessage;
    echo $outputBoard;
    ?>
</body>
</html>
