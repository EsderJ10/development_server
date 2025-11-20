<form method="POST">
    <h2 class="step-title">Muscle Group</h2>
    <div class="form-group">
        <p>Select the muscle group(s) you want to improve:</p>
        <div class="checkbox-group">
            <?php foreach ($muscles as $value => $label): ?>
                <label class="checkbox-option">
                    <input type="checkbox" name="muscles[]" value="<?php echo htmlspecialchars($value); ?>"
                        <?php echo (isset($formData['muscles']) && is_array($formData['muscles']) && in_array($value, $formData['muscles'])) ? 'checked' : ''; ?>
                        onchange="updateMainTargetOptions()">
                    <?php echo htmlspecialchars($label); ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="form-group" id="main-target-section" style="display: none; margin-top: 20px; animation: fadeIn 0.3s ease-in;">
        <p style="color: #667eea; font-weight: 600;">Which one is your main priority?</p>
        <select name="main_muscle" id="main_muscle_select" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-top: 8px;">
            <!-- Options populated by JS -->
        </select>
    </div>

    <?php $showPrevious = true; $nextButtonText = 'Next →'; include __DIR__ . '/components/form-buttons.php'; ?>
</form>

<script>
    // Update main target options based on selected muscles
    function updateMainTargetOptions() {
        const checkboxes = document.querySelectorAll('input[name="muscles[]"]:checked');
        const mainTargetSection = document.getElementById('main-target-section');
        const select = document.getElementById('main_muscle_select');
        const currentMain = "<?php echo $formData['main_muscle'] ?? ''; ?>";
        
        // Save current selection if any
        const currentSelection = select.value || currentMain;
        
        // Clear current options
        select.innerHTML = '';
        
        if (checkboxes.length > 1) {
            mainTargetSection.style.display = 'block';
            let foundSelected = false;
            
            checkboxes.forEach(cb => {
                const option = document.createElement('option');
                option.value = cb.value;
                option.text = cb.parentElement.textContent.trim();
                if (cb.value === currentSelection) {
                    option.selected = true;
                    foundSelected = true;
                }
                select.appendChild(option);
            });
            
            // If previously selected option is no longer available, select the first one
            if (!foundSelected && select.options.length > 0) {
                select.options[0].selected = true;
            }
        } else {
            mainTargetSection.style.display = 'none';
        }
    }

    // Run on load
    document.addEventListener('DOMContentLoaded', updateMainTargetOptions);
</script>