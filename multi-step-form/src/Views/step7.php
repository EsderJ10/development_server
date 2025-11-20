<?php
$summary = $controller->getPlanSummary();
$plans = $summary['plans'];
$selectedPlan = $summary['selectedPlan'];

$profileImageUrl = ViewHelper::getUploadedImageSrc($formData['profile_pic']);
?>

<form method="POST">
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 class="step-title">Your Personalized Plan is Ready!</h2>
    </div>
    
    <div class="profile-section">
        <img src="<?php echo $profileImageUrl; ?>" alt="Profile photo" class="profile-image">
        <h3><?php echo htmlspecialchars($formData['name']); ?></h3>
        <p><?php echo htmlspecialchars($formData['email']); ?></p>
    </div>
    
    <div class="summary-card">
        <h3 style="color: #667eea; margin-bottom: 15px;">Your Plan Summary</h3>
        
        <?php ViewHelper::renderSummaryItem('Sex', ucfirst(htmlspecialchars($formData['gender']))); ?>
        <?php ViewHelper::renderSummaryItem('Target muscles', ViewHelper::formatMuscleList($muscles, $formData['muscles'])); ?>
        <?php ViewHelper::renderSummaryItem('Main muscle', htmlspecialchars($muscles[$formData['main_muscle']])); ?>
        <?php ViewHelper::renderSummaryItem('Current performance', ViewHelper::formatStats($formData['weight'], $formData['reps'])); ?>
        <?php ViewHelper::renderSummaryItem('Selected plan', htmlspecialchars($selectedPlan['name'])); ?>
        <?php ViewHelper::renderSummaryItem('Target', ViewHelper::formatTargetStats($selectedPlan['target_weight'], $selectedPlan['target_reps'])); ?>
        <?php ViewHelper::renderSummaryItem('Timeline', htmlspecialchars($selectedPlan['weeks']) . ' weeks'); ?>
        <?php ViewHelper::renderSummaryItem('Intensity', htmlspecialchars($selectedPlan['intensity'])); ?>
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
