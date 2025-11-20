<?php

/* Configuration and initialization */
// Enable output buffering to prevent header errors
define('TOTAL_STEPS', 7);
ob_start();
session_start();

// Initialize required classes
require_once __DIR__ . '/src/Controllers/FormController.php';

// Initialize session variables
if (!isset($_SESSION['step'])) {
    $_SESSION['step'] = 1;
}

if (!isset($_SESSION['form_data'])) {
    $_SESSION['form_data'] = [];
}

// Initialize controller
$controller = new FormController();

// Handle form requests
$controller->handleRequest();

// Get current state
$step = $controller->getCurrentStep();
$errors = $controller->getErrors();
$formData = $controller->getFormData();
$muscles = $controller->getMuscles();

// Determine which view file to load
$viewFile = __DIR__ . '/src/Views/step' . $step . '.php';

// Render the view
include __DIR__ . '/src/Views/layout.php';

// Flush output buffer
ob_end_flush();