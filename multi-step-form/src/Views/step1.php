<form method="POST">
    <h2 class="step-title">Basic Information</h2>
    <div class="form-group">
        <label>Biological Sex:</label>
        <?php
            $options = ['male' => 'Male', 'female' => 'Female'];
            $name = 'gender';
            $selected = $formData['gender'] ?? null;
            include __DIR__ . '/components/radio-group.php';
        ?>
    </div>

    <?php $showPrevious = false; $nextButtonText = 'Next →'; include __DIR__ . '/components/form-buttons.php'; ?>
</form>
