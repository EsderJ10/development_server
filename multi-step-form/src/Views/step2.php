<form method="POST">
    <h2 class="step-title">Muscle Group</h2>
    <div class="form-group">
        <p>Select the muscle group(s) you want to improve:</p>
        <?php
            ViewHelper::renderCheckboxGroup(
                'muscles',
                $muscles,
                $formData['muscles'] ?? []
            );
        ?>
    </div>

    <?php
        ViewHelper::renderDynamicSelect(
            'main-target-section',
            'Which one is your main priority?',
            'main_muscle',
            'main_muscle_select',
            $formData['main_muscle'] ?? ''
        );
        ViewHelper::renderButtons(true, 'Next →'); 
    ?>
</form>