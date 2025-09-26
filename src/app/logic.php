<?php
// Board
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

function getBoardDimensions($boardData) {
    if (empty($boardData)) {
        return ['rows' => 0, 'cols' => 0];
    }
    return [
        'rows' => count($boardData),
        'cols' => count($boardData[0])
    ];
}

// Characters
function createCharacter($name, $class, $position = null, $boardDimensions = null) {
    $validPosition = null;
    if ($position && $boardDimensions && isValidPosition($position, $boardDimensions)) {
        $validPosition = $position;
    }
    
    return [
        'name' => $name,
        'class' => $class,
        'position' => $validPosition
    ];
}

function findCharacterAtPosition($characters, $position) {
    if (!$position || !is_array($position)) {
        return null;
    }
    
    foreach ($characters as $character) {
        if ($character['position'] && 
            $character['position'][0] === $position[0] && 
            $character['position'][1] === $position[1]) {
            return $character;
        }
    }
    return null;
}

function validateCharacterPositions($characters, $boardDimensions) {
    $validCharacters = [];
    foreach ($characters as $character) {
        if (isValidPosition($character['position'], $boardDimensions)) {
            $validCharacters[] = $character;
        }
    }
    return $validCharacters;
}

// Tileboard
function initializeTileboard($boardFilePath) {
    $boardData = getBoardData($boardFilePath);
    if (!$boardData) {
        return null;
    }
    return [
        'board' => $boardData,
        'board_dimensions' => getBoardDimensions($boardData),
        'characters' => []
    ];
}

function addCharacterToBoard(&$boardData, $character) {
    if ($boardData && is_array($boardData['characters'])) {
        $boardData['characters'][] = $character;
    }
}

function parsePosition($positionString) {
    if (empty($positionString)) {
        return null;
    }
    
    if (strpos($positionString, ',') !== false) {
        $parts = explode(',', $positionString);
        if (count($parts) == 2) {
            $row = (int)trim($parts[0]);
            $col = (int)trim($parts[1]);
            return [$row, $col];
        }
    }
    
    return null;
}

function isValidPosition($position, $boardDimensions) {
    if (!$position || !is_array($position) || count($position) != 2) {
        return false;
    }
    
    [$row, $col] = $position;
    return $row >= 0 && $row < $boardDimensions['rows'] && 
           $col >= 0 && $col < $boardDimensions['cols'];
}

// Not used (just for fun)
/*
function generateRandomPosition($boardDimensions) {
    return [
        rand(0, $boardDimensions['rows'] - 1),
        rand(0, $boardDimensions['cols'] - 1)
    ];
}
*/