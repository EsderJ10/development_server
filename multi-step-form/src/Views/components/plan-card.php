<label class="plan-card <?php echo ($selectedPlan == $index) ? 'selected' : ''; ?>">
    <input type="radio" name="plan" value="<?php echo htmlspecialchars($index); ?>" style="display: none;"
           <?php echo ($selectedPlan == $index) ? 'checked' : ''; ?>>
    <h3><?php echo htmlspecialchars($plan['name']); ?></h3>
    <p><?php echo htmlspecialchars($plan['description']); ?></p>
    <div class="plan-details">
        <div><strong>Target weight:</strong> <?php echo htmlspecialchars($plan['target_weight']); ?> kg</div>
        <div><strong>Reps:</strong> <?php echo htmlspecialchars($plan['target_reps']); ?></div>
        <div><strong>Timeline:</strong> <?php echo htmlspecialchars($plan['weeks']); ?> weeks</div>
        <div><strong>Intensity:</strong> <?php echo htmlspecialchars($plan['intensity']); ?></div>
    </div>
</label>
