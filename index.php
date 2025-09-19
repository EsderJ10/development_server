<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Logic
function dump($var) {
    echo '<pre>'. print_r($var, 1) . '</pre>';
}

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


function generateTileBoard($boardData) {
   if (!isset($boardData) || empty($boardData)) {
      return '<p>No board data found.</p>';
   }

   $tileBoard = '<table class="tileboard">';

   // Iterate through the multidimensional array
   foreach ($boardData as $row) {
      $tileBoard .= '<tr>';
      foreach ($row as $tileName) {
         $tile = getTileImage($tileName);
         $tileBoard .= '<td><img src="' . $tile . '" alt="' . $tileName . '"></td>';
      }
      $tileBoard .= '</tr>';
   }
   $tileBoard .= '</table>';
   return $tileBoard;
}


// Data
$boardData = [
   ["ice", "dirt", "stone", "sand", "dirt", "brick", "sand", "dirt", "brick", "ice", "brick", "ice"],
   ["stone", "sand", "dirt", "stone", "dirt", "ice", "stone", "dirt", "ice", "brick", "ice", "brick"],
   ["dirt", "stone", "sand", "dirt", "stone", "sand", "dirt", "stone", "sand", "ice", "sand", "brick"],
   ["sand", "brick", "dirt", "stone", "sand", "dirt", "stone", "brick", "stone", "ice", "stone", "dirt"],
   ["brick", "dirt", "sand", "brick", "stone", "dirt", "brick", "ice", "sand", "stone", "brick", "ice"],
   ["ice", "stone", "sand", "brick", "dirt", "stone", "dirt", "brick", "stone", "sand", "dirt", "stone"],
   ["dirt", "stone", "ice", "dirt", "sand", "stone", "sand", "dirt", "ice", "brick", "stone", "sand"],
   ["stone", "sand", "brick", "ice", "dirt", "stone", "dirt", "brick", "stone", "ice", "dirt", "brick"],
   ["sand", "stone", "dirt", "sand", "brick", "stone", "brick", "dirt", "ice", "stone", "sand", "ice"],
   ["brick", "dirt", "ice", "stone", "sand", "brick", "sand", "dirt", "stone", "dirt", "stone", "sand"],
   ["ice", "stone", "sand", "dirt", "brick", "stone", "brick", "sand", "stone", "dirt", "ice", "brick"],
   ["dirt", "stone", "ice", "stone", "sand", "dirt", "stone", "brick", "dirt", "ice", "sand", "stone"]
];

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
   <?php echo $outputBoard ?>
</body>


</html>