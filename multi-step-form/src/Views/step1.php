<form method="POST">
    <h2 class="step-title">Basic Information</h2>
    <div class="form-group">
        <label>Biological Sex:</label>
        <?php
            ViewHelper::renderRadioGroup(
                'gender',
                ['male' => 'Male', 'female' => 'Female'],
                $formData['gender'] ?? null
            );
        ?>
    </div>

    <?php ViewHelper::renderButtons(false, 'Next →'); ?>
</form>
