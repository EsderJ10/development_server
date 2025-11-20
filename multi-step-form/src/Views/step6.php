<?php
$formData = $controller->getFormData();
$muscles = $controller->getMuscles();
$selectedPlan = $controller->getSelectedPlan($formData['plan']);

$profilePicSrc = ViewHelper::getTempImageSrc($controller, $formData['profile_pic'] ?? '');
?>

<form method="POST">
    <h2 class="step-title">Confirm Your Details</h2>
    
    <div class="summary-card">
        <h3 style="color: #667eea; margin-bottom: 15px;">Personal Information</h3>
        
        <?php 
            ViewHelper::renderSummaryItem('Name', htmlspecialchars($formData['name']));  
            ViewHelper::renderSummaryItem('Email', htmlspecialchars($formData['email'])); 
        ?>

        <?php ViewHelper::renderProfileSummary($profilePicSrc); ?>

        <h3 style="color: #667eea; margin-bottom: 15px; margin-top: 20px;">Workout Plan</h3>
        
        <?php ViewHelper::renderSummaryItem('Gender', ucfirst(htmlspecialchars($formData['gender']))); ?>
        <?php ViewHelper::renderSummaryItem('Target Muscles', ViewHelper::formatMuscleList($muscles, $formData['muscles'])); ?>
        <?php ViewHelper::renderSummaryItem('Main Muscle', htmlspecialchars($muscles[$formData['main_muscle']])); ?>
        <?php ViewHelper::renderSummaryItem('Current Stats', ViewHelper::formatStats($formData['weight'], $formData['reps'])); ?>
        <?php ViewHelper::renderSummaryItem('Selected Plan', htmlspecialchars($selectedPlan['name'])); ?>
    </div>

    <?php ViewHelper::renderButtons(true, 'Confirm & Submit', '← Edit'); ?>
</form>
