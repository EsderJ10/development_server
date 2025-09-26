<?php
require_once "logic.php";

function renderTileBoard($boardData, $characters = []) {
    if (empty($boardData)) {
        return '<p>No board data found.</p>';
    }
    
    $boardDimensions = getBoardDimensions($boardData);
    $validCharacters = validateCharacterPositions($characters, $boardDimensions);
    
    $html = '<div class="tileboard">';
    
    for ($row = 0; $row < $boardDimensions['rows']; $row++) {
        for ($col = 0; $col < $boardDimensions['cols']; $col++) {
            $tileName = $boardData[$row][$col];
            $currentPosition = [$row, $col];
            $character = findCharacterAtPosition($validCharacters, $currentPosition);
            $html .= renderTile($tileName, $character, $currentPosition);
        }
    }
    
    $html .= '</div>';
    return $html;
}

function renderTile($tileName, $character = null, $position = null) {
    $positionClass = '';
    if ($position) {
        $positionClass = ' position-' . $position[0] . '-' . $position[1];
    }
    
    $html = '<div class="tile ' . htmlspecialchars($tileName) . $positionClass . '">';
    if ($character) {
        $html .= renderCharacter($character);
    }
    $html .= '</div>';
    return $html;
}

function renderCharacter($character) {
    return '<div class="character ' . htmlspecialchars($character['class']) .'"></div>';
}

function renderBoard($boardData) {
    if (!$boardData) {
        return '<p>Failed to render tileboard.</p>';
    }
    return renderTileBoard($boardData['board'], $boardData['characters']);
}