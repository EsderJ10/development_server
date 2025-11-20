<?php
// Move plan generation to controller
$plans = $controller->generatePlans(
    $formData['muscle'],
    $formData['weight'],
    $formData['reps']
);
$selectedPlan = $formData['plan'] ?? null;
$muscles = $controller->getMuscles();
?>

<form method="POST">
    <h2 class="step-title">Select Your Plan</h2>
    <?php foreach ($plans as $index => $plan): ?>
        <?php include __DIR__ . '/components/plan-card.php'; ?>
    <?php endforeach; ?>

    <?php $showPrevious = true; $nextButtonText = 'Next →'; include __DIR__ . '/components/form-buttons.php'; ?>
</form>
