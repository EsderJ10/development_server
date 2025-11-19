<form method="POST">
    <h2 class="step-title">Muscle Group</h2>
    <div class="form-group">
        <label>Select the muscle group you want to improve:</label>
        <?php
            $options = $muscles;
            $name = 'muscle';
            $selected = $formData['muscle'] ?? null;
            include __DIR__ . '/components/radio-group.php';
        ?>
    </div>

    <?php $showPrevious = true; $nextButtonText = 'Next →'; include __DIR__ . '/components/form-buttons.php'; ?>
</form>

