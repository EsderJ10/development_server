<div class="radio-group">
    <?php foreach ($options as $value => $label): ?>
        <label class="radio-option">
            <input type="radio" name="<?php echo htmlspecialchars($name); ?>" 
                   value="<?php echo htmlspecialchars($value); ?>"
                   <?php echo ($selected == $value) ? 'checked' : ''; ?>>
            <?php echo htmlspecialchars($label); ?>
        </label>
    <?php endforeach; ?>
</div>
