<?php
$formData = $controller->getFormData();
$muscles = $controller->getMuscles();
$selectedPlan = $controller->getSelectedPlan($formData['plan']);
?>

<form method="POST">
    <h2 class="step-title">Confirm Your Details</h2>
    
    <div class="summary-card">
        <h3 style="color: #667eea; margin-bottom: 15px;">Personal Information</h3>
        <?php 
        $label = 'Name'; 
        $value = htmlspecialchars($formData['name']); 
        include __DIR__ . '/components/summary-item.php'; 
        ?>
        <?php 
        $label = 'Email'; 
        $value = htmlspecialchars($formData['email']); 
        include __DIR__ . '/components/summary-item.php'; 
        ?>
        <?php if (!empty($formData['profile_pic'])): ?>
            <div class="summary-item">
                <span class="summary-label">Profile Photo</span>
                <span class="summary-value">
                    <?php
                        // Since the file is in a temp directory outside web root, we need to embed it
                        $imageData = $controller->getTempImage($formData['profile_pic']);
                        if ($imageData):
                            $base64 = base64_encode($imageData);
                            $mime = (strpos($formData['profile_pic'], '.png') !== false) ? 'image/png' : 'image/jpeg';
                            $src = 'data:' . $mime . ';base64,' . $base64;
                    ?>
                        <img src="<?php echo $src; ?>" alt="Profile Preview" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <span>Image preview not available</span>
                    <?php endif; ?>
                </span>
            </div>
        <?php endif; ?>

        <h3 style="color: #667eea; margin-bottom: 15px; margin-top: 20px;">Workout Plan</h3>
        <?php 
        $label = 'Gender'; 
        $value = ucfirst(htmlspecialchars($formData['gender'])); 
        include __DIR__ . '/components/summary-item.php'; 
        ?>
        <?php 
        $label = 'Target Muscles'; 
        $muscleNames = array_map(function($m) use ($muscles) { return $muscles[$m]; }, $formData['muscles']);
        $value = htmlspecialchars(implode(', ', $muscleNames));
        include __DIR__ . '/components/summary-item.php'; 
        ?>
        <?php 
        $label = 'Main Muscle'; 
        $value = htmlspecialchars($muscles[$formData['main_muscle']]); 
        include __DIR__ . '/components/summary-item.php'; 
        ?>
        <?php 
        $label = 'Current Stats'; 
        $value = htmlspecialchars($formData['weight']) . 'kg / ' . htmlspecialchars($formData['reps']) . ' reps'; 
        include __DIR__ . '/components/summary-item.php'; 
        ?>
        <?php 
        $label = 'Selected Plan'; 
        $value = htmlspecialchars($selectedPlan['name']); 
        include __DIR__ . '/components/summary-item.php'; 
        ?>
    </div>

    <div class="buttons">
        <button type="submit" name="prev" class="btn-secondary">← Edit</button>
        <button type="submit" name="next" class="btn-primary">Confirm & Submit</button>
    </div>
</form>
