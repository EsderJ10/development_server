<?php
require_once "logic.php";

function renderTileBoard($boardData, $characters = []) {
    if (empty($boardData)) {
        return '<p>No board data found.</p>';
    }

    $boardSize = getBoardSize($boardData);
    $validCharacters = validateCharacterPositions($characters, $boardSize);

    $html = '<div class="tileboard">';
    $position = 0;

    foreach ($boardData as $row) {
        foreach ($row as $tileName) {
            $position++;
            $character = findCharacterAtPosition($validCharacters, $position);
            $html .= renderTile($tileName, $character);
        }
    }

    $html .= '</div>';
    return $html;
}

function renderTile($tileName, $character = null) {
    $html = '<div class="tile ' . htmlspecialchars($tileName) . '">';
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
