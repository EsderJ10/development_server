<?php
// Prepare data
$summary = $controller->getPlanSummary();
$plans = $summary['plans'];
$selectedPlan = $summary['selectedPlan'];

// Format data for display
$profileImageUrl = 'uploads/' . htmlspecialchars($formData['profile_pic']);
$userName = htmlspecialchars($formData['name']);
$userEmail = htmlspecialchars($formData['email']);
$userGender = htmlspecialchars(ucfirst($formData['gender']));
$userMuscle = htmlspecialchars($muscles[$formData['main_muscle']]);
$muscleNames = array_map(function($m) use ($muscles) { return $muscles[$m]; }, $formData['muscles']); 
$allMuscles = htmlspecialchars(implode(', ', $muscleNames));
$currentPerf = htmlspecialchars($formData['weight']) . ' kg x ' . htmlspecialchars($formData['reps']) . ' reps';
$selectedPlanName = htmlspecialchars($selectedPlan['name']);
$targetPerf = htmlspecialchars($selectedPlan['target_weight']) . ' kg x ' . htmlspecialchars($selectedPlan['target_reps']) . ' reps';
$timelineWeeks = htmlspecialchars($selectedPlan['weeks']);
$intensity = htmlspecialchars($selectedPlan['intensity']);
?>

<form method="POST">
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 class="step-title">Your Personalized Plan is Ready!</h2>
    </div>
    
    <div class="profile-section">
        <img src="<?php echo $profileImageUrl; ?>" alt="Profile photo" class="profile-image">
        <h3><?php echo $userName; ?></h3>
        <p><?php echo $userEmail; ?></p>
    </div>
    
    <div class="summary-card">
        <h3 style="color: #667eea; margin-bottom: 15px;">Your Plan Summary</h3>
        
        <?php $label = 'Sex'; $value = $userGender; include __DIR__ . '/components/summary-item.php'; ?>
        <?php $label = 'Target muscles'; $value = $allMuscles; include __DIR__ . '/components/summary-item.php'; ?>
        <?php $label = 'Main muscle'; $value = $userMuscle; include __DIR__ . '/components/summary-item.php'; ?>
        <?php $label = 'Current performance'; $value = $currentPerf; include __DIR__ . '/components/summary-item.php'; ?>
        <?php $label = 'Selected plan'; $value = $selectedPlanName; include __DIR__ . '/components/summary-item.php'; ?>
        <?php $label = 'Target'; $value = $targetPerf; include __DIR__ . '/components/summary-item.php'; ?>
        <?php $label = 'Timeline'; $value = $timelineWeeks . ' weeks'; include __DIR__ . '/components/summary-item.php'; ?>
        <?php $label = 'Intensity'; $value = $intensity; include __DIR__ . '/components/summary-item.php'; ?>
    </div>
    
    <div class="success" style="margin-top: 20px;">
        <strong>Success! Your training plan has been created</strong>
        <p>• All information has been saved successfully</p>
        <p>• You will receive detailed instructions via email within 24 hours</p>
        <p>• Check your spam folder if you don't see our email</p>
    </div>
    
    <div class="closing-message">
        <p style="margin: 0; font-size: 1.1rem; font-weight: 500;">
            Good luck with your training journey!<br>
            <small style="opacity: 0.9;">Stay consistent and track your progress</small>
        </p>
    </div>
    
    <div class="buttons">
        <button type="submit" name="reset" class="btn-primary">Create New Plan</button>
    </div>
</form>
