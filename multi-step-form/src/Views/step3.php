<form method="POST" enctype="multipart/form-data">
    <h2 class="step-title">Current Performance</h2>
    <p style="color: #666;">
        Indicate your current performance in <?php echo htmlspecialchars($muscles[$formData['main_muscle']]); ?>
    </p>
    <div class="input-row">
        <div class="form-group">
            <label>Weight (kg):</label>
            <input type="number" name="weight" step="0.1" min="0" max="500"
                value="<?php echo isset($formData['weight']) ? $formData['weight'] : ''; ?>" 
                placeholder="e.g: 50" required>
            <small class="form-helper" style="margin-bottom: 20px;">Enter the weight you can lift (0.1 - 500 kg)</small>
        </div>
        <div class="form-group">
            <label>Repetitions to failure:</label>
            <input type="number" name="reps" min="1" max="100"
                value="<?php echo isset($formData['reps']) ? $formData['reps'] : ''; ?>" 
                placeholder="e.g: 10" required>
            <small class="form-helper">Maximum reps you can perform (1-100)</small>
        </div>
    </div>

    <div class="buttons">
        <button type="submit" name="prev" class="btn-secondary">← Previous</button>
        <button type="submit" name="next" class="btn-primary">Next →</button>
    </div>
</form>
