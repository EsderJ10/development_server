<div class="buttons">
    <?php if ($showPrevious): ?>
        <button type="submit" name="prev" class="btn-secondary">← Previous</button>
    <?php endif; ?>
    <button type="submit" name="next" class="btn-primary"><?php echo htmlspecialchars($nextButtonText); ?></button>
</div>
