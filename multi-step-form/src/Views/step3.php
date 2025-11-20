<form method="POST" enctype="multipart/form-data">
    <h2 class="step-title">Current Performance</h2>
    <p style="color: #666;">
        Indicate your current performance in <?php echo htmlspecialchars($muscles[$formData['main_muscle']]); ?>
    </p>
    <div class="input-row">
        <?php
            ViewHelper::renderInput(
                'Weight (kg):',
                'weight',
                $formData['weight'] ?? '',
                'number',
                'e.g: 50',
                true,
                ['step' => '0.1', 'min' => '0', 'max' => '500'],
                'Enter the weight you can lift (0.1 - 500 kg)'
            );

            ViewHelper::renderInput(
                'Repetitions to failure:',
                'reps',
                $formData['reps'] ?? '',
                'number',
                'e.g: 10',
                true,
                ['min' => '1', 'max' => '100'],
                'Maximum reps you can perform (1-100)'
            );
        ?>
    </div>

    <?php ViewHelper::renderButtons(true, 'Next →'); ?>
</form>
