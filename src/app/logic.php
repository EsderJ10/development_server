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

function getBoardSize($boardData) {
    if (empty($boardData)) {
        return 0;
    }
    return count($boardData) * count($boardData[0]);
}

// Characters
function createCharacter($name, $class, $position = null, $boardSize = 144) {
    return [
        'name' => $name,
        'class' => $class,
        'position' => $position ?? rand(1, $boardSize)
    ];
}

function generateRandomPosition($boardSize = 144) {
    return rand(1, $boardSize);
}

function findCharacterAtPosition($characters, $position) {
    foreach ($characters as $character) {
        if ($character['position'] === $position) {
            return $character;
        }
    }
    return null;
}

function validateCharacterPositions($characters, $boardSize) {
    $validCharacters = [];
    foreach ($characters as $character) {
        if ($character['position'] >= 1 && $character['position'] <= $boardSize) {
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
        'board_size' => getBoardSize($boardData),
        'characters' => []
    ];
}

function addCharacterToBoard(&$boardData, $character) {
    if ($boardData && is_array($boardData['characters'])) {
        $boardData['characters'][] = $character;
    }
}
