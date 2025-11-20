<?php
// Move plan generation to controller
$plans = $controller->generatePlans(
    $formData['main_muscle'],
    $formData['weight'],
    $formData['reps']
);
$selectedPlan = $formData['plan'] ?? null;
$muscles = $controller->getMuscles();
?>

<form method="POST">
    <h2 class="step-title">Select Your Plan</h2>
    <?php foreach ($plans as $index => $plan): ?>
        <?php ViewHelper::renderPlanCard($plan, $index, $selectedPlan, $muscles); ?>
    <?php endforeach; ?>

    <?php ViewHelper::renderButtons(true, 'Next →'); ?>
</form>
